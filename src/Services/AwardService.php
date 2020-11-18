<?php

namespace Yormy\ReferralSystem\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yormy\ReferralSystem\Models\ReferralAward;
use Yormy\ReferralSystem\Traits\CookieTrait;

class AwardService
{
    use CookieTrait;

    public function getTotalForReferrer(int $referrerId)
    {
        $points = ReferralAward::select('points')
            ->where('referrer_id', $referrerId)
            ->leftJoin('referral_actions', 'referral_actions.id', '=', 'action_id')
            ->select(DB::raw('sum(points) as points'))
            ->first();
        return $points->points;
    }

    public function getPaidForReferrer(int $referrerId)
    {
        $points = ReferralAward::select('points')
            ->where('referrer_id', $referrerId)
            ->whereNotNull('payment_id')
            ->leftJoin('referral_actions', 'referral_actions.id', '=', 'action_id')
            ->select(DB::raw('sum(points) as points'))
            ->first();
        return $points->points;
    }

    public function getUnpaidForReferrer(int $referrerId)
    {
        $points = ReferralAward::select('points')
            ->where('referrer_id', $referrerId)
            ->whereNull('payment_id')
            ->leftJoin('referral_actions', 'referral_actions.id', '=', 'action_id')
            ->select(DB::raw('sum(points) as points'))
            ->first();
        return $points->points;
    }

    public function getReferrer()
    {
        $referrerQueryParam = config('referral-system.referrer_query_parameter');
        $referrerIdFromRequest = request()->input($referrerQueryParam);

        if ($referrerIdFromRequest) {
            return $referrerIdFromRequest;
        }

        return $this->getReferrerFromCookie();
    }

    public function getReferringUser(string $publicReferrerId)
    {
        $referringUserModelName = config('referral-system.models.referring_user_model');
        $modelIdColumn = config('referral-system.models.referring_user_public_column');

        /**
        * @psalm-suppress UndefinedClass
        */
        return (new $referringUserModelName)->where($modelIdColumn, $publicReferrerId)->first();
    }

    public function getReferringUserFromLatestAward(int $referrerUserId)
    {
        return ReferralAward::with('user')
            ->where('user_id', $referrerUserId)
            ->latest('created_at')
            ->first();
    }
}
