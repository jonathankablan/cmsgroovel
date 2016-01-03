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
namespace Groovel\Cmsgroovel\Http\Controllers\groovel\admin\users;
use Illuminate\Database\Eloquent\Model;
use Groovel\Cmsgroovel\Http\Controllers\groovel\admin\common\GroovelFormController;
use models;
use Groovel\Cmsgroovel\business\groovel\admin\users\GroovelUserManagerBusiness;
use Monolog\Logger;
use Groovel\Cmsgroovel\business\groovel\admin\users\GroovelUserManagerBusinessInterface;


class GroovelUserFormController extends GroovelFormController {

	
	protected $userManager;
	
	
	public function __construct( GroovelUserManagerBusinessInterface $userManager)
	{
		$this->userManager=$userManager;
		$this->beforeFilter('auth');
	}
	
	public function makeValidation($params){
		
			$this->checkToken();
			$rules=array();
			$rules['username']= 'required|alpha_num';
			$rules['email']= 'required|email';
			$rules['pseudo']= 'required|alpha_num';
			$input =   \Input::all();
			$validation = \Validator::make($input, $rules);
			if($validation->fails()){
				$validation->getMessageBag()->add('user', 'Please check errors');
				$messages=$validation->messages();
				$formatMess=null;
				foreach ($messages->all() as $message)
				{
					$formatMess=$message.'- '.$formatMess;
				}
				return $this->jsonResponse($formatMess,false,true,true);
			}else if($validation->passes()){
				if('admin/user/add'==\Input::get('action')){
					$pseudo=$this->userManager->getUserByPseudo(\Input::get('pseudo'));
					if($pseudo!=null){
						$validation->getMessageBag()->add('user', 'pseudo is already used');
						$messages=$validation->messages();
						$formatMess=null;
						foreach ($messages->all() as $message)
						{
							$formatMess=$message.'- '.$formatMess;
						}
						return $this->jsonResponse($formatMess,false,true,true);
					}
					$email=$this->userManager->getUserByEmail(\Input::get('email'));
					if($email!=null){
						$validation->getMessageBag()->add('user', 'email is already used');
						$messages=$validation->messages();
						$formatMess=null;
						foreach ($messages->all() as $message)
						{
							$formatMess=$message.'- '.$formatMess;
						}
						return $this->jsonResponse($formatMess,false,true,true);
					}
				}
				if('admin/user/update'==\Input::get('action')){
					$email=$this->userManager->checkUserByEmailIsUnique(\Input::get('email'),\Input::get('pseudo'));
						if(!$email){
							$validation->getMessageBag()->add('user', 'email is already used');
							$messages=$validation->messages();
							$formatMess=null;
							foreach ($messages->all() as $message)
							{
								$formatMess=$message.'- '.$formatMess;
							}
							return $this->jsonResponse($formatMess,false,true,true);
						}
					}
				}
			return $this->jsonResponse(array('user has been updated'),false,true,false);
	}

	public function validateForm($params)
	{
		if (\Request::is('*/user/add'))
		{
			$this->checkToken();
			$rules=array();
			$rules['username']= 'required|alpha_num';
			$rules['email']= 'required|email';
			$rules['pseudo']= 'required|alpha_num';
			$input =   \Input::all();
			$validation = \Validator::make($input, $rules);
			if($validation->fails()){
				$validation->getMessageBag()->add('user', 'Please check errors');
				$messages=$validation->messages();
				$formatMess=null;
				foreach ($messages->all() as $message)
				{
					$formatMess=$message.'- '.$formatMess;
				}
				return $this->jsonResponse($formatMess,false,true,true);
			}else if($validation->passes()){
				$pseudo=$this->userManager->getUserByPseudo(\Input::get('pseudo'));
				if($pseudo!=null){
					$validation->getMessageBag()->add('user', 'pseudo is already used');
					$messages=$validation->messages();
					$formatMess=null;
					foreach ($messages->all() as $message)
					{
						$formatMess=$message.'- '.$formatMess;
					}
					return $this->jsonResponse($formatMess,false,true,true);
				}
				$email=$this->userManager->getUserByEmail(\Input::get('email'));
				if($email!=null){
					$validation->getMessageBag()->add('user', 'email is already used');
					$messages=$validation->messages();
					$formatMess=null;
					foreach ($messages->all() as $message)
					{
						$formatMess=$message.'- '.$formatMess;
					}
					return $this->jsonResponse($formatMess,false,true,true);
				}
			}
			//test password
			
		}else if (\Request::is('*/user/update')){
			$this->checkToken();
			$rules=array();
			$rules['username']= 'required|alpha_num';
			$rules['email']= 'required|email';
			$rules['pseudo']= 'required|alpha_num';
			$input =   \Input::all();
			$validation = \Validator::make($input, $rules);
			if($validation->fails()){
				$validation->getMessageBag()->add('user', 'Please check errors');
				$messages=$validation->messages();
				$formatMess=null;
				foreach ($messages->all() as $message)
				{
					$formatMess=$message.'- '.$formatMess;
				}
				return $this->jsonResponse($formatMess,false,true,true);
			}else if($validation->passes()){
				
			}
			
		}
	  	return $this->processForm();
	}

