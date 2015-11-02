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
namespace Groovel\Cmsgroovel\business\groovel\admin\routes;

interface GroovelRoutesBusinessInterface {
	
	public function paginateRoutes();
	
	public function paginateRoutesOnlyUser();
	
	public function getRouteByUri($uri);
	
	public function addRoute($domain,$uri,$name,$controller,$method,$action,$view,$before_filter,$after_filter,$type,$subtype,$audit_url_enabled,$activate_route);
	
	public function deleteRoute($id);
	
	public function find($id);
	
	public function updateRoute($id,$domain,$uri,$name,$controller,$method,$action,$view,$before_filter,$after_filter,$type,$subtype,$audit_url_enabled,$activate_route);
	
	public function getSubtypeList();
	
	public function getRouteByViewName($view);
}