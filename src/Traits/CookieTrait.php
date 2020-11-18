<?php

namespace Yormy\ReferralSystem\Traits;

use Illuminate\Support\Facades\Cookie;

trait CookieTrait
{
    protected $cookieName;

    protected $cookieLifetime;

    public function __construct()
    {
        $this->cookieName = config('referral-system.cookie.name');
        $this->cookieLifetime = config('referral-system.cookie.lifetime');
    }

    public function getReferrerFromCookie()
    {
        if (request()->hasCookie($this->cookieName)) {
            $publicReferrerId = request()->cookie($this->cookieName);
            return $publicReferrerId;
        }

        return null;
    }

    public function setCookie($referringUserId)
    {
        if ($referringUserId) {
            Cookie::queue($this->cookieName, $referringUserId, $this->cookieLifetime);
        }
    }
}
