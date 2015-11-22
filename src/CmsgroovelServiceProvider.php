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
		
		// Views
		$this->publishes([
				__DIR__.'/../views' => base_path('resources/views/cmsgroovel'),
		]);
		
		$this->publishes([
				__DIR__.'/../public/packages' => base_path('public/packages'),
		]);
		
		$this->publishes([
				__DIR__.'/../templates' => base_path('templates'),
		]);
		
		include __DIR__.'/Http/routes.php';
		include __DIR__.'/Http/groovel.php';
		$this->loadViewsFrom(__DIR__.'/../../views', 'cmsgroovel');
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
