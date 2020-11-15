<?php

namespace Yormy\ReferralSystem\Observers;

use Illuminate\Events\Dispatcher;
use Yormy\ReferralSystem\Observers\Events\AwardReferrerEvent;
use Yormy\ReferralSystem\Observers\Listeners\AwardReferrerListener;

class ActionSubscriber
{
    /**
     * Binding of SettingsChanged Events
     *
     * @param Dispatcher $events
     */
    public function subscribe(Dispatcher $events)
    {
        $events->listen(
            AwardReferrerEvent::class,
            AwardReferrerListener::class
        );
    }
}
