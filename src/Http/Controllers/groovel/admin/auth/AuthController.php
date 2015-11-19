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


namespace Groovel\Cmsgroovel\Http\Controllers\groovel\admin\auth;
use Illuminate\Database\Eloquent\Model;
use Groovel\Cmsgroovel\Http\Controllers\groovel\admin\common\GroovelController;
use Monolog\Logger;
use Groovel\Cmsgroovel\business\groovel\admin\users\GroovelUserManagerBusiness;
use Groovel\Cmsgroovel\business\groovel\admin\users\GroovelUserManagerBusinessInterface;
use Groovel\Cmsgroovel\business\groovel\admin\configuration\GroovelConfigurationBusinessInterface;
use Groovel\Cmsgroovel\business\groovel\admin\messages\GroovelUserMessageBusinessInterface;

use Groovel\Cmsgroovel\business\groovel\admin\contents\GroovelContentManagerBusiness;
use Groovel\Cmsgroovel\business\groovel\admin\contents\GroovelContentTypeManagerBusiness;
use Groovel\Cmsgroovel\business\groovel\admin\permissions\GroovelPermissionManagerBusiness;
use Groovel\Cmsgroovel\business\groovel\admin\permissions\GroovelPermissionManagerBusinessInterface;

use Groovel\Cmsgroovel\business\groovel\admin\roles\GroovelUserRoleManagerBusiness;
use Groovel\Cmsgroovel\business\groovel\admin\configuration\GroovelConfigurationBusiness;
use Groovel\Cmsgroovel\business\groovel\admin\messages\GroovelUserMessageBusiness;
use Groovel\Cmsgroovel\models\User;



class AuthController extends GroovelController {
 
	protected $userManager;
	
	protected $permissionManager;
	
	protected $configManager;
	
	protected $messageManager;
	
	private static $rulesLogin = array(
    			'pseudo' => 'required',
    			'password' => 'required'
    	);
	
	private static $rulesSubscribe = array(
			'username' => 'required|Alpha|between:6,64',
			'pseudo' => 'required|Alpha_num|between:6,64|unique:users',
			'email' => 'required|email|unique:users',
			'password' => 'required|AlphaNum|between:6,20|confirmed'
	);
	
    private static	$messages = array(
    			'username.required' => 'We need your usename.',
    			'pseudo.required' => 'We need your pseudo.',
    			'username.Alpha' => 'The pseudo must have caracters.',
    			'username.between' => 'The number of caracters of your pseudo must be between :min and :max.',
    			'username.unique' => 'This username is already used.',
    			'pseudo.unique' => 'This pseudo is already used.',
    			'email.required' => 'We need your email.',
    			'email.email' => 'The format of email adress is not correct.',
    			'email.unique' => 'This adress email is already used.',
    			'password.required' => 'We need a password.',
    			'password.Alphanum' => 'The pseudo must have alpha numerical caracters.',
    			'password.between' => 'The number of caracters of password must be between :min and :max.',
    			'password.confirmed' => 'The confirmation of password is not correct'
    	);
	
    public function __construct( GroovelUserManagerBusinessInterface $userManager,GroovelPermissionManagerBusinessInterface $permissionManager,GroovelConfigurationBusinessInterface $configManager,GroovelUserMessageBusinessInterface $messageManager)
  {
  	    $this->userManager=$userManager;
  	    $this->permissionManager=$permissionManager;
  	    $this->configManager=$configManager;
  	    $this->messageManager=$messageManager;
        $this->beforeFilter('auth', array('only' => 'getLogout'));
        $this->beforeFilter('guest', array('except' => 'getLogout'));
        $this->beforeFilter('csrf', array('on' => 'post'));
  }
 
  /**
    * Login form
    *
    * @return View
    */
    protected function createView($name)
    {
        return \View::make($name,array('actif' => -1));
    } 
 
  /**
    * Login form
    *
    * @return View
    */
    public function getLogin()
    {
        return $this->createView('auth.login');
    }
 
