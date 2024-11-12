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

        return inertia('Offers/Index', [
            'offers' => Offer::getPaginatedOffers($filters, $sortOrder),
            'locations' => Location::get(['name', 'slug']),
            'experiences' => Experience::get(['name', 'slug']),
            'contracts' => Contract::get(['name', 'slug']),
            'specializations' => Specialization::get(['name', 'slug']),
            'workTypes' => WorkType::get(['name', 'slug']),
            'filters' => $filters,
        ]);
    }

    public function show(Offer $offer)
    {
        $offer->loadMissing([
            'company', 'locations', 'experiences', 'contracts', 'specializations', 'workTypes'
        ]);

        return inertia('Offers/Show', [
            'offer' => $offer
        ]);
    }
}
