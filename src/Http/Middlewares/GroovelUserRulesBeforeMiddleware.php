<?php
namespace  Groovel\Cmsgroovel\Http\Middlewares;

use Closure;
use Monolog\Logger;
use Illuminate\Database\Eloquent\Model;
use Groovel\Cmsgroovel\Http\Controllers\groovel\admin\common\GroovelController;
use Groovel\Cmsgroovel\Http\Controllers\groovel\admin\routes\GroovelRouteController;
use Groovel\Cmsgroovel\Http\Controllers\groovel\admin\users_rules\GroovelUserRulesController;
use Illuminate\Http\Response;

class GroovelUserRulesBeforeMiddleware
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
		    if($route!=null && $route->uri!='undefined'){
				$params =array('uri'=>\Request::path(),'method'=>$route->method,'controller'=>$route->controller,'view'=>$route->view,'action'=>$route->action,'type'=>$route->type);
				$hasAccessForUser=$rulesController->checkAccessRulesURL(\Auth::user(),$params);
				if($hasAccessForUser&& $route->activate_route=='1'){
					\Session::put('params',$params);
					return $next($request);
				}else{
					\Log::info('no access rules for');
					\Log::info($params['uri']);
					\Log::info($params['action']);
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