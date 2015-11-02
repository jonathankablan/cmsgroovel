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
namespace Groovel\Cmsgroovel\business\groovel\admin\users;
use Illuminate\Database\Eloquent\Model;
use models;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Connection;
use Monolog\Logger;
use Groovel\Cmsgroovel\dao\ContentTypeDao;
use Groovel\Cmsgroovel\dao\UserPermissionDao;
use Groovel\Cmsgroovel\dao\UserDao;
use Groovel\Cmsgroovel\dao\UserRoleDao;
use Groovel\Cmsgroovel\dao\ContentTypeDaoInterface;
use Groovel\Cmsgroovel\dao\UserPermissionDaoInterface;
use Groovel\Cmsgroovel\dao\UserDaoInterface;
use Groovel\Cmsgroovel\dao\UserRoleDaoInterface;


class GroovelUserManagerBusiness implements GroovelUserManagerBusinessInterface{

	private $userDao;
	private $contentTypeDao;
	private $permissionDao;
	private $userRoleDao;
	
	public function __construct(UserDaoInterface $userDao,ContentTypeDaoInterface $contentTypeDao,UserPermissionDaoInterface $permissionDao,UserRoleDaoInterface $userRoleDao)
	{
		$this->userDao =$userDao;
		$this->contentTypeDao =$contentTypeDao;
		$this->permissionDao=$permissionDao;
		$this->userRoleDao=$userRoleDao;
	}
	
	public function setLastTimeSeen($pseudo){
		$this->userDao->setLastTimeSeen($pseudo);
	}

	
	public function getUserByUsername($username){
		return $this->userDao->getUserByUsername($username);
	}
	
	public function getUserRole($id){
		return $this->userRoleDao->getUserRoleByUserId($id);
	}
	
	
	
	public function getUserByPseudo($pseudo){
		return $this->userDao->getUserByPseudo($pseudo);
	}
	
	public function getUserByEmail($email){
		return $this->userDao->getUserByEmail($email);
	}
	
	
	public function getUser($id){
		return $this->userDao->getUser($id);
	}
	
	
	public function addUser($picture,$username,$pseudo,$email,$password,$activate,$notification_email_enable){
		$this->userDao->addUser($picture,$username, $pseudo, $email, $password,$activate,$notification_email_enable);
	}
	
	public function updateUser($picture,$id,$username,$pseudo,$email,$password,$activate=null,$notif_enable){
		$this->userDao->updateUser($picture,$id,$username,$pseudo,$email,$password,$activate,$notif_enable);
	}
	
	
	public function deleteUser($id){
		$this->userDao->delete($id);
		$permissions=$this->permissionDao->getPermissionByUserid($id);
		if($permissions!=null){
			foreach($permissions as $permission){
				$permission->delete();
			}
		}
	}
   
   public function paginateUser(){
   	return $this->userDao->paginate();
   }
   
   public function addUserPermissions($userid,$contenttype,$actions,$owncontent,$othercontent){
   	
   	//to do
   }
   public function removeUserPermissions($userid,$contenttype,$actions,$owncontent,$othercontent){
   	//to do
   	
   }
   public function addUserRole($userid,$roleid){
   	//to do
   	
   }
   public function removeUserRole($userid,$roleid){
   	//to do
   }
   
   public function paginateUserPermission(){
   	return $this->permissionDao->paginate();
   }
   
   public function paginateUserRole(){
   	return $this->userRoleDao->paginate();
   }

   
   public function getUserPermissions($username){
    $user=$this->getUserByUsername($username);
    if($user!=null){
    	return $this->permissionDao->getPermissionByUserid($user->id);
    }
   	else return null;
   }
   
   public function updateUserPermissions($userid,$contenttype,$actions,$owncontent,$othercontent){
   	
   	
   }
   

   public function getPermissionsByContentTypeAndAction($content_type,$action){
   	    $type=$this->contentTypeDao->findAllContentTypeByName($content_type);
   	    return $this->permissionDao->getPermissionsByContentTypeAndAction($type->id, $action);
   }
   
   public function activateUser($userid){
   	$this->userDao->activateUser($userid);
   }
   public function blockUser($userid){
   	$this->userDao->blockUser($userid);
   }
   
   public function getAllUsersAdmin(){
   	return $this->userDao->getAllUsersAdmin();
   }
    
   
}