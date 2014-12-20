<?php namespace Nielsen\Rbac;

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\AliasLoader;

class RbacServiceProvider extends ServiceProvider {

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
		$this->registerCommands();
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array();
	}

	public function boot()
	{
		$this->package('nielsen/rbac');

		AliasLoader::getInstance()->alias('Rbac','Nielsen\Rbac\Rbac');

		require 'global.php';
	}

	public function registerCommands()
	{
		foreach(Command::allCommands() as $command) {
			$this->app[$command->command] = $this->app->share(function() use ($command) {
				return \App::make($command->path);
			});

			$this->commands($command->command);
		}
	}

}
