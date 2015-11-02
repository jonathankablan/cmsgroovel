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

class PermissionServiceProvider extends \Illuminate\View\ViewServiceProvider {
	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 *
	 */
	protected $defer = false;
	/**
	 * Register the service provider.
	 *
	 * @return void
	 *
	 */
	public function register() {
		parent::register ();
		$this->registerBladeExtensions ();
	}
	
	
	/**
	 * Register custom blade extensions.
	 *
	 * @return void
	 *
	 */
	protected function registerBladeExtensions() {
		$blade = $this->app ['view']->getEngineResolver ()->resolve ( 'blade' )->getCompiler ();
		
		$blade->extend ( function ($value, $compiler) {
			$pattern = $compiler->createPlainMatcher ( 'controluseraccess' );
			return preg_replace ( $pattern, '$1<?php Session::get("user"); ?>', $value );
		} );
		$blade->extend ( function ($value, $compiler) {
			$pattern = $compiler->createPlainMatcher ( 'endcontroluseraccess' );
			return preg_replace ( $pattern, '$1<?php echo "test2"; ?>$2', $value );
		} );
		
	}
}
