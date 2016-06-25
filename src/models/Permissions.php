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

class Permissions extends Model{


	protected $table = 'permissions';


	public $timestamps = true;


	protected $fillable = array('op_create','op_read','op_update','op_delete','uri','owncontent','othercontent','updated_at','created_at');
	
	
	public function user()
	{
		return $this->belongsTo('Groovel\Cmsgroovel\models\User','userid');
	}
	
	public function contentType()
	{
		return $this->belongsTo('Groovel\Cmsgroovel\models\AllContentTypes','contenttypeid');
	}
	
}