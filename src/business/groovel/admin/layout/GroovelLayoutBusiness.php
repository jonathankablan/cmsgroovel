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

namespace Groovel\Cmsgroovel\business\groovel\admin\layout;
use Groovel\Cmsgroovel\business\groovel\admin\layout\GroovelLayoutBusinessInterface;
use Groovel\Cmsgroovel\dao\CountryDaoInterface;
use Groovel\Cmsgroovel\dao\CountryDao;
use Groovel\Cmsgroovel\dao\LayoutDaoInterface;

class GroovelLayoutBusiness implements GroovelLayoutBusinessInterface{
	
	private $countryDao;
	
	private $layoutDao;
	
	public function __construct(LayoutDaoInterface $layoutDao,CountryDaoInterface $countryDao){
		$this->countryDao=$countryDao;
		$this->layoutDao=$layoutDao;
	}
	
	public function delete($id){
		$this->layoutDao->delete($id);
	}
	
	private function listAllTemplates(){
		$dir_vendor= base_path () . '/starter-templates/layouts/*';
		$template_directories = glob ( $dir_vendor, GLOB_ONLYDIR );
		$template_names=array();
		foreach ( $template_directories as $templatenamedir ) {
			$exp = explode ( "/", $templatenamedir );
			$templateName = $exp [sizeof ( $exp ) - 1];
			$template_names[$templateName ]=$templateName ;
		}
	   
		//merge with resources/views
		$dir_resources_views= base_path () . '/resources/views/*';
		$template_directories = glob ( $dir_resources_views, GLOB_ONLYDIR );
		foreach ( $template_directories as $templatenamedir ) {
			$exp = explode ( "/", $templatenamedir );
			$templateName = $exp [sizeof ( $exp ) - 1];
			if('cmsgroovel'!=$templateName){
				$template_names[$templateName ]=$templateName ;
			}
		}
		
		return $template_names;
	}
	
	public function getAllCountries(){
		return $this->countryDao->all();
	}
   
	public function save($langage,$title,$header,$footer,$layout,$logo){
		$codelang=$this->countryDao->findByName($langage);
		return $this->layoutDao->save($codelang, $title, $header, $footer,$layout,$logo);
	}
	
	public function paginateAllLayouts(){
		return $this->layoutDao->paginateAllLayouts();
	}
	
    public function layouts(){
		return $this->listAllTemplates();
	}
	

	public function find($id){
		$layout=$this->layoutDao->find($id);
		return $layout;
	}
	
	public function update($id, $langage, $title, $header, $footer,$logo){
		$this->layoutDao->update($id,$langage, $title, $header, $footer,$logo);
	}
	
	public function paginateFullLayoutDeserialize($lang,$layout){
		return $this->layoutDao->paginate($lang,$layout);
	}
	
}