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

namespace Groovel\Cmsgroovel\Http\Controllers\groovel\admin\routes;
use Illuminate\Database\Eloquent\Model;
use models;
use Groovel\Cmsgroovel\Http\Controllers\groovel\admin\common\GroovelFormController;
use Groovel\Cmsgroovel\business\groovel\admin\routes\GroovelRoutesBusiness;
use Groovel\Cmsgroovel\business\groovel\admin\routes\GroovelRoutesBusinessInterface;
use Groovel\Cmsgroovel\business\groovel\admin\layout\GroovelLayoutBusiness;
use Groovel\Cmsgroovel\business\groovel\admin\layout\GroovelLayoutBusinessInterface;

class GroovelRoutesFormController extends GroovelFormController {

	
	protected $routeBusiness;
	private $layoutManager;
	
	
	public function __construct( GroovelRoutesBusinessInterface $routeBusiness,GroovelLayoutBusinessInterface $layoutManager)
	{
		$this->routeBusiness =$routeBusiness;
		$this->layoutManager=$layoutManager;
		$this->middleware('auth');
	}
	
	public function init(){
		$subtypes=$this->routeBusiness->getSubtypeList();
		$layouts=$this->layoutManager->layouts();
		array_push($layouts,'Groovel');
		return \View::make('cmsgroovel.pages.admin_form_route',['subtypes'=>$subtypes,'layouts'=>$layouts]);
	}
	
	
	public function validateForm($params)
	{
		if(\Request::is('admin/pages/code/save')){
			return $this->processForm();
		}
		$rulesadd = array(
				'name' => 'required',
				'uri' => 'required|unique:routes_groovel',
				'subtype'=>'required'
		);
		$validation=null;
		$rulesupdate = array(
				'name' => 'required',
				'uri' => 'required',
				'subtype'=>'required'
		);
			
		if(\Request::is('*/routes/add')){
			$this->checkToken();
			$validation = \Validator::make(\Input::all(), $rulesadd);
		}
		else  if(\Request::is('*/routes/update')){
			$this->checkToken();
			$input=\Input::all();
			if(empty($input)){
				$input=\Input::all();
			}
			$validation = \Validator::make($input, $rulesupdate);
		}
		else if (\Request::is('*/routes/edit')){
			return $this->editRoute();
		}
		if (!\Request::is('*/routes/delete')){
			 if($validation->fails() && \Request::is('*/routes/add')){
				$messages=$validation->messages();
				$formatMess=null;
				foreach ($messages->all() as $message)
				{
					$formatMess=$message.'- '.$formatMess;
				}
				return $this->jsonResponse($formatMess,false,true,true);
			}else if($validation->fails() &&  \Request::is('*/routes/update')){
				$validation->getMessageBag()->add('user', 'Please check errors');
				$messages=$validation->messages();
				$formatMess=null;
				foreach ($messages->all() as $message)
				{
					$formatMess=$message.'- '.$formatMess;
				}
				return $this->jsonResponse($formatMess,false,true,true);
			}else if($validation->passes() &&  \Request::is('*/routes/update')){
				$routegroovel = $this->routeBusiness->find($input['id']);
				if($routegroovel->uri!=$input['uri']){
					$rulesupdate = array(
							'uri' => 'required|unique:routes_groovel',
					);
					$validation = \Validator::make(array('uri'=>$input['uri']), $rulesupdate);
					if($validation->fails()){
						$messages=$validation->messages();
						$formatMess=null;
						foreach ($messages->all() as $message)
						{
							$formatMess=$message.'- '.$formatMess;
						}
						return $this->jsonResponse($formatMess,false,true,true);
					}
				}
			}
		}
		return $this->processForm();
	}
	
	public function processForm(){
		if (\Request::is('*/routes/add')){
			$this->addRoute();
			return $this->jsonResponse(array('route has been added'),false,true,false);
		}
		else if(\Request::is('*/routes/delete')){
			$this->deleteRoute();
			return $this->jsonResponse(array('route has been deleted'),false,true,false);
		}
		else if(\Request::is('*/routes/update')){
			 $this->updateRoute();
			return $this->jsonResponse(array('route has been updated'),false,true,false);
		}else if(\Request::is('admin/pages/code/save')){
			$this->updateCodePage();
			return $this->jsonResponse(array('code has been updated'),false,true,false);
		}
		
		return \Redirect::to('/admin/routes');
	
	}
	
	
	private function updateCodePage(){
		$this->saveFilePage(\Input::get('page_name'),\Input::get('page'));
	}
	
	
	function deleteFile($layoutName,$pageName){
		$dst_base=base_path () . '/resources/views/'.$layoutName.'/base';
		$dst_includes=base_path () . '/resources/views/'.$layoutName.'/includes';
		$page=base_path () . '/resources/views/'.$layoutName.'/pages/'.$pageName;
		if(file_exists($page)){
			unlink($page);
		}
	}
	
