<?php
namespace  Groovel\Cmsgroovel\Http\Middlewares;

use Closure;
use Monolog\Logger;
use Groovel\Cmsgroovel\Http\Controllers\groovel\admin\common\GroovelController;
use Groovel\Cmsgroovel\log\LogConsole;


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
		LogConsole::debug("middleware content : START METHOD handle()");
	
		$params=\Session::get("params");
		$app = App();
		$controllerContents = $app->make('Groovel\Cmsgroovel\Http\Controllers\groovel\admin\contents\GroovelContentsListController');
		
		$site_extension=null;
		$lang=null;
		if(\Input::has('lang_choice')){
			if(\Input::get('lang_choice')=='none'){
				\Session::forget('lang');
				//$lang=null;
				LogConsole::debug(config('app.fallback_locale'));
				if(config('app.fallback_locale')=="en"){
					$lang="US";
				}else{
					$lang=config('app.fallback_locale');
				}
			}else{
				LogConsole::debug(config('app.fallback_locale'));
				\Session::put('lang',\Input::get('lang_choice'));//get from session
				$lang=\Session::get('lang');
			}
		}else{
			$lang=\Session::get('lang');
			if($lang==null){
				LogConsole::debug('no language is specified, groovel choose the default in your config '.config('app.fallback_locale'));
				if(config('app.fallback_locale')=="en"){
					$lang="US";
				}else{
					$lang=config('app.fallback_locale');
				}
			}
		}
		if(array_key_exists('SERVER_NAME', $_SERVER)){
			if($_SERVER['SERVER_NAME']!='localhost'){
				$site_extension=substr($_SERVER['SERVER_NAME'], strrpos($_SERVER['SERVER_NAME'], ".")+1);
				$lang=null;
			}
		}
		$contents=$controllerContents->callAction('loadContents',array('extension'=>$site_extension,'lang'=>$lang,'layout'=>$params['type']));
		\Session::put('contents',$contents);
		LogConsole::debug("middleware content : END METHOD handle()");
	
	     return $next($request);
	}


}