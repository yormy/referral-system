<?php

namespace Yormy\ReferralSystem;

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
        $migrations = new FilesystemIterator(__DIR__ . "/../database/migrations");

        foreach ($migrations as $fileInfo) {
            $migrationFileName = $fileInfo->getFilename();
            if (! $this->migrationFileExists($migrationFileName)) {
                $this->publishes([
                    $fileInfo->getPath().  "/{$migrationFileName}" => database_path('migrations/' . date('Y_m_d_His', time()) . '_' . $migrationFileName),
                ], 'migrations');
            }
        }
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/referral-system.php', 'referral-system');
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
