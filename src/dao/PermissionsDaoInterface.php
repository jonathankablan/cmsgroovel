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

interface PermissionsDaoInterface{

	public function create($action,$type,$owncontent,$othercontent);
	/*public function updateUserPermissions($permissionid,$userid,$contenttype,$actions,$owncontent,$othercontent);
	public function deleteUserPermission($id);
	public function getPermissionByUserid($id);
	public function getPermissionsByContentTypeAndActionAndUserId($userid,$typeid,$action);
	public function getPermissionById($id);
	public function paginate();
	public function getPermissionsByContentTypeAndAction($typeid,$action);*/
	
}