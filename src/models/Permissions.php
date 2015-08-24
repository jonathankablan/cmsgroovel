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
use Illuminate\Database\Eloquent\Model;

class Permissions extends Eloquent{


	protected $table = 'permissions';


	public $timestamps = true;


	//protected $fillable = array('userid','actions','contenttypeid','owncontent','othercontent','updated_at','created_at');

	protected $fillable = array('userid','op_edit','op_save','op_update','op_delete','op_add','op_retrieve','contenttypeid','owncontent','othercontent','updated_at','created_at');
	
	
	public function user()
	{
		return $this->belongsTo('User','userid');
	}
	
	public function contentType()
	{
		return $this->belongsTo('AllContentTypes','contenttypeid');
	}
	
}