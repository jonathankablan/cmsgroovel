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

namespace Groovel\Cmsgroovel\dao;

use \Carbon\Carbon;
use Groovel\Cmsgroovel\models\StatsUserLocation;

class StatsUsersGeolocationDao implements StatsUsersGeolocationDaoInterface{

	public function save($country,$countryCodeIso,$city,$countPeople,$latitude,$longitude){
		 $stats=new StatsUserLocation;
		 $stats->country=$country;
		 $stats->country_code_iso=$countryCodeIso;
		 $stats->city=$city;
		 $stats->people=$countPeople;
		 $stats->latitude=$latitude;
		 $stats->longitude=$longitude;
		 $stats->save();
		
	}
	
	public function getByCountryAndCity($countryCodeIso,$city){
	   return StatsUserLocation::where('country_code_iso','=',$countryCodeIso)->where('city','=',$city)->first();
	}
	
	public function getByCountry($countryCodeIso){
		return StatsUserLocation::where('country_code_iso','=',$countryCodeIso)->get();
	}
	
	public function update($country,$countryCodeIso,$city,$latitude,$longitude){
		$stats=StatsUserLocation::where('country_code_iso','=',$countryCodeIso)->where('city','=',$city)->first();
		$stats->people=$stats->people+1;
		$stats->save();
	}
	
	public function getAllStatsUsers(){
		$res= StatsUserLocation::where('isarchived','!=',1)->get();
		return $res;
	}

	public function archivedStats(){
		$pdo=\DB::connection()->getPdo();
		$pdo->beginTransaction();
		$pdo->setAttribute(\PDO::ATTR_EMULATE_PREPARES, false);
		//UPDATE `routes_groovel` SET `audit_tracking_url_enable`=1
		$now=\Carbon\Carbon::now();
		$q=$pdo->prepare("update stats_users_location set isarchived=1,archived_at= " .'\''.$now.'\''.' where isarchived!=1'   );
		$q->execute();
		$pdo->commit();
		$pdo->beginTransaction();
		$q=$pdo->prepare("delete from user_tracking");
		$q->execute();
		$pdo->commit();
		
		
		
	}
	
	public function getTotalUsersByDay(){
		$pdo=\DB::connection()->getPdo();
		$pdo->beginTransaction();
		$pdo->setAttribute(\PDO::ATTR_EMULATE_PREPARES, false);
		$q=$pdo->prepare("SELECT created_at as 'date',SUM(people) as 'number' FROM `stats_users_location` group by country");
		$q->execute();
		$res=$q->fetchAll(\PDO::FETCH_ASSOC);
		$pdo->commit();
		return $res;
	}

}