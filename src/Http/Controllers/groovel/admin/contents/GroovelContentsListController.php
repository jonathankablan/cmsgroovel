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

namespace Groovel\Cmsgroovel\Http\Controllers\groovel\admin\contents;
use Illuminate\Database\Eloquent\Model;
use Groovel\Cmsgroovel\Http\Controllers\groovel\admin\common\GroovelController;
use Monolog\Logger;
use Groovel\Cmsgroovel\business\groovel\admin\contents\GroovelContentManagerBusiness;
use Groovel\Cmsgroovel\business\groovel\admin\contents\GroovelContentManagerBusinessInterface;



class GroovelContentsListController extends GroovelController {

	protected $contentManager;
	
	

	public function __construct( GroovelContentManagerBusinessInterface $contentManager)
	{
		$this->contentManager=$contentManager;
		$this->beforeFilter('auth');
	}

	//load all contents into a view
	public function loadContents($site_extension){
		$lang=null;
		if($site_extension==='com'){
			$lang='US';
		}else if($site_extension==='fr'){
			$lang='FR';
		}else if($site_extension==='uk'){
			$lang='GB';
		}
		return $this->contentManager->paginateFullContentDeserialize($lang);
	}
	
	
	public function init(){
	     return \View::make('cmsgroovel.pages.admin_list_contents',['contents'=>$this->contentManager->paginateAllContent()]);
 	}

}
