<?php namespace Tomcorbett\OpentokLaravel;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use OpenTok\OpenTok;

class ServiceProvider extends BaseServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;


	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->mergeConfigFrom($this->configPath(), 'opentok');
	}

    public function boot()
    {
        $this->publishes([$this->configPath() => config_path('opentok.php')], 'config');

		$this->app['OpentokApi'] = $this->app->share(function($app) {
			return new OpenTok(
				$app['config']->get('opentok')['api_key'],
				$app['config']->get('opentok')['api_secret']
			);
		});
    }

	protected function configPath()
	{   
		return __DIR__ . '/../config/opentok.php';
	}   

}
