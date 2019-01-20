<?php 
namespace Faryar76\LRM;

use Illuminate\Support\ServiceProvider;


class LRMServiceProvider extends ServiceProvider
{
     /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/config/laravel_remote_manager.php' => config_path('lrm.php'),
        ]);
        
        $this->mergeConfigFrom(
            __DIR__.'/config/laravel_remote_manager.php', 'lrm'
        );
        
        $this->commands(
            [
                \Faryar76\LRM\Console\Commands\Migration::class,
                \Faryar76\LRM\Console\Commands\SyncMigrate::class,
                \Faryar76\LRM\Console\Commands\SyncFile::class
            ]
        );
        $this->loadRoutesFrom(__DIR__."/routes/web.php");
    }
 
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}