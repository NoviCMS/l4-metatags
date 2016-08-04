<?php
/**
 * Laravel 4 - Persistant metatags
 *
 * @author   Andreas Lutro <anlutro@gmail.com>
 * @license  http://opensource.org/licenses/MIT
 * @package  l4-metatags
 */

namespace NoviCMS\LaravelMetatags;

use Illuminate\Foundation\Application;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
	/**
	 * This provider is deferred and should be lazy loaded.
	 *
	 * @var boolean
	 */
	protected $defer = true;

	/**
	 * Register IoC bindings.
	 */
	public function register()
	{
		$method = version_compare(Application::VERSION, '5.2', '>=') ? 'singleton' : 'bindShared';

		// Bind the manager as a singleton on the container.
		$this->app->$method('NoviCMS\LaravelMetatags\MetatagsManager', function($app) {
			// When the class has been resolved once, make sure that settings
			// are saved when the application shuts down.
			if (version_compare(Application::VERSION, '5.0', '<')) {
				$app->shutdown(function($app) {
					$app->make('NoviCMS\LaravelMetatags\MetatagStore')->save();
				});
			}

			/**
			 * Construct the actual manager.
			 */
			return new MetatagsManager($app);
		});

		// Provide a shortcut to the SettingStore for injecting into classes.
		$this->app->bind('NoviCMS\LaravelMetatags\MetatagStore', function($app) {
			return $app->make('NoviCMS\LaravelMetatags\MetatagsManager')->driver();
		});

		if (version_compare(Application::VERSION, '5.0', '>=')) {
			$this->mergeConfigFrom(__DIR__ . '/config/config.php', 'settings');
		}
	}

	/**
	 * Boot the package.
	 */
	public function boot()
	{
		if (version_compare(Application::VERSION, '5.0', '>=')) {
			$this->publishes([
				__DIR__.'/config/config.php' => config_path('metatagssettings.php')
			], 'config');
			$this->publishes([
				__DIR__.'/migrations' => database_path('migrations')
			], 'migrations');
		} else {
			$this->app['config']->package(
				'NoviCMS/l4-metatags', __DIR__ . '/config', 'NoviCMS/l4-metatags'
			);
		}
	}

	/**
	 * Which IoC bindings the provider provides.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array(
			'NoviCMS\LaravelMetatags\MetatagsManager',
			'NoviCMS\LaravelMetatags\MetatagStore',
		);
	}
}
