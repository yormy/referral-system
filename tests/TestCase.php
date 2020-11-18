<?php

namespace Yormy\ReferralSystem\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Route;
use Orchestra\Testbench\TestCase as Orchestra;
use Yormy\ReferralSystem\ReferralSystemServiceProvider;

class TestCase extends Orchestra
{
    protected $prefix = 'ref';

    protected $testUser;

    public function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn(string $modelName) => 'Yormy\\ReferralSystem\\Database\\Factories\\' . class_basename($modelName) . 'Factory'
        );
        // Note: this also flushes the cache from within the migration
        $this->setUpDatabase($this->app);

        $this->testUser = User::first();

        Route::ReferralSystemUser($this->prefix);

        $this->setViewForLayout();
    }

    private function setViewForLayout()
    {
        $viewPath = dirname(__DIR__);
        $viewPath .= "/resources/views";
        config(['view.paths' => [$viewPath]]);
    }

    public function get($uri, array $headers = [])
    {
        $uri = $this->prefix . $uri;
        return parent::get($uri, $headers);
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

    }

    public function dump($message)
    {
        if (!is_array($message) && !is_object($message)) {
            fwrite(STDERR, $message);
        } else {
            fwrite(STDERR, print_r($message));
        }
        fwrite(STDERR, PHP_EOL);
    }

    /**
     * Set up the database.
     *
     * @param \Illuminate\Foundation\Application $app
     */
    protected function setUpDatabase($app)
    {
        $app['db']->connection()->getSchemaBuilder()->create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('email');
            $table->softDeletes();
        });

        include_once __DIR__.'/../database/migrations/create_referral_awards_table.php.stub';
        (new \CreateReferralAwardsTable())->up();

        include_once __DIR__.'/../database/migrations/create_referral_actions_table.php.stub';
        (new \CreateReferralActionsTable())->up();

        include_once __DIR__.'/../database/migrations/create_referral_domains_table.php.stub';
        (new \CreateReferralDomainsTable())->up();

        include_once __DIR__.'/../database/migrations/create_referral_payments_table.php.stub';
        (new \CreateReferralPaymentsTable())->up();

        include_once __DIR__.'/../database/migrations/seed_referral_actions_table.php.stub';
        (new \SeedReferralActionsTable())->up();

        User::create(['email' => 'test@user.com']);

    }

}
