<?php
namespace  Groovel\Cmsgroovel\Http\Middlewares;

use Closure;
use Monolog\Logger;
use Illuminate\Database\Eloquent\Model;
use Groovel\Cmsgroovel\Http\Controllers\groovel\admin\common\GroovelController;
use Groovel\Cmsgroovel\Http\Controllers\groovel\admin\routes\GroovelRouteController;
use Groovel\Cmsgroovel\Http\Controllers\groovel\admin\users_rules\GroovelUserRulesController;
use  Groovel\Cmsgroovel\log\LogConsole;


/**
 * middleware class called on each request http.
 * check if uri exists for request api or web
 */

class GroovelFilterBeforeMiddleware
{
	
	
	private function filterBadUriApi($uri){
		$uriex=explode('api',$uri);
		if(count($uriex)==1){
			return \Request::path();
		}
		return 'api'.$uriex[1];
	}
	
	
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
		LogConsole::debug("middleware Filter : START METHOD handle()");
			$uri=$this->filterBadUriApi(\Request::path());
			$app = App();
			$controller = $app->make('Groovel\Cmsgroovel\Http\Controllers\groovel\admin\routes\GroovelRouteController');
			$route= $controller->getRouteFromSession();
			$userTrackingController = $app->make('Groovel\Cmsgroovel\Http\Controllers\groovel\admin\users_tracking\GroovelTrackingUserAPI');
			$configController = $app->make('Groovel\Cmsgroovel\Http\Controllers\groovel\admin\configuration\GroovelSystemConfigurationController');
			LogConsole::debug($route);
			if($configController->isMaintenanceWebSiteEnable()==1 &&  (!\Request::is('admin/*'))){
				return \View::make('cmsgroovel.pages.page_maintenance');
			}
			//tracking user
			if( $configController->isAuditTrackingUserEnable()=='1' && $userTrackingController->tracking_ip()!='127.0.0.1' && $route->audit_tracking_url_enable=='1'){
				$userTrackingController->saveTrackingUserInfo();
			}
			if($route!=null && $route->uri!='undefined'){
				$params =array('uri'=>$uri,'method'=>$route->method,'controller'=>$route->controller,'view'=>$route->view,'action'=>$route->action,'type'=>$route->type);
				if($route->activate_route=='1'){
					\Session::put('params',$params);
					$response = $next($request);
					$response->header('Content-Type', 'text/html');
					LogConsole::debug("middleware Filter route found! : END METHOD handle()");
					return $response;
				}else{
					LogConsole::debug("middleware Filter route not found! : END METHOD handle()");
					return response()->view('cmsgroovel.pages.pagenotauthorized')->header('Content-Type', 'text/html');
				}
			}else{
				if (\Request::ajax() && !\Request::is('api','api/*'))
				{
				     LogConsole::debug("middleware Filter ajax route not found! : END METHOD handle()");
					return $this->jsonResponse('error 404 page not found',false,true,true);
				}else if (\Request::is('api','api/*')){
					\Log::info("404 not found api");
					 LogConsole::debug("middleware Filter api route not found! : END METHOD handle()");
					 return $this->jsonResponse('error 404 page not found',false,true,true);
				}
			}
			LogConsole::debug("middleware Filter : END METHOD handle()");
			return $next($request);
		}catch (\Exception $ex){
			\Log::info($ex);
			return \Redirect::to('undefined');
		}
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
	
		return response()->json($out);
		if ($print) {
			if ($header) header('Content-type: application/json');
	
			echo $out;
			return;
		}
	
		return $out;
	}
}