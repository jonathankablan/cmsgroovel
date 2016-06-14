<?php
namespace  Groovel\Cmsgroovel\Http\Middlewares;

use Closure;
use Monolog\Logger;
use Groovel\Cmsgroovel\Http\Controllers\groovel\admin\common\GroovelController;
class ContentsBeforeMiddleware
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
		$params=\Session::get("params");
		$app = App();
		$controllerContents = $app->make('Groovel\Cmsgroovel\Http\Controllers\groovel\admin\contents\GroovelContentsListController');
		
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
		$contents=$controllerContents->callAction('loadContents',array('extension'=>$site_extension,'lang'=>$lang,'layout'=>$params['type']));
		\Session::put('contents',$contents);
	     return $next($request);
	}


}