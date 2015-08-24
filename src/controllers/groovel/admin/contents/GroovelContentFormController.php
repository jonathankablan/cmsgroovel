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

namespace controllers\groovel\admin\contents;
use Illuminate\Database\Eloquent\Model;
use controllers\groovel\admin\common\GroovelFormController;
use models;
use business\groovel\admin\contents\GroovelContentTypeManagerBusiness;
use business\groovel\admin\contents\GroovelContentManagerBusiness;
use business\groovel\admin\contents\GroovelContentManagerBusinessInterface;
use business\groovel\admin\contents\GroovelContentTypeManagerBusinessInterface;
use Monolog\Logger;
use controllers\groovel\admin\common\FileHelper;
use Illuminate\Support\Facades\View;


class GroovelContentFormController extends GroovelFormController {


    private static $FILES='myfiles';
    
    protected $contentManager;
    
    protected $contentTypeManager;
    
    
    public function __construct( \GroovelContentManagerBusinessInterface $contentManager, \GroovelContentTypeManagerBusinessInterface $contentTypeManager)
    {
    	$this->contentManager=$contentManager;
    	$this->contentTypeManager=$contentTypeManager;
    	$this->beforeFilter('auth');
    //	$this->beforeFilter('csrf');
    }
	
   
    
    
	public function validateForm($params)
	{
		//\Log::info(\Input::all());
		//\Log::info($_FILES);
		
		
		if (\Request::is('*/content/add')){
			$this->checkToken();
			$field_requireds=$this->contentManager->getFieldRequired(\Input::get('ContentType'));
			$rules=array();
			foreach($field_requireds as $key=>$input)
			{
				$rules[$key] = 'required';
			}
			$rules['title']='required';
			$rules['url']='required|url';
			$rules['groovelDescription']='required';
			
			$url=\Input::get('url');
			$validInput=\Input::all();
			if($url!=null){
				$urlvalid='http://localhost/'.$url;
				$validInput['url']=$urlvalid;
			}
			$validation = \Validator::make($validInput, $rules);
			if($validation->passes()){
				$rules=array();
				$rules['url']='required|unique:routes_groovel,uri';
				$validation = \Validator::make(array('url'=>\Input::get('url')), $rules);
				if($validation->passes()){
						
				}else if($validation->fails()){
					$validation->getMessageBag()->add('content', 'Please check errors');
					$messages=$validation->messages();
					$formatMess=null;
					foreach ($messages->all() as $message)
					{
						$formatMess=$message.'- '.$formatMess;
					}
					return $this->jsonResponse($formatMess,false,true,true);
				}
			}else if($validation->fails()){
				$validation->getMessageBag()->add('content', 'Please check errors');
				$messages=$validation->messages();
				$formatMess=null;
				foreach ($messages->all() as $message)
				{
				 $formatMess=$message.'- '.$formatMess;
				}
				return $this->jsonResponse($formatMess,false,true,true);
			}
		}else if (\Request::is('*/content/update')){
			$this->checkToken();
			$content_id= \Input::get('content_id');
			//\Log::info(\Input::all());
			$contentname=$this->contentManager->getContentTypeNameOfContent($content_id);
			//\Log::info($contentname);
			$field_requireds=$this->contentManager->getFieldRequired($contentname['name']);
			$rules=array();
			foreach($field_requireds as $key=>$input)
			{
				$rules[$key] = 'required';
			}
			$rules['title']='required';
			$rules['url']='required|url';
			$rules['groovelDescription']='required';
			$url=\Input::get('url');
			$validInput=\Input::all();
			if($url!=null){
				$urlvalid='http://localhost/'.$url;
				$validInput['url']=$urlvalid;
			}
			$validation = \Validator::make($validInput, $rules);
			if($validation->passes()){
				$rules=array();
				$rules['url']='required';
				$validation = \Validator::make(array('url'=>\Input::get('url')), $rules);
				if($validation->passes()){
					
				}else if($validation->fails()){
					$validation->getMessageBag()->add('content', 'Please check errors');
					$messages=$validation->messages();
					$formatMess=null;
					foreach ($messages->all() as $message)
					{
						$formatMess=$message.'- '.$formatMess;
					}
					$content= \Contents::find(\Input::get('content_id'));
					$this->refreshContent($content->id);
					return $this->jsonResponse($formatMess,false,true,true);
				}
				
			}else if($validation->fails()){
				$validation->getMessageBag()->add('content', 'Please check errors');
				$messages=$validation->messages();
				$formatMess=null;
				foreach ($messages->all() as $message)
				{
					$formatMess=$message.'- '.$formatMess;
				}
				$content= \Contents::find(\Input::get('content_id'));
				$this->refreshContent($content->id);
				return $this->jsonResponse($formatMess,false,true,true);
			}
		}
	  	return $this->processForm();
	}

