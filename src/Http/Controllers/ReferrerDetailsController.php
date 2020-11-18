<?php

namespace Yormy\ReferralSystem\Http\Controllers;


use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Yormy\ReferralSystem\Http\Controllers\Resources\ReferrerAwardedActionCollection;
use Yormy\ReferralSystem\Models\ReferralAward;
use Yormy\ReferralSystem\Services\AwardService;

class ReferrerDetailsController extends Controller
{
    public function show()
    {
        $currentUser = Auth::user();
        $awardedAction = ReferralAward::with(['action','user'])
            ->where('referrer_id', $currentUser->id)
            ->get();

        $awardService = new AwardService();
        $totalPoints = $awardService->getTotalForReferrer($currentUser->id);
        $paidPoints = $awardService->getPaidForReferrer($currentUser->id);
        $unpaidPoints = $awardService->getUnpaidForReferrer($currentUser->id);

        $points = [
            "total" => $totalPoints,
            "paid" => $paidPoints,
            "unpaid" => $unpaidPoints,
        ];

        $awardedActions = (new ReferrerAwardedActionCollection($awardedAction))->toArray(null);

        return view('referral-system::user.details', [
            'awardedActions' => json_encode($awardedActions),
            'points' => json_encode($points),
        ]);
    }
}
