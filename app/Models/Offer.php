<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Offer extends Model
{
    use HasFactory, HasSlug;

    protected $guarded = [];

    protected $casts = [
        'locations' => 'array',
        'experiences' => 'array',
        'contracts' => 'array',
        'specializations' => 'array',
        'tech_stack' => 'array',
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(User::class, 'company_id');
    }

    public function locations(): BelongsToMany
    {
        return $this->belongsToMany(Location::class, 'offer_locations');
    }

    public function experiences(): BelongsToMany
    {
        return $this->belongsToMany(Experience::class, 'offer_experiences');
    }

    public function contracts(): BelongsToMany
    {
        return $this->belongsToMany(Contract::class, 'offer_contracts');
    }

    public function specializations(): BelongsToMany
    {
        return $this->belongsToMany(Specialization::class, 'offer_specializations');
    }

    public function workTypes(): BelongsToMany
    {
        return $this->belongsToMany(WorkType::class, 'offer_work_types', 'offer_id', 'work_type_id');
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

    public static function getPaginatedOffers(array $filters = [], string $sortOrder = 'newest', int $perPage = 20): LengthAwarePaginator
    {
        $company = Arr::get($filters, 'company');
        $locations = Arr::get($filters, 'location');
        $experiences = Arr::get($filters, 'experience');
        $workTypes = Arr::get($filters, 'workType');
        $contract = Arr::get($filters, 'contract');

        return self::query()
            ->with([
                'company',
                'locations',
                'contracts',
                'specializations',
                'experiences',
                'workTypes',
            ])
            ->when($company, function ($query) use ($company) {
                return $query->whereHas('company', function ($query) use ($company) {
                    $query->where('name', 'like', "%{$company}%");
                });
            })
            ->when($locations, function ($query) use ($locations) {
                return $query->whereHas('locations', function ($query) use ($locations) {
                    $query->whereIn('slug', explode(',', $locations));
                });
            })
            ->when($experiences, function ($query) use ($experiences) {
                return $query->whereHas('experiences', function ($query) use ($experiences) {
                    $query->whereIn('slug', explode(',', $experiences));
                });
            })
            ->when($workTypes, function ($query) use ($workTypes) {
                return $query->whereHas('workTypes', function ($query) use ($workTypes) {
                    $query->whereIn('slug', explode(',', $workTypes));
                });
            })
            ->orderBy('id', $sortOrder === 'newest' ? 'desc' : 'asc')
            ->paginate($perPage);
    }
}
