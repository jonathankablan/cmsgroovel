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
use Groovel\Cmsgroovel\models\Permissions;


class PermissionsDao implements PermissionsDaoInterface{

 public function create($action,$uri,$owncontent,$othercontent){
	$permission= new Permissions();
	foreach($action as $key=>$value){
        switch($key){
		
			case 'create':$permission->op_create=$value;break;
			
			case 'read': $permission->op_read=$value;break;
		
	     	case 'update': $permission->op_update=$value;break;
	        	
			case 'delete':$permission->op_delete=$value;break;
			
			default :\Log::info('nothing');
		}
	}
	$permission->uri=$uri;
	$permission->owncontent=$owncontent;
	$permission->othercontent=$othercontent;
	$permission->save();
	return $permission;
 }
 
 /*public function updateUserPermissions($permissionid,$userid,$contenttype,$action,$owncontent,$othercontent){
  $permission=Permissions::find($permissionid);
  $permission->userid=$userid;
  foreach($action[0] as $key=>$value){
  	switch($key){
  
  		case 'edit':$permission->op_edit=$value[0];break;
  			
  		case 'save': $permission->op_save=$value[0];break;
  
  		case 'update': $permission->op_update=$value[0];break;
  
  		case 'delete':$permission->op_delete=$value[0];break;
  			
  		case 'add':$permission->op_add= $value[0];break;
  			
  		case 'retrieve':$permission->op_retrieve= $value[0];break;
  			
  		default :\Log::info('nothing');
  	}
  }
  $permission->contenttypeid=$contenttype;
  $permission->owncontent=$owncontent;
  $permission->othercontent=$othercontent;
  $permission->save();
 
 }

 public function deleteUserPermission($id){
 	$permission=Permissions::find($id);
 	$permission->delete();
 }
 
 public function getPermissionByUserid($id){
 	return Permissions::where('userid','=',$id)->get();
 }
 
 public function getPermissionsByContentTypeAndActionAndUserId($userid,$typeid,$action){
 	return \DB::table('permissions')->select(\DB::raw('*'))
 	->where('userid', '=', $userid)
 	->where('contenttypeid', '=', $typeid)
 	->where('actions', '=', $action)
 	->get();
 	
 }
 
 public function getPermissionsByContentTypeAndAction($typeid,$action){
  return Permissions::where('contenttypeid','=',$typeid)->andWhere('actions','=',$action)->get();
 }
 
 public function getPermissionById($id){
 	return Permissions::find($id);
 }
 
 public function paginate(){
 	return Permissions::paginate(15);
 }*/

}