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
use Groovel\Cmsgroovel\Http\Controllers\groovel\admin\common\GroovelFormController;
use Groovel\Cmsgroovel\business\groovel\admin\layout\GroovelLayoutBusiness;
use Groovel\Cmsgroovel\business\groovel\admin\layout\GroovelLayoutBusinessInterface;



class GroovelLayoutController extends GroovelFormController {
	
	private $layoutManager;
	
		
	public function __construct(GroovelLayoutBusinessInterface $layoutManager)
	{
		$this->layoutManager=$layoutManager;
	}
	
	
	
	public function init(){
		$countries=$this->layoutManager->getAllCountries();
		$lang=array();
		foreach($countries as $country){
			//fix up to limit the list of country
			if($country['code']=='FR'|| $country['code']=='US' ||$country['code']=='GB'){
				$lang[$country['code']]=$country['name_en'];
			}
		}
		return \View::make('cmsgroovel.pages.layout.admin_layout_management',['layouts'=>$this->layoutManager->layouts(),'langages'=>$lang,'logo'=>null]);
	}
	

	public function validateForm($params) {
		$input = \Input::all();
		\Log::info($input);
		if (\Request::is('*/layout/add')){
		
			$rules=array();
			$rules['layoutchoice']='required';
			$rules['langages']='required';
			$rules['title']='required';
			$rules['header']='required';
			$rules['footer']='required';
				
			$url=\Input::get('url');
			$validInput=\Input::all();
			$validation = \Validator::make($validInput, $rules);
			if($validation->passes()){
					ini_set ('max_execution_time', 0);
					$this->copyBladeTemplatesToApp(\Input::get('layoutchoice'));//copy templates from groovel to new package
					if(\Input::get('layout_id')!=null){
						$this->layoutManager->delete(\Input::get('layout_id'));
					}
					$layoutid=$this->layoutManager->save( \Input::get('langages'), \Input::get('title'), \Input::get('header'), \Input::get('footer'),\Input::get('layoutchoice'),\Input::get('myfiles'));
				    return $this->jsonResponse(array("id"=>	$layoutid,"mess"=>'layout has been added'),false,true,false);
			}else if($validation->fails()){
				$validation->getMessageBag()->add('layout', 'Please check errors');
				$messages=$validation->messages();
				$formatMess=null;
				foreach ($messages->all() as $message)
				{
					$formatMess=$message.'- '.$formatMess;
				}
				return $this->jsonResponse($formatMess,false,true,true);
			}
		}else if(\Request::is('*/layout/edit')){
		    $uri=array();
	        $uri['uri']= url('admin/layout/editform', $parameters = array(), $secure = null);
	        \Session::put('layoutid',\Input::get('q')['id']);
	        return $this->jsonResponse($uri);
 		}else if(\Request::is('*/layout/delete')){
			$this->layoutManager->delete(\Input::get('q')['id']);
		}else if(\Request::is('*/layout/editform')){
			$countries=$this->layoutManager->getAllCountries();
			$lang=array();
			foreach($countries as $country){
				//fix up to limit the list of country
				if($country['code']=='FR'|| $country['code']=='US' ||$country['code']=='GB'){
					$lang[$country['code']]=$country['name_en'];
				}
			}
			$layout=$this->layoutManager->find(\Session::get('layoutid'));
			return \View::make('cmsgroovel.pages.layout.admin_layout_form',['layouts'=> $layout,'langages'=>$lang,'logo'=>$layout->logo]);
		}else if (\Request::is('*/layout/update')){
			$rules=array();
			$rules['langages']='required';
			$rules['title']='required';
			$rules['header']='required';
			$rules['footer']='required';
			
			$url=\Input::get('url');
			$validInput=\Input::all();
			$validation = \Validator::make($validInput, $rules);
			if($validation->passes()){
				ini_set ('max_execution_time', 0);
				$this->layoutManager->update(\Session::get('layoutid'), \Input::get('langages'), \Input::get('title'), \Input::get('header'), \Input::get('footer'),\Input::get('myfiles'));
				return $this->jsonResponse(array('done'),false,true,false);
			}else if($validation->fails()){
				$validation->getMessageBag()->add('layout', 'Please check errors');
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
	
	function folder_exist($folder)
	{
		// Get canonicalized absolute pathname
		$path = realpath($folder);
		// If it exist, check if it's a directory
		return ($path !== false AND is_dir($path)) ? $path : false;
	}
	
	
	function recurse_copy($src, $dst) {
		if($this->folder_exist($src)){
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
							if (is_file($dst . '/' . $file) != true) {
								$result = copy($src . '/' . $file,$dst . '/' . $file);
							}
						}
					}
				}
				closedir($dir);
			}
			return $result;
		}
	}
	
	function copyBladeTemplatesToApp($templateName){
		$dir_workbench_base=base_path () . '/starter-templates/layouts/'.$templateName.'/base';
		$dir_workbench_includes=base_path () . '/starter-templates/layouts/'.$templateName.'/includes';
		$dir_workbench_pages=base_path () . '/starter-templates/layouts/'.$templateName.'/pages';
		$dst_base=base_path () . '/resources/views/'.$templateName.'/base';
		$dst_includes=base_path () . '/resources/views/'.$templateName.'/includes';
		$dst_pages=base_path () . '/resources/views/'.$templateName.'/pages';
		$dir_workbench_styles=base_path () . '/starter-templates/layouts/'.$templateName.'/styles';
		$pub=public_path() ;
	
		$this->recurse_copy($dir_workbench_base, $dst_base);
		$this->recurse_copy($dir_workbench_includes, $dst_includes);
		$this->recurse_copy($dir_workbench_pages, $dst_pages);
		$this->recurse_copy($dir_workbench_styles, $pub.'/'.$templateName.'/styles');
	
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
	
	public function makeValidation($params){
		$rules=array();
		$rules['layoutchoice']='required';
		$rules['langages']='required';
		$rules['title']='required';
		$rules['header']='required';
		$rules['footer']='required';
		$validInput=\Input::all();
		$validation = \Validator::make($validInput, $rules);
		if($validation->passes()){
			return $this->jsonResponse(true,false,true,false);
		}else if($validation->fails()){
			$validation->getMessageBag()->add('layout', 'Please check errors');
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