<?php

namespace Yormy\ReferralSystem\Tests\Features;

use Illuminate\Support\Facades\Auth;
use Yormy\ReferralSystem\Tests\TestCase;

use Yormy\ReferralSystem\Observers\Events\AwardReferrerEvent;
use Yormy\ReferralSystem\Models\ReferralAction;

class BlaCaseTest extends TestCase
{

    /** @test */
    public function set_cookie_middleware()
    {
        Auth::login($this->userBob);
        $this->get('details?via='. $this->referrerFelix->id);
        event(new AwardReferrerEvent(ReferralAction::UPGRADE_SILVER));

        Auth::login($this->userAdam);
        $this->get('details?via='. $this->referrerFelix->id);
        event(new AwardReferrerEvent(ReferralAction::UPGRADE_GOLD));

        Auth::login($this->referrerFelix);
        $response = $this->get('/details');
        echo $response->getContent();

    }

    /** @test4 */
    public function accessdetails()
    {
        Auth::login($this->referrerFelix);

        $response = $this->get('/details');
        echo $response->getContent();
        $response->assertOk();
    }
}
