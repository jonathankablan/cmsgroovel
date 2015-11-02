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
namespace Groovel\Cmsgroovel\business\groovel\admin\trackers;
use Illuminate\Database\Eloquent\Model;
use models;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Connection;
use Monolog\Logger;
use Groovel\Cmsgroovel\business\groovel\admin\trackers\GroovelUserTrackingBusinessInterface;
use Groovel\Cmsgroovel\dao\UserDao;
use Groovel\Cmsgroovel\dao\UserDaoInterface;
use Groovel\Cmsgroovel\dao\CountryDao;
use Groovel\Cmsgroovel\dao\CountryDaoInterface;
use Groovel\Cmsgroovel\dao\LocationIPCitiesDao;
use Groovel\Cmsgroovel\dao\LocationGeoCitiesDao;
use Groovel\Cmsgroovel\dao\LocationIPCitiesDaoInterface;
use Groovel\Cmsgroovel\dao\LocationGeoCitiesDaoInterface;
use Groovel\Cmsgroovel\dao\UserTrackingDao;
use Groovel\Cmsgroovel\dao\UserTrackingDaoInterface;
use Groovel\Cmsgroovel\dao\StatsUsersGeolocationDao;
use Groovel\Cmsgroovel\dao\StatsUsersGeolocationDaoInterface;
use Groovel\Cmsgroovel\dao\LocationGeoCountriesDao;
use Groovel\Cmsgroovel\dao\LocationGeoCountriesDaoInterface;
use Groovel\Cmsgroovel\dao\MessageDao;
use Groovel\Cmsgroovel\dao\MessageDaoInterface;

class GroovelUserTrackingBusiness implements GroovelUserTrackingBusinessInterface{

	private $locationIPDao;
	
	private $locationGeoCitiesDao;
	
	private $userTrackingDao;
	
	private $statsUsersGeolocationDao;
	
	private $locationGeoCountriesDao;
	
	private $countriesDao;
	
	private $userDao;
	
	private $messageDao;
	
	public function __construct(LocationIPCitiesDaoInterface $locationIPDao, LocationGeoCitiesDaoInterface $locationGeoCitiesDao,UserTrackingDaoInterface $userTrackingDao
			,StatsUsersGeolocationDaoInterface $statsUsersGeolocationDao,CountryDaoInterface $countriesDao
			, LocationGeoCountriesDaoInterface $locationGeoCountriesDao,UserDaoInterface $userDao,MessageDaoInterface $messageDao)
	{
	
		$this->locationIPDao=$locationIPDao;
		$this->locationGeoCitiesDao=$locationGeoCitiesDao;
		$this->userTrackingDao=$userTrackingDao;
		$this->statsUsersGeolocationDao=$statsUsersGeolocationDao;
		$this->countriesDao=$countriesDao;
		$this->locationGeoCountriesDao=$locationGeoCountriesDao;
		$this->userDao=$userDao;
		$this->messageDao=$messageDao;
	}
	
	public function getTotalUsers(){
		return $this->userDao->getTotalUsers();
	}
	
	public function getTotalUsersConnectedByDays(){
		return $this->userDao->getTotalUsersConnectedByDays();
	}
	
	
	public function getTotalMessage(){
		return $this->messageDao->getTotalMessage();
	}
	
	public function saveTrackingUserInfo($hostname,$ip,$agent,$ref){
		$result=$this->userTrackingDao->get($ip, $hostname, $ref);
		$isAlreadyStatsExist=false;
		if(!empty($result) && count($result)!=0){
			$this->userTrackingDao->update($ip, $hostname, $ref);
		}else{
			$this->userTrackingDao->save($ip,$hostname,$ref,$agent);
		}
		$res=$this->locationIPDao->Lookup($ip);
		//\Log::info($res->city);
		//\Log::info($res->country);
		$countryName=null;
		$city=null;
		$latitude=null;
		$longitude=null;
		if($res!=null){
			$countryName=$this->countriesDao->find($res->country);
			if($countryName!=null){
				$city=$res->city;
				$lat_long=$this->locationGeoCitiesDao->find($countryName['name_en'],$res->city);
				if($lat_long!=null && !empty($lat_long) && count($lat_long)>0){
					$latitude=$lat_long[0]['latitude'];
					$longitude=$lat_long[0]['longitude'];
				}
				else{//we get latitude and longitude of country if cities not found
					//\Log::info($res->country);
					$lat_long=$this->locationGeoCountriesDao->find($res->country);
					//\Log::info($lat_long);
					if($lat_long!=null && !empty($lat_long) && count($lat_long)>0){
						$latitude=$lat_long['latitude'];
						$longitude=$lat_long['longitude'];
					}
				}
			}
			$stats=$this->statsUsersGeolocationDao->getByCountryAndCity($res->country,$city);
			if($stats==null){
				$this->saveStatsUsers($countryName['name_en'],$res->country,$city,1,$latitude,$longitude);
			}else if(!$this->userTrackingDao->checkExist($ip)){
				$this->updateStatsUsers($countryName['name_en'],$res->country,$city,$latitude,$longitude);
			}
		}
		//\Log::info($res->country.' '. $res->city);
	}
	
	public function getUserLocationFromIP($ip){
		return $this->locationIPDao->Lookup($ip);
	}
	
	public function getLatitudeLongitude($country,$city){
		return $this->locationGeoCitiesDao->find($country,$city);
	}
	
	public function saveStatsUsers($country,$countryCodeIso,$city,$countPeople,$latitude,$longitude){
		return $this->statsUsersGeolocationDao->save($country,$countryCodeIso,$city,$countPeople,$latitude,$longitude);
	}
	
	public function updateStatsUsers($country,$countryCodeIso,$city,$latitude,$longitude){
		$this->statsUsersGeolocationDao->update($country,$countryCodeIso,$city,$latitude,$longitude);
	}
	
	public function getAllStatsUsers(){
		return $this->statsUsersGeolocationDao->getAllStatsUsers();
	}
	
	public function getTotalUsersByDay(){
		return $this->statsUsersGeolocationDao->getTotalUsersByDay();
	}
}