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
class RoutesGroovel extends Model{


protected $table = 'routes_groovel';


public $timestamps = true;

protected $fillable = array('domain','uri','name','controller','method','action','view','before_filter','after_filter','type','subtype','audit_tracking_url_enable','activate_route');

	public function getUri()
    {
        return $this->attributes['uri'];
    }


}