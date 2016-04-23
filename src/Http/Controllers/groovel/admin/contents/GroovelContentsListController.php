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
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Groovel\Cmsgroovel\business\groovel\admin\configuration\GroovelConfigurationBusinessInterface;


class GroovelContentsListController extends GroovelController {

	protected $contentManager;
	
	protected $configurationManager;
	
	private static $perPage = 100;
	

	public function __construct( GroovelContentManagerBusinessInterface $contentManager,GroovelConfigurationBusinessInterface  $configurationManager)
	{
		$this->contentManager=$contentManager;
		$this->configurationManager=$configurationManager;
		$this->beforeFilter('auth');
	}

	
	//load all contents into a view
	public function loadContents($site_extension,$lang=null,$layout=null){
		if($lang==null){
			if($site_extension=='com'){
				$lang='US';
			}else if($site_extension=='fr'){
				$lang='FR';
			}else if($site_extension=='uk'){
				$lang='GB';
			}
		}   
		
			self::$perPage=$this->configurationManager->getMaxContentsNumber();
			
			$contents= $this->contentManager->paginateFullContentDeserialize($lang,$layout);
			
			$currentPage = \Input::get('page')-1;
			if($currentPage<0){
				$currentPage=0;
			}
			$pagedData = array_slice( $contents, $currentPage * self::$perPage, self::$perPage);
			$currentPage = LengthAwarePaginator::resolveCurrentPage() ?: 1;
			$paginator = new LengthAwarePaginator($pagedData, count( $contents),  self::$perPage, $currentPage, [
					'path'  => Paginator::resolveCurrentPath()
			
			]);
		return $paginator;
	}
	
	
	public function init(){
	     return \View::make('cmsgroovel.pages.admin_list_contents',['contents'=>$this->contentManager->paginateAllContent()]);
 	}

}
