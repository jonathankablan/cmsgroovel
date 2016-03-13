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
use Groovel\Cmsgroovel\Http\Controllers\groovel\admin\common\GroovelFormController;
use Groovel\Cmsgroovel\business\groovel\admin\menu\GroovelMenuBusiness;
use Groovel\Cmsgroovel\business\groovel\admin\menu\GroovelMenuBusinessInterface;
use Groovel\Cmsgroovel\business\groovel\admin\layout\GroovelLayoutBusiness;
use Groovel\Cmsgroovel\business\groovel\admin\layout\GroovelLayoutBusinessInterface;



class GroovelMenuController extends GroovelFormController {
	
	private $menuManager;
	private $layoutManager;
	
		
	public function __construct(GroovelMenuBusinessInterface $menuManager,GroovelLayoutBusinessInterface $layoutManager)
	{
		$this->menuManager=$menuManager;
		$this->layoutManager=$layoutManager;
	}
	
	public function validateForm($params){
		$input=\Input::all();
		$rules=array();
		$rules['name']='required';
		$rules['langage']='required';
		$rules['layout']='required';
		$validation = \Validator::make($input, $rules);
		if (\Request::is('*/menu/add')){
			if($validation->passes()){
				if($input['id']==null){
					$isexist=$this->menuManager->isMenuAlreadyExist($input['name'], $input['langage']);
					if($isexist){
						return $this->jsonResponse('menu already exist',false,true,true);
					}
				}
				$id=$this->menuManager->saveMenu($input['id'],$input['name'], $input['langage'], $input['menu'],$input['layout']);
				return $this->jsonResponse(array('id'=>$id,'menu added done'),false,true,false);
			}else{
				$validation->getMessageBag()->add('menu', 'Please check errors');
	    		$messages=$validation->messages();
	    		$formatMess=null;
	    			foreach ($messages->all() as $message)
	    			{
	    				$formatMess=$message.'- '.$formatMess;
	    			}
	    		return $this->jsonResponse($formatMess,false,true,true);
			}
		}else if(\Request::is('*/menu/delete')){
			$input=null;
			if(array_key_exists('q',\Input::all())){
				 $input=\Input::all()['q'];
			}else{
				 $input=\Input::all();
			}
			 $this->menuManager->delete($input['id']);
			 return $this->jsonResponse(array('menu deleted done'),false,true,false);
		}else if(\Request::is('*/menu/edit')){
			$uri=array();
			$uri['uri']= url('admin/menu/editform', $parameters = array(), $secure = null);
			\Session::put('menuid',\Input::get('q')['id']);
			return $this->jsonResponse($uri);
		}else if(\Request::is('*/menu/editform')){
			$menu=$this->menuManager->find(\Session::get('menuid'));
			$countries=$this->menuManager->getAllCountries();
			$lang=array();
			foreach($countries as $country){
				//fix up to limit the list of country
				if($country['code']=='FR'|| $country['code']=='US' ||$country['code']=='GB'){
					$lang[$country['code']]=$country['name_en'];
				}
			}
			$layouts=$this->layoutManager->layouts();
			$layouts=array_merge($layouts,array('Groovel'=>'Groovel'));
			
			$myMenu ='';
			$level=0;
			foreach($menu['menu'] as $arr){
				foreach($arr as $arr1){
					$myMenu .= $this->generateHTMLMenu($arr1,$level);
					$level=0;
				}
			}
			$res= "<ul class='u'>".$myMenu."</ul>";
			return \View::make('cmsgroovel.pages.admin_menu_form',['menuid'=>$menu['id'],'title'=>$menu['name'],'menu'=> $res,'langages'=>$lang,'menulang'=>$menu['lang'],'layoutselected'=>$menu['layout'],'layouts'=>$layouts]);
		}
	}
	

