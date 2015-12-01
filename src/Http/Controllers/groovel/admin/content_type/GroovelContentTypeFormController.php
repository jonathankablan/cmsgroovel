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

namespace Groovel\Cmsgroovel\Http\Controllers\groovel\admin\content_type;
use Illuminate\Database\Eloquent\Model;
use models;
use Groovel\Cmsgroovel\Http\Controllers\groovel\admin\common\GroovelFormController;
use Groovel\Cmsgroovel\business\groovel\admin\contents\GroovelContentTypeManagerBusiness;
use Groovel\Cmsgroovel\business\groovel\admin\contents\GroovelContentTypeManagerBusinessInterface;
use  Groovel\Cmsgroovel\models\Widgets; 

class GroovelContentTypeFormController extends GroovelFormController {

	
	protected $contentTypeManager;
	
	
	public function __construct(GroovelContentTypeManagerBusinessInterface $contentTypeManager)
	{
		$this->contentTypeManager=$contentTypeManager;
		$this->beforeFilter('auth');
	}
	
	
	public function init(){
		$widgets=Widgets::all();
		$w=array();
		$w['blank']='';
		foreach ($widgets as $widget){
			$w[$widget->name]=$widget->name;
		}
		\Session::flash('widgets',$w);
		return \View::make('cmsgroovel.pages.admin_content_type_management');
	}

	public function processForm(){
		$messages=\Input::all();
		if (\Request::is('*/content_type/add')){
			$this->add();
			return $this->jsonResponse(array('content_type added done'),false,true,false);
		}
		else if(\Request::is('*/content_type/fields/delete')){
			return $this->deleteField();
		}
		else if(\Request::is('*/content_type/delete')){
			 $this->delete();
			 return $this->jsonResponse(array('content_type deleted done'),false,true,false);
		}
		else if(\Request::is('*/content_type/update')){
			$this->update();
			return $this->jsonResponse(array('content_type updated done'),false,true,false);
		}
		else if(\Request::is('*/content_type')){
			$content_type=\ContentTypes::findAll();
			\Session::flash('messages', $content_type);
			 
		} else if(\Request::is('*/content_type/edit')){
			return $this->editContentType();
			 
		}
		return \Redirect::to('/admin/content_type/form')->with($messages);
	}
	
