<?php

namespace Yormy\ReferralSystem\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Route;
use Orchestra\Testbench\TestCase as Orchestra;
use Yormy\ReferralSystem\ReferralSystemServiceProvider;

class TestCase extends Orchestra
{
    public function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'Yormy\\ReferralSystem\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );

       // Route::ReferralSystem('referralsystem');
    }

    protected function getPackageProviders($app)
    {
        return [
            ReferralSystemServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.default', 'sqlite');
        $app['config']->set('database.connections.sqlite', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);

        /*
        include_once __DIR__.'/../database/migrations/create_referral_system_table.php.stub';
        (new \CreatePackageTable())->up();
        */
    }
}
