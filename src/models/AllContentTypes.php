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
class AllContentTypes extends Model{


	protected $table = 'all_contents_type';


	public $timestamps = true;



	protected $fillable = array('name','type','template','author_id','updated_at','created_at');

	public function author()
	{
		return $this->belongsTo('Groovel\Cmsgroovel\models\User');
	}
	
	public function contents() {
		return $this->hasMany('Groovel\Cmsgroovel\models\Contents','type_id','id'); // this matches the Eloquent model
	}
	
	public function getId()
	{
		return $this->attributes['id'];
	}
	
}