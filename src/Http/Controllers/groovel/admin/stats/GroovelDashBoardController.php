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
namespace Groovel\Cmsgroovel\Http\Controllers\groovel\admin\stats;
use Illuminate\Database\Eloquent\Model;
use Groovel\Cmsgroovel\Http\Controllers\groovel\admin\common\GroovelController;
use Monolog\Logger;
use Groovel\Cmsgroovel\business\groovel\admin\routes\GroovelRoutesBusiness;
use Groovel\Cmsgroovel\business\groovel\admin\routes\GroovelRoutesBusinessInterface;
use Groovel\Cmsgroovel\business\groovel\admin\trackers\GroovelUserTrackingBusiness;
use Groovel\Cmsgroovel\business\groovel\admin\trackers\GroovelUserTrackingBusinessInterface;


class GroovelDashBoardController extends GroovelController {

	private $userTrackingManager;
	
	public function __construct(GroovelUserTrackingBusinessInterface $userTrackingManager)
	{
	
		$this->userTrackingManager=$userTrackingManager;
		$this->beforeFilter('auth');
	}
	
	public function getUsersLocation(){
		$users=$this->userTrackingManager->getAllStatsUsers();
		$headers=array('Content-type'=> 'application/json; charset=utf-8');
		$jsonarray=array();
		foreach($users as $user){
			$jsondata=json_encode(array('id'=>$user['id'],'country'=>$user['country'],'city'=>$user['city'],'latitude'=>$user['latitude'],'longitude'=>$user['longitude'],'city'=>$user['city'],'people'=>$user['people']));
			array_push($jsonarray, $jsondata);
		}
		return \Response::json(json_encode($jsonarray));
	}
	
	public function init(){
		return  \View::make('cmsgroovel.pages.dashboard',['total_users'=>$this->userTrackingManager->getTotalUsers(),
				'total_users_connected'=>$this->userTrackingManager->getTotalUsersConnectedByDays(),'total_message'=>$this->userTrackingManager->getTotalMessage()]);
	}
	
	public function getTotalUsersByDay(){
		$users=$this->userTrackingManager->getTotalUsersByDay();
		$headers=array('Content-type'=> 'application/json; charset=utf-8');
		$jsonarray=array();
		foreach($users as $user){
			$jsondata=json_encode($user);
			array_push($jsonarray, $jsondata);
		}
		return \Response::json(json_encode($jsonarray));
	}
		
	
 }



