<?php

namespace Yormy\ReferralSystem\Observers\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AwardRevokeEvent
{
    use Dispatchable, SerializesModels;

    public string $actionId;

    public string $deleteReason;

    public function __construct(string $actionId, string $deleteReason ="")
    {
        $this->actionId = $actionId;
        $this->deleteReason = $deleteReason;
    }
}
