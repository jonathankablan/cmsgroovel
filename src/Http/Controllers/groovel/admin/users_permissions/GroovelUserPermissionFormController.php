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

namespace Groovel\Cmsgroovel\Http\Controllers\groovel\admin\users_permissions;
use Illuminate\Database\Eloquent\Model;
use Groovel\Cmsgroovel\Http\Controllers\groovel\admin\common\GroovelFormController;
use models;
use Groovel\Cmsgroovel\business\groovel\admin\users\GroovelUserManagerBusiness;
use Monolog\Logger;
use Groovel\Cmsgroovel\business\groovel\admin\users\GroovelUserManagerBusinessInterface;
use Groovel\Cmsgroovel\business\groovel\admin\contents\GroovelContentTypeManagerBusinessInterface;
use Groovel\Cmsgroovel\business\groovel\admin\permissions\GroovelPermissionManagerBusinessInterface;
use Groovel\Cmsgroovel\business\groovel\admin\contents\GroovelContentTypeManagerBusiness;
use Groovel\Cmsgroovel\business\groovel\admin\permissions\GroovelPermissionManagerBusiness;


class GroovelUserPermissionFormController extends GroovelFormController {

	
	protected $userManager;
	protected $contentTypeManager;
	protected $permissionManager;
	
	
	public function __construct( GroovelUserManagerBusinessInterface $userManager,GroovelContentTypeManagerBusinessInterface $contentTypeManager,GroovelPermissionManagerBusinessInterface $permissionManager)
	{
		$this->userManager=$userManager;
		$this->contentTypeManager=$contentTypeManager;
		$this->permissionManager=$permissionManager;
		$this->middleware('auth');
	}
	

	public function validateForm($params)
	{	$messages=null;
	    $valid=true;
	    $validator =null;
	    $action=array();
	    $content_types_array=array();
	    $owncontent=array();
	    $othercontent=array();
	    $index=0;
	    $unique_validation=array();
	    $input=null;
	   	if(\Request::is('*/user/permission/add')){
	   		$this->checkToken();
	   		
	   		$actions=array();
	   		foreach(\Input::get('content_types') as $content_types){
	   			if(!empty($content_types)){
	   				array_push($content_types_array,$content_types);
	   				$action['retrieve']=\Input::get('retrieve')[$index];
	   				$action['add']=\Input::get('add')[$index];
	   				$action['delete']=\Input::get('delete')[$index];
	   				$action['update']=\Input::get('update')[$index];
	   				$action['save']=\Input::get('save')[$index];
	   				$action['edit']=\Input::get('edit')[$index];
	   				array_push($actions,$action);
	   				if(count(\Input::get('owncontent'))>$index){
	   					array_push($owncontent,\Input::get('owncontent')[$index]);
	   				}
	   				if(count(\Input::get('othercontent'))>$index){
	   					array_push($othercontent,\Input::get('othercontent')[$index]);
	   				}
	   				array_push($unique_validation,$content_types);
	   			}
	   			$index++;
	   		}
			$rules =  array('pseudo' => 'required','content_types' => 'required');
			$input=array("pseudo"=>\Input::get('pseudo'),"content_types"=>$content_types_array,'action'=>$actions,'owncontent'=>$owncontent,'othercontent'=>$othercontent);
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
			$valid=$this->validateUser($messages);
			if($valid['status']){
				if($this->has_duplicates($unique_validation)){
					$validator->getMessageBag()->add('permission', 'types must be unique');
					$formatMess=null;
					$messages=$validator->messages();
					foreach ($messages->all() as $message)
					{
						$formatMess=$message.'- '.$formatMess;
					}
					return $this->jsonResponse($formatMess,false,true,true);
				}
				
				//check duplicate
				$permissions=$this->permissionManager->getUserPermissions(\Input::get('pseudo'));
				$index=0;
				$notunique=false;
				foreach($input['content_types'] as $type){
					foreach($permissions as $permission){
						$content_type=$this->contentTypeManager->find($permission['contenttypeid']);
						if($content_type['name']==$type){
							$notunique=true;
						}
					}
					$index++;
				}
				if($notunique){
					return $this->jsonResponse(array('permissions already set'),false,true,true);
				}
				return $this->processForm($input);
			}else{
				return $this->jsonResponse(array('user not valid'),false,true,true);
			}
		}else{
			return $this->processForm();
		}
	}

	public function processForm($input=null){
		$messages=\Input::all();
		if (\Request::is('*/user/form/view_update')){
			return $this->view_update();
        }else if (\Request::is('*/user/permission/add')){
        	$this->addUserPermissions($input);	
        	return $this->jsonResponse(array('added done'),false,true,false);
        }else if (\Request::is('*/user/permission/update')){
        	$this->checkToken();
        	$this->updateUserPermission();	
        	return $this->jsonResponse(array('updated done'),false,true,false);
        }else if (\Request::is('*/users/delete/permission')){
        	$this->deleteUserPermission();	
        }else if (\Request::is('*/users/permission/edit')){
        	return $this->editUserPermission();	
        }
         return \Redirect::to('/admin/user/permissions/form')->with($messages);
        

    }

    function has_duplicates( $array ) {
    	return count( array_keys( array_flip( $array ) ) ) !== count( $array );
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
    	
    	\Session::put('system_types', $systems);
    	\Session::put('content_types', $options);
    }

    public function init(){
    	$this->loadContentTypes();
    	return \View::make('cmsgroovel.pages.admin_user_permission_management');
    }
    
    
	private function addUserPermissions($input=null){
		$index=0;
		foreach($input['content_types'] as $type){
			$this->permissionManager->addUserPermissions($input['pseudo'],$input['action'][$index],$type,$input['owncontent'][$index],$input['othercontent'][$index]);
			$index++;
		}
	}

	private function deleteUserPermission(){
		$input =  \Input::get('q');
		$this->permissionManager->deleteUserPermission($input['id']);
	}
  
   private function updateUserPermission(){
   		$input =  \Input::all();
   		
  		$contentTypeid=$this->permissionManager->getContenttypeIdFromName($input['content_types'][0]);
   		$user= $this->permissionManager->getUserByPseudo($input['pseudo']);
   		$actions=array();
   		$action=array();
   		$action['retrieve']=\Input::get('retrieve');
   		$action['add']=\Input::get('add');
   		$action['delete']=\Input::get('delete');
   		$action['update']=\Input::get('update');
   		$action['save']=\Input::get('save');
   		$action['edit']=\Input::get('edit');
   		array_push($actions,$action);
   		$this->permissionManager->updateUserPermissions($input['permission_id'],$user->id,$contentTypeid,$actions,$input['owncontent'][0],$input['othercontent'][0]);
   }

	
	//action called when you are in the list users and you edit one
	private function editUserPermission(){
		$input =  \Input::get('q');
		$permission=$this->permissionManager->getPermission($input['id']);
		$this->loadContentTypes();
		if($this->contentTypeManager->findAllContentTypeByName($permission['contentTypeName'])['type']=='system'){
			$systems_types=$this->contentTypeManager->getListSystemContentType();
			$systems = array();
			$systems['NULL']='';
			foreach ($systems_types as $content_type)
			{
				$systems[$content_type->name] = $content_type->name;
			}
			\Session::put('content_types', $systems);
		}
		\Session::put('user_permissions', $permission);
		$uri=array();
		$uri['uri']= url('admin/user/permission/editform', $parameters = array(), $secure = null);
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
