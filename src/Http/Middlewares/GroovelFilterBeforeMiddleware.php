<?php
namespace  Groovel\Cmsgroovel\Http\Middlewares;

use Closure;
use Monolog\Logger;
use Illuminate\Database\Eloquent\Model;
use Groovel\Cmsgroovel\Http\Controllers\groovel\admin\common\GroovelController;
use Groovel\Cmsgroovel\Http\Controllers\groovel\admin\routes\GroovelRouteController;
use Groovel\Cmsgroovel\Http\Controllers\groovel\admin\users_rules\GroovelUserRulesController;

class GroovelFilterBeforeMiddleware
{
	/**
	 * Run the request filter.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		try{
			$app = App();
			$controller = $app->make('Groovel\Cmsgroovel\Http\Controllers\groovel\admin\routes\GroovelRouteController');
			$rulesController = $app->make('Groovel\Cmsgroovel\Http\Controllers\groovel\admin\users_rules\GroovelUserRulesController');
			$route= $controller->getRouteFromSession();
			//\Log::info($route);
			$userTrackingController = $app->make('Groovel\Cmsgroovel\Http\Controllers\groovel\admin\users_tracking\GroovelTrackingUserAPI');
			$configController = $app->make('Groovel\Cmsgroovel\Http\Controllers\groovel\admin\configuration\GroovelSystemConfigurationController');
			 
			if($configController->isMaintenanceWebSiteEnable()==1 &&  (!\Request::is('admin/*'))){
				return \View::make('cmsgroovel.pages.page_maintenance');
			}
			//tracking user
			if( $configController->isAuditTrackingUserEnable()=='1' && $userTrackingController->tracking_ip()!='127.0.0.1' && $route->audit_tracking_url_enable=='1'){
				$userTrackingController->saveTrackingUserInfo();
			}
		
			$params =array('uri'=>\Request::path(),'method'=>$route->method,'controller'=>$route->controller,'view'=>$route->view,'middleware'=>$route->middleware,'subtype'=>$route->subtype,'action'=>$route->action,'type'=>$route->type);
			$hasAccessForUser=$rulesController->checkAccessRulesURL(\Auth::user(),$params);
				// \Log::info($params);
			if($hasAccessForUser&& $route->activate_route=='1'){
				\Session::put('params',$params);
				return $next($request);
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