 	private function deleteRoute(){
 		 $input = null;
 		 if(\Input::get('q')!=null){
 		 	$input=\Input::get('q');
 		 }else{
 		 	$input=\Input::all();
 		 }
 		 $route=$this->routeBusiness->find($input['id']);
 		 \Session::forget('route_edit');
 		 if($route!=null){
 		 	$view= explode('.',$route->view);
 		 	$ln=count($view);
 		 	$this->deleteFile($route->type, $view[$ln-1].'.'.'blade.php');
 		 }
 		 
 		 $this->routeBusiness->deleteRoute($input['id']);
	}

 	private function updateRoute(){
 		   $input=\Input::get('q');
 		  	if(empty($input)){
	     		$input=\Input::all();
	     		}
           $this->routeBusiness->updateRoute($input['id'],$input['domain'],$input['uri'],$input['name'],$input['controller'],$input['method'],$input['action'][0],$input['view'],null,null,$input['type'],$input['subtype'][0],$input['audit_tracking_url_enable'],$input['activate_route']);
           $this->refreshRoute($input['id']);
  	}

	private function addRoute(){
		\Log::info(\Input::all());
		$this->routeBusiness->addRoute(\Input::get('domain'), \Input::get('uri'),\Input::get('name'), \Input::get('controller'), \Input::get('method'), \Input::get('action')[0], \Input::get('view'), \Input::get('before_filter'),\Input::get('after_filter'),\Input::get('type'),\Input::get('subtype')[0],\Input::get('audit_tracking_url_enable'),\Input::get('activate_route'));
	}

	private function refreshRoute($id){
	    	$routegroovel=$this->routeBusiness->find($id);
	  		$route=array('id'=>$id,
    				'domain'=>$routegroovel->domain,
    				'uri'=>$routegroovel->uri,
    				'name'=>$routegroovel->name,
    				'controller'=>$routegroovel->controller,
    				'method'=>$routegroovel->method,
    				'action'=>$routegroovel->action,
    				'view'=>$routegroovel->view,
    				'before_filter'=>$routegroovel->before_filter,
    				'after_filter'=>$routegroovel->after_filter,
    				'type'=>$routegroovel->type,
	  				'subtype'=>$routegroovel->subtype,
	  				'audit_tracking_url_enable'=>$routegroovel->audit_tracking_url_enable,
	  				'activate_route'=>$routegroovel->activate_route
	  				
	  		);
		\Session::flash('msg', 'route has been updated');
		\Session::flash('route_edit', $route);
	}



	
	private function editRoute(){
		$input =  \Input::get('q');
		$routegroovel = $this->routeBusiness->find($input['id']);
		$route=array('id'=>$input['id'],
				'domain'=>$routegroovel->domain,
				'uri'=>$routegroovel->uri,
				'name'=>$routegroovel->name,
				'controller'=>$routegroovel->controller,
				'method'=>$routegroovel->method,
				'action'=>$routegroovel->action,
				'view'=>$routegroovel->view,
				'before_filter'=>$routegroovel->before_filter,
				'after_filter'=>$routegroovel->after_filter,
				'type'=>$routegroovel->type,
				'subtype'=>$routegroovel->subtype,
				'audit_tracking_url_enable'=>$routegroovel->audit_tracking_url_enable,
				'activate_route'=>$routegroovel->activate_route
		);
		$subtypes=$this->routeBusiness->getSubtypeList();
		$layouts=$this->layoutManager->layouts();
		$layouts=array_merge($layouts,array('Groovel'=>'Groovel'));
		\Session::put('layouts', $layouts);
		\Session::put('route_edit', $route);
		\Session::put('subtypes', $subtypes);
		\Session::put('page',$this->getFilePage($routegroovel->view));
		$uri=array();
		$uri['uri']= url('admin/routes/editform', $parameters = array(), $secure = null);
		return $this->jsonResponse($uri);
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
	
	public function saveFilePage($viewName,$content){
		$view= explode('.',$viewName);
		$dir_pages=base_path () . '/resources/views/'.$view[0].'/pages';
		$ln=count($view);
		$page_name=$view[$ln-1];
		//$data = file_get_contents($dir_pages.'/'.$page_name.'.blade.php');
		$myfile = fopen($dir_pages.'/'.$page_name.'.blade.php', "w");
		fwrite($myfile, htmlspecialchars_decode($content));
		//file_put_contents($data, $content);
		
	}
	
	
	
	
	public function getFilePage($viewName){
		$view= explode('.',$viewName);
		$dir_pages=base_path () . '/resources/views/'.$view[0].'/pages';
		$ln=count($view);
		$page_name=$view[$ln-1];
		$data =null;
		if($page_name!=null){
			if(file_exists($dir_pages.'/'.$page_name.'.blade.php')){
			$data = file_get_contents($dir_pages.'/'.$page_name.'.blade.php');
			}
		}
	    return $data;
	}

}
