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
use Groovel\Cmsgroovel\models\Menu;
use DB;

class MenuDao implements MenuDaoInterface{

	public function save($name,$langage,$menus,$layout){
		$menu=new Menu;
		$menu->name=$name;
		$menu->layout=$layout;
		$menu->lang=$langage['code'];
		$menu->menu=base64_encode(serialize($menus));
		$menu->save();
		return $menu->id;
	}
	
	public function find($id){
		$menu= Menu::where('id','=',$id)->first();
		$menu->menu=unserialize(base64_decode($menu->menu));
		return $menu;
	}
	
	public function findByNameAndLang($name,$lang){
		return Menu::where('name','=',$name)->where('lang','=',$lang)->first();
	}

	public function delete($id){
		$menu= Menu::find($id);
		$menu->delete($id);
	}
	
	public function paginateAllMenus(){
		$menus=Menu::paginate(15);
		return $menus;
	}
	
	public function paginate($langage,$layout){
	   if($langage!=null){
			return  Menu::where('lang','=',$langage)->where('layout','=',$layout)->get();
		}else{
			$menus= Menu::all();
			if($menus!=null){
				return array($menus['0']);
			}else return $menus;
		}
	}
}