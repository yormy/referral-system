<?php

namespace Yormy\ReferralSystem\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Yormy\ReferralSystem\Http\Controllers\Resources\ReferrerAwardedActionCollection;
use Yormy\ReferralSystem\Http\Controllers\Resources\ReferrersCollection;
use Yormy\ReferralSystem\Models\ReferralAward;

class ReferrerOverviewController extends Controller
{
    public function index()
    {
        $allReferrers = ReferralAward::select('referrer_id')->groupBy('referrer_id')->get();

        $lastAward = ReferralAward::select('referrer_id', DB::raw('max(created_at) as created_at'))
            ->groupBy('referrer_id')
            ->get()
            ->pluck('created_at', 'referrer_id');

        $points = ReferralAward::groupBy('referrer_id')
            ->leftJoin('referral_actions', 'referral_actions.id', '=', 'action_id')
            ->select('referrer_id', DB::raw('sum(points) as points'));

        $totalPoints = clone $points;
        $totalPoints = $totalPoints
            ->get()
            ->pluck('points', 'referrer_id');

        $unpaidPoints = clone $points;
        $unpaidPoints = $unpaidPoints
            ->whereNull('payment_id')
            ->get()
            ->pluck('points', 'referrer_id');

        $paidPoints = clone $points;
        $paidPoints = $paidPoints
            ->whereNotNull('payment_id')
            ->get()
            ->pluck('points', 'referrer_id');

        $referrers = [];
        foreach ($allReferrers as $referrer) {
            $referrerId = $referrer->referrer_id;
            $referrer = array();
            $referrer['id'] = $referrerId;

            $referrer['total'] = $totalPoints->get($referrerId, 0);
            $referrer['paid'] = $paidPoints->get($referrerId, 0);
            $referrer['unpaid'] = $unpaidPoints->get($referrerId, 0);
            $referrer['created_at'] = $lastAward->get($referrerId, 0)->format(config('referral-system.datetime_format'));

            $referrers[] = (object)$referrer;
        }
        return view('referral-system::admin.overview', [
            'referrers' => json_encode($referrers)
        ]);
    }
}
