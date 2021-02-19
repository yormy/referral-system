<?php

namespace Yormy\ReferralSystem;

use Illuminate\Support\Facades\Facade;

class ReferralSystemFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'ReferralSystem';
    }
}
