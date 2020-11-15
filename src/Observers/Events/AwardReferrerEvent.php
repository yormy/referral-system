<?php

namespace Yormy\ReferralSystem\Observers\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AwardReferrerEvent
{
    use Dispatchable, SerializesModels;

    public string $actionId;

    public function __construct(string $actionId)
    {
        $this->actionId = $actionId;
    }

}
