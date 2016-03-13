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


namespace Groovel\Cmsgroovel\Http\Controllers\groovel\admin\page;
use Illuminate\Database\Eloquent\Model;
use Groovel\Cmsgroovel\Http\Controllers\groovel\admin\common\GroovelController;
use Monolog\Logger;
use Groovel\Cmsgroovel\Http\Controllers\groovel\admin\common\GroovelFormController;
use Groovel\Cmsgroovel\business\groovel\admin\layout\GroovelLayoutBusiness;
use Groovel\Cmsgroovel\business\groovel\admin\layout\GroovelLayoutBusinessInterface;
use Groovel\Cmsgroovel\business\groovel\admin\routes\GroovelRoutesBusiness;
use Groovel\Cmsgroovel\business\groovel\admin\routes\GroovelRoutesBusinessInterface;



class GroovelPageController extends GroovelFormController {
	
	private $layoutManager;
	private $routeManager;
	
		
	public function __construct(GroovelRoutesBusinessInterface $routeManager,GroovelLayoutBusinessInterface $layoutManager)
	{
		$this->routeManager=$routeManager;
		$this->layoutManager=$layoutManager;
	}
	
	
	
	public function init(){
		return \View::make('cmsgroovel.pages.page.admin_page_form',['layouts'=>$this->layoutManager->layouts()]);
	}
	

	public function createRoute($uri,$name,$controller,$method,$action,$view,$template,$activate_route){
		return $this->routeManager->addRoute(null,$uri,$name,$controller,$method,$action,$view,null,null,$template,'public','0',$activate_route);
	}
	
	public function validateForm($params) {
		if (\Request::is('*/pages/add')){
			$rules=array();
			$rules['title']='required';
			$rules['view']='required';
			$rules['url']='required';
			$rules['template']='required';
			$pageid=\Input::get('page_id');	
			$url=\Input::get('url');
			if($url!=null){
				$urlvalid='http://localhost/'.$url;
				$validInput['url']=$urlvalid;
			}
			$validInput=\Input::all();
			$validation = \Validator::make($validInput, $rules);
			if($validation->passes()){
				$rules2=array();
				$rules2['url']='required';
				if($pageid==null){
					$rules2['url']='required|unique:routes_groovel,uri';
				}
				$validation2 = \Validator::make(array('url'=>\Input::get('url')), $rules2);
				if($validation2->passes()){
					ini_set ('max_execution_time', 0);
					if(!$this->checkExistBladeGenericPage(\Input::get('template'))){
						return $this->jsonResponse('file index.blade.php missing in your layout',false,true,true);
					}
					if($pageid==null){ 
						$this->generateBladeTemplatesPage(\Input::get('view').'.'.'blade.php',\Input::get('template'));
						$id= $this->createRoute(\Input::get('url'),\Input::get('title'),null,null,'op_retrieve',\Input::get('template').'.'.'pages'.'.'.\Input::get('view'),\Input::get('template'),\Input::get('activate_route'));
						$page=$this->getFilePage(\Input::get('template').'.'.'pages'.'.'.\Input::get('view'));
						\Session::put('page_edit',$page);
						return $this->jsonResponse(array('id'=>$id,'url'=>\Input::get('url'),'page added done'),false,true,false);
					}else{
						$route=$this->routeManager->find($pageid);
						$rules2['url']='required|unique:routes_groovel,uri';
						$validation2 = \Validator::make(array('url'=>\Input::get('url')), $rules2);
						$pd=$this->routeManager->find($pageid);
						if($pd!=null){
							$this->routeManager->deleteRoute($pageid);
						}
						if($validation2->passes()){
							if($pd!=null){
								$view= explode('.',$route->view);
								$ln=count($view);
								$this->deleteFile($route->type, $view[$ln-1].'.'.'blade.php');
							}
							$id= $this->createRoute(\Input::get('url'),\Input::get('template'),null,null,'op_retrieve',\Input::get('template').'.'.'pages'.'.'.\Input::get('view'),\Input::get('template'),\Input::get('activate_route'));
							$this->generateBladeTemplatesPage(\Input::get('view').'.'.'blade.php',\Input::get('template'));
							$page=$this->getFilePage(\Input::get('view'));
							\Session::put('page_edit',$page);
							return $this->jsonResponse(array('id'=>$id,'url'=>\Input::get('url'),'page added done'),false,true,false);
						}else{
							$validation2->getMessageBag()->add('page', 'please check errors');
							$messages=$validation2->messages();
							$formatMess=null;
							foreach ($messages->all() as $message)
							{
								$formatMess=$message.'- '.$formatMess;
							}
							return $this->jsonResponse($formatMess,false,true,true);
						}
					}
					return $this->jsonResponse(array('id'=>$id,'page added done'),false,true,false);
				}else if($validation2->fails()){
					$validation2->getMessageBag()->add('page', 'please check errors');
					$messages=$validation2->messages();
					$formatMess=null;
					foreach ($messages->all() as $message)
					{
						$formatMess=$message.'- '.$formatMess;
					}
					return $this->jsonResponse($formatMess,false,true,true);
				}
			}else if($validation->fails()){
				$validation->getMessageBag()->add('page', 'Please check errors');
				$messages=$validation->messages();
				$formatMess=null;
				foreach ($messages->all() as $message)
				{
					$formatMess=$message.'- '.$formatMess;
				}
				return $this->jsonResponse($formatMess,false,true,true);
			}
		}else if(\Request::is('*/pages/delete')){
			$pageid=\Input::get('page_id');
			$route=$this->routeManager->find($pageid);
			\Session::forget('page_edit');
			if($route!=null){
				$view= explode('.',$route->view);
				$ln=count($view);
				$this->deleteFile($route->type, $view[$ln-1].'.'.'blade.php');
				$this->routeManager->deleteRoute($pageid);
			}
			return $this->jsonResponse(array('page deleted done'),false,true,false);
		}
	}
	
