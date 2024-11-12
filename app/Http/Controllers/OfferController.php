<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use App\Models\Experience;
use App\Models\Location;
use App\Models\Offer;
use App\Models\Specialization;
use App\Models\WorkType;
use Illuminate\Http\Request;

class OfferController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->only(['search', 'location', 'experience', 'contract', 'specialization', 'workType']);
        $sortOrder = $request->get('sort', 'newest');

        $offers = Offer::getPaginatedOffers($filters, $sortOrder)->toArray();

        $offers['data'] = collect($offers['data'])
            ->map(function ($offer) {
                $offer['locations_array'] = collect($offer['locations'])->pluck('name')->toArray();
                $offer['experiences_array'] = collect($offer['experiences'])->pluck('name')->toArray();
                $offer['contracts_array'] = collect($offer['contracts'])->pluck('name')->toArray();
                $offer['specializations_array'] = collect($offer['specializations'])->pluck('name')->toArray();
                $offer['work_types_array'] = collect($offer['work_types'])->pluck('name')->toArray();

                return $offer;
            })->toArray();

        $locations = Location::get(['name', 'slug']);
        $experiences = Experience::get(['name', 'slug']);
        $contracts = Contract::get(['name', 'slug']);
        $specializations = Specialization::get(['name', 'slug']);
        $workTypes = WorkType::get(['name', 'slug']);

        return inertia('Offers/Index', [
            'offers' => $offers,
            'locations' => $locations,
            'experiences' => $experiences,
            'contracts' => $contracts,
            'specializations' => $specializations,
            'workTypes' => $workTypes,
            'total' => $offers['total'],
            'filters' => $filters,
        ]);
    }

    public function show(Offer $offer)
    {
        $offer->loadMissing([
            'company', 'locations', 'experiences', 'contracts', 'specializations', 'workTypes'
        ]);

        $offer = $offer->toArray();

        $offer['locations_array'] = collect($offer['locations'])->pluck('name')->toArray();
        $offer['experiences_array'] = collect($offer['experiences'])->pluck('name')->toArray();
        $offer['contracts_array'] = collect($offer['contracts'])->pluck('name')->toArray();
        $offer['specializations_array'] = collect($offer['specializations'])->pluck('name')->toArray();
        $offer['work_types_array'] = collect($offer['work_types'])->pluck('name')->toArray();

        return inertia('Offers/Show', [
            'offer' => $offer
        ]);
    }
}
