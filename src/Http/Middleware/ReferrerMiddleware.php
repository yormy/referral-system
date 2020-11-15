<?php

namespace Yormy\ReferralSystem\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Yormy\ReferralSystem\Traits\CookieTrait;

class ReferrerMiddleware
{
    use CookieTrait;

    protected $referrerQueryParam = "via";

    protected $referringUserModel;

    public function __construct()
    {
        $this->referringUserModel = config('referral-system.models.referring_user_model');
    }

    public function handle(Request $request, Closure $next)
    {
        $referringUser = $this->getReferrerFromParameter($request);

        if(!$referringUser) {
            $referringUser = $this->getReferrerFromCookie();
        }

        $this->setCookie($referringUser);

        return $next($request);
    }

    private function getReferrerFromParameter(Request $request)
    {
        $via = $request->input($this->referrerQueryParam);
        return (new $this->referringUserModel)->where('id', $via)->first();
    }



}