	function recurse_copy($src, $dst) {
		$dir = opendir($src);
		$result = ($dir === false ? false : true);
		if ($result !== false) {
			while(false !== ( $file = readdir($dir)) ) {
				if (( $file != '.' ) && ( $file != '..' ) && $result) {
					if ( is_dir($src . '/' . $file) ) {
						$result = self::recurse_copy($src . '/' . $file,$dst . '/' . $file);
					}     else {
						if (!is_dir($dst)) {
							mkdir($dst, 0700,true);
						}
						$result = copy($src . '/' . $file,$dst . '/' . $file);
					}
				}
			}
			closedir($dir);
		}
		return $result;
	}
	
	function checkExistBladeGenericPage($layoutName){
		//find generic page call index.blade
		$dst_pages=base_path () . '/resources/views/'.$layoutName.'/pages';
		$path=$dst_pages . '/' . 'index.blade.php';
		return  file_exists($path);
	}
	
	function deleteFile($layoutName,$pageName){
		$dst_base=base_path () . '/resources/views/'.$layoutName.'/base';
		$dst_includes=base_path () . '/resources/views/'.$layoutName.'/includes';
		$page=base_path () . '/resources/views/'.$layoutName.'/pages/'.$pageName;
		if(file_exists($page)){
			unlink($page);
		}
	}
	

	
	function generateBladeTemplatesPage($pageName,$layoutName){
		$dst_base=base_path () . '/resources/views/'.$layoutName.'/base';
		$dst_includes=base_path () . '/resources/views/'.$layoutName.'/includes';
		$dst_pages=base_path () . '/resources/views/'.$layoutName.'/pages';
		
		$dir = opendir($dst_pages);
		$result = ($dir === false ? false : true);
		if ($result !== false) {
			$result = copy($dst_pages . '/' . 'index.blade.php',$dst_pages . '/' . $pageName);
		}
		closedir($dir);
	}
	
	public function processForm(){
		
		
		
	}
	
	public function jsonResponse($param, $print = false, $header = true,$error=false) {
		if (is_array($param) && !$error) {
			$out = array(
					'success' => true
			);
	
			if (array_key_exists('datas',$param) && is_array($param['datas']) ) {
				$out['datas'] = $param['datas'];
				unset($param['datas']);
				$out = array_merge($out, $param);
			} else {
				$out['datas'] = $param;
			}
	
		}else if (is_bool($param) &&!$error) {
			$out = array(
					'success' => $param
			);
		} else if($error) {
			$out = array(
					'success' => false,
					'errors' => array(
							'reason' => $param
					)
			);
		}
	
		$out = json_encode($out);
	
		if ($print) {
			if ($header) header('Content-type: application/json');
	
			echo $out;
			return;
		}
	
		return $out;
	}
	
	
	public function getFilePage($viewName){
		$view= explode('.',$viewName);
		$dir_pages=base_path () . '/resources/views/'.$view[0].'/pages';
		$ln=count($view);
		$page_name=$view[$ln-1];
		$data = file_get_contents($dir_pages.'/'.$page_name.'.blade.php');
		return $data;
	}
	
	
	
}