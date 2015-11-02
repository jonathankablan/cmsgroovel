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

interface GroovelUserTrackingBusinessInterface{

	public function saveTrackingUserInfo($hostname,$ip,$agent,$ref);

	public function getUserLocationFromIP($ip);
	
	public function getLatitudeLongitude($country,$city);
	
	public function getAllStatsUsers();
	
	public function getTotalUsers();
	
	
	public function getTotalUsersConnectedByDays();
	
	public function getTotalMessage();
	
	public function getTotalUsersByDay();
}


