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

namespace controllers\groovel\admin\users_roles;
use Illuminate\Database\Eloquent\Model;
use controllers\groovel\admin\common\GroovelFormController;
use models;
use business\groovel\admin\roles\GroovelUserRoleManagerBusiness;
use Monolog\Logger;
use business\groovel\admin\roles\GroovelUserRoleManagerBusinessInterface;
use business\groovel\admin\users\GroovelUserManagerBusinessInterface;
use business\groovel\admin\users\GroovelUserManagerBusiness;


class GroovelUserRoleFormController extends GroovelFormController {

	
	protected $userRoleManager;
	protected $userManager;
	
	
	public function __construct( \GroovelUserRoleManagerBusinessInterface $userRoleManager,\GroovelUserManagerBusinessInterface $userManager)
	{
		$this->userRoleManager=$userRoleManager;
		$this->userManager=$userManager;
		$this->beforeFilter('auth');
	}
	
	private function loadRoles(){
		$roles=$this->userRoleManager->getListRoles();
		$options = array();
		foreach ($roles as $role)
		{
			$options[$role->role] = $role->role;
		}
		//\Log::info($options);
		\Session::flash('roles', $options);
	}
	
	public function init(){
		$this->loadRoles();
		return \View::make('cmsgroovel::pages.admin_user_role_management');
	}
	

	private function validateUser(){
		$pseudo=$_POST['pseudo'];
		$response=array();
		$user=$this->userManager->getUserByPseudo($pseudo);
		if($user==null){
			$message='pseudo does not exist';
			$response=array('status'=>false,'messages'=>$message);
			return $response;
		}else{
			$response=array('status'=>true,'messages'=>'');
			return $response;
		}
	}
	 
	public function validateForm($params)
	{	$messages=null;
		$valid=true;
		if(\Request::is('*/user/role/add')){
			$this->checkToken();
			$rules =  array('pseudo' => 'required');
			$validator = \Validator::make(\Input::all(), $rules);
			if ($validator->fails())
			{
				$formatMess=null;
				$messages=$validator->messages();
				foreach ($messages->all() as $message)
				{
					$formatMess=$message.'- '.$formatMess;
				}
				return $this->jsonResponse($formatMess,false,true,true);
			}
			$valid=$this->validateUser();
			if($valid['status']){
				//check if already has role
				$user=$this->userRoleManager->getUserByPseudo(\Input::get('pseudo'));
				$roles=$this->userRoleManager->getUserRoleByUserId($user['id']);
				//\Log::info($roles);
				foreach($roles as $role){
					if($role->role['role']==\Input::get('roles')){
						return $this->jsonResponse('role already affected',false,true,true);
					}
					
				}
				return $this->processForm();
			}else{
				return $this->jsonResponse($valid['messages'],false,true,true);
			}
		}else{
			return $this->processForm();
		}
	}


	public function processForm(){
		$messages=\Input::all();
		if (\Request::is('*/user/role/form/view_update')){
			 $this->view_update();
        }else if (\Request::is('*/user/role/add')){
        	 $this->addUserRole();	   
        	 return $this->jsonResponse(array('added done'),false,true,false);
        }else if (\Request::is('*/user/role/update')){
        	$this->checkToken();
        	$this->updateUserRole();
        	return $this->jsonResponse(array('updated done'),false,true,false);
        }else if (\Request::is('*/user/role/delete')){
        	 $this->deleteUserRole();	
        }else if (\Request::is('*/users/role/edit')){
        	 return $this->editUserRole();	
        }
       return \Redirect::to('/admin/user/role/form')->with($messages);
    }
   
	private function addUserRole(){
		$input =  \Input::all();
		$this->userRoleManager->addUserRole($input['pseudo'],$input['roles']);
	}

	private function deleteUserRole(){
		$input =  \Input::get('q');
		$this->userRoleManager->deleteUserRole($input['id']);
	}
  
   private function updateUserRole(){
   		$input =  \Input::all();
   		\Log::info($input);
   		$this->userRoleManager->updateUserRole($input['id'],$input['role']);
   }

	
	//action called when you are in the list users and you edit one
	private function editUserRole(){
		$this->loadRoles();
		$input =  \Input::get('q');
	    $user_role=$this->userRoleManager->getUserRole($input['id']);
	    $user=$user_role->user;
	    $activate=$user['activate'];
	    $default_val='Not activate';
	    if ($activate=='1'){
	    	$default_val='activate';
	    }
	    $user['activate']=$default_val;
	    $user['role']= $user_role->role['role'];
	   \Session::flash('user_role', $user);
		$uri=array();
		$uri['uri']= url('admin/user/role/editform', $parameters = array(), $secure = null);
		return $this->jsonResponse($uri);
 	}


public function jsonResponse($param, $print = false, $header = true,$error=false) {
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
