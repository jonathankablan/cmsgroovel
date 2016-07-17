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

namespace Groovel\Cmsgroovel\Http\Controllers\groovel\admin\users_rules;
use Illuminate\Database\Eloquent\Model;
use Groovel\Cmsgroovel\Http\Controllers\groovel\admin\common\GroovelController;
use Monolog\Logger;
use Groovel\Cmsgroovel\Http\Controllers\groovel\admin\routes\GroovelRouteController;
use Groovel\Cmsgroovel\business\groovel\admin\permissions\GroovelPermissionManagerBusinessInterface;
use Groovel\Cmsgroovel\business\groovel\admin\contents\GroovelContentTypeManagerBusinessInterface;
use Groovel\Cmsgroovel\business\groovel\admin\roles\GroovelUserRoleManagerBusinessInterface;

class GroovelUserRulesController extends GroovelController {
 
	protected $permissionManager;
	
	protected $contentTypeManager;
	
	protected $userRoleManager;
	
	public function __construct(GroovelPermissionManagerBusinessInterface $permissionManager,GroovelContentTypeManagerBusinessInterface $contentTypeManager,GroovelUserRoleManagerBusinessInterface $userRoleManager)
	{
		$this->permissionManager=$permissionManager;
		$this->contentTypeManager=$contentTypeManager;
		$this->userRoleManager=$userRoleManager;
		$this->middleware('auth');
	}
	
   public function checkAccessRulesURL($user,$params){
   	 $isAccess=0;
   	 try{
   	 	if(!empty($user)){
	   	 	$role=$this->userRoleManager->getUserRoleByUserId($user->id);
	  	 	
	  	 	if($role!=null && !empty($role) && count($role)>0){
		  	 	if($role->role['role']=='ADMIN'){
		  	 		return true;
		  	 	}
	  	 	}
	  	    $rolePermissions=$role->role->rolepermissions;
	 	    $permissions = array();
	 	    foreach($rolePermissions as $permission){
	 	    	foreach($permission->permissions as $permission){
	 	    		$permissions[$permission['id']]=['id'=>$permission['id'],'op_create'=>$permission['op_create'],'op_read'=>$permission['op_read'],
	 	    				'op_update'=>$permission['op_update'],'op_delete'=>$permission['op_delete'],'uri'=>$permission['uri'],'owncontent'=>$permission['owncontent'],'othercontent'=>$permission['othercontent']];
	 	    	}
	 	    }
	 	     
	 	    $auth=\Auth::user();
	 	    if(empty($auth)&& empty($permissions)|| (!empty($auth)&&$params['action']=='op_none')){
	 	    	return true;
	 	    }
	 	    if($permissions!=null && !empty($permissions)){
	 	    	foreach($permissions as $permission){
	 	    		if($params['uri']==$permission['uri'] &&  $permission[$params['action']]==1 ){
	 	    			$isAccess= true;
	 	    			return $isAccess;
	 	    		}
	 	    	}
	 	    }
	 	    return 0;
   	 	}else if(empty($user)){
   	 		if($params['action']=='op_none'){
   		 			return true;
   	 		}
   	 	
   	 	}
      }catch (\Exception $ex){
       	   \Log::info($ex);
	   	    return \Redirect::to('undefined');
	   }
	   return $isAccess;
   }
 
}