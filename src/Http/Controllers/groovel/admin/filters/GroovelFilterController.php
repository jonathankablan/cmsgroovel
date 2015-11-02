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

namespace Groovel\Cmsgroovel\Http\Controllers\groovel\admin\filters;
use Illuminate\Database\Eloquent\Model;
use Groovel\Cmsgroovel\Http\Controllers\groovel\admin\common\GroovelController;
use Monolog\Logger;
use Groovel\Cmsgroovel\Http\Controllers\groovel\admin\routes\GroovelRouteController;
use Groovel\Cmsgroovel\Http\Controllers\groovel\admin\users_rules\GroovelUserRulesController;

class GroovelFilterController extends GroovelController {
 
   public function filter(){
  	 try{
  	 	//\Log::info(\Request::path());
 	      $app = App();
 	      $controller = $app->make('Groovel\Cmsgroovel\Http\Controllers\groovel\admin\routes\GroovelRouteController');
 	      $rulesController = $app->make('Groovel\Cmsgroovel\Http\Controllers\groovel\admin\users_rules\GroovelUserRulesController');
	      $route= $controller->getRouteFromSession();
	      //\Log::info($route);
	      $userTrackingController = $app->make('Groovel\Cmsgroovel\Http\Controllers\groovel\admin\users_tracking\GroovelTrackingUserAPI');
	      $configController = $app->make('Groovel\Cmsgroovel\Http\Controllers\groovel\admin\configuration\GroovelSystemConfigurationController');
	      
	      if($configController->isMaintenanceWebSiteEnable()==1){
	      	return \View::make('cmsgroovel.pages.page_maintenance');
	      }
	      //tracking user
	      if( $configController->isAuditTrackingUserEnable()=='1' && $userTrackingController->tracking_ip()!='127.0.0.1' && $route->audit_tracking_url_enable=='1'){
	      	$userTrackingController->saveTrackingUserInfo();
	      }
	     if (\Auth::guest() && isset($route->before_filter)&&$route->before_filter=='yes'){
	      		return \View::make('cmsgroovel.pages.login_form');
	     }
	  	   $params =array('uri'=>\Request::path(),'method'=>$route->method,'controller'=>$route->controller,'view'=>$route->view,'before_filter'=>$route->before_filter,'subtype'=>$route->subtype,'action'=>$route->action);
	 	   $hasAccessForUser=$rulesController->checkAccessRulesURL(\Auth::user(),$params);
	 	 
	 	  // \Log::info($params);
	 	   if($hasAccessForUser&& $route->activate_route=='1'){
		   	return $controller->callAction('dispatcher',array($params));
	 	   }else{
	 	   	return  \View::make('cmsgroovel.pages.pagenotauthorized');
	 	   } 
      }catch (\Exception $ex){
       	   \Log::info($ex);
	   	    return \Redirect::to('undefined');
	   }
	   return $uri;
   }
 
}