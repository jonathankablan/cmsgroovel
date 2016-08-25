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

interface GroovelUserManagerBusinessInterface{
	
	public function getUser($id);
	public function addUser($picture,$username,$pseudo,$email,$password,$activate,$notification_email_enable);
	public function updateUser($picture,$id,$username,$pseudo,$email,$password,$activate=null,$notification_email_enable);
	public function deleteUser($id);
	public function paginateUser();
	public function addUserPermissions($userid,$contenttype,$actions,$owncontent,$othercontent);
	public function updateUserPermissions($userid,$contenttype,$actions,$owncontent,$othercontent);
	public function removeUserPermissions($userid,$contenttype,$actions,$owncontent,$othercontent);
	public function addUserRole($userid,$roleid);
	public function removeUserRole($userid,$roleid);
	public function paginateUserPermission();
	public function paginateUserRole();
	public function getUserByUsername($username);
	public function getUserPermissions($username);
	public function getPermissionsByContentTypeAndAction($content_type,$action);
	public function getUserByPseudo($pseudo);
	public function getUserByEmail($email);
	public function activateUser($userid);
	public function blockUser($userid);
	public function setLastTimeSeen($pseudo);
	public function getUserRole($id);
	public function getAllUsersAdmin();
	public function checkUserByEmailIsUnique($email,$pseudo);
	public function searchUser($pseudo);
	
}