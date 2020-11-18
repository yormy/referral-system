<?php

namespace Yormy\ReferralSystem\Traits;

use Illuminate\Support\Facades\Cookie;

trait CookieTrait
{
    public function getReferrerFromCookie()
    {
        $referrerCookieName = config('referral-system.cookie.name');

        if (request()->hasCookie($referrerCookieName)) {
            $publicReferrerId = request()->cookie($referrerCookieName);

            return $publicReferrerId;
        }

        return null;
    }

    public function setCookie($referringUserId)
    {
        $referrerCookieName = config('referral-system.cookie.name');

        if ($referringUserId) {
            Cookie::queue($referrerCookieName, $referringUserId, config('referral-system.cookie.lifetime'));
        }
    }
}
