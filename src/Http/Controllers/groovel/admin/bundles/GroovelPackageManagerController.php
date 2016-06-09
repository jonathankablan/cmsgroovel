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

namespace Groovel\Cmsgroovel\Http\Controllers\groovel\admin\bundles;
use Illuminate\Database\Eloquent\Model;
use Groovel\Cmsgroovel\Http\Controllers\groovel\admin\common\GroovelController;
use models;
use Monolog\Logger;
use Symfony\Component\HttpKernel\Tests\Controller;
use Groovel\Cmsgroovel\business\groovel\admin\bundles\GroovelPackageManagerBusiness;
use Groovel\Cmsgroovel\business\groovel\admin\bundles\GroovelPackageManagerBusinessInterface;


class GroovelPackageManagerController extends GroovelController {
	protected $packageManager;
	
	public function __construct(GroovelPackageManagerBusinessInterface $packageManager) {
		$this->packageManager = $packageManager;
		$this->middleware('auth');
	}
	public function validateForm() {
		$input = \Input::get ( 'q' );
		$function = $input ['function'];
		if ($input ['function'] == 'getStatus') {
			$this->getStatus ();
		} else if ($input ['function'] == 'install') {
			$this->install ( $input ['packageDir'] );
		} else if ($input ['function'] == 'update') {
			$this->update ( $input ['packageDir'] );
		} else if ($input ['function'] == 'dump-autoload') {
			$this->dumpAutoload ( $input ['packageDir'] );
		} else if ($input ['function'] == 'remove') {
			//to do
		}else if ($input ['function'] == 'artisan-cache-clear') {
			$this->artisanCacheClear();
		}else if ($input ['function'] == 'artisan-dump-autoload') {
			$this->artisanDumpAutoload();
		}
		
		return $this->processForm ();
	}
	
	private function processForm() {
	}
	
	function extractComposer()
	{
		if (file_exists('composer.phar'))
		{
			echo 'Extracting composer.phar ...' . PHP_EOL;
			flush();
			$composer = new Phar('composer.phar');
			$composer->extractTo('extracted');
			echo 'Extraction complete.' . PHP_EOL;
		}
		else
			echo 'composer.phar does not exist';
	}
	
	
	function artisanCacheClear() {
		\Cache::flush();
	}
	
	
	function artisanDumpAutoload() {
		ini_set ('max_execution_time', 0);
		\Artisan::call('cache:clear');
	}
	
	function dumpAutoload($jsonDirFile) {
		ini_set ('max_execution_time', 0);
		$this->packageManager->dumpAutoload($jsonDirFile);
	}
	
	function install($jsonDirFile) {
		ini_set ('max_execution_time', 0);
		$this->packageManager->install($jsonDirFile);
	}
	
	function update($jsonDirFile) {
		ini_set ('max_execution_time', 0);
		$this->packageManager->update($jsonDirFile);
	}
		
	function getStatus() {
		return $this->packageManager->getStatus();
	}
   
    
    public function init(){
  		return \View::make('cmsgroovel.pages.admin_list_packages',['packages'=>$this->packageManager->paginatePackage()]);
    }


}
