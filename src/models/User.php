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
//use Illuminate\Auth\UserInterface;
//use Illuminate\Auth\Reminders\RemindableInterface;
namespace Groovel\Cmsgroovel\models;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Groovel\Cmsgroovel\handlers\ElasticSearchHandler;
use Groovel\Cmsgroovel\handlers\DatabaseSearchHandler;
use Groovel\Cmsgroovel\commons\ModelConstants;
use Illuminate\Database\Eloquent\Model;
use Groovel\Cmsgroovel\facades\auth\AuthAccessRules;
use Groovel\Cmsgroovel\log\LogConsole;


class User extends Model implements AuthenticatableContract, CanResetPasswordContract {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';
	

	protected $fillable = array('username','email','picture','pseudo','activate','lastTimeSeen','notification_email_enable','updated_at','created_at');

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password');
	
	/**
	 * Check media all access
	 *
	 * @return bool
	 */
	public function accessMediasAll()
	{
		// return true for access to all medias
		return ($this->role->role->role=='ADMIN');
	}
	
	/**
	 * Check media all access
	 *
	 * @return bool
	 */
	public function accessMediasFolder()
	{
		// return true for access to one folder
		return ($this->role->role->role!='ADMIN');
	}
	
	public function getUserName()
	{
		return $this->username;
	}
	
	public function getEmail()
	{
		return $this->email;
	}
	
	public function getPicture()
	{
		return $this->picture;
	}
	
	public function getPseudo()
	{
		return $this->pseudo;
	}
	
	public function getActivate()
	{
		return $this->activate;
	}	
	
	
	

	/**
	 * Get the unique identifier for the user.
	 *
	 * @return mixed
	 */
	public function getAuthIdentifier()
	{
		return $this->getKey();
	}

	/**
	 * Get the password for the user.
	 *
	 * @return string
	 */
	public function getAuthPassword()
	{
		return $this->password;
	}

	/**
	 * Get the token value for the "remember me" session.
	 *
	 * @return string
	 */
	public function getRememberToken()
	{
		return $this->remember_token;
	}

	/**
	 * Set the token value for the "remember me" session.
	 *
	 * @param  string  $value
	 * @return void
	 */
	public function setRememberToken($value)
	{
		$this->remember_token = $value;
	}

	/**
	 * Get the column name for the "remember me" token.
	 *
	 * @return string
	 */
	public function getRememberTokenName()
	{
		return 'remember_token';
	}

	/**
	 * Get the e-mail address where password reminders are sent.
	 *
	 * @return string
	 */
	public function getReminderEmail()
	{
		return $this->email;
	}

	
//ok for permissions
	public function permissions()
	{
		return $this->hasMany('Groovel\Cmsgroovel\models\Permissions','userid');
	}
	
	public function role()
	{
		return $this->hasOne('Groovel\Cmsgroovel\models\UserRoles','userid');
	}
	

	public function getId()
	{
		return $this->attributes['id'];
	}
	
	
	public function	getEmailForPasswordReset(){
		
		
	}
	
	
	
	public static function boot()
		{
			parent::boot();
		
		User::updating(function($user)
		{
			if(AuthAccessRules::getCurrentAction()!="op_none"
					 &&(AuthAccessRules::hasPermissionToOtherContent()==false && AuthAccessRules::hasPermissionToOwnContent($user->id)==false)){
				throw new \Exception(ModelConstants::$error_message);
			}
			$data=array('id'=>$user['id'],'title'=>$user['username'],'pseudo'=>$user['pseudo'],
					'description'=>'','tag'=>$user['username'].' '.$user['pseudo'],'created_at'=>$user['created_at'],'updated_at'=>$user['updated_at']);
		   
			\Queue::push('Groovel\Cmsgroovel\handlers\DatabaseSearchHandler@update', array('type'=>ModelConstants::$user,'data'=>$data));
			\Queue::push('Groovel\Cmsgroovel\handlers\ElasticSearchHandler@update', array('type'=>ModelConstants::$user,'data'=>$data));
		});
		
		User::saved(function($user)
		{
			if(AuthAccessRules::getCurrentAction()!="op_none"
					&&(AuthAccessRules::hasPermissionToOtherContent()==false && AuthAccessRules::hasPermissionToOwnContent($user->id)==false)){
				throw new \Exception(ModelConstants::$error_message);
			}
			$data=array('id'=>$user['id'],'title'=>$user['username'],'pseudo'=>$user['pseudo'],
					'description'=>'','tag'=>$user['username'].' '.$user['pseudo'],'created_at'=>$user['created_at'],'updated_at'=>$user['updated_at']);
				
			\Queue::push('Groovel\Cmsgroovel\handlers\DatabaseSearchHandler@create', array('type'=>ModelConstants::$user,'data'=>$data));
			\Queue::push('Groovel\Cmsgroovel\handlers\ElasticSearchHandler@create', array('type'=>ModelConstants::$user,'data'=>$data));
		});
		
		User::deleting(function($user)
		{
			LogConsole::debug("user deleting event");
			if(AuthAccessRules::getCurrentAction()!="op_none"
					&&(AuthAccessRules::hasPermissionToOtherContent()==false && AuthAccessRules::hasPermissionToOwnContent($user->id)==false)){
				throw new \Exception(ModelConstants::$error_message);
			}
			$data=array('id'=>$user['id'],'title'=>$user['username'],'pseudo'=>$user['pseudo'],
					'description'=>'','tag'=>$user['username'].' '.$user['pseudo'],'created_at'=>$user['created_at'],'updated_at'=>$user['updated_at']);
			
			\Queue::push('Groovel\Cmsgroovel\handlers\DatabaseSearchHandler@delete', array('type'=>ModelConstants::$user,'data'=>$data));
			\Queue::push('Groovel\Cmsgroovel\handlers\ElasticSearchHandler@delete', array('type'=>ModelConstants::$user,'data'=>$data));
		});
		
		
	}
	
	
	public function getAuthIdentifierName(){}
	
}
