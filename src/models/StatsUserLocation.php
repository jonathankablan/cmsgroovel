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
use handlers\ElasticSearchHandler;
use handlers\DatabaseSearchHandler;
use commons\ModelConstants;
class StatsUserLocation extends Eloquent{


	protected $table = 'stats_users_location';


	public $timestamps = true;



	protected $fillable = array('country','country_code_iso','city','people','latitude','longitude','isarchived','archived_at','created_at','updated_at');
	
	
}