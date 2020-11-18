<?php

namespace Yormy\ReferralSystem\Tests\Features;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Yormy\ReferralSystem\ReferralSystemServiceProvider;
use Yormy\ReferralSystem\Tests\TestCase;

class BlaCaseTest extends TestCase
{
//    /** @test */
//    public function access()
//    {
//        //$response = $this->get('ref/details');
//        $response = $this->get('/');
//        $content = json_decode($response->getContent());
//
//        //echo $response->getContent();
//        $response->assertOk();
//    }


    /** @test */
    public function accessdetails()
    {
        //$response = $this->get('ref/details');
//
//        resource_path('sss');
//
//        //config(['view.paths' => 'New Name']);
        dump( Config::get('referral-system.ui_type'));

//
//        return;
        // force config to blade
        // allow layouts.app
        Auth::login($this->testUser);


        $response = $this->get('/details');
        $content = json_decode($response->getContent());


        //echo $response->getContent();
        dump($response->getContent());
dump($content);
        $response->assertOk();
    }

}