	public function processForm(){
		//\Log::info(\Request::url());
		if (\Request::is('*/content/form/view_update')){
			return $this->view_update();
        }else if (\Request::is('*/content/add')){
           	$this->addContent();	
           	return $this->jsonResponse(array('content has been added'),false,true,false);
        }else if (\Request::is('*/content/update')){
        	$this->updateContent();	
        	return $this->jsonResponse(array('content has been updated'),false,true,false);
        }else if (\Request::is('*/content/delete')){
        	return $this->deleteContent();	
        }else if (\Request::is('*/content/edit')){
        	return $this->editContent();	
        }
    }

  
    
	private function addContent(){
	    $query_string = "";
		if ($_POST) {
			  $kv = array();
			  foreach ($_POST as $key => $value) {
			    $kv[] = "$key=$value";
			  }
			  $query_string = join("&", $kv);
		}
		else {
		  $query_string = $_SERVER['QUERY_STRING'];
		}	 
	   	$data = explode("&", $query_string);
		//\Log::info($data);
 		$title_parse = explode("=", $data[0]);
		$title=$title_parse[1];

		$contentType_parse = explode("=", $data[3]);
		$contentType=$contentType_parse[1];
		
		$url_parse = explode("=", $data[1]);
		$url=$url_parse[1];
		//\Log::info('type '.$contentType);
		$type=\AllContentTypes::where('name','=',$contentType)->firstOrFail();
		
		$groovelDescription_parse = explode("=", $data[2]);
		$groovelDescription=$groovelDescription_parse[1];
		//\Log::info($groovelDescription);
        $arr=array();
        $ispublish=0;
        $ontop=0;
        foreach ($data as $elt){
        	$elt_parse=explode("=",$elt,2);
         	if('Title'!=$elt_parse[0] && 'ContentType'!=$elt_parse[0] && 'groovelDescription'!=$elt_parse[0] 
         			&& 'isPublish'!=$elt_parse[0] && 'isTopPublish'!=$elt_parse[0]&&'url'!=$elt_parse[0]){
         		$arr[$elt_parse[0]]=$elt_parse[1];
         	}
         	if('isPublish'==$elt_parse[0]){
         		$ispublish=1;
         	}
         	if('isTopPublish'==$elt_parse[0]){
         		$ontop=1;
         	}
        }
       //\Log::info('arr '. $arr);
        $content=$this->contentManager->serialize($arr);
        
     	$userid=\Auth::id();
    	$id=$this->contentManager->addContent($title,$content,$url,$groovelDescription,$type->id,$userid,$ispublish,$ontop);
		return $this->editContent($id);
	}

	private function deleteContent(){
		//\Log::info('delete');
		$input = \Input::get('q');
		//\Log::info($input);
		$this->contentManager->deleteContent($input['id']);
	}
  
   private function updateContent(){
		$input = \Input::all();
		//\Log::info($input);
		$content= \Contents::find($input['content_id']);
	    $content->name=$input['title'];
	    $content->url=$input['url'];
	    if(filter_var(\Input::get('isPublish'), FILTER_VALIDATE_BOOLEAN)){
	    	$content->ispublish=1;
	    }else{
	    	$content->ispublish=0;
	    }
	    if(filter_var(\Input::get('isTopPublish'), FILTER_VALIDATE_BOOLEAN)){
	    	$content->ontop=1;
	    }else{
	    	$content->ontop=0;
	    }
	    $blob=$this->contentManager->deserialize($content['content']);
	    foreach (array_keys($input) as $key){
	    	if($key!='_token' && $key!='content_id' && $key!='files' && $key!='fileName' && $key!='fileSize' && $key!='fileType'){
	    		$blob[$key]=$input[$key];
	    		if('myfiles'==$key && array_key_exists('myfiles',$input)){
	    			if(empty($input['myfiles'])){
	    				unset($blob[$key]);
	    			}else{
	    				$blob[$key]=$input['myfiles'];
	    				//\Log::info($input['myfiles']);
	    			}
	    		}
	    	}
	    }
	    $blobout=$this->contentManager->serialize($blob);
	    $content->content=$blobout;
        $content->update();
	   // \Log::info('update done');
	}

	
	private function refreshContent($id){
		$content=$this->contentManager->editContent($id);
        //\Log::info($content);
		//mapping of data and type and widget
		$contentItems=$this->contentTypeManager->getContentType($content['contentType']);
		$mapping=array();
		$i=0;
		foreach ($contentItems as $items) {
			$map[$items->getFieldName()][]=array(
					'type'=>$items->getFieldType(),
					'required'=>$items->getFieldRequired(),
					'widget'=>$items->getFieldWidget());
			
			$items_contentFieldName=null;
			if(array_key_exists($items->getFieldName(), $content['content'])){
				$items_contentFieldName=$content['content'][$items->getFieldName()];
			}
			$mapping[$i]=array(
					'name'=>$items->getFieldName(),
					'content'=>$items_contentFieldName,
					'type'=>$items->getFieldType(),
					'required'=>$items->getFieldRequired(),
					'widget'=>$items->getFieldWidget()
			);
			$i++;
		}
		$ct=array('id'=>$id,'title'=>$content['title'],'url'=>$content['url'],'groovelDescription'=>$content['groovelDescription'],'contentType'=>$content['contentType'],'content'=>$mapping,'ispublish'=>$content['ispublish'],'ontop'=>$content['ontop']);
		//\Log::info($ct);
		
		\Session::flash('msg', 'content has been updated');
		\Session::flash('content_edit', $ct);
		
	}
	
	
	
