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

namespace Groovel\Cmsgroovel\Http\Controllers\groovel\admin\role_permissions;
use Illuminate\Database\Eloquent\Model;
use Groovel\Cmsgroovel\Http\Controllers\groovel\admin\common\GroovelFormController;
use models;
use Groovel\Cmsgroovel\business\groovel\admin\roles\GroovelRolePermissionsManagerBusiness;
use Monolog\Logger;
use Groovel\Cmsgroovel\business\groovel\admin\roles\GroovelRolePermissionsManagerBusinessInterface;
use Groovel\Cmsgroovel\business\groovel\admin\routes\GroovelRoutesBusinessInterface;
use Groovel\Cmsgroovel\business\groovel\admin\contents\GroovelContentTypeManagerBusinessInterface;
use Groovel\Cmsgroovel\business\groovel\admin\roles\GroovelUserRoleManagerBusinessInterface;


class GroovelRolePermissionsFormController extends GroovelFormController {

	
	protected $rolepermissionManager;
	
	protected $routeManager;
	
	protected $contentTypeManager;
	
	protected $userRoleManager;
	
	public function __construct( GroovelRolePermissionsManagerBusinessInterface $rolepermissionManager, GroovelRoutesBusinessInterface $routeManager,GroovelContentTypeManagerBusinessInterface $contentTypeManager, GroovelUserRoleManagerBusinessInterface $userRoleManager )
	{
		$this->contentTypeManager=$contentTypeManager;
		$this->rolepermissionManager=$rolepermissionManager;
		$this->routeManager=$routeManager;
		$this->userRoleManager=$userRoleManager;
		$this->middleware('auth');
	}
	
	private function loadContentTypes(){
		$content_types=$this->contentTypeManager->getListContentType();
		$systems_types=$this->contentTypeManager->getListSystemContentType();
		$options = array();
		$systems = array();
		$options['NULL']='';
		$systems['NULL']='';
		foreach ($content_types as $content_type)
		{
			$options[$content_type->name] = $content_type->name;
		}
		foreach ($systems_types as $content_type)
		{
			$systems[$content_type->name] = $content_type->name;
		}
		return $systems;
	}
	
	
	private function loadUris(){
		\Session::put('uris', $this->routeManager->getAllUris());
		\Session::put('content_types', $this->loadContentTypes());
	}
	
	public function init(){
		$this->loadUris();
		return \View::make('cmsgroovel.pages.admin_role_permissions_management');
	}
	

	
	 
	public function validateForm($params)
	{
		$messages=null;
	    $valid=true;
	    $validator =null;
	    $action=array();
	    $uris_array=array();
	    $owncontent=array();
	    $othercontent=array();
	    $index=0;
	    $unique_validation=array();
	    $input=null;
	   	$actions=array();
	   	$isuniqueri=true;
		if(\Request::is('*admin/role/permission/add')||\Request::is('*admin/role/permission/update')){
			foreach(\Input::get('uris') as $uri){
	   			if(!empty($uri)){
	   				array_push($uris_array,$uri);
	   				$action['create']=\Input::get('create')[$index];
	   				$action['read']=\Input::get('read')[$index];
	   				$action['update']=\Input::get('update')[$index];
	   				$action['delete']=\Input::get('delete')[$index];
	   				array_push($actions,$action);
	   				if(count(\Input::get('owncontent'))>$index){
	   					array_push($owncontent,\Input::get('owncontent')[$index]);
	   				}
	   				if(count(\Input::get('othercontent'))>$index){
	   					array_push($othercontent,\Input::get('othercontent')[$index]);
	   				}
	   				array_push($unique_validation,$uri);
	   			}else{
	   				$isuniqueri=false;
	   			}
	   			$index++;
	   		}
			$rules =  array('role' => 'required',"uri"=>'required');
			$input=array("role"=>\Input::get('role'),"uri"=>$uris_array,'action'=>$actions,'owncontent'=>$owncontent,'othercontent'=>$othercontent);
			$validator = \Validator::make( $input, $rules);
			if ($validator->fails())
			{ 
				$messages=$validator->messages();
				$formatMess=null;
				foreach ($messages->all() as $message)
				{
					$formatMess=$message.'- '.$formatMess;
				}
				return $this->jsonResponse($formatMess,false,true,true);
			}
			if(!$isuniqueri){
				$validator->getMessageBag()->add('permission', 'url must be not empty');
				$formatMess=null;
				$messages=$validator->messages();
				foreach ($messages->all() as $message)
				{
					$formatMess=$message.'- '.$formatMess;
				}
				return $this->jsonResponse($formatMess,false,true,true);
			}
			if($this->has_duplicates($unique_validation)){
				$validator->getMessageBag()->add('permission', 'url must be unique');
				$formatMess=null;
				$messages=$validator->messages();
				foreach ($messages->all() as $message)
				{
					$formatMess=$message.'- '.$formatMess;
				}
				return $this->jsonResponse($formatMess,false,true,true);
			}
			else{
				return $this->processForm($input);
			}
		}else if (\Request::is('*/role/edit')){
        	return $this->editRolePermission();	
        }else if (\Request::is('*/role/delete')){
        	return $this->deleteRolePermission();	
        }
        else{
			return $this->processForm();
		}
	}	
	
	
	private function deleteRolePermission(){
		$role=\Input::all()['q']['role'];
		$roleMd=$this->rolepermissionManager->getRoleByName($role);
		$usersroles=$this->userRoleManager->getAllUsersThatHaveRole($roleMd->id);
		foreach($usersroles as $userrole){
		 $this->userRoleManager->updateUserRole($userrole->user->id,null);
			
		}
		foreach($roleMd->rolepermissions as $rolepermissions){
			foreach($rolepermissions->permissions as $permission){
				$permission->delete();
			}
		}
		$roleMd->delete();
	}
	

