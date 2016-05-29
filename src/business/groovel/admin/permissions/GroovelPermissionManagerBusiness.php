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
namespace Groovel\Cmsgroovel\business\groovel\admin\permissions;
use Illuminate\Database\Eloquent\Model;
use models;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Connection;
use Monolog\Logger;
use Groovel\Cmsgroovel\dao\UserDaoInterface;
use Groovel\Cmsgroovel\dao\UserDao;
use Groovel\Cmsgroovel\dao\ContentTypeDaoInterface;
use Groovel\Cmsgroovel\dao\ContentTypeDao;
use Groovel\Cmsgroovel\dao\UserPermissionDaoInterface;
use Groovel\Cmsgroovel\dao\UserPermissionDao;
use Groovel\Cmsgroovel\dao\UserRoleDaoInterface;
use Groovel\Cmsgroovel\dao\UserRoleDao;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;

class GroovelPermissionManagerBusiness implements GroovelPermissionManagerBusinessInterface{

private $userDao;
private $contentTypeDao;
private $permissionDao;
private $userRoleDao;
private static $perPage = 10;
	
	public function __construct(UserDaoInterface $userDao,ContentTypeDaoInterface $contentTypeDao,UserPermissionDaoInterface $permissionDao,UserRoleDaoInterface $userRoleDao)
	{
		$this->userDao =$userDao;
		$this->contentTypeDao =$contentTypeDao;
		$this->permissionDao=$permissionDao;
		$this->userRoleDao=$userRoleDao;
	}
	
	public function getUserByPseudo($pseudo){
		return $this->userDao->getUserByPseudo($pseudo);
	}
	
	
	public function getUser($id){
		return $this->userDao->getUser($id);
	}
	
	
	public function getContenttypeIdFromName($name){
		$type=$this->contentTypeDao->findAllContentTypeByName($name);
		return $type->id;
	}
	
	public function addDefaultPermission($pseudo){
		$user = $this->userDao->getUserByPseudo($pseudo);
		$owncontent='yes';
		$othercontent='no';
		
		$type=$this->contentTypeDao->findAllContentTypeByName('file');
		$action=array();
		$action['retrieve']=0;
		$action['add']=0;
		$action['delete']=0;
		$action['update']=0;
		$action['save']=1;
		$action['edit']=1;
		
		$this->permissionDao->create($user, $action, $type, $owncontent, $othercontent);
		
		$type=$this->contentTypeDao->findAllContentTypeByName('profile');
		$action=array();
		$action['retrieve']=1;
		$action['add']=0;
		$action['delete']=0;
		$action['update']=0;
		$action['save']=0;
		$action['edit']=0;
		$this->permissionDao->create($user, $action, $type, $owncontent, $othercontent);
		
		$type=$this->contentTypeDao->findAllContentTypeByName('information');
		$action=array();
		$action['retrieve']=1;
		$action['add']=0;
		$action['delete']=0;
		$action['update']=0;
		$action['save']=0;
		$action['edit']=0;
		$this->permissionDao->create($user, $action, $type, $owncontent, $othercontent);
		
		$type=$this->contentTypeDao->findAllContentTypeByName('message');$action=array();
		$action=array();
		$action['retrieve']=1;
		$action['add']=1;
		$action['delete']=1;
		$action['update']=1;
		$action['save']=1;
		$action['edit']=1;
		
		$this->permissionDao->create($user, $action, $type, $owncontent, $othercontent);
			
		$type=$this->contentTypeDao->findAllContentTypeByName('user');
		$action=array();
		$action['retrieve']=1;
		$action['add']=0;
		$action['delete']=0;
		$action['update']=1;
		$action['save']=1;
		$action['edit']=1;
		
		$this->permissionDao->create($user, $action, $type, $owncontent, $othercontent);
		
		
		$type=$this->contentTypeDao->findAllContentTypeByName('forum');
		$action=array();
		$action['retrieve']=1;
		$action['add']=0;
		$action['delete']=0;
		$action['update']=0;
		$action['save']=1;
		$action['edit']=0;
		
		$this->permissionDao->create($user, $action, $type, $owncontent, $othercontent);
		
		$type=$this->contentTypeDao->findAllContentTypeByName('public');
		$action=array();
		$action['retrieve']=1;
		$action['add']=0;
		$action['delete']=0;
		$action['update']=0;
		$action['save']=0;
		$action['edit']=0;
		
		$this->permissionDao->create($user, $action, $type, $owncontent, $othercontent);
		
	}
   
