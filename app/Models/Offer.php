<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Offer extends Model
{
    use HasFactory, HasSlug, SoftDeletes;

    protected $guarded = [];

    protected $perPage = 20;

    protected $appends = [
        'location_names',
        'specialization_names',
        'work_type_names',
        'contract_names',
        'experience_names',
    ];

    protected function casts(): array
    {
        return [
            'tech_stack' => 'array',
        ];
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(User::class, 'company_id');
    }

    public function locations(): BelongsToMany
    {
        return $this->belongsToMany(Location::class, 'offer_locations');
    }

    public function getLocationNamesAttribute(): array
    {
        return Arr::pluck($this->locations, 'name');
    }

    public function experiences(): BelongsToMany
    {
        return $this->belongsToMany(Experience::class, 'offer_experiences');
    }

    public function getExperienceNamesAttribute(): array
    {
        return Arr::pluck($this->experiences, 'name');
    }

    public function contracts(): BelongsToMany
    {
        return $this->belongsToMany(Contract::class, 'offer_contracts');
    }

    public function getContractNamesAttribute(): array
    {
        return Arr::pluck($this->contracts, 'name');
    }

    public function specializations(): BelongsToMany
    {
        return $this->belongsToMany(Specialization::class, 'offer_specializations');
    }

    public function getSpecializationNamesAttribute(): array
    {
        return Arr::pluck($this->specializations, 'name');
    }

    public function workTypes(): BelongsToMany
    {
        return $this->belongsToMany(WorkType::class, 'offer_work_types', 'offer_id', 'work_type_id');
    }

    public function getWorkTypeNamesAttribute(): array
    {
        return Arr::pluck($this->workTypes, 'name');
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

    public static function getPaginatedOffers(array $filters = [], int $perPage = 12): LengthAwarePaginator
    {
        $location       = Arr::get($filters, 'location');
        $specialization = Arr::get($filters, 'specialization');
        $experience     = Arr::get($filters, 'experience');
        $workType       = Arr::get($filters, 'workType');
        $contract       = Arr::get($filters, 'contract');
        $search         = Arr::get($filters, 'search');
        $sortOrder      = Arr::get($filters, 'sortOrder', 'latest');

        $query = self::query()
            ->with([
                'company',
                'locations',
                'contracts',
                'specializations',
                'experiences',
                'workTypes',
            ])
            ->when($search, function ($query) use ($search) {
                return $query->where('title', 'like', "%{$search}%");
            })
            ->when($location, function ($query) use ($location) {
                return $query->whereHas('locations', function ($query) use ($location) {
                    $query->where('slug', $location);
                });
            })
            ->when($experience, function ($query) use ($experience) {
                return $query->whereHas('experiences', function ($query) use ($experience) {
                    $query->where('slug', $experience);
                });
            })
            ->when($workType, function ($query) use ($workType) {
                return $query->whereHas('workTypes', function ($query) use ($workType) {
                    $query->where('slug', $workType);
                });
            })
            ->when($contract, function ($query) use ($contract) {
                return $query->whereHas('contracts', function ($query) use ($contract) {
                    $query->where('slug', $contract);
                });
            })
            ->when($specialization, function ($query) use ($specialization) {
                return $query->whereHas('specializations', function ($query) use ($specialization) {
                    $query->where('slug', $specialization);
                });
            });

        match ($sortOrder) {
            'salary_max' => $query->orderBy('salary_max', 'desc'),
            'salary_min' => $query->orderBy('salary_min', 'asc'),
            default => $query->orderBy('created_at', 'desc'),
        };

        return $query->paginate($perPage);
    }
}
