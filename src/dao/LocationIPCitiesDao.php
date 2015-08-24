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

class Groovel_Exception extends \Exception {

}


class LocationIPCitiesDao implements \LocationIPCitiesDaoInterface{
	
	public function update(){}

	public function Lookup($addr) {
		if ($ret = $this->Do_Lookup('location_ip_cities', self::Addr_Type($addr), inet_pton($addr))) {
			$ret->ip_start = inet_ntop($ret->ip_start);
			$ret->ip_end = inet_ntop($ret->ip_end);
			return $ret;
		} else {
			return null;
		}
	
	}
	
	protected function Do_Lookup($table_name, $addr_type, $addr_start) {
		$db=\DB::connection()->getPdo();
		$q = $db->prepare("select * from `{$table_name}` where addr_type = ? and ip_start <= ? order by ip_start desc limit 1");
		$q->execute(array($addr_type, $addr_start));
		return $q->fetchObject();
	}
	
	static private function Addr_Type($addr) {
	
		if (ip2long($addr) !== false) {
			return "ipv4";
		} else if (preg_match('/^[0-9a-fA-F:]+$/', $addr) && @inet_pton($addr)) {
			return "ipv6";
		} else {
			return null;
		}
	
	}
}