   public function addUserPermissions($pseudo,$action,$contenttype,$owncontent,$othercontent){
   	    $user = $this->userDao->getUserByPseudo($pseudo);
   	    $type=$this->contentTypeDao->findAllContentTypeByName($contenttype);
   	    $this->permissionDao->create($user, $action, $type, $owncontent, $othercontent);
   }

    
   public function updateUserPermissions($permissionid,$userid,$contenttype,$actions,$owncontent,$othercontent){
   	$this->permissionDao->updateUserPermissions($permissionid,$userid,$contenttype,$actions,$owncontent,$othercontent);
    }
   
   
   public function deleteUserPermission($id){
   	$this->permissionDao->deleteUserPermission($id);
   }
   
   
   public function paginateUserPermission(){
   	$users = $this->userDao->paginate();
   	$permissions_users=array();
   	$i=0;
   	
   	foreach($users as $user){
   	    if(count($user->permissions)>0){

   	    	foreach ($user->permissions as $permission){
   	    		$contentTypeName=$permission->contentType['name'];
   	     		$permission=['id'=>$permission['id'],'username'=>$user->username,'pseudo'=>$user->pseudo,'retrieve'=>$permission['op_retrieve'],'save'=>$permission['op_save'],
   	     				'update'=>$permission['op_update'],'delete'=>$permission['op_delete'],'add'=>$permission['op_add'],'edit'=>$permission['op_edit'],'contentTypeName'=>$contentTypeName,'owncontent'=>$permission['owncontent'],'othercontent'=>$permission['othercontent'],'updated_at'=>$permission['updated_at'],'created_at'=>$permission['created_at']];
   	     		$permissions_users[$i]=$permission;
   	    		$i++;
   	    	}
   	    }
   	}
   	
   	$currentPage = \Input::get('page') - 1;
   	$pagedData = array_slice( $permissions_users, $currentPage * self::$perPage, self::$perPage);
   	$currentPage = LengthAwarePaginator::resolveCurrentPage() ?: 1;
   	$paginator = new LengthAwarePaginator($pagedData, count( $permissions_users),  self::$perPage, $currentPage, [
   			'path'  => Paginator::resolveCurrentPath()
   	
   	]);
   	return $paginator;
   }
   
   
   public function paginateUserRole(){
   	return $this->userRoleDao->paginate(); 
   }

   
   public function getUserPermissions($pseudo){
    $user=$this->getUserByPseudo($pseudo);
    if($user!=null){
    	return $this->permissionDao->getPermissionByUserid($user->id);
    }
   	else return null;
   }
   

   public function getPermissionsByContentTypeAndAction($userid,$content_type,$action){
       $type=$this->contentTypeDao->findAllContentTypeByName($content_type);
   	   return $this->permissionDao->getPermissionsByContentTypeAndActionAndUserId($userid,$type->id,$action);
    }
    
    
    public function getPermission($id){
    	$permission=$this->permissionDao->getPermissionById($id);
    	$user=$permission->user;
    	$contentTypeName=$permission->contentType['name'];
    	$permission=['id'=>$permission['id'],'username'=>$user->username,'pseudo'=>$user->pseudo,'retrieve'=>$permission['op_retrieve'],'save'=>$permission['op_save'],
    			'update'=>$permission['op_update'],'delete'=>$permission['op_delete'],'add'=>$permission['op_add'],'edit'=>$permission['op_edit'],'contentTypeName'=>$contentTypeName,'owncontent'=>$permission['owncontent'],'othercontent'=>$permission['othercontent'],'updated_at'=>$permission['updated_at'],'created_at'=>$permission['created_at']];
    	
    	return $permission;
    }
    
   
}