<?php

namespace Yormy\ReferralSystem\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Yormy\ReferralSystem\Models\ReferralDomain;

class ReferrerMiddleware
{

    protected $referrerCookieName = "via";

    protected $referringUserModel;

    public function __construct()
    {
        $this->referringUserModel = config('referral-system.models.referring_user_model');
    }

    public function handle(Request $request, Closure $next)
    {
        // check parameter
        $referringUser = $this->getFromParameter($request);

        if(!$referringUser) {
            $referringUser = $this->getFromCookie();
        }

        $this->setCookie($referringUser);

        return $next($request);
    }

    private function getFromParameter(Request $request)
    {
        $via = $request->input('via');
        return (new $this->referringUserModel)->where('id', $via)->first();
    }

    private function getFromCookie()
    {
        if (request()->hasCookie($this->referrerCookieName)) {
            $userId = request()->cookie($this->referrerCookieName);
            return (new $this->referringUserModel)->where('id', $userId)->first();
        }
    }

    private function setCookie($referringUser)
    {
        Cookie::queue($this->referrerCookieName, $referringUser->id, config('referral-system.cookie_lifetime_in_minutes'));
    }

}