  /**
    * Subscribe Form
    *
    * @return View
    */
    public function getInscription()
    {
        return $this->createView('auth.subscribe');
    }
 
    public function validate($input,$rules)
    {
    	return \Validator::make($input, $rules, self::$messages);
    }
  /**
    *Workflow login subscribe
    *
    * @return Redirect
    */
    public function postLogin()
    {
    	$this->validateForm();
    	$v = $this->validate(\Input::all(),self::$rulesLogin);
    	if ($v->passes()) {
             $user = array('pseudo' => \Input::get('pseudo'), 'password' =>  \Input::get('password'),'activate'=>'1');
	        if (\Auth::attempt($user, \Input::get('rememberme'),true)) {
	          $this->userManager->setLastTimeSeen(\Input::get('pseudo'));
	          $user=$this->userManager->getUserByPseudo(\Input::get('pseudo'));
	          $role= $this->userManager->getUserRole($user['id']);
	          $user_privileges=array("role"=>$role,"status"=>$user['activate']);
	          \Session::put('user_privileges',$user_privileges);
	          return \Redirect::intended('/admin/welcome')->with('flash_notice', 'Vous avez été correctement connecté avec le pseudo ' . \Auth::user()->pseudo);
	        }
    	}else if ($v->failed()) {	
    		return \Redirect::to('admin/failed/login')->withErrors($v)->withInput();
      	}
        return \Redirect::to('admin/failed/login')->with('flash_error', 'Pseudo ou mot de passe non correct !')->withInput();      
    }
 
  /**
    * Workflow registration
    *
    * @return Redirect
    */
    public function postInscription()
    {
     	$referer=null;
    	if($_SERVER['SERVER_NAME']=='localhost'){
    		$referer='http://'.$_SERVER['SERVER_NAME'].'/admin/auth/subscribe/form';
    	}else{
    		$referer='http://'.$_SERVER['SERVER_NAME'].'/admin/auth/subscribe/form';
    	}
    	if(!parent::checkRefererStatus($referer)){
       		sleep(rand(2, 5)); // delay spammers a bit
    		header("HTTP/1.0 403 Forbidden");
    		exit;
    	}
    	parent::checkToken();
    	if(!parent::checkPOSTStatus()){
    		sleep(rand(2, 5)); // delay spammers a bit
    		header("HTTP/1.0 403 Forbidden");
    		exit;
    	}
    	
    	$this->validateForm();
        $v = $this->validate(\Input::all(),self::$rulesSubscribe);
        if ($v->passes()) {
            $user = new User;
            $user->pseudo = \Input::get('pseudo');
            $user->username = \Input::get('username');
            $user->email = \Input::get('email');
            $user->password = \Hash::make(\Input::get('password'));
            if($this->configManager->isEnableUserActivation()){
            	$user->activate='1';
            	$user->save();
            	$this->permissionManager->addDefaultPermission($user->pseudo);
            	$adminusers=$this->userManager->getAllUsersAdmin();
            	foreach ($adminusers as $admin){
            		$this->messageManager->sendMessage('new user subscribed '.$user->pseudo,$admin,'no-reply','');
            	}
             	return \Redirect::to('admin')->with('flash_notice', 'Your account has been created.');
            }
            $user->save();
            $this->permissionManager->addDefaultPermission($user->pseudo);
            $adminusers=$this->userManager->getAllUsersAdmin();
            foreach ($adminusers as $admin){
             	$this->messageManager->sendMessage('new user subscribed '.$user->pseudo,$admin,'no-reply','');
            }
            return \Redirect::to('admin')->with('flash_notice', 'Your account has been created.You will be informed soon when it will be activated');
        }
        return \Redirect::to('admin/auth/subscribe/form')->withErrors($v)->withInput();
    } 
    
  /**
    * logout
    *
    * @return Redirect
    */
    public function getLogout()
    {
        \Auth::logout();
        \Session::flush();
        return \Redirect::to('admin/auth/login')->with('flash_notice', 'You have been disconnected successfully.');
    }
 
}