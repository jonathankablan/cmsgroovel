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
use  Groovel\Cmsgroovel\handlers\ElasticSearchHandler;
use  Groovel\Cmsgroovel\handlers\DatabaseSearchHandler;
use  Groovel\Cmsgroovel\commons\ModelConstants;

class Contents extends Model{


	protected $table = 'contents';


	public $timestamps = true;


	protected $fillable = array('author_id','type_id','description','ispublish','weight','uri','updated_at','created_at');
	
	
	public function translation()
	{
		return $this->hasMany('Groovel\Cmsgroovel\models\ContentsTranslation','refcontentid');
	}
	
	public function type(){
		return $this->belongsTo('Groovel\Cmsgroovel\models\AllContentTypes');
	}

	 public function author()
    {
        return $this->belongsTo('Groovel\Cmsgroovel\models\User');
    }
    
    public function getId()
    {
    	return $this->attributes['id'];
    }
}