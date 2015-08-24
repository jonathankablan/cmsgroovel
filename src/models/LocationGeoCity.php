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
class LocationGeoCity extends Eloquent{


	protected $table = 'location_geo_cities';


	public $timestamps = false;



	protected $fillable = array('country','city','latitude','longitude');

	
	
	public function getId()
	{
		return $this->attributes['id'];
	}
	
}