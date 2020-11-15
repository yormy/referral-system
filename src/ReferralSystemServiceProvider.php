<?php

namespace Yormy\ReferralSystem;

use Yormy\ReferralSystem\Providers\EventServiceProvider;
use DirectoryIterator;
use FilesystemIterator;
use Illuminate\Support\ServiceProvider;
use Yormy\ReferralSystem\Commands\ReferralSystemCommand;

class ReferralSystemServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/referral-system.php' => config_path('referral-system.php'),
            ], 'config');

            $this->publishes([
                __DIR__ . '/../resources/views' => base_path('resources/views/vendor/referral-system'),
            ], 'views');

            $this->publishMigrations();

            $this->commands([
                ReferralSystemCommand::class,
            ]);
        }

        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'referral-system');
    }

    private function publishMigrations()
    {
        $migrations = [
            'create_referral_actions_table.php',
            'create_referral_domains_table.php',
            'create_referral_payments_table.php',
            'create_referral_awards_table.php',
            'seed_referral_actions_table.php',
        ];

        $index = 0;
        foreach ($migrations as $migrationFileName) {
            if (!$this->migrationFileExists($migrationFileName)) {

                $sequence = date('Y_m_d_His', time());
                $newSequence = substr($sequence, 0, strlen($sequence)-2);
                $paddedIndex = str_pad($index, 2, '0', STR_PAD_LEFT);
                $newSequence .= $paddedIndex;
                $this->publishes([
                    __DIR__ . "/../database/migrations/{$migrationFileName}.stub" => database_path('migrations/' . $newSequence . '_' . $migrationFileName),
                ], 'migrations');

                $index ++;
            }
        }
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/referral-system.php', 'referral-system');
        $this->app->register(EventServiceProvider::class);
    }

    public static function migrationFileExists(string $migrationFileName): bool
    {
        $len = strlen($migrationFileName);
        foreach (glob(database_path("migrations/*.php")) as $filename) {
            if ((substr($filename, -$len) === $migrationFileName)) {
                return true;
            }
        }

        return false;
    }

}