	public function processForm(){
		if (\Request::is('*/user/form/view_update')){
			return $this->view_update();
        }else if (\Request::is('*/user/add')){
        	$this->addUser();	
        	return $this->jsonResponse(array('new user added done'),false,true,false);
        }else if (\Request::is('*/user/update')){
        	 $this->updateUser();	
        	 return $this->jsonResponse(array('updated done'),false,true,false);
        }else if (\Request::is('*/user/delete')){
         	return $this->deleteUser();	
        }else if (\Request::is('*/user/edit')){
        	return $this->editUser();	
        }else if (\Request::is('*/user/view')) {
			return $this->viewUser();
		}else if (\Request::is('*/user/view/profile/edit')) {
			return $this->editUser();
		}else if(\Request::is('*/user/activate')){
			 $this->activateUser();
			 return $this->jsonResponse(array('done'),false,true,false);
		}else if(\Request::is('*/user/notactivate')){
			 $this->blockUser();
			return $this->jsonResponse(array('done'),false,true,false);
		}else if(\Request::is('user/view/profile')){
			return $this->viewUser(\Auth::user()->id);
		}else if (\Request::is('user/view/profile/edit')) {
			return $this->editUser();
		}
   }

   private function activateUser(){
   	$input =   \Input::get('q');
 	$user=$this->userManager->activateUser($input['id']);
  }
   
   private function blockUser(){
   	$input =   \Input::get('q');
   	$user=$this->userManager->blockUser($input['id']);
   }
    
     
    private function viewUser($id=null){
    	if($id==null){
	    	$input =   \Input::get('q');
	    	$user=$this->userManager->getUser($input['id']);
	    	\Session::flash('user', $user);
	    	$uri=array();
	    	$uri['uri']= url('admin/user/view/profile', $parameters = array(), $secure = null);
	    	return $this->jsonResponse($uri);
    	}else{
    		$user=$this->userManager->getUser($id);
    		\Session::flash('user', $user);
    		return \View::make('cmsgroovel.pages.user_profile');
    	}
    }
    
    
    
	private function addUser(){
		$input =  \Input::all();
		$this->userManager->addUser(\Input::get('myfiles'),$input['username'],$input['pseudo'],$input['email'],$input['password'],$input['activate'],$input['notification_email_enable']);
	}

	private function deleteUser(){
		$input = \Input::get('q');
		$this->userManager->deleteUser($input['id']);
	}
  
   private function updateUser(){
   		$input =  \Input::all();
   		$picture=\Input::get('myfiles');
   		if(!array_key_exists('myfiles', $input)){
   			$user=$this->userManager->getUser($input['id']);
   			$picture=$user['userpicture'];
   		}
   		if(!array_key_exists('activate',$input)){
   			$this->userManager->updateUser($picture,$input['id'],$input['username'],$input['pseudo'],$input['email'],$input['password'],null,$input['notification_email_enable']);
   		}else if(\Session::get('user_privileges')['role']=='ADMIN'){
   			$this->userManager->updateUser($picture,$input['id'],$input['username'],$input['pseudo'],$input['email'],$input['password'],$input['activate'],$input['notification_email_enable']);
   		}
   }

	
	//action called when you are in the list users and you edit one
	private function editUser(){
		$input =  \Input::get('q');
		$user=$this->userManager->getUser($input['id']);
		\Session::put('user_edit', $user);
		$uri=array();
		$uri['uri']= url('admin/user/editform', $parameters = array(), $secure = null);
		return $this->jsonResponse($uri);
 	}


 	public function jsonResponse($param, $print = false, $header = true,$error=false) {
 		$out=null;
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
 	
 		$out = json_encode($out);
 	
 		if ($print) {
 			if ($header) header('Content-type: application/json');
 	
 			echo $out;
 			return;
 		}
 	
 		return $out;
 	}
 	

}
