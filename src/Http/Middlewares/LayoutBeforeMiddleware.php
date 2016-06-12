<?php
namespace  Groovel\Cmsgroovel\Http\Middlewares;

use Closure;
use Monolog\Logger;
use Groovel\Cmsgroovel\Http\Controllers\groovel\admin\common\GroovelController;
class LayoutBeforeMiddleware
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
		\Log::info("layout");
		$app = App();
		$controllerMenu = $app->make('Groovel\Cmsgroovel\Http\Controllers\groovel\admin\menu\GroovelMenusListController');
		$controllerLayout = $app->make('Groovel\Cmsgroovel\Http\Controllers\groovel\admin\layout\GroovelLayoutsListController');
		
		$params=\Session::get("params");
		
		$site_extension=null;
		$lang=null;
		if(\Input::has('lang_choice')){
			if(\Input::get('lang_choice')=='none'){
				\Session::forget('lang');
				$lang=null;
			}else{
				\Session::put('lang',\Input::get('lang_choice'));//get from session
				$lang=\Session::get('lang');
			}
		}else{
			$lang=\Session::get('lang');
		}
		if($_SERVER['SERVER_NAME']!='localhost'){
			$site_extension=substr($_SERVER['SERVER_NAME'], strrpos($_SERVER['SERVER_NAME'], ".")+1);
		}
		
		$menus=$controllerMenu->callAction('loadMenus',array('extension'=>$site_extension,'lang'=>$lang,'layout'=>$params['type']));
		
		$layouts=$controllerLayout->callAction('loadLayouts',array('extension'=>$site_extension,'lang'=>$lang,'layout'=>$params['type']));
		$layout=null;
		if(count($layouts)>0){
		  $layout=$layouts[0];
		}
		\Session::put("layouts",$layout);
		\Session::put("menus",$menus);
		//\Session::put('params',$params);
		return $next($request);
	}


}