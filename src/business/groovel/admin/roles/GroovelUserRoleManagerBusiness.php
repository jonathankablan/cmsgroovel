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

namespace Groovel\Cmsgroovel\business\groovel\admin\roles;
use Illuminate\Database\Eloquent\Model;
use models;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Connection;
use Monolog\Logger;
use Groovel\Cmsgroovel\dao\UserPermissionDao;
use Groovel\Cmsgroovel\dao\UserRoleDao;
use Groovel\Cmsgroovel\dao\UserPermissionDaoInterface;
use Groovel\Cmsgroovel\dao\UserRoleDaoInterface;
use Groovel\Cmsgroovel\dao\UserDao;
use Groovel\Cmsgroovel\dao\UserDaoInterface;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;


class GroovelUserRoleManagerBusiness implements GroovelUserRoleManagerBusinessInterface{

private $userDao;
private $userRoleDao;
private static $perPage = 10;
	
	public function __construct(UserDaoInterface $userDao,UserRoleDaoInterface $userRoleDao)
	{
		$this->userDao =$userDao;
		$this->userRoleDao=$userRoleDao;
	}
	
	public function getUserByPseudo($pseudo){
		return $this->userDao->getUserByPseudo($pseudo);
	}
	
	
	public function getUser($id){
		$user = $this->userDao->getUser($id);
		return $user;
	}
	
	public function getUserRole($id){
		$role = $this->userRoleDao->getUserRole($id);
		return $role;
	}
	
  public function getListRoles(){
  	return $this->userRoleDao->all();
  }
   
   public function paginateUserRole(){
   		$users=$this->userDao->paginate();
   		$users_role=array();
   		$i=0;
   		foreach($users as $user){
   			$role=$user->role;
   			if(!empty($role)){
   			$roleName=$role->role;
	   			$user_role=['id'=>$role['id'],'username'=>$user->username,'pseudo'=>$user->pseudo,'role'=>$roleName->role,'updated_at'=>$role['updated_at'],'created_at'=>$role['created_at']];
	   			$users_role[$i]=$user_role;
	   			$i++;
   			}
   				
 		}
   		//return \Paginator::make($users_role,count($users),10);
 		$currentPage = \Input::get('page') - 1;
 		$pagedData = array_slice( $users_role, $currentPage * self::$perPage, self::$perPage);
 		//$items = Paginator::make($pagedData, count( $items), self::$perPage);
 		$currentPage = LengthAwarePaginator::resolveCurrentPage() ?: 1;
 		$paginator = new LengthAwarePaginator($pagedData, count( $users_role),  self::$perPage, $currentPage, [
 				'path'  => Paginator::resolveCurrentPath()
 		
 		]);
 		return $paginator;
}
	

   public function addUserRole($pseudo,$rolename){
   	 $user=$this->getUserByPseudo($pseudo);
   	 $role=$this->userRoleDao->getRoleIdByRoleName($rolename);
   	 $this->userRoleDao->add($role->id,  $user->id);
   }
   
   public function deleteUserRole($id){
   	$this->userRoleDao->delete($id);
   }
   
   public function editUserRole($username,$rolename){
   	//Not implemented yet
   }
   
   
   
   public function updateUserRole($userid,$rolename){
	    $this->userRoleDao->updateUserRole($userid, $rolename[0]);
   }
   
   public function getUserRoleByUserId($userid){
   	  return $this->userRoleDao->getUserRoleByUserId($userid);
   }
  
    
   
}