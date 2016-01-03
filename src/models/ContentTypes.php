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
class ContentTypes extends Model{


	protected $table = 'content_types';


	public $timestamps = true;

	protected $casts = [
			'required' => 'boolean',
	];

	protected $fillable = array('tableName','fieldName','description','type','fieldValue','content_type','widget','required','updated_at','created_at');

	public function contents() {
		return $this->hasMany('Groovel\Cmsgroovel\models\Contents'); // this matches the Eloquent model
	}
	
	public function hasWidget(){
		return $this->hasOne('Groovel\Cmsgroovel\models\Widgets','id');
	}

	public function getTableName()
    {
        return $this->attributes['tableName'];
    }

	public function getFieldName()
    {
        return $this->attributes['fieldName'];
    }

    public function getDescription()
    {
        return $this->attributes['description'];
    }

    public function getFieldType()
    {
        return $this->attributes['type'];
    }
    
    public function getFieldValue()
    {
    	return $this->attributes['fieldValue'];
    }

   
     public function getFieldWidget()
    {
        return $this->attributes['widget'];
    }

    public function getId()
    {
    	return $this->attributes['id'];
    }
    
    public function getFieldRequired()
    {
    	return $this->attributes['required'];
    }
    
   
}