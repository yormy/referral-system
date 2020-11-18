<?php

namespace Yormy\ReferralSystem\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Yormy\ReferralSystem\Traits\CookieTrait;

class ReferrerMiddleware
{
    use CookieTrait;

    protected $referrerQueryParam;

    protected $referringUserModel;

    public function __construct()
    {
        $this->referringUserModel = config('referral-system.models.referrer.class');
        $this->referrerQueryParam = config('referral-system.query_parameter');
    }

    public function handle(Request $request, Closure $next)
    {
        $referringUserId = $this->getReferrerFromParameter($request);

        if (! $referringUserId) {
            $referringUserId = $this->getReferrerFromCookie();
        }

        $this->setCookie($referringUserId);

        $referrerQueryParam = config('referral-system.query_parameter');
        $request->request->add([$referrerQueryParam => $referringUserId]);

        return $next($request);
    }

    private function getReferrerFromParameter(Request $request) : ?string
    {
        return $request->input($this->referrerQueryParam);
    }
}
