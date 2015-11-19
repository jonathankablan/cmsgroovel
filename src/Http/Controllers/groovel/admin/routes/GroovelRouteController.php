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

namespace Groovel\Cmsgroovel\Http\Controllers\groovel\admin\routes;
use Illuminate\Database\Eloquent\Model;
use Groovel\Cmsgroovel\Http\Controllers\groovel\admin\common\GroovelController;
use Monolog\Logger;
use Groovel\Cmsgroovel\business\groovel\admin\routes\GroovelRoutesBusiness;
use Groovel\Cmsgroovel\business\groovel\admin\routes\GroovelRoutesBusinessInterface;


class GroovelRouteController extends GroovelController {

	protected $routeBusiness;
	

	public function __construct( GroovelRoutesBusinessInterface $routeBusiness)
	{
		$this->routeBusiness =$routeBusiness;
	}
	
	
	private function buildRouteGroovelFromInput(){
		$routegroovel->domain=Input::get('domain');
    	$routegroovel->uri=Input::get('uri');
    	$routegroovel->name=Input::get('name');
    	$routegroovel->controller=Input::get('controller');
    	$routegroovel->method=Input::get('method');
    	$routegroovel->action=Input::get('action');
    	$routegroovel->view=Input::get('view');
    	$routegroovel->before_filter=Input::get('before_filter');
    	$routegroovel->after_filter=Input::get('after_filter');
    	$routegroovel->audit_tracking_url_enable=Input::get('audit_tracking_url_enable');
       	return $routegroovel;	
	} 

	public function getRouteFromSession(){
     $uri=\Request::path();
	$route=null;
     try {
	       	if (\Cache::has($uri)){
	       		$route=\Cache::get($uri);
	       		return $route;
	       	}
	       	else{
	       		$route=$this->routeBusiness->getRouteByUri($uri);
	       		if ($route==null){
	       			$route=\Cache::get('undefined');
	       			return $route;
	       		}else{
	       			\Cache::put($uri,$route);
	       			return $route;
	       		}
	       	}
         }catch(\Exception $ex){
        	\Log::info($ex);
         }
  	}

	public function dispatcher($params)
	{
	//init the uri and controller to call and view put in memory simple singleton
		if($params['controller']!=null){
			$app = App();
		    $controller = $app->make($params['controller']);
		    return $controller->callAction($params['method'],array('view'=>$params['view']));
		}
		if($params['view']=='cmsgroovel.pages.login_form' && !\Auth::guest()){
			return \View::make('cmsgroovel.pages.welcome');
		}
		
		//overload the view
		$view=$params['view'];
		if(array_key_exists('view', \Input::all())){
			$view=\Input::get('view');
		}
		
		return \View::make($view);
	}

	public function showRoutes(){
		$routesAll=$this->routeBusiness->paginateRoutes();
 		return \View::make('cmsgroovel.pages.admin_list_routes',['routesAll'=>$routesAll]);
 	}
 	
 	public function showOnlyRoutesUser(){
 		$routesAll=$this->routeBusiness->paginateRoutesOnlyUser();
 		return \View::make('cmsgroovel.pages.admin_list_routes',['routesAll'=>$routesAll]);
 	}

	public function clearRoutesCache(){
		\Cache::flush();
 	}
 	
 	public function getRouteByViewName($view){
 		$route=$this->routeBusiness->getRouteByViewName($view);
 		return $route;
 	}
}



