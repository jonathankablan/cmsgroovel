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
namespace Groovel\Cmsgroovel\dao;
use Groovel\Cmsgroovel\models\RoutesGroovel;


class RouteDao implements RouteDaoInterface{

public function create($title,$url,$name){
	$routegroovel=new RoutesGroovel;
	$routegroovel->uri=$url;
	$routegroovel->name=$title;
	$routegroovel->action='get';
	$routegroovel->view='cmsgroovel::pages.demo';
	$routegroovel->type=$name['name'];
	$routegroovel->subtype='demo';
	$routegroovel->save();
}

	public function paginateRoutes(){
		return RoutesGroovel::where('type', '=', 'Groovel')->paginate(15);
	}

	public function paginateRoutesOnlyUser(){
		return RoutesGroovel::where('type', '!=', 'Groovel')->paginate(15);
	}

	public function getRouteByUri($uri){
		return RoutesGroovel::where('uri', '=', $uri)->first();
	}
	
	public function find($id){
		return RoutesGroovel::find($id);
	}
	
	public function deleteRoute($id){
		$routegroovel = RoutesGroovel::find($id);
		$routegroovel->delete();
	}
	
	public function updateRoute($id,$domain,$uri,$name,$controller,$method,$action,$view,$before_filter,$after_filter,$type,$subtype,$audit_url_enabled,$activate_route){
		$routegroovel = RoutesGroovel::find($id);
		$routegroovel->domain=$domain;
		$routegroovel->uri=$uri;
		$routegroovel->name=$name;
		$routegroovel->controller=$controller;
		$routegroovel->method=$method;
		$routegroovel->action=$action;
		$routegroovel->view=$view;
		$routegroovel->before_filter=$before_filter;
		$routegroovel->after_filter=$after_filter;
		$routegroovel->type=$type;
		$routegroovel->subtype=$subtype;
		$routegroovel->audit_tracking_url_enable=$audit_url_enabled;
		$routegroovel->activate_route=$activate_route;
		$routegroovel->save();
	}
	
	public function addRoute($domain,$uri,$name,$controller,$method,$action,$view,$before_filter,$after_filter,$type,$subtype,$audit_url_enabled,$activate_route){
		$routegroovel=new RoutesGroovel;
		$routegroovel->domain=$domain;
		$routegroovel->uri=$uri;
		$routegroovel->name=$name;
		$routegroovel->controller=$controller;
		$routegroovel->method=$method;
		$routegroovel->action=$action;
		$routegroovel->view=$view;
		$routegroovel->before_filter=$before_filter;
		$routegroovel->after_filter=$after_filter;
		$routegroovel->type=$type;
		$routegroovel->subtype=$subtype;
		$routegroovel->audit_tracking_url_enable=$audit_url_enabled;
		$routegroovel->activate_route=$activate_route;
		$routegroovel->save();
		return $routegroovel->id;
	}
	
	public function getRouteByViewName($view){
		return RoutesGroovel::where('view','=',$view)->where('type','!=','Groovel')->get();
	}

}