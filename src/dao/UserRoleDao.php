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
namespace dao;


class UserRoleDao implements \UserRoleDaoInterface{

	public function paginate(){
		return \Roles::paginate(15);
	}
	
	public function all(){
		return \Roles::all(); 
	}
	
	public function getRoleIdByRoleName($rolename){
		return \Roles::where('role', '=', $rolename)->first();
	}
	
	public function add($roleid,$userid){
		$userrole=new \UserRoles();
		$userrole->userid=$userid;
		$userrole->roleid=$roleid;
		$userrole->save();
	}
	
	public function delete($id){
		$role=\Roles::find($id);
		$role->delete();
	}
	
	public function updateUserRole($userid,$rolename){
		$role=$this->getRoleIdByRoleName($rolename);
		$userrole=\UserRoles::where('userid','=',$userid)->first();
		if(empty($role)){
			$userrole->roleid=2;
		}else{
			$userrole->roleid=$role->id;
		}
		$userrole->save();
	}
	
	public function getUserRole($id){
		$user_role= \UserRoles::find($id);
		return $user_role;
	}
	
	public function getUserRoleByUserId($userid){
		$role= \UserRoles::where('userid','=',$userid)->first();
		//\Log::info($role->role);
		if($role!=null){
			return $role->role['role'];
		}
	 return null;	
	}
	
	
}