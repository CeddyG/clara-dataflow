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
        $this->publishesConfig();
		$this->publishesTranslations();
        $this->loadRoutesFrom(__DIR__.'/routes.php');
		$this->publishesView();
        $this->publishesMigrations();
    }
    
    /**
	 * Publish config file.
	 * 
	 * @return void
	 */
	private function publishesConfig()
	{
		$sConfigPath = __DIR__ . '/../config';
        if (function_exists('config_path')) 
		{
            $sPublishPath = config_path();
        } 
		else 
		{
            $sPublishPath = base_path();
        }
		
        $this->publishes([$sConfigPath => $sPublishPath], 'clara.dataflow.config');  
	}

	private function publishesTranslations()
	{
		$sTransPath = __DIR__.'/../resources/lang';

        $this->publishes([
			$sTransPath => resource_path('lang/vendor/clara-dataflow'),
			'clara.dataflow.trans'
		]);
        
		$this->loadTranslationsFrom($sTransPath, 'clara-dataflow');
    }

	private function publishesView()
	{
        $sResources = __DIR__.'/../resources/views';

        $this->publishes([
            $sResources => resource_path('views/vendor/clara-dataflow'),
        ], 'clara.dataflow.views');
        
        $this->loadViewsFrom($sResources, 'clara-dataflow');
	}
    
    private function publishesMigrations()
    {
        $sMigration = realpath(__DIR__.'/database');

        $this->publishes([
            $sMigration => base_path().'/database'
        ], 'clara.dataflow.migrations');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/clara.dataflow.php', 'clara.dataflow'
        );
        
        $this->app->singleton('clara.dataflow', function ($app) 
		{
            return new Dataflow();
        });
    }
}
