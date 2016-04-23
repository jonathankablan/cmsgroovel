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
namespace Groovel\Cmsgroovel\business\groovel\admin\configuration;

interface GroovelConfigurationBusinessInterface{

	public function updateCountryFiles();
	public function updateCityFiles();
	
	public function updateConfigAuditTracking($enableUserTracking,$enableMap);
	public function updateConfigElasticSearch($enableElasticSearch);
	public function updateConfigMaintenance($enableMaintenance);
	public function updateConfigEmail($enableMail);
	public function updateEnableUserActivation($enableUserActivation);
	
	public function isUserAuditTrackingEnable();
	public function isWorldMapLocationEnable();
	public function isElasticSearchEnable();
	public function isMaintenanceEnable();
	public function isEmailEnable();
	public function isEnableUserActivation();
	public function getMaxContentsNumber();
	public function updateMaxNumberContents($maxNumber);
	
	public function clearHistoryTrackingUser();
}


