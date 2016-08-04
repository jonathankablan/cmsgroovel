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

namespace Groovel\Cmsgroovel\Http\Controllers\groovel\admin\layout;
use Illuminate\Database\Eloquent\Model;
use Groovel\Cmsgroovel\Http\Controllers\groovel\admin\common\GroovelController;
use Monolog\Logger;
use Groovel\Cmsgroovel\business\groovel\admin\layout\GroovelLayoutBusiness;
use Groovel\Cmsgroovel\business\groovel\admin\layout\GroovelLayoutBusinessInterface;


/**
 * list layout
 */
class GroovelLayoutsListController extends GroovelController {

	protected $layoutManager;
	
	

	public function __construct( GroovelLayoutBusinessInterface $layoutManager)
	{
		$this->layoutManager=$layoutManager;
		$this->middleware('auth');
	}

	
	public function init(){
	     return \View::make('cmsgroovel.pages.admin_list_layouts',['layouts'=>$this->layoutManager->paginateAllLayouts()]);
 	}
 	
 	//load all contents into a view
 	public function loadLayouts($site_extension,$lang=null,$layout=null){
 		if($lang==null){
 			if($site_extension=='com'){
 				$lang='US';
 			}else if($site_extension=='fr'){
 				$lang='FR';
 			}else if($site_extension=='uk'){
 				$lang='GB';
 			}
 		}
 		return $this->layoutManager->paginateFullLayoutDeserialize($lang,$layout);
 	}

}
