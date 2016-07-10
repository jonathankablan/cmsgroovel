<?php
/**********************************************************************/
/*This file is part of Groovel.                                       */
/*Groovel is free software: you can redistribute it and/or modify     */
/*it under the terms of the GNU General Public License as published by*/
/*the Free Software Foundation, either version 2 of the License, or   */
/*(at your option) any later version.                                 */
/*Groovel is distributed in the hope that it will be useful,          */
/*but WITHOUT ANY WARRANTY; without even the implied warranty of      */
/*MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the       */
/*GNU General Public License for more details.                        */
/*You should have received a copy of the GNU General Public License   */
/*along with Groovel.  If not, see <http://www.gnu.org/licenses/>.    */
/**********************************************************************/

namespace Groovel\Cmsgroovel;

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\Application;
use Monolog\Logger;
use Groovel\Cmsgroovel\config\install\groovel\database\InstallDatabase;

class CmsgroovelServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->mergeConfigFrom(
				__DIR__.'/Http/groovel.php', 'groovel'
		);
		
		
		
			// Get namespace
		$nameSpace = $this->app->getNamespace();
		
		// Routes
		$this->app->router->group(['namespace' => $nameSpace . 'Http\Controllers'], function()
		{
			require __DIR__.'/Http/routes.php';
			require __DIR__.'/Http/groovel.php';
		});
		
		$this->app->router->group(['namespace' => $nameSpace . 'Http\Middlewares'], function()
		{
			//require __DIR__.'/Http/Kernel.php';
		});
		
		// Views
		$this->publishes([
				__DIR__.'/../views' => base_path('resources/views/cmsgroovel'),
		]);
		
		$this->publishes([
				__DIR__.'/../public/groovel' => base_path('public/groovel'),
		]);
		
		$this->publishes([
				__DIR__.'/../public/images' => base_path('public/images'),
		]);
		
		$this->publishes([
				__DIR__.'/../starter-templates' => base_path('starter-templates'),
		]);
		
		$this->publishes([
				__DIR__.'/../starter-templates/layouts/blog/base' => base_path('resources/views/blog/base'),
		]);
		
		$this->publishes([
				__DIR__.'/../starter-templates/layouts/blog/includes' => base_path('resources/views/blog/includes'),
		]);
		
		$this->publishes([
				__DIR__.'/../starter-templates/layouts/blog/pages' => base_path('resources/views/blog/pages'),
		]);
		
		$this->publishes([
				__DIR__.'/../starter-templates/layouts/blog/styles' => base_path('public/blog/styles'),
		]);
		
		//include __DIR__.'/Http/Kernel.php';
		include __DIR__.'/Http/routes.php';
		include __DIR__.'/Http/groovel.php';
		$this->loadViewsFrom(__DIR__.'/../../views', 'cmsgroovel');
		
		$dbinstall=new InstallDatabase;
		$dbinstall->installDB();
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app['cmsgroovel'] = $this->app->share(function($app)
	    {
	        return new Cmsgroovel;
	    });
	
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array('GroovelRouteController');
	}

}
