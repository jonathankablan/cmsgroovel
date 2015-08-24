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
namespace dao;
use dbip\Dbip;
use dbip\DBIP_Exception;
use dbip\DbLocateCities;
use dbip\DbLocateCountries;

class ConfigurationDao implements \ConfigurationDaoInterface{

	/*public function importCountryData($filename, $type, $table_name , $progress_callback = null){
		$pdo=\DB::connection()->getPdo();
		$dbip=new Dbip($pdo);
		$nrecs =$dbip->Import_From_CSV($filename, Dbip::TYPE_CITY, $table_name , function($progress) {
		\Log::info( "progress ...");
	});
		\Log::info("\rfinished importing ' .$nrecs.' 'records\n");
	
	}*/

	
	public function importCityData($filename){
		/*$pdo=\DB::connection()->getPdo();
		$dbip=new DbLocateCities($pdo);
		$nrecs =$dbip->Import_From_CSV($filename);
		\Log::info("\rfinished importing ' .$nrecs.' 'records\n");*/
	
	}
	
	public function importCountryData($filename, $type, $table_name , $progress_callback = null){
		/*$pdo=\DB::connection()->getPdo();
		$dbip=new DbLocateCountries($pdo);
		$nrecs =$dbip->Import_From_CSV(public_path().'\\files\\'.'country_latlon.csv');
		\Log::info("\rfinished importing ' .$nrecs.' 'records\n");*/
	
	}
	
	public function updateConfigAuditTracking($enableUserTracking,$enableMap){
		$config=\Configuration::find(0);
		if($config==null){
			$config = new \Configuration();
		}
		$config->enable_user_tracking=$enableUserTracking;
		$config->enable_map_location=$enableMap;
		$config->save();
	}
	
	public function updateConfigElasticSearch($enableElasticSearch){
		$config=\Configuration::find(0);
		if($config==null){
			$config = new \Configuration();
		}
		$config->enable_elasticsearch=$enableElasticSearch;
		$config->save();
	}
	
	
	public function updateConfigMaintenance($enableMaintenance){
		$config=\Configuration::find(0);
		if($config==null){
			$config = new \Configuration();
		}
		$config->enable_maintenance=$enableMaintenance;
		$config->save();
	}
	
	public function updateConfigMail($enableMail){
		$config=\Configuration::find(0);
		if($config==null){
			$config = new \Configuration();
		}
		$config->enable_email=$enableMail;
		$config->save();
	}
	
	public function updateEnableUserActivation($enableUserActivation){
		$config=\Configuration::find(0);
		if($config==null){
			$config = new \Configuration();
		}
		$config->enable_user_activation=$enableUserActivation;
		$config->save();
	}
	
	public function isEnableUserActivation(){
		$config=\Configuration::find(0);
		return $config->enable_user_activation;
	}

	public function isUserAuditTrackingEnable(){
		$config=\Configuration::find(0);
		return $config->enable_user_tracking;
	}
	public function isWorldMapLocationEnable(){
		$config=\Configuration::find(0);
		return $config->enable_map_location;
	}
	public function isElasticSearchEnable(){
		$config=\Configuration::find(0);
		return $config->enable_elasticsearch;
	}
	
	public function isMaintenanceEnable(){
		$config=\Configuration::find(0);
		return $config->enable_maintenance;
	}
	
	public function isEmailEnable(){
		$config=\Configuration::find(0);
		return $config->enable_email;
	}

}