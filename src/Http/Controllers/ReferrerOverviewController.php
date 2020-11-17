<?php

namespace Yormy\ReferralSystem\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Yormy\ReferralSystem\Models\ReferralAward;

class ReferrerOverviewController extends Controller
{
    public function index()
    {
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
        foreach ($totalPoints as $referrer_id => $total) {
            $referrers[$referrer_id]['total'] = $total;
        }

        foreach ($unpaidPoints as $referrer_id => $total) {
            $referrers[$referrer_id]['unpaid'] = $total;
        }

        foreach ($paidPoints as $referrer_id => $total) {
            $referrers[$referrer_id]['paid'] = $total;
        }

        foreach ($lastAward as $referrer_id => $created_at) {
            $referrers[$referrer_id]['created_at'] = $created_at->format(config('referral-system.datetime_format'));
        }

        return view('referral-system::admin.overview', [
            'referrers' => json_encode($referrers)
        ]);
    }
}
