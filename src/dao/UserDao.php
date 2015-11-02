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

class UserDao implements UserDaoInterface{

	public function getAllUsersAdmin(){
		$pdo=\DB::connection()->getPdo();
		$pdo->beginTransaction();
		$pdo->setAttribute(\PDO::ATTR_EMULATE_PREPARES, false);
		$q=$pdo->prepare("SELECT u.pseudo FROM users u,user_roles r, roles ro  WHERE u.id=r.userid and r.roleid=ro.id and ro.role=\"ADMIN\"");
		$q->execute();
		$res=$q->fetchAll(\PDO::FETCH_COLUMN, 0);
		$pdo->commit();
		return $res;
	}
	
	
	public function setLastTimeSeen($pseudo){
		$now=\Carbon\Carbon::now();
		$user = User::where('pseudo', '=', $pseudo)->first();
		$user->lastTimeSeen=$now;
		$user->save();
	}
	

	
	public function getTotalUsers(){
		return \DB::table('users')->count();
	}
	
	public function getUserByPseudo($pseudo){
		$user = User::where('pseudo', '=', $pseudo)->first();
		return $user;
	}
	
	public function getUserByEmail($email){
		$user = User::where('email', '=', $email)->first();
		return $user;
	}
	
	public function getTotalUsersConnectedByDays(){
		$pdo=\DB::connection()->getPdo();
		$pdo->beginTransaction();
		$pdo->setAttribute(\PDO::ATTR_EMULATE_PREPARES, false);
		$q=$pdo->prepare("SELECT COUNT(*) FROM users WHERE LastTimeSeen > DATE_SUB(NOW(), INTERVAL 24 HOUR)");
		$q->execute();
		$res=$q->fetchAll(\PDO::FETCH_COLUMN, 0);
		$pdo->commit();
		return $res['0'];
		
	}
	
	public function getUser($id){
		$user = User::find($id);
		$user=array('id'=>$id,
				'userpicture'=>$user->picture,
				'username'=>$user->username,
				'password'=>'',
				'pseudo'=>$user->pseudo,
				'email'=>$user->email,
				'created_at'=>$user->created_at,
				'updated_at'=>$user->updated_at,
				'activate'=>$user->activate,
				'notification_email_enable'=>$user->notification_email_enable
		);
		return $user;
	}
	
	public function paginate(){
		$users=User::paginate(15);
		return $users;
	}
	
	public function addUser($picture,$username,$pseudo,$email,$password,$activate,$enable_notification_email){
		$user = new User();
		$user->picture=$picture;
		$user->username=$username;
		if(!empty($password)){
			$user->password=\Hash::make($password);
		}
		$user->pseudo=$pseudo;
		$user->email=$email;
		$user->activate=$activate;
		$user->notification_email_enable=$enable_notification_email;
		$user->save();
	
	}
	
	public function updateUser($picture,$id,$username,$pseudo,$email,$password,$activate,$enable_notification_email){
		$user=User::find($id);
		$user->picture=$picture;
		$user->username=$username;
		if(!empty($password)){
			$user->password=\Hash::make($password);
		}
		$user->pseudo=$pseudo;
		$user->email=$email;
		if($activate!=null){
			$user->activate=$activate;
		}
		$user->notification_email_enable=$enable_notification_email;
		$user->save();
	}
	
	public function find($id){
		return User::find($id);
	}
	
	public function delete($id){
		$user = User::find($id);
		$user->delete();
	}
	
	public function activateUser($userid){
		$user=User::find($userid);
		$user->activate=1;
		$user->save();
	}
	
	public function blockUser($userid){
		$user=User::find($userid);
		$user->activate=0;
		$user->save();
	}
}