<?php

namespace App\Http\Controllers;

use App\Http\Requests\OfferApplyRequest;
use App\Models\Application;
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
        $filters = $request->only(['search', 'location', 'experience', 'contract', 'specialization', 'workType', 'sortOrder']);

        return inertia('Offers/Index', [
            'offers' => Offer::getPaginatedOffers($filters),
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
            'offer' => $offer,
            'application' => Application::where('user_id', auth()->id())->where('offer_id', $offer->id)->first(),
        ]);
    }

    public function apply(Offer $offer, OfferApplyRequest $request)
    {
        $user = auth()->user();

        $user->apply()->create($request->validated() + [
            'offer_id' => $offer->id,
            'cv' => $user->cv,
        ]);

        return back()->with('success', 'Successfully applied for this offer');
    }
}
