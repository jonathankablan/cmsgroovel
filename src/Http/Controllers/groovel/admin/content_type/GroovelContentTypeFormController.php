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
			$id=$this->saveOrUpdate();
			return $this->jsonResponse(array('id'=>$id,'content_type added done'),false,true,false);
		}
		else if(\Request::is('*/content_type/delete')){
			 $this->delete();
			 return $this->jsonResponse(array('content_type deleted done'),false,true,false);
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
		if (\Request::is('*/content_type/add'))
			{
				$this->checkToken();
				if(!$this->checkUploaderExistsOnlyOnce(\Input::all())){
					return $this->jsonResponse('Only one file type is possible',false,true,true);
				}
				$template=\Input::all();
				$content_type_id=$template['id'];
				if(empty($content_type_id)){
					$contentType=$this->contentTypeManager->findAllContentTypeByName($template['template']['title']);
					if($contentType!=null){
						return $this->jsonResponse('content type with the same name already exists choose another name',false,true,true);
					}
				}
				
			}
		else if(\Request::is('*/content_type/delete')){
				$input=\Input::get('q');
				$iscontent=false;
				if(!empty($input['id'])){
			        $contentType=$this->contentTypeManager->find($input['id']);
					$iscontent=$this->contentTypeManager->existContents( $contentType->name);
				}
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
	
	private function checkUploaderExistsOnlyOnce($template){
		$count=0;
		$body=$template['template']['body'];
		foreach($body as $field){
			if($field['fieldtype']=='file'){
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
	
	
	
	private function delete(){
		$input=\input::get('q');
		if(!empty($input['id'])){
			$contentType=$this->contentTypeManager->find($input['id']);
			$contentType=$this->contentTypeManager->findAllContentTypeByName($contentType->name);
			if(!empty($contentType)){
				$this->contentTypeManager->deleteContentType($contentType->name);
			}
		}
	}
	
	
	private function saveOrUpdate(){
		$input=\Input::all();
		$title=$input['template']['title'];
		$body=$input['template']['body'];
		$content_type_id=$input['id'];
		$contentType=$this->contentTypeManager->find($content_type_id);
		if(empty($contentType)){
			$contentType=$this->contentTypeManager->createContentType($title);
			foreach($body as $field){
				$this->contentTypeManager->addField($title,$field['fieldname'],$field['fielddescription'],$field['fieldtype'],$field['fieldvalue'],$field['fieldwidget'],$field['fieldrequired'],$contentType->id);
			}
		}else{//update
			//clean all
			$this->contentTypeManager->deleteContentType($contentType->name);
			$contentType=$this->contentTypeManager->createContentType($title);
			foreach($body as $field){
				$this->contentTypeManager->addField($title,$field['fieldname'],$field['fielddescription'],$field['fieldtype'],$field['fieldvalue'],$field['fieldwidget'],$field['fieldrequired'],$contentType->id);
			}
		}
		return $contentType->id;
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
