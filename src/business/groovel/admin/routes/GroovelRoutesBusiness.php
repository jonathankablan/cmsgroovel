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


namespace business\groovel\admin\routes;
use Illuminate\Database\Eloquent\Model;
use dao\RouteDao;
use dao\SubtypeDao;

class GroovelRoutesBusiness implements \GroovelRoutesBusinessInterface{

	
	private $routeDao;
	
	private $subtypeDao;
	
	public function __construct(\RouteDaoInterface $routeDao,\ContentTypeDaoInterface $subtypeDao)
	{
		$this->routeDao =$routeDao;
		$this->subtypeDao=$subtypeDao;
	}
	
	public function getSubtypeList(){
		$subs=array();
		foreach($this->subtypeDao->findAllSystemContentType() as $sub){
			array_push($subs,$sub->name);
		}
		return $subs;
	}
	
	public function paginateRoutes(){
		return $this->routeDao->paginateRoutes();
	}

	public function paginateRoutesOnlyUser(){
		return $this->routeDao->paginateRoutesOnlyUser();
	}

	public function getRouteByUri($uri){
		return $this->routeDao->getRouteByUri($uri);
	}
	
	public function deleteRoute($id){
		$this->routeDao->deleteRoute($id);
	}
	
	public function find($id){
		return $this->routeDao->find($id);
	}
	
	public function updateRoute($id,$domain,$uri,$name,$controller,$method,$action,$view,$before_filter,$after_filter,$type,$subtype,$audit_url_enabled,$activate_route){
		 $this->routeDao->updateRoute($id,$domain,$uri,$name,$controller,$method,$action,$view,$before_filter,$after_filter,$type,$subtype,$audit_url_enabled,$activate_route);
	}
	
	public function addRoute($domain,$uri,$name,$controller,$method,$action,$view,$before_filter,$after_filter,$type,$subtype,$audit_url_enabled,$activate_route){
		$this->routeDao->addRoute($domain,$uri,$name,$controller,$method,$action,$view,$before_filter,$after_filter,$type,$subtype,$audit_url_enabled,$activate_route);
	}
	
	public function getRouteByViewName($view){
		return $this->routeDao->getRouteByViewName($view);
	}
}
