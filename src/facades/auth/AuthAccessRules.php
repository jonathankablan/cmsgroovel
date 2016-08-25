<?php
namespace Groovel\Cmsgroovel\facades\auth;
use Groovel\Cmsgroovel\log\LogConsole;


class AuthAccessRules {

	public static function isstarted(){
		if(!\Session::has("permissions")&& !\Session::has("user_role")){
			return false;
		}
		return true;
	}
	
	public static function start($permissions,$role){
		\Session::put("permissions",$permissions);
		\Session::put("user_role",$role);
	}
	
	public static function getCurrentAction(){
		return \Session::get("action"); 
	}
	
	public static function putCurrentAction($action){
		return \Session::put("action",$action);
	}
	
	public static function hasAccess($uri,$action){
		$permissions=\Session::get("permissions");
		$auth=\Auth::user();
		
		if(empty($auth)&& empty($permissions)|| (!empty($auth)&& $action=='op_none')){
			\Session::put("action",$action);
			return true;
		}
		
		
		if(self::getRole()=="ADMIN"){
			\Session::put("action",$action);
			return true;
		}
		foreach($permissions as $permission){
			if($uri==$permission['uri'] &&  $permission[$action]==1 ){
				\Session::put("action",$action);
				\Session::put("owncontent",$permission['owncontent']);
				\Session::put("othercontent",$permission['othercontent']);
				return true;
			}
		}
		
		return false;
	}
	
	public static function putRole($role){
		return \Session::put("user_role",$role);
	}
	
	
	public static function getRole(){
		return \Session::get("user_role");
	}
	
	
	
	public static function hasRead($uri,$action,$userid){
		return self::hasAccess($uri,$action,$userid);
	}
	
	public static function hasCreate($uri,$action,$userid){
		return self::hasAccess($uri,$action,$userid);
	}
		
	public static function hasUpdate($uri,$action,$userid){
		return self::hasAccess($uri,$action,$userid);
	}
	
	public static function hasDelete($uri,$action,$userid){
		return self::hasAccess($uri,$action,$userid);
	}
	
	public static function hasPermissionToOwnContent($userid){
		if(self::getRole()=="ADMIN"){
			return true;
		}
		if(\Session::get("owncontent")=="yes" && \Auth::user()->id ==$userid){
			return true;
		}else {
			return false;
		}
		
	}
	
	public static function hasPermissionToOtherContent(){
		if(self::getRole()=="ADMIN"){
			return true;
		}
		if(\Session::get("othercontent")=="yes"){
			return true;
		}else return false;
	}
	
}