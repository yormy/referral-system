<?php

namespace Yormy\ReferralSystem\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Yormy\ReferralSystem\Models\ReferralAward;

class ReferrerOverviewController extends Controller
{
    public function index()
    {

        $totalPoints = ReferralAward::groupBy('referrer_id')
            ->leftJoin('referral_actions', 'referral_actions.id', '=', 'action_id')
            ->select('referrer_id', DB::raw('sum(points) as points'))
            ->get()
            ->pluck('points', 'referrer_id');

        $unpaidPoints = ReferralAward::groupBy('referrer_id')
            ->leftJoin('referral_actions', 'referral_actions.id', '=', 'action_id')
            ->whereNull('payment_id')
            ->select('referrer_id', DB::raw('sum(points) as points'))
            ->get()
            ->pluck('points', 'referrer_id');

        $paidPoints = ReferralAward::groupBy('referrer_id')
            ->leftJoin('referral_actions', 'referral_actions.id', '=', 'action_id')
            ->whereNotNull('payment_id')
            ->select('referrer_id', DB::raw('sum(points) as points'))
            ->get()
            ->pluck('points', 'referrer_id');

        //$me = ReferralAward::action()->with('action')->toSql();
        //$awards = $me->action;


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

        dd($referrers);


        return view('referral-system::admin.overview');
    }
}
