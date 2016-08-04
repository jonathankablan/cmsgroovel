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
use Groovel\Cmsgroovel\Http\Controllers\groovel\admin\common\GroovelFormController;
use Monolog\Logger;
use Groovel\Cmsgroovel\business\groovel\admin\users\GroovelUserManagerBusiness;
use Groovel\Cmsgroovel\business\groovel\admin\users\GroovelUserManagerBusinessInterface;
use Groovel\Cmsgroovel\business\groovel\admin\configuration\GroovelConfigurationBusinessInterface;
use Groovel\Cmsgroovel\business\groovel\admin\configuration\GroovelConfigurationBusiness;
use Illuminate\Support\Facades\Password;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\View\Factory;
use Illuminate\Mail\Message;
use Groovel\Cmsgroovel\log\LogConsole;

/**
 * provide remembers or reset password
 */

class RemindersController extends GroovelFormController {
 
	protected $configManager;

	public function __construct( GroovelConfigurationBusinessInterface $configManager)
	{
		$this->configManager=$configManager;
		
	}
	
	public function validateForm($params){
		if(!$this->configManager->isEmailEnable()){
			\Config::set('mail.pretend',1);
		}
		return $this->processForm();
	}
	
	public function processForm(){
		if (\Request::is('*/auth/login/remind')){
		return $this->postRemind();
		}else if (\Request::is('*/auth/remind/reset')){
		 return $this->postReset();	
		}else if(\Request::is('remind/reset')){
		  return $this->getReset(\Input::get('_token'));	
		}
	}
	
	public function postRemind(){
	    $response = Password::sendResetLink(\Input::only('email'), function (Message $message) {
	    	$message->subject('Password forgotten.');
	    });
	    	
	    	switch ($response) {
	    		case Password::RESET_LINK_SENT:
	    			return redirect()->back()->with('status', trans($response));
	    
	    		case Password::INVALID_USER:
	      			return redirect()->back()->with('error', trans($response));
	    	}
	    
	}
	
	/**
	 * Display the password reset view for the given token.
	 *
	 * @param  string  $token
	 * @return Response
	 */
	public function getReset($token = null)
	{   if (is_null($token)) \App::abort(404);
		return \View::make('cmsgroovel.pages.login_reset', array('token' => $token));
	}
	
	public function postReset()
	{
		$credentials = \Input::only(
				'email', 'password', 'password_confirmation', 'token'
		);
		$response = \Password::reset($credentials, function($user, $password)
		{
			$user->password = \Hash::make($password);
	
			$user->save();
		});
		switch ($response)
		{
			case \Password::INVALID_PASSWORD:
			case \Password::INVALID_TOKEN:
			case \Password::INVALID_USER:
				return \Redirect::back()->with('error', \Lang::get($response))->withInput();
	
			case \Password::PASSWORD_RESET:
				return \Redirect::to('admin');
		}
	}
 
}