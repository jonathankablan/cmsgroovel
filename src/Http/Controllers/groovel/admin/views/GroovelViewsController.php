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

namespace Groovel\Cmsgroovel\Http\Controllers\groovel\admin\filters;
use Illuminate\Database\Eloquent\Model;
use Groovel\Cmsgroovel\Http\Controllers\groovel\admin\common\GroovelController;
use Monolog\Logger;
use Groovel\Cmsgroovel\Http\Controllers\groovel\admin\routes\GroovelRouteController;

class GroovelViewsController extends GroovelController {
 
   public function getAllData(){

     $routegroovel=new GroovelRouteController();
     $route= $routegroovel->getRouteFromSession();
     if (\Auth::guest() && $route->before_filter=='yes'){
   		return \View::make('cmsgroovel.pages.login_form');
  	 }else{
     		 \View::make('cmsgroovel.pages.login_form');
  	 }

   $app = App();
   $controller = $app->make('Groovel\Cmsgroovel\Http\Controllers\groovel\admin\routes\GroovelRouteController');
   $params =array('method'=>$route->method,'controller'=>$route->controller,'before_filter'=>$route->before_filter);
     return $controller->callAction('dispatcher',array($params));
   }
 
}