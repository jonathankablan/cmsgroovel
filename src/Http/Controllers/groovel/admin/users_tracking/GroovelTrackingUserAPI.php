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

namespace Groovel\Cmsgroovel\Http\Controllers\groovel\admin\users_tracking;
use Groovel\Cmsgroovel\business\groovel\admin\trackers\GroovelUserTrackingBusinessInterface;
class GroovelTrackingUserAPI implements GroovelTrackingUserInterface {
	
	private $userTrackingManager;
	
	public function __construct(GroovelUserTrackingBusinessInterface $userTrackingManager)
	{
	
		$this->userTrackingManager=$userTrackingManager;
	}
	
	public function saveTrackingUserInfo(){
		$hostname=$this->tracking_hostname();
		$ip=$this->tracking_ip();
		$agent=$this->tracking_agent();
		$ref=$this->tracking_ref();
		//$ip='184.160.213.209';
		$this->userTrackingManager->saveTrackingUserInfo($hostname,$ip,$agent,$ref);
	}
	
	private function tracking_ref(){
		/*if(array_key_exists('HTTP_REFERER', $_SERVER)){
			return $_SERVER['HTTP_REFERER'];
		}else return '';*/
		return \Request::path();
	}
	
	private function tracking_agent(){
		return $_SERVER['HTTP_USER_AGENT'];
	}
	
	public function tracking_ip(){
		return $_SERVER['REMOTE_ADDR'];
	}
	
	private function tracking_hostname(){
		return gethostbyaddr($_SERVER['REMOTE_ADDR']);
	}
	
	public function geoloc_ip_locally($ip){
		$res=$this->userTrackingManager->getUserLocationFromIP($ip);
		return $this->userTrackingManager->getLatitudeLongitude($res['country'],$res['city']);
	}
	
	
	public function geoloc_ip_remotely($input){
		$ip = ''.$_SERVER['REMOTE_ADDR'].'';
		$s = file_get_contents(\Config::get('groovel.locateGPS').'/'.$ip);
		switch($s[0])
		{
			case '0':
				return 0;//'Something wrong';
				break;
			case '1':
				$reply = explode(';',$s);
				return $reply;
				break;
			case '2':
				 return 2; //'Not found in database';
				break;
		}
	}
	

	
}