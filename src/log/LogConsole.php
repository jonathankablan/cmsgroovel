<?php
namespace Groovel\Cmsgroovel\log;

use Illuminate\Support\Facades\Facade;
class LogConsole extends Facade
{
	
protected static function getFacadeAccessor() { return 'logConsole'; }

 public static function info($mess){
  	if(config('app.log-level')=='INFO'||
  			config('app.log-level')=='WARNING'
  			||config('app.log-level')=='ERROR'
  			||config('app.log-level')=='FATAL'){
  		\Log::info("test");
  		\Log::info($mess);
  		//
  	}
 }
  
public static function debug($mess){
  	if(config('app.log-level')=='DEBUG'){
  		\Log::debug($mess);
  		//
  	}
  }
  
public static function warning($mess){
  	if(config('app.log-level')=='WARNING'
  			||config('app.log-level')=='ERROR'
  			||config('app.log-level')=='FATAL'){
  		\Log::warning($mess);
  		//
  	}
  }
  
public static function error($mess){
  	if(config('app.log-level')=='ERROR'
  			||config('app.log-level')=='FATAL'){
  		\Log::error($mess);
  		//
  	}
  }
  
public static function fatal($mess){
  	if(config('app.log-level')=='FATAL'){
  		\Log::fatal($mess);
  		//
  	}
  }
	
	
}