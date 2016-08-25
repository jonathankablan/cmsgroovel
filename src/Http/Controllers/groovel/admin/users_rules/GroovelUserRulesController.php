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
use Groovel\Cmsgroovel\log\LogConsole;
use Groovel\Cmsgroovel\facades\auth\AuthAccessRules;

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
				LogConsole::debug("PARAMS ACCESSURL");
				LogConsole::debug($params);
				LogConsole::debug("Groovel\Cmsgroovel\Http\Controllers\groovel\admin\users_rules\GroovelUserRulesController.checkAccessRulesURL START METHOD ");
				LogConsole::debug("user is ". $user);
				 
				if(!empty($user)){
					if(!AuthAccessRules::isstarted()){
						LogConsole::debug("START INIT RULES");
						$role=$this->userRoleManager->getUserRoleByUserId($user->id);
						LogConsole::debug("user id: ".$user->id ." role: ".$role->role['role']);
						if($role!=null && !empty($role) && count($role)>0){
							if($role->role['role']=='ADMIN'){
								AuthAccessRules::putRole($role->role['role']);
								LogConsole::debug(" user is admin ");
								LogConsole::debug("Groovel\Cmsgroovel\Http\Controllers\groovel\admin\users_rules\GroovelUserRulesController.checkAccessRulesURL END METHOD");
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
				
						AuthAccessRules::start($permissions,$role->role['role']);
					}
						return AuthAccessRules::hasAccess($params['uri'], $params['action']);
					
				}else if(empty($user)){
					if($params['action']=='op_none'){
						AuthAccessRules::putCurrentAction($params['action']);
						LogConsole::debug("public access true ");
						LogConsole::debug("Groovel\Cmsgroovel\Http\Controllers\groovel\admin\users_rules\GroovelUserRulesController.checkAccessRulesURL END METHOD");
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