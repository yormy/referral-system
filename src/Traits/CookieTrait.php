<?php

namespace Yormy\ReferralSystem\Traits;

use Illuminate\Support\Facades\Cookie;

trait CookieTrait
{
    public function getReferrerFromCookie()
    {
        $referringUserModel = config('referral-system.models.referring_user_model');
        $referrerCookieName = config('referral-system.cookie_name');

        if (request()->hasCookie($referrerCookieName)) {
            $userId = request()->cookie($referrerCookieName);

            $model = new $referringUserModel;
            return $model->where('id', $userId)->first();
        }
    }

    public function setCookie($referringUser)
    {
        $referrerCookieName = config('referral-system.cookie_name');

        if ($referringUser) {
            Cookie::queue($referrerCookieName, $referringUser->id, config('referral-system.cookie_lifetime_in_minutes'));
        }
    }
}