	private function editRolePermission(){
		$role=\Input::all()['q']['role'];
		$roleMd=$this->rolepermissionManager->getRoleByName($role);
		$rolePermissions=$roleMd->rolepermissions;
		$perms = array();
		foreach($rolePermissions as $permission){
			foreach($permission->permissions as $permission){
				$perms[$permission['id']]=['id'=>$permission['id'],'create'=>$permission['op_create'],'read'=>$permission['op_read'],
						'update'=>$permission['op_update'],'delete'=>$permission['op_delete'],'uri'=>$permission['uri'],'owncontent'=>$permission['owncontent'],'othercontent'=>$permission['othercontent']];
			}
		}
	    \Session::put('permissions', $perms);
	    \Session::put('role', $role);
	    $uris=array();
	    foreach($this->routeManager->getAllUris() as $route){
	    	$uris[$route->uri]=$route->uri;
	    }
	    \Session::put('uris',$uris);
		$uri=array();
		$uri['uri']= url('admin/role/permission/editform', $parameters = array(), $secure = null);
		return $this->jsonResponse($uri);
	}
	
	
	private function addRole($input=null){
		$index=0;
		//check if role already exist if yes delete it and replace it by the new
		$role=$this->rolepermissionManager->getRole(\Input::get('role_id'));
		if($role!=null){
			foreach($role->rolepermissions as $roleperm){
					$permissions=$roleperm->permissions;
					foreach($permissions as $permission){
						$permission->delete();
					}
					$roleperm->delete();
			}
			$role->delete();
		}
		
		$role=$this->rolepermissionManager->addRole($input['role']);
		foreach($input['uri'] as $uri){
			$this->rolepermissionManager->addRolePermissions($role->id,$input['action'][$index],$input['uri'][$index],$input['owncontent'][$index],$input['othercontent'][$index]);
			$index++;
		}
		return $role;
	}
	
	private function updateRolePermission($input=null){
		$index=0;
		//check if role already exist if yes delete it and replace it by the new
		$role=$this->rolepermissionManager->getRoleByName($input['role']);
		if($role!=null){
			foreach($role->rolepermissions as $roleperm){
				$permissions=$roleperm->permissions;
				foreach($permissions as $permission){
					$permission->delete();
				}
				$roleperm->delete();
			}
		}
		foreach($input['uri'] as $uri){
			$this->rolepermissionManager->addRolePermissions($role->id,$input['action'][$index],$input['uri'][$index],$input['owncontent'][$index],$input['othercontent'][$index]);
			$index++;
		}
		return $role;
	}
	
	

	public function processForm($input=null){
		if(\Request::is('*admin/role/permission/add')){
			$role=$this->addRole($input);
			return $this->jsonResponse(array('id'=>$role->id,'added done'),false,true,false);
		}
		else if(\Request::is('*admin/role/permission/update')){
			$this->updateRolePermission($input);
			return $this->jsonResponse(array('updated done'),false,true,false);
		}
    }
   
	
    function has_duplicates( $array ) {
    	return count( array_keys( array_flip( $array ) ) ) !== count( $array );
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
