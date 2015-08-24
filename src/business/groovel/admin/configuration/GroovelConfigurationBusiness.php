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

namespace business\groovel\admin\configuration;
use Illuminate\Database\Eloquent\Model;
use models;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Connection;
use dao\ConfigurationDaoInterface;
use dao\ConfigurationDao;
use dao\StatsUsersGeolocationDaoInterface;
use dao\StatsUsersGeolocationDao;

class GroovelConfigurationBusiness implements \GroovelConfigurationBusinessInterface{
	
	private $systemDao;
	
	private $statsUsersGeolocationDao;

	public function __construct(\ConfigurationDaoInterface $systemDao,\StatsUsersGeolocationDaoInterface $statsUsersGeolocationDao)
	{
		$this->systemDao =$systemDao;
		$this->statsUsersGeolocationDao=$statsUsersGeolocationDao;
	}
	
	public function updateEnableUserActivation($enableUserActivation){
		$this->systemDao->updateEnableUserActivation($enableUserActivation);
	}
	
	public function isEnableUserActivation(){
		return $this->systemDao->isEnableUserActivation();
	}
	
	public function updateCountryFiles(){
		\Log::info('updateCountryFilesf');
		//$filename_path=public_path().'dbip-city.csv';
		$this->systemDao->importCountryData(public_path().'\\files\\'.'dbip-city.csv','2', "location_ip" , null);
		
		\Log::info('exit updateCountryFiles');
	}

	public function updateCityFiles(){
		$this->systemDao->importCityData(public_path().'\\files\\'.'World_Cities_Location_table.csv');
		
	}
	
	public function updateConfigAuditTracking($enableUserTracking,$enableMap){
		$this->systemDao->updateConfigAuditTracking($enableUserTracking,$enableMap);
	}
	
	public function updateConfigElasticSearch($enableElasticSearch){
		$this->systemDao->updateConfigElasticSearch($enableElasticSearch);
	}
	
	public function updateConfigMaintenance($enableMaintenance){
		$this->systemDao->updateConfigMaintenance($enableMaintenance);
	}
	
	public function updateConfigEmail($enableMail){
		$this->systemDao->updateConfigMail($enableMail);
	}
	
	public function isUserAuditTrackingEnable(){
		return $this->systemDao->isUserAuditTrackingEnable();
	}
	public function isWorldMapLocationEnable(){
		return $this->systemDao->isWorldMapLocationEnable();
	}
	public function isElasticSearchEnable(){
		return $this->systemDao->isElasticSearchEnable();
	}
	public function isMaintenanceEnable(){
		return $this->systemDao->isMaintenanceEnable();
	}
	public function isEmailEnable(){
		return $this->systemDao->isEmailEnable();
	}
	
	public function clearHistoryTrackingUser(){
		$this->statsUsersGeolocationDao->archivedStats();
	}
	
}