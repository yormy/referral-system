<?php

namespace Yormy\ReferralSystem\Observers\Listeners;

use Illuminate\Support\Facades\Auth;
use Yormy\ReferralSystem\Models\ReferralAward;
use Yormy\ReferralSystem\Observers\Events\AwardReferrerEvent;
use Yormy\ReferralSystem\Traits\CookieTrait;

class AwardReferrerListener
{
    use CookieTrait;

    public function handle(AwardReferrerEvent $event)
    {
        $user = Auth::user();
        if ($user) {
            $referrer = $this->getReferrerFromCookie();

            if (!$referrer) {
                $latestReward = ReferralAward::with('user')
                    ->where('user_id', $user->id)
                    ->latest('created_at')
                    ->first();

                $referrer = $latestReward->user;
            }

            if ($referrer) {
                ReferralAward::create([
                    'user_id' => $user->id,
                    'referrer_id' => $referrer->id,
                    'action_id' => $event->actionId,
                ]);
            }

        }

    }
}
