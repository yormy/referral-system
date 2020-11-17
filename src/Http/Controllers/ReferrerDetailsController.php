<?php

namespace Yormy\ReferralSystem\Http\Controllers;


use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Yormy\ReferralSystem\Http\Controllers\Resources\ReferrerAwardedActionCollection;
use Yormy\ReferralSystem\Models\ReferralAward;

class ReferrerDetailsController extends Controller
{
    public function show()
    {
        $currentUser = Auth::user();
        $awardedAction = ReferralAward::with('action')
            ->where('referrer_id', $currentUser->id)
            ->get();

        $awardedActions = (new ReferrerAwardedActionCollection($awardedAction))->toArray(null);

        return view('referral-system::user.details', [
            'awardedActions' => json_encode($awardedActions),
        ]);
    }
}
