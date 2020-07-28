<?php

namespace Hedeqiang\Permission;

use Illuminate\Support\ServiceProvider;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Collection;

class PermissionServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     */
    public function boot(Filesystem $filesystem)
    {

        $this->publishes([
            \dirname(__DIR__).'/migrations/create_menus_tables.php.stub' => $this->getMigrationFileName($filesystem),
        ], 'migrations');

        if ($this->app->runningInConsole()) {
            $this->loadMigrationsFrom(\dirname(__DIR__) . '/migrations/');
        }
    }

    /**
     * Returns existing migration file if found, else uses the current timestamp.
     *
     * @param Filesystem $filesystem
     * @return string
     */
    protected function getMigrationFileName(Filesystem $filesystem): string
    {
        $timestamp = date('Y_m_d_His');

        return Collection::make($this->app->databasePath().DIRECTORY_SEPARATOR.'migrations'.DIRECTORY_SEPARATOR)
            ->flatMap(function ($path) use ($filesystem) {
                return $filesystem->glob($path.'*_create_menus_tables.php');
            })->push($this->app->databasePath()."/migrations/{$timestamp}_create_menus_tables.php")
            ->first();
    }

    public function register()
    {
//        $this->app->singleton(Package::class, function(){
//            return new Package();
//        });
    }
}
