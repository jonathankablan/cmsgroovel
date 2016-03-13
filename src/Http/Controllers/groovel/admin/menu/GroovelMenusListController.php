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

namespace Groovel\Cmsgroovel\Http\Controllers\groovel\admin\menu;
use Illuminate\Database\Eloquent\Model;
use Groovel\Cmsgroovel\Http\Controllers\groovel\admin\common\GroovelController;
use Monolog\Logger;
use Groovel\Cmsgroovel\business\groovel\admin\menu\GroovelMenuBusiness;
use Groovel\Cmsgroovel\business\groovel\admin\menu\GroovelMenuBusinessInterface;



class GroovelMenusListController extends GroovelController {

	protected $menuManager;
	
	

	public function __construct( GroovelMenuBusinessInterface $menuManager)
	{
		$this->menuManager=$menuManager;
		$this->beforeFilter('auth');
	}

	
	public function init(){
	     return \View::make('cmsgroovel.pages.admin_list_menus',['menus'=>$this->menuManager->paginateAllMenus()]);
 	}
 	
 	public function loadMenus($site_extension,$lang=null,$layout=null){
 		if($lang==null){
 			if($site_extension=='com'){
 				$lang='US';
 			}else if($site_extension=='fr'){
 				$lang='FR';
 			}else if($site_extension=='uk'){
 				$lang='GB';
 			}
 		}
 		$menus=$this->menuManager->paginateFullMenuDeserialize($lang,$layout);
 		$listMenus=array();
 		foreach($menus as $menubin){
 			$menu=unserialize(base64_decode($menubin['menu']));
 			$myMenu ='';
	 		$level=0;
	 		foreach($menu as $arr){
	 			foreach($arr as $arr1){
	 				$myMenu .= $this->generateHTMLMenu($arr1,$level);
	 				$level=0;
	 			}
	 		}
	 		$res= $myMenu;
	 	    array_push($listMenus,['menuid'=>$menubin['id'],'title'=>$menubin['name'],'layout'=>$menubin['layout'],'menu'=> $res]);
 		}
 		return $listMenus;
 	}

 	
 	/**override it to generate other style menu**/
 	public function generateHTMLMenu($arr,&$level){
 		$str = '';
 		if(is_array($arr)){
 			$str .= "<li>";
 			if($level==0){
 				$a='<a href=\''.$arr['name']['uri']."'>".$arr['name']['name'].'</a>';
 			}
 			else if($level==1){
 				$a='<a href=\''.$arr['name']['uri']."'>".$arr['name']['name'].'</a>';
 			}
 			else if($level==2){
 				$a='<a href=\''.$arr['name']['uri']."'>".$arr['name']['name'].'</a>';
 			}
 			else if($level==3){
 				$a='<a href=\''.$arr['name']['uri']."'>".$arr['name']['name'].'</a>';
 			}
 			$str .=$a;
 			if(!empty($arr['child'])){
 				$str .="<ul>";
 				$level=$level+1;
 	
 				foreach($arr['child'] as $child){
 					$str .= $this->generateHTMLMenu($child,$level);
 				}
 				$str .="</ul>";
 			}
 			$str .= "</li>";
 		}
 		return $str;
 	}
 	
}
