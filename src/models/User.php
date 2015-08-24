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
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;
use handlers\ElasticSearchHandler;
use handlers\DatabaseSearchHandler;
use commons\ModelConstants;

class User extends Eloquent implements UserInterface, RemindableInterface {

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
		return $this->hasMany('Permissions','userid');
	}
	
	public function role()
	{
		return $this->hasOne('UserRoles','userid');
	}


	public function getId()
	{
		return $this->attributes['id'];
	}
	
	
	
	
	
	
public static function boot()
	{
		parent::boot();
	
	User::updating(function($user)
	{
		$data=array('id'=>$user['id'],'title'=>$user['username'],'pseudo'=>$user['pseudo'],
				'url'=>'','grooveldescription'=>$user['username'].' '.$user['pseudo'],'created_at'=>$user['created_at'],'updated_at'=>$user['updated_at']);
	   
		\Queue::push('handlers\DatabaseSearchHandler@update', array('type'=>ModelConstants::$user,'data'=>$data));
		\Queue::push('handlers\ElasticSearchHandler@update', array('type'=>ModelConstants::$user,'data'=>$data));
	});
	
	User::saved(function($user)
	{
			
		$data=array('id'=>$user['id'],'title'=>$user['username'],'pseudo'=>$user['pseudo'],
				'url'=>'','grooveldescription'=>$user['username'].' '.$user['pseudo'],'created_at'=>$user['created_at'],'updated_at'=>$user['updated_at']);
			
		\Queue::push('handlers\DatabaseSearchHandler@create', array('type'=>ModelConstants::$user,'data'=>$data));
		\Queue::push('handlers\ElasticSearchHandler@create', array('type'=>ModelConstants::$user,'data'=>$data));
	});
	
	User::deleting(function($user)
	{
		$data=array('id'=>$user['id'],'title'=>$user['username'],'pseudo'=>$user['pseudo'],
				'url'=>'','grooveldescription'=>$user['username'].' '.$user['pseudo'],'created_at'=>$user['created_at'],'updated_at'=>$user['updated_at']);
		
		\Queue::push('handlers\DatabaseSearchHandler@delete', array('type'=>ModelConstants::$user,'data'=>$data));
		\Queue::push('handlers\ElasticSearchHandler@delete', array('type'=>ModelConstants::$user,'data'=>$data));
	});
}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
}
