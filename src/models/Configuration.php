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
use Groovel\Cmsgroovel\handlers\ElasticSearchHandler;
use Groovel\Cmsgroovel\handlers\DatabaseSearchHandler;
use  Groovel\Cmsgroovel\commons\ModelConstants;

class Configuration extends Model{


	protected $table = 'system_configuration';


	public $timestamps = false;



	protected $fillable = array('enable_user_tracking','enable_map_location','enable_elasticsearch','enable_maintenance','enable_email','enable_user_activation');
	
	
}