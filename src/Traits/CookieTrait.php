<?php

namespace Yormy\ReferralSystem\Traits;

use Illuminate\Support\Facades\Cookie;

trait CookieTrait
{
    public function getReferrerFromCookie()
    {
//        $referringUserModel = config('referral-system.models.referring_user_model');
        $referrerCookieName = config('referral-system.cookie_name');

        if (request()->hasCookie($referrerCookieName)) {
            $publicReferrerId = request()->cookie($referrerCookieName);

            return $publicReferrerId;
        }
    }

    public function setCookie($referringUserId)
    {
        $referrerCookieName = config('referral-system.cookie_name');

        if ($referringUserId) {
            Cookie::queue($referrerCookieName, $referringUserId, config('referral-system.cookie_lifetime_in_minutes'));
        }
    }
}
