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
namespace Groovel\Cmsgroovel\models;
use Illuminate\Database\Eloquent\Model;
use Groovel\Cmsgroovel\log\LogConsole;
use Groovel\Cmsgroovel\facades\auth\AuthAccessRules;
use Groovel\Cmsgroovel\commons\ModelConstants;

class Messages extends Model{


	protected $table = 'messages';


	public $timestamps = true;



	protected $fillable = array('subject','body','recipient','author','isalreadyread','created_at','updated_at');
	
	
	public function hasAuthor(){
		return $this->hasOne('Groovel\Cmsgroovel\models\User','pseudo','author');
	}
	
	public function hasRecipient(){
		return $this->hasOne('Groovel\Cmsgroovel\models\User','pseudo','recipient');
	}
	
	
	
	public static function boot()
	{
		parent::boot();
	
		
	
		Messages::deleting(function($message)
		{
			LogConsole::debug("user message event delete");
			if(AuthAccessRules::getCurrentAction()!="op_none"
					&&(AuthAccessRules::hasPermissionToOtherContent()==false && AuthAccessRules::hasPermissionToOwnContent($message->hasRecipient->id)==false)){
				throw new \Exception(ModelConstants::$error_message);
			}
			
		});
	
	
	}
	
	
	
}