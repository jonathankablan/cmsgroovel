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

class UserTrackingDao implements \UserTrackingDaoInterface{
	
	static private function Addr_Type($addr) {
		
			if (ip2long($addr) !== false) {
				return "ipv4";
			} else if (preg_match('/^[0-9a-fA-F:]+$/', $addr) && @inet_pton($addr)) {
				return "ipv6";
			} else {
				throw new DBIP_Exception("unknown address type for {$addr}");
			}
		
	}

	public function update($ip,$hostname,$ref) {
		$result=\UserTracking::where('ip','=',inet_pton($ip))->where('hostname', '=', $hostname)->where('ref', '=', $ref)->first();
		$track=\UserTracking::find($result['id']);
		$track->count=$track->count+1;
		$track->save();
	}
	
	public function get($ip,$hostname,$ref) {
		$result=\UserTracking::where('ip','=',inet_pton($ip))->where('hostname', '=', $hostname)->where('ref', '=', $ref)->get();
		return $result;
	}
	
	public function save($ip,$hostname,$ref,$agent){
		$result=new \UserTracking();
		$result->hostname=$hostname;
		$ipv = inet_pton($ip);
		$result->addr_type=self::Addr_Type($ip);
		$result->ip=$ipv;
		$result->agent=$agent;
		$result->ref=$ref;
		$result->count=1;
		$result->save();
	}

	public function checkExist($ip){
		$result=\UserTracking::where('ip','=',inet_pton($ip))->get();
		if($result!=null && count($result)>0){
			return true;
		}else return false;
	}

	public function getAllIps(){
		return \UserTracking::all();
	}
}