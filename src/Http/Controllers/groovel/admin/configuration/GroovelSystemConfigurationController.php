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

namespace Groovel\Cmsgroovel\Http\Controllers\groovel\admin\configuration;
use Groovel\Cmsgroovel\business\groovel\admin\configuration\GroovelConfigurationBusinessInterface;
use Illuminate\Database\Eloquent\Model;
use Groovel\Cmsgroovel\Http\Controllers\groovel\admin\common\GroovelController;
use Monolog\Logger;
use Groovel\Cmsgroovel\business\groovel\admin\routes\GroovelRoutesBusiness;
use Groovel\Cmsgroovel\business\groovel\admin\routes\GroovelRoutesBusinessInterface;


class GroovelSystemConfigurationController extends GroovelController {

	protected $configBusiness;
	

	public function __construct( GroovelConfigurationBusinessInterface $configBusiness)
	{
		$this->configBusiness =$configBusiness;
		$this->beforeFilter('auth');
	}
	
	public function validateForm()
	{
		$input = \Input::all();
		if(array_key_exists('function', $input)){
			$function = $input ['function'];
			if ($input ['function'] == 'updateCountryFiles') {
				$this->updateCountryFiles();
			}
			if ($input ['function'] == 'updateCityFiles') {
				$this->updateCityFiles();
			}
			if ($input ['function'] == 'clearHistoryTrackingUser') {
				$this->clearHistoryTrackingUser();
				return $this->jsonResponse(array('history users tracking has been purged'),false,true,false);
			}
		}else if (\Request::is('*/configuration/update_audit')){
			$this->checkToken();
			$this->configBusiness->updateConfigAuditTracking($input['tracking_service'],$input['worldmap_service']);
			return $this->jsonResponse(array('config has been updated'),false,true,false);
		}else if (\Request::is('*/configuration/update_search_engine')){
			$this->checkToken();
			$this->configBusiness->updateConfigElasticSearch($input['elasticsearch_service']);
			return $this->jsonResponse(array('config has been updated'),false,true,false);
		}else if (\Request::is('*/configuration/maintenance')){
			$this->checkToken();
			$this->configBusiness->updateConfigMaintenance($input['maintenance_service']);
			return $this->jsonResponse(array('config has been updated'),false,true,false);
		}else if (\Request::is('*/configuration/email')){
			$this->checkToken();
			$this->configBusiness->updateConfigEmail($input['email_service']);
			\Config::set('mail.pretend',$input['email_service']);
			return $this->jsonResponse(array('config has been updated'),false,true,false);
		}else if(\Request::is('*/configuration/activate/users')){
			$this->checkToken();
			$this->configBusiness->updateEnableUserActivation($input['activate_users']);
			return $this->jsonResponse(array('config has been updated'),false,true,false);
		}
		return $this->processForm();
	}
	
	public function init(){
		\Session::flash('configuration',['elastic'=>$this->configBusiness->isElasticSearchEnable(),
				'maintenance'=>$this->configBusiness->isMaintenanceEnable(),'audit_tracking'=>$this->configBusiness->isUserAuditTrackingEnable()
				,'map_locate'=>$this->configBusiness->isWorldMapLocationEnable()
				,'email'=>$this->configBusiness->isEmailEnable(),'activate_users'=>$this->configBusiness->isEnableUserActivation()
		]);
		return \View::make('cmsgroovel.pages.admin_configuration_system');
	}

	private function processForm(){
		
		
	}
	
	
	
	function isAuditTrackingUserEnable(){
		return $this->configBusiness->isUserAuditTrackingEnable();
	}
	function isMapGeoUserTrackingUserEnable(){
		return $this->configBusiness->isWorldMapLocationEnable();
	}	
	function isMaintenanceWebSiteEnable(){
		return $this->configBusiness->isMaintenanceEnable();
	}
	
	function isEnableUserActivation(){
		return $this->configBusiness->isEnableUserActivation();
	}
	
	function clearHistoryTrackingUser(){
		$this->configBusiness->clearHistoryTrackingUser();
	}
	
	function updateCountryFiles(){
		$this->configBusiness->updateCountryFiles();
		return \Response::json(array('status' => 'ip country table updated',"errors"=>''));
	}
	
	function updateCityFiles(){
		$this->configBusiness->updateCityFiles();
		return \Response::json(array('status' => 'city table updated',"errors"=>''));
	}
	
	public function jsonResponse($param, $print = false, $header = true,$error=false) {
		if (is_array($param) && !$error) {
			$out = array(
					'success' => true
			);
	
			if (array_key_exists('datas',$param) && is_array($param['datas']) ) {
				$out['datas'] = $param['datas'];
				unset($param['datas']);
				$out = array_merge($out, $param);
			} else {
				$out['datas'] = $param;
			}
	
		}else if (is_bool($param) &&!$error) {
			$out = array(
					'success' => $param
			);
		} else if($error) {
			$out = array(
					'success' => false,
					'errors' => array(
							'reason' => $param
					)
			);
		}
	
		$out = json_encode($out);
	
		if ($print) {
			if ($header) header('Content-type: application/json');
	
			echo $out;
			return;
		}
	
		return $out;
	}
	
 }



