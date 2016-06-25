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
use Groovel\Cmsgroovel\dao\RolePermissionsDao;
use Groovel\Cmsgroovel\dao\RoleDao;
use Groovel\Cmsgroovel\dao\RoleDaoInterface;
use Groovel\Cmsgroovel\dao\RolePermissionsDaoInterface;
use Groovel\Cmsgroovel\dao\PermissionsDao;
use Groovel\Cmsgroovel\dao\PermissionsDaoInterface;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Groovel\Cmsgroovel\models\Permissions;


class GroovelRolePermissionsManagerBusiness implements GroovelRolePermissionsManagerBusinessInterface{

private $rolePermissionsDao;
private $roleDao;
private $permissionsDao;

private static $perPage = 10;
	
	public function __construct(RolePermissionsDaoInterface $rolePermissionsDao,RoleDaoInterface $roleDao,PermissionsDao $permissionsDao)
	{
		$this->rolePermissionsDao =$rolePermissionsDao;
		$this->roleDao=$roleDao;
		$this->permissionsDao=$permissionsDao;
	}
	
	public function addRole($role){
		return $this->roleDao->addRole($role);
	}
	
	public function addRolePermissions($roleid,$action,$uri,$owncontent,$othercontent){
		 $permission=$this->permissionsDao->create($action, $uri, $owncontent, $othercontent);
		 $this->rolePermissionsDao->create($roleid,$permission->id);
		
	}
	
	public function getRoleByName($role){
		return $this->roleDao->findByRoleName($role);
	}
	
	public function getRole($role){
		return $this->roleDao->findByRoleId($role);
	}
	
	public function paginateRolePermission(){
		return $this->roleDao->paginate();
	}
   
}