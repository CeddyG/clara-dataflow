<?php
namespace CeddyG\ClaraDataflow;

use Illuminate\Support\ServiceProvider;

/**
 * Description of EntityServiceProvider
 *
 * @author CeddyG
 */
class DataflowServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Publish services
        $sApp = realpath(__DIR__.'/app');

        $this->publishes([
            $sApp => base_path().'/app',
        ], 'services');

        // Publish views
        $sViews = realpath(__DIR__.'/resources');

        $this->publishes([
            $sViews => base_path().'/resources',
        ], 'views');

        // Publish migrations
        $sMigration = realpath(__DIR__.'/database');

        $this->publishes([
            $sMigration => base_path().'/database',
        ], 'migrations');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