	public function validateForm($params)
	{
			if (\Request::is('*/content_type/add')||\Request::is('*/content_type/update'))
			{
				$this->checkToken();
				$rules=array();
				$rules['title']= 'required';
				$i=0;
				$inputs=\Input::get('fieldName');
				$inputstovalidate=array();
				$inputstovalidate['title']=\Input::get('title');
				$field_description=false;
				foreach(\Input::get('fieldName') as $val)
				{
					if(strcasecmp($val, 'groovelDescription') == 0){
						$field_description=true;
					}
					$rules['fieldName '.$i] = 'required|alpha';
					$inputstovalidate['fieldName '.$i]=$val;
					$i++;
				}
				$validation = \Validator::make($inputstovalidate, $rules);
				if($validation->passes()){
					if($field_description){
						$validation->getMessageBag()->add('contentType', 'groovelDescription is a specific reserved words you can not use it');
					}
					if($this->has_duplicates(\Input::get('fieldName'))){
						$validation->getMessageBag()->add('contentType', 'fieldName must be unique');
					}
					$contentType=$this->contentTypeManager->getContentType(\Input::get('title'));
					if( count($contentType)!=0 && !\Request::is('*/content_type/update')){
						$validation->getMessageBag()->add('contentType', 'contentType already exists!');
					}
					if(!\Request::is('*/content_type/update')){
						if(!$this->checkTinyMCEeditorExistsOnlyOnce(\Input::get('widget'))){
							$validation->getMessageBag()->add('contentType', 'Editor HTML can only be choice once');
						}
						
						if(!$this->checkUploaderExistsOnlyOnce(\Input::get('widget'))){
							$validation->getMessageBag()->add('contentType', 'Uploader files can only be choice once');
						}
					}else if(\Request::is('*/content_type/update')){
						$this->checkToken();
						$wid=array();
						$i=0;
						foreach(\Input::get('widget_selected') as $widgetid){
							$widgets= $this->contentTypeManager->getWidget($widgetid);
							if($widgets!=null){
								$wid[$i]=$widgets->getName();
								$i++;
							}
						}
						if(!$this->checkTinyMCEeditorExistsOnlyOnce($wid)){
							$validation->getMessageBag()->add('contentType', 'Editor HTML can only be choice once');
						}
						if(!$this->checkUploaderExistsOnlyOnce($wid)){
							$validation->getMessageBag()->add('contentType', 'Uploader files can only be choice once');
						}
					}
					$messages=$validation->messages();
					if(count($messages)>0){
						$formatMess=null;
						foreach ($messages->all() as $message)
						{
							$formatMess=$message.'- '.$formatMess;
						}
						return $this->jsonResponse($formatMess,false,true,true);
					}
				}
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
			else if(\Request::is('*/content_type/delete')){
				$input=\Input::get('q');
				$iscontent=$this->contentTypeManager->existContents($input['title']);
				$rules=array();
				$inputstovalidate=array();
				$validation = \Validator::make($inputstovalidate, $rules);
				if( $iscontent){
					$validation->getMessageBag()->add('contentType', 'Please delete all contents that are the content type you want to delete!');
					return $this->jsonResponse('Please delete attached contents to this content type before!',false,true,true);
				}
				
			}
	  	return $this->processForm();
	}

	function has_duplicates( $array ) {
		return count( array_keys( array_flip( $array ) ) ) !== count( $array );
	}
	
	private function checkUploaderExistsOnlyOnce($widgets){
		$count=0;
		foreach($widgets as $widget){
			if($widget	=='uploader'){
				$count++;
			}
		}
		if($count>1){
			return false;
		}else return true;
	}
	
    private function checkTinyMCEeditorExistsOnlyOnce($widgets){
    	$count=0;
   		foreach($widgets as $widget){
       		 if($widget	=='editorHTML'){
    			$count++;
    		}
    	}
    	if($count>1){
    		return false;
    	}else return true;
    } 
	
	private function deleteField(){
		$input = \Input::get('q');
		$this->contentTypeManager->deleteField($input);
	}
	
	private function delete(){
		$input = \Input::get('q');
		$this->contentTypeManager->deleteContentType($input['title']);
	}
	
	private function add(){
 		$this->contentTypeManager->add(\Input::get('title'),\Input::get('fieldName'),\Input::get('description'),\Input::get('type'),\Input::get('widget'),\Input::get('isnullable'),\Input::get('required')); 
	}


	private function update(){
		$tableName=$this->contentTypeManager->update(\Input::get('title'),$_POST['field_id'],$_POST['fieldName'],$_POST['type_selected'],$_POST['widget_selected'],$_POST['description'],$_POST['isnullable'],$_POST['required']);
		$this->refreshContent(\Input::get('title'),\Input::get('content_type_id'));
		return \Redirect::to('/admin/content_type/editform');
	}
	
	

	private function refreshContent($title,$contentTypeid){
		$contentType=$this->contentTypeManager->editContentType($contentTypeid);
		$res=array('id'=>$contentTypeid,'title'=>$title,'fields'=>$contentType);
		\Session::flash('content_type_edit', $res);
		$widgets=\Widgets::all();
		$w=array();
		$w['-1']='';
		foreach ($widgets as $widget){
			$w[$widget->getId()]=$widget->name;
		}
		\Session::flash('widgets',$w);
		\Session::flash('msg', 'content type has been updated');
	}
	
	
	//action called when you are in the list content types and you edit one
	private function editContentType(){
		$input =  \Input::get('q');
		$contentType=$this->contentTypeManager->editContentType($input['id']);
		$res=array('id'=>$input['id'],'title'=>$input['title'],'fields'=>$contentType);
		\Session::put('content_type_edit', $res);
		$uri=array();
		$uri['uri']= url('admin/content_type/editform', $parameters = array(), $secure = null);
		$widgets=Widgets::all();
		$w=array();
		$w['-1']='';
		foreach ($widgets as $widget){
			$w[$widget->getId()]=$widget->name;
		}
		\Session::put('widgets',$w);
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
	

}
