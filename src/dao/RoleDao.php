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

namespace Groovel\Cmsgroovel\dao;

use \Carbon\Carbon;
use Groovel\Cmsgroovel\models\User;
use Groovel\Cmsgroovel\models\Roles;

class RoleDao implements RoleDaoInterface{

	public function addRole($name){
		$role= new Roles();
		$role->role=$name;
		$role->save();
		return $role;
	}
	public function findByRoleId($role){
		return Roles::where('id','=',$role)->first();
	}
	
	public function findByRoleName($role){
		return Roles::where('role','=',$role)->first();
	}
	
	public function paginate(){
		return Roles::paginate(15);
	}
}