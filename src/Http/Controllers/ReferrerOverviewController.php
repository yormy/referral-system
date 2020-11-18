<?php

namespace Yormy\ReferralSystem\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Yormy\ReferralSystem\Http\Controllers\Resources\ReferrerAwardedActionCollection;
use Yormy\ReferralSystem\Http\Controllers\Resources\ReferrersCollection;
use Yormy\ReferralSystem\Models\ReferralAward;
use Yormy\ReferralSystem\Services\AwardService;

class ReferrerOverviewController extends Controller
{
    public function index()
    {
        $referringUserModelName = config('referral-system.models.referring_user_model');


        $modelNameColumn = config('referral-system.models.referring_user_name_column');

        $table = (new $referringUserModelName)->getTable();

        $modelIdColumn = config('referral-system.models.referring_user_public_column');

        $allReferrers = ReferralAward::select('referrer_id',$table.".". $modelIdColumn , $table. ".". $modelNameColumn)
            ->leftJoin($table, 'referrer_id', '=', $table.'.id')
            ->groupBy('referrer_id')
            ->get();

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
        foreach ($allReferrers as $referrerModel) {
            $referrerId = $referrerModel->referrer_id;

            $referrer = array();
            $referrer['id'] = $referrerModel->{$modelIdColumn};

            $referrer['name'] = $referrerModel->{$modelNameColumn};

            $referrer['total'] = $totalPoints->get($referrerId, 0);
            $referrer['paid'] = $paidPoints->get($referrerId, 0);
            $referrer['unpaid'] = $unpaidPoints->get($referrerId, 0);
            $referrer['created_at'] = $lastAward->get($referrerId, 0)->format(config('referral-system.datetime_format'));

            $referrers[] = (object)$referrer;
        }

        $awardService = new AwardService();
        $totalPoints = $awardService->getTotal();
        $paidPoints = $awardService->getPaid();
        $unpaidPoints = $awardService->getUnpaid();

        $points = [
            "total" => $totalPoints,
            "paid" => $paidPoints,
            "unpaid" => $unpaidPoints,
        ];

        return view('referral-system::admin.overview', [
            'referrers' => json_encode($referrers),
            'points' => json_encode($points)
        ]);
    }
}