	//action called when you are in the list contents and you edit one
	private function editContent($id=null){
		$input=null;
		if($id== null){
			$input =  \Input::get('q');
		}else{
			$input['id']=$id;
		}
		$content=$this->contentManager->editContent($input['id']);
		//\log::info($content);
		if($id!= null){
			$input['url']=$content['url'];
		}
		//mapping of data and type and widget
		$contentItems=$this->contentTypeManager->findContentTypeById($content['contentType']);
		//\log::info($contentItems);
		$mapping=array();
		$i=0;
		foreach ($contentItems as $items) {
    	 	$map[$items->getFieldName()][]=array(
    			 'type'=>$items->getFieldType(),
    			 'isnullable'=>$items->getFieldNullable(),
    	 		 'required'=>$items->getFieldRequired(),	
    			 'widget'=>$items->getFieldWidget());
    	 	$element=null;
     	 	if(array_key_exists($items->getFieldName(),$content['content'])){
    	 		if($items->getFieldType()=='file'  && array_key_exists(self::$FILES,$content['content'])){
    	 			$urls=explode(',',$content['content'][self::$FILES]);
    	 			$infos_images=array();
    	 			foreach($urls as $url){
    	 				$parsed_url=explode('/',$url);
    	 				$name_image=$parsed_url[count($parsed_url)-1];
    	 				$infos_images[$name_image]=$url;
    	 			}
    	 			$element=$infos_images;
    	 		}else{
    	 			$element=$content['content'][$items->getFieldName()];
     	 		}
    	 	}
    	 	if(($items->getFieldType()=='image'|| $items->getFieldType()=='file') && array_key_exists('myfiles',$content['content'])){
    	 		$urls=explode(',',$content['content']['myfiles']);
    	 		$infos_images=array();
    	 		foreach($urls as $url){
    	 			$parsed_url=explode('/',$url);
    	 			$name_image=$parsed_url[count($parsed_url)-1];
    	 			$infos_images[$name_image]=$url;
    	 		}
    	 		$element=$infos_images;
    	 	}
    	 	$mapping[$i]=array(
    	 		'name'=>$items->getFieldName(),
    	 		'content'=>$element,
    	 		'type'=>$items->getFieldType(),
    	 		'widget'=>$items->getFieldWidget(),
    	 		'isnullable'=>$items->getFieldNullable(),
    	 		'required'=>$items->getFieldRequired()	
    	 		);
    	 	$i++;
    	}
    	
   		$ct=array('id'=>$input['id'],'title'=>$content['title'],'url'=>$input['url'],'groovelDescription'=>$content['groovelDescription'],'contentType'=>$content['contentType'],'content'=>$mapping,'ispublish'=>$content['ispublish'],'ontop'=>$content['ontop']);
    	\Session::flash('content_edit', $ct);
        $uri=array();
 		$uri['uri']= url('admin/content/editform', $parameters = array(), $secure = null);
 		return $this->jsonResponse($uri);
 	}

	private function listAllContentType(){
		$lists=$this->contentTypeManager->getListContentType();
		return $lists;
	}

	
//action called when add new content
    private function view_update(){
    	$input = \Input::get('q');
 		$contentItems=$this->contentTypeManager->getContentType($input);
		//\Log::info($contentItems);
		$response = array(array());
		$i=0;
   		foreach ($contentItems as $items) {
    	 	$response[$i][]=array(
    			 'id' => $i,
    			 'tableName'=>$items->getTableName(),
    			 'name'=>$items->getFieldName(),
    			 'type'=>$items->getFieldType(),
    			 'description'=>$items->getDescription(),
    			 'widget'=>$items->getFieldWidget(),
    	 		 'isnullable'=>$items->getFieldNullable(),
    	 		 'required'=>$items->getFieldRequired()
    	 	);
    		$i=$i+1;
		}
	return $this->jsonResponse($response);
   }



	public function init(){
		//\Log::info('init');
		$content_types=$this->listAllContentType();
		$options = array();
        $options['NULL']='';
		foreach ($content_types as $content_type)
		{
		     $options[$content_type->name] = $content_type->name;
		}
		\Session::flash('content_types', $options);
		return \View::make('cmsgroovel::pages.admin_content_management');
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
