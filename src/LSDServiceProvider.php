<?php 
namespace Faryar76\LSD;

use Illuminate\Support\ServiceProvider;


class LSDServiceProvider extends ServiceProvider
{
     /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        app()->config["filesystems.disks.lsd"] = [
            'driver' => 'local',
            'root' => base_path(),
        ];
        $this->commands(
            [
                \Faryar76\LSD\Console\Commands\lsd::class
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