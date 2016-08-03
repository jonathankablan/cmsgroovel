<?php
namespace  Groovel\Cmsgroovel\Http\Middlewares;

use Closure;
use Monolog\Logger;
use Illuminate\Database\Eloquent\Model;
use Groovel\Cmsgroovel\Http\Controllers\groovel\admin\common\GroovelController;
use Groovel\Cmsgroovel\Http\Controllers\groovel\admin\routes\GroovelRouteController;
use Groovel\Cmsgroovel\Http\Controllers\groovel\admin\users_rules\GroovelUserRulesController;
use Illuminate\Http\Response;
use Dingo\Api\Routing\Helpers;
use Groovel\Cmsgroovel\log\LogConsole;

class GroovelUserRulesBeforeMiddleware
{
	use Helpers;
	
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
			LogConsole::debug("middleware UserRules : START METHOD handle()");
			$uri=$this->filterBadUriApi(\Request::path());
			$app = App();
			$controller = $app->make('Groovel\Cmsgroovel\Http\Controllers\groovel\admin\routes\GroovelRouteController');
			$rulesController = $app->make('Groovel\Cmsgroovel\Http\Controllers\groovel\admin\users_rules\GroovelUserRulesController');
			$route= $controller->getRouteFromSession();
			$userTrackingController = $app->make('Groovel\Cmsgroovel\Http\Controllers\groovel\admin\users_tracking\GroovelTrackingUserAPI');
			$configController = $app->make('Groovel\Cmsgroovel\Http\Controllers\groovel\admin\configuration\GroovelSystemConfigurationController');
		    if($route!=null && $route->uri!='undefined'){
				$params =array('uri'=>$uri,'method'=>$route->method,'controller'=>$route->controller,'view'=>$route->view,'action'=>$route->action,'type'=>$route->type);
				$hasAccessForUser=0;
				if(!\Request::is('api','api/*','/api/*','*/api/*')){
					LogConsole::debug("middleware UserRules Check acess web METHOD handle()");
					$hasAccessForUser=$rulesController->checkAccessRulesURL(\Auth::user(),$params);
				}else{
				    LogConsole::debug("middleware UserRules Check access api METHOD handle()");
					$user = $this->auth->user();
					$hasAccessForUser=$rulesController->checkAccessRulesURL(\Auth::user(),$params);
				}
				if($hasAccessForUser&& $route->activate_route=='1'){
					\Session::put('params',$params);
					LogConsole::debug("middleware UserRules : END METHOD handle()");
					return $next($request);
				}else{
				    LogConsole::debug("middleware UserRules NOT AUTHORIZED : END METHOD handle()");
					return response()->view('cmsgroovel.pages.pagenotauthorized')->header('Content-Type', 'text/html');
				}
		    }
		}catch (\Exception $ex){
			\Log::info($ex);
			return \Redirect::to('undefined');
		}
		return $next($request);
	}
	
}