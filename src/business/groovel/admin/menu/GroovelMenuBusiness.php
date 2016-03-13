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

namespace Groovel\Cmsgroovel\business\groovel\admin\menu;
use Illuminate\Database\Eloquent\Model;
use models;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Connection;
use Groovel\Cmsgroovel\dao\MenuDaoInterface;
use Groovel\Cmsgroovel\dao\MenuDao;
use Groovel\Cmsgroovel\dao\CountryDaoInterface;
use Groovel\Cmsgroovel\dao\CountryDao;


class GroovelMenuBusiness implements GroovelMenuBusinessInterface{
	
	private $menuDao;
	private $countryDao;
	
	
	public function __construct(MenuDaoInterface $menuDao,CountryDaoInterface $countryDao){
		$this->menuDao =$menuDao;
		$this->countryDao=$countryDao;
	}
    
	public function isMenuAlreadyExist($name,$langage){
		$codelang=$this->countryDao->findByName($langage);
		$menu=$this->menuDao->findByNameAndLang($name, $codelang['code']);
		if($menu!=null){
			return true;
		}else return false;
	}
	
	public function delete($id){
		$this->menuDao->delete($id);
	}
	
	public function saveMenu($id,$name,$langage,$newmenu,$layout){
		$codelang=$this->countryDao->findByName($langage);
		if($id!=null){
			$menu=$this->menuDao->find($id);
			$menu->delete();
		}
		return $this->menuDao->save($name, $codelang, $newmenu,$layout);
	}
	
	public function getAllCountries(){
		return $this->countryDao->all();
	}
	
	public function  paginateAllMenus(){
		return $this->menuDao->paginateAllMenus();
	}
	
	public function find($id){
		return $this->menuDao->find($id);
	}
	
	public function paginateFullMenuDeserialize($lang,$layout){
		$res= $this->menuDao->paginate($lang,$layout);
		return $res;
	}
}