	function generateHTMLMenu($arr,&$level){
		$str = '';
		if(is_array($arr)){
			$str .= "<li>";
			if($level==0){
				$div='<div class="add-right d row">
					<div class="col-md-1">
					<i style="font-size:15px" class="glyphicon glyphicon-plus" onmouseover="this.style.cursor=\'pointer\'"></i>
					</div>
					<div class="col-md-1">
					<label for="name">link name</label>
					</div>
					<div class="col-md-2">
					<input class="form-control" id="name" placeholder="name" type="text"'.' value="'.$arr['name']['name'].'"'.'>'.
					'</div>
					<div class="col-md-1">
					<label for="url">url</label>
					</div>
					<div class="col-md-2">
					<input class="form-control" id="url" placeholder="url" type="text"'.' value="'.$arr['name']['uri'].'"'.'>'.
					'</div>
					<div class="col-md-4">
					<button id="addMnItem" class="btn btn-info" style="margin-bottom:15px">Add Item</button>
					<button id="addMnChildItem" class="btn btn-primary" style="margin-bottom:15px">Add Child Item</button>
					<i style="font-size:15px" class="glyphicon glyphicon-remove" onmouseover="this.style.cursor=\'pointer\'"></i>
					</div>
				</div>';
			}
			else if($level==1){
				$div='<div class="add-right dd row">
					<div class="col-md-1">
					<i style="font-size:15px" class="glyphicon glyphicon-plus" onmouseover="this.style.cursor=\'pointer\'"></i>
					</div>
					<div class="col-md-2">
					<label for="name">link name</label>
					</div>
					<div class="col-md-2">
					<input class="form-control" id="name" placeholder="name" type="text"'.' value="'.$arr['name']['name'].'"'.'>'.
					'</div>
					<div class="col-md-1">
					<label for="url">url</label>
					</div>
					<div class="col-md-2">
					<input class="form-control" id="url" placeholder="url" type="text"'.' value="'.$arr['name']['uri'].'"'.'>'.
					'</div>
					<div class="col-md-4">
					<button id="addMnItem" class="btn btn-info" style="margin-bottom:15px">Add Item</button>
					<button id="addMnChildItem" class="btn btn-primary" style="margin-bottom:15px">Add Child Item</button>
					<i style="font-size:15px" class="glyphicon glyphicon-remove" onmouseover="this.style.cursor=\'pointer\'"></i>
					</div>
				</div>';
			}
			else if($level==2){
				$div='<div class="add-right ddd row">
					<div class="col-md-1">
					<i style="font-size:15px" class="glyphicon glyphicon-plus" onmouseover="this.style.cursor=\'pointer\'"></i>
					</div>
					<div class="col-md-1">
					<label for="name">link name</label>
					</div>
					<div class="col-md-2">
					<input class="form-control" id="name" placeholder="name" type="text"'.' value="'.$arr['name']['name'].'"'.'>'.
					'</div>
					<div class="col-md-1">
					<label for="url">url</label>
					</div>
					<div class="col-md-2">
					<input class="form-control" id="url" placeholder="url" type="text"'.' value="'.$arr['name']['uri'].'"'.'>'.
					'</div>
					<div class="col-md-4">
					<button id="addMnItem" class="btn btn-info" style="margin-bottom:15px">Add Item</button>
					<button id="addMnChildItem" class="btn btn-primary" style="margin-bottom:15px">Add Child Item</button>
					<i style="font-size:15px" class="glyphicon glyphicon-remove" onmouseover="this.style.cursor=\'pointer\'"></i>
					</div>
				</div>';
			}
			else if($level==3){
				$div='<div class="add-right dddd row">
					<div class="col-md-1">
					<i style="font-size:15px" class="glyphicon glyphicon-plus" onmouseover="this.style.cursor=\'pointer\'"></i>
					</div>
					<div class="col-md-2">
					<label for="name">link name</label>
					</div>
					<div class="col-md-2">
					<input class="form-control" id="name" placeholder="name" type="text"'.' value="'.$arr['name']['name'].'"'.'>'.
					'</div>
					<div class="col-md-1">
					<label for="url">url</label>
					</div>
					<div class="col-md-2">
					<input class="form-control" id="url" placeholder="url" type="text"'.' value="'.$arr['name']['uri'].'"'.'>'.
					'</div>
					<div class="col-md-4">
					<button id="addMnItem" class="btn btn-info" style="margin-bottom:15px">Add Item</button>
					<button id="addMnChildItem" class="btn btn-primary" style="margin-bottom:15px">Add Child Item</button>
					<i style="font-size:15px" class="glyphicon glyphicon-remove" onmouseover="this.style.cursor=\'pointer\'"></i>
					</div>
				</div>';
			}
			$str .=$div;
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
	

	public function processForm(){}
	
	
	
	public function init(){
		$countries=$this->menuManager->getAllCountries();
		$lang=array();
		foreach($countries as $country){
			//fix up to limit the list of country
			if($country['code']=='FR'|| $country['code']=='US' ||$country['code']=='GB'){
				$lang[$country['code']]=$country['name_en'];
			}
		}
		$layouts=$this->layoutManager->layouts();
		array_push($layouts,'Groovel');
		return \View::make('cmsgroovel.pages.admin_menu_management',['langages'=>$lang,'layouts'=>$layouts]);
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
	
}