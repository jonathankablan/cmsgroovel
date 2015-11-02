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

namespace Groovel\Cmsgroovel\business\groovel\admin\bundles;
use Illuminate\Database\Eloquent\Model;
use models;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Connection;
use Illuminate\Pagination\Paginator;
use Monolog\Logger;
use Groovel\Cmsgroovel\business\groovel\admin\bundles\GroovelPackageManagerBusinessInterface;
use Groovel\Cmsgroovel\business\groovel\admin\bundles\DTD_COMPOSER;
use Composer\Composer\Console\Application;
use Composer\Composer\Command\UpdateCommand;
use Symfony\Component\Console\Input\ArrayInput;
use Illuminate\Pagination\LengthAwarePaginator;

class GroovelPackageManagerBusiness implements GroovelPackageManagerBusinessInterface{

	private static $PACKAGES_DIR=array();
	
	private static $PACKAGES_DIR_LIST=array();
	
	private static $PACKAGES="BUNDLES";
	
	private static $perPage = 5;
	
	
	public function getPathJson($dir) {
		$isjson = file_exists ( $dir . '/composer.json' );
		$res=array();
		if (! $isjson) {
			$directories = glob ( $dir . '/*' );
			if (empty ( $directories )) {
				return array ();
			}
			foreach ( $directories as $directory ) {
				//\Log::info ( $directory  );
				$result = $this->getPathJson ( $directory );
			}
		} else if ($isjson) {
			$exp = explode ( "/", $dir );
			$key = $exp [sizeof ( $exp ) - 1];
			if (array_key_exists ( $key, self::$PACKAGES_DIR )) {
				$key = $exp [sizeof ( $exp ) - 2] . '\\' . $exp [sizeof ( $exp ) - 1];
			}
			self::$PACKAGES_DIR [$key]=$dir;
			return self::$PACKAGES_DIR;
		} else {
			\Log::info ( 'nothing' );
		}
	}
	
	public function getPathWhereComposerJsonFile($path) {
		$package_directories = glob ( $path . '/vendor/*', GLOB_ONLYDIR );
		$package_directories_workspace = glob ( $path . '/packages/*', GLOB_ONLYDIR );
		//\Log::info($path . '/workbench/*');
		$res=array_merge($package_directories,$package_directories_workspace);
		
		$i = 0;
		foreach ( $res as $package ) {
			$this->getPathJson ( $package );
			$i++;
		}
		return self::$PACKAGES_DIR;
	}
	
	public static function parseJson($pathToJsonFile) {
		$json = file_get_contents ( $pathToJsonFile. '/composer.json' );
		$json_a = json_decode ( $json, true );
		$composer=new ComposeJson;
		$composer->pathComposerJson=$pathToJsonFile;
		//\Log::info($composer->pathComposerJson);
		if(!empty($json_a)){
			foreach ( $json_a as $key => $value ) {
				if (DTD_COMPOSER::$name == $key) {
					$composer->name=$value;
				}
				if (DTD_COMPOSER::$authors == $key) {
					$composer->authors=$value;
				}
				if (DTD_COMPOSER::$description == $key) {
					$composer->description= $value;
				}
				if (DTD_COMPOSER::$require == $key) {
					$composer->require=$value;
				}
				if (DTD_COMPOSER::$requiredev== $key) {
					$composer->requireDev= $value;
				}
			}
		}
		return $composer;
	}
	
	public function extractComposer()
	{
		if (file_exists(public_path() . '/packages/packagemanager/composer/composer.phar' ))
		{
			echo 'Extracting composer.phar ...' . PHP_EOL;
			flush();
			$flags=null;
			$alias=null;
			$fileformat=null;
			$composer = new \Phar(public_path() . '/packages/packagemanager/composer/composer.phar');//Phar(public_path() . '/packages/packagemanager/composer/composer.phar');
			$composer->extractTo('c:\\tmp');
			echo 'Extraction complete.' . PHP_EOL;
		}
		else
			echo 'composer.phar does not exist';
	}
	
	public function getStatus() {
		$output = array (
				'composer' => file_exists ( public_path() . '/packages/packagemanager/composer/composer.phar' )
		);
		header ( "Content-Type: text/json; charset=utf-8");
		echo json_encode($output);
	}
	
	public function paginatePackage(){
		$items=\Cache::get(self::$PACKAGES);
		if(empty($items)){
			$packages=$this->getPathWhereComposerJsonFile(base_path ());
			$bundles=array();
			foreach ($packages as $package){
				$bundles[$package]=self::parseJson($package);
			}
			//\Log::info($bundles);
			\Cache::forever(self::$PACKAGES,$bundles);
			 $items=\Cache::get(self::$PACKAGES);
			
		}
		
		$currentPage = \Input::get('page') - 1;
		$pagedData = array_slice( $items, $currentPage * self::$perPage, self::$perPage);
		 //$items = Paginator::make($pagedData, count( $items), self::$perPage);
		$currentPage = LengthAwarePaginator::resolveCurrentPage() ?: 1;
		$paginator = new LengthAwarePaginator($pagedData, count( $items),  self::$perPage, $currentPage, [
				'path'  => Paginator::resolveCurrentPath()
				
		]);
		//$items= new Paginator( $pagedData, self::$perPage,count( $items));
		
		return $paginator;
	}
	
	function dumpAutoload($jsonDirFile) {
		//Create the commands
		$input = new ArrayInput(array('command' => 'dump-autoload'));
		chdir($jsonDirFile);
		putenv('COMPOSER_HOME=' . $jsonDirFile);
		$input = new \Symfony\Component\Console\Input\StringInput($input .' -vvv ' );
		$output = new \Symfony\Component\Console\Output\StreamOutput(fopen(storage_path().'/logs/packages.log','w'));
		$app = new \Composer\Console\Application();
		$app->setAutoExit(false);
		$app->run($input,$output);
		\Log::info("Done.");
	}
	
	function install($jsonDirFile) {
		$input = new ArrayInput(array('command' => 'install'));
		chdir($jsonDirFile);
		putenv('COMPOSER_HOME=' . $jsonDirFile);
		$input = new \Symfony\Component\Console\Input\StringInput($input .' -vvv ' );
		$output = new \Symfony\Component\Console\Output\StreamOutput(fopen(storage_path().'/logs/packages.log','w'));
		$app = new \Composer\Console\Application();
		$app->setAutoExit(false);
		$app->run($input,$output);
		\Log::info("Done.");
	}
	
	function update($jsonDirFile) {
		$input = new ArrayInput(array('command' => 'update'));
		chdir($jsonDirFile);
		putenv('COMPOSER_HOME=' . $jsonDirFile);
		$input = new \Symfony\Component\Console\Input\StringInput($input .' -vvv ' );
		$output = new \Symfony\Component\Console\Output\StreamOutput(fopen(storage_path().'/logs/packages.log','w'));
		$app = new \Composer\Console\Application();
		$app->setAutoExit(false);
		$app->run($input,$output);
		\Log::info("Done.");
	}
	
	
	
	
	
	
	
	
	
	
	
	
	 
	
}