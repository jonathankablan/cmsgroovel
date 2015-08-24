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

class UserRoles extends Eloquent{


	protected $table = 'user_roles';
	
	public $timestamps = true;
	
	protected $fillable = array('userid','roleid','updated_at','created_at');
	
	public function role()
	{
		return $this->hasOne('Roles','id','roleid');
	}
	
	public function user()
	{
		return $this->belongsTo('User','userid');
	}
	
	
	public function getId()
	{
		return $this->attributes['id'];
	}
	
}