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
use Groovel\Cmsgroovel\Http\Controllers\groovel\admin\common\GroovelFormController;
use models;
use Groovel\Cmsgroovel\business\groovel\admin\contents\GroovelContentTypeManagerBusiness;
use Groovel\Cmsgroovel\business\groovel\admin\contents\GroovelContentManagerBusiness;
use Groovel\Cmsgroovel\business\groovel\admin\contents\GroovelContentManagerBusinessInterface;
use Groovel\Cmsgroovel\business\groovel\admin\contents\GroovelContentTypeManagerBusinessInterface;
use Monolog\Logger;
use Groovel\Cmsgroovel\Http\Controllers\groovel\admin\common\FileHelper;
use Illuminate\Support\Facades\View;
use Groovel\Cmsgroovel\models\AllContentTypes;
use Groovel\Cmsgroovel\models\Contents;
use Groovel\Cmsgroovel\models\ContentsTranslation;
use Groovel\Cmsgroovel\log\LogConsole;


class GroovelContentFormController extends GroovelFormController {


    private static $FILES='myfiles';
    
    protected $contentManager;
    
    protected $contentTypeManager;
    
    
    public function __construct( GroovelContentManagerBusinessInterface $contentManager, GroovelContentTypeManagerBusinessInterface $contentTypeManager)
    {
    	$this->contentManager=$contentManager;
    	$this->contentTypeManager=$contentTypeManager;
    	$this->middleware('auth');
    }
    
    public function makeValidation($params){
    		$this->checkToken();
    		$field_requireds=$this->contentManager->getFieldRequired(\Input::get('ContentType'));
    		$rules=array();
    		foreach($field_requireds as $key=>$input)
    		{
    			$rules[$key] = 'required';
    		}
    		$rules['title']='required';
    		$rules['description']='required';
    		$rules['tag']='required';
    		$validInput=\Input::all();
     		$validation = \Validator::make($validInput, $rules);
    		if($validation->passes()){
    			return $this->jsonResponse(true,false,true,false);
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
    }
    
	public function validateForm($params)
	{
		if (\Request::is('*/content/add')){
			$this->checkToken();
			$field_requireds=$this->contentManager->getFieldRequired(\Input::get('ContentType'));
			$rules=array();
			foreach($field_requireds as $key=>$input)
			{
				$rules[$key] = 'required';
			}
			$rules['title']='required';
			$rules['description']='required';
			$rules['tag']='required';
			
			$validInput=\Input::all();
			$validation = \Validator::make($validInput, $rules);
		    if($validation->fails()){
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
			$contentname=$this->contentManager->getContentTypeNameOfContent($content_id);
			$field_requireds=$this->contentManager->getFieldRequired($contentname['name']);
			$rules=array();
			foreach($field_requireds as $key=>$input)
			{
				$rules[$key] = 'required';
			}
			$rules['title']='required';
			$rules['description']='required';
			$rules['tag']='required';
			$validInput=\Input::all();
			$validation = \Validator::make($validInput, $rules);
			if($validation->passes()){
				$messages=$validation->messages();
				if(count($messages)>0){
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
			}else if(\Request::is('*/content/show')){
				return $this->showContent($params);
			}
	  	return $this->processForm();
	}

	public function processForm(){
		if (\Request::is('*/content/form/view_update')){
			return $this->view_update();
        }else if (\Request::is('*/content/add')){
        	if(\Input::get('content_id')!=null){
         		$this->contentManager->deleteContent(null,\Input::get('content_id'));
        	}
           	$contentid=$this->addContent();	
           	return $this->jsonResponse(array("id"=>	$contentid,"mess"=>'content has been added'),false,true,false);
        }else if (\Request::is('*/content/update')){
        	$this->updateContent();	
        	return $this->jsonResponse(array('content has been updated'),false,true,false);
        }else if (\Request::is('*/content/delete')){
        	return $this->deleteContent();	
        }else if (\Request::is('*/content/edit')){
        	return $this->editContent();	
        }else if (\Request::is('*/content/translate')){
			return $this->translateContent();
		}else if(\Request::is('*/content/viewcode')){
			return $this->viewCode();
		}
    }

    
    private function showContent($params){
    	$input =  \Input::all();
    	if(array_key_exists('lang',$input)){
    		$content=$this->contentManager->editContentByUri($input['url'],$input['lang']);
    	}else{
    		$content=$this->contentManager->editContent($input['contentid'],$input['contenttranslationid']);
    	}
   	    $menus=array();
		$layouts=array();
		if(\Session::has('menus')){
			$menus=\Session::get('menus');
		}
		if(\Session::has('layouts')){
			$layouts=\Session::get('layouts');
		}
		if(\Session::has('contents')){
			$contents=\Session::get('contents');
		}
		return \View::make($params,['content'=>$content,'menus'=>$menus,'layouts'=>$layouts]);
    }
    
  
    private function viewCode(){
     	$input =  \Input::get('q');
     	$content=array('nothing to show');
     	if($input['translation_id']!=null){
    		$content=$this->contentManager->editContent($input['id'],$input['translation_id']);
     	}
    	return $this->jsonResponse($content);
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
		$title=$_POST['title'];
		$contentType=$_POST['ContentType'];
		$description=$_POST['description'];
		$uri=$_POST['uri'];
		$type=AllContentTypes::where('name','=',$contentType)->firstOrFail();
		$tag=$_POST['tag'];
		$langage=$_POST['langage'];
	    $ispublish=0;
	    if(array_key_exists('isPublish',$_POST)){
	    	if($_POST['isPublish']=='on'){
	    		$ispublish=1;
	    	}
	    }
       $weight=$_POST['weight'];
       $arr=array();
        $datas=\Input::all();
        foreach($datas as $key=>$value){
        	if('title'!=$key && 'ContentType'!=$key && 'tag'!=$key
        			&& 'isPublish'!=$key &&'description'!=$key &&'weight'!=$key && '_token'!=$key
        			&&'langage'!=$key && 'uri'!=$key && 'action'!=$key && 'content_id'!=$key){
        		$arr[$key]=$value;
        		
        	}
        }
        $content=$this->contentManager->serialize($arr);
     	$userid=\Auth::id();
    	$id=$this->contentManager->addContent($title,$content,$description,$tag,$langage,$type->id,$userid,$ispublish,$weight,$uri);
    	return $id;
	}

	private function deleteContent(){
		$input = \Input::get('q');
		$this->contentManager->deleteContent($input['id'],$input['translation_id']);
	}
  
   private function updateContent(){
   		$input = \Input::all();
   		if($input['duplicate']=='yes'){//duplicate and create new translation content
   			$res=$this->contentManager->find( \Input::get('content_id'), \Input::get('langage')[0]);
   			if (\Input::get('langage')[0]!=$res['lang']){// new traduction
   				$content_translation= new ContentsTranslation;
				$content_translation->name=$input['title'];
				$content_translation->tag=$input['tag'];
				$content_translation->lang=$input['langage'][0];
				$content_translation->refcontentid=$input['content_id'];
				
				$content= Contents::find($input['content_id']);
				$content->description=$input['description'];
				$content->weight=$input['weight'];
				$content->uri=$input['uri'];
				if(filter_var(\Input::get('isPublish'), FILTER_VALIDATE_BOOLEAN)){
					$content->ispublish=1;
				}else{
					$content->ispublish=0;
				}
				$data=array();
				foreach (array_keys($input) as $key){
					if($key!='_token' && $key!='content_id' && $key!='files' && $key!='fileName' && $key!='fileSize' && $key!='fileType' &&
			    			$key!='translation_id' && $key!='duplicate' 
							&& $key!='title' &&  $key!='description' && $key!='tag' && $key!='langage' && $key!='weight' 
							&& $key!='isPublish' &&$key!='uri'  && $key!='action'){
						$data[$key]=$input[$key];
						if('myfiles'==$key && array_key_exists('myfiles',$input)){
							if(empty($input['myfiles'])){
								$data[$key]="";
							}else{
								$data[$key]=$input['myfiles'];
							}
						}
					}
				}
				$blobout=$this->contentManager->serialize($data);
				$content_translation->content=$blobout;
				$content->update();
				$content_translation->save();
   			}else{
   				$content= Contents::find($input['content_id']);
			    $content->description=$input['description'];
			    if(filter_var(\Input::get('isPublish'), FILTER_VALIDATE_BOOLEAN)){
			    	$content->ispublish=1;
			    }else{
			    	$content->ispublish=0;
			    }
			   
			    $content->weight=$input['weight'];
			    $content->uri=$input['uri'];
			    $content_translation= ContentsTranslation::where('id','=',$res['id'])->first();
			    
			    $content_translation->name=$input['title'];
			    $content_translation->tag=$input['tag'];
			    $content_translation->lang=$input['langage'][0];
			    $content_translation->updated_at=time();
			    $blob=$this->contentManager->deserialize( $content_translation['content']);
			    foreach (array_keys($input) as $key){
			    	if($key!='_token' && $key!='content_id' && $key!='files' && $key!='fileName' && $key!='fileSize' && $key!='fileType' &&
			    			$key!='translation_id' && $key!='duplicate' && $key!='title' &&  $key!='description' && $key!='tag' && $key!='langage' && $key!='weight' 
			    			&& $key!='isPublish' && $key!='uri'  && $key!='action'){
			    		$blob[$key]=$input[$key];
			    		if('myfiles'==$key && array_key_exists('myfiles',$input)){
			    			if(empty($input['myfiles'])){
			    				$blob[$key]="";
			    			}else{
			    				$blob[$key]=$input['myfiles'];
			    			}
			    		}
			    	}
			    }
			    $blobout=$this->contentManager->serialize($blob);
			    $content_translation->content=$blobout;
			    $content->update();
			    $content_translation->update();
   				
   			}
		}else{
			$content= Contents::find($input['content_id']);
		    $content->description=$input['description'];
		    if(filter_var(\Input::get('isPublish'), FILTER_VALIDATE_BOOLEAN)){
		    	$content->ispublish=1;
		    }else{
		    	$content->ispublish=0;
		    }
		   
		    $content->weight=$input['weight'];
		    $content->uri=$input['uri'];
		    $content_translation= ContentsTranslation::where('id','=',$input['translation_id'])->first();
		    $content_translation->name=$input['title'];
		    $content_translation->tag=$input['tag'];
		    $content_translation->lang=$input['langage'][0];
		    $content_translation->updated_at=time();
		    $blob=$this->contentManager->deserialize( $content_translation['content']);
		    foreach (array_keys($input) as $key){
		    	if($key!='_token' && $key!='content_id' && $key!='files' && $key!='fileName' && $key!='fileSize' && $key!='fileType' &&
		    			$key!='translation_id' && $key!='duplicate' && $key!='title' &&  $key!='description' && $key!='tag' && $key!='langage' && $key!='weight'
		    			&& $key!='isPublish'  && $key!='uri' && $key!='action'){
		    		$blob[$key]=$input[$key];
		    		if('myfiles'==$key && array_key_exists('myfiles',$input)){
		    			if(empty($input['myfiles'])){
		    				$blob[$key]="";
		    			}else{
		    				$blob[$key]=$input['myfiles'];
		    			}
		    		}
		    	}
		    }
		    $blobout=$this->contentManager->serialize($blob);
		    $content_translation->content=$blobout;
	        $content->update();
	        $content_translation->update();
		}
	}

	
	
	//action called when you are in the list contents and you edit one
	private function editContent($id=null){
		$input=null;
		if($id== null){
			$input =  \Input::get('q');
			if($input==null){//from search controller
				$input =\Session::get('q');
				$cttranslation=$this->contentManager->findContentTranslation($input['translation_id']);
				$input['id']=$cttranslation->refcontentid;
			}
		}else{
			$input['id']=$id;
		}
		$content=$this->contentManager->editContent($input['id'],$input['translation_id']);
		if($id!= null){
			$input['description']=$content['description'];
			$input['uri']=$content['uri'];
		}else{
			$input['description']=$content['description'];
			$input['uri']=$content['uri'];
		}
		$type=$this->contentTypeManager->findAllContentTypeByName($content['contentType']);
		//mapping of data and type and widget
		$contentItems=$this->contentTypeManager->findContentTypeById($type->id);
		$mapping=array();
		$i=0;
		foreach ($contentItems as $items) {
    	 	$map[$items->getFieldName()][]=array(
    			 'type'=>$items->getFieldType(),
    	 		 'value'=>$items->getFieldValue(),
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
    	 		'required'=>$items->getFieldRequired(),
    	 		'value'=>$items->getFieldValue()
    	 		);
    	 	$i++;
    	}
    	
   		$ct=array('id'=>$input['id'],'lang'=>$content['langage'],'duplicate'=>'no','translation_id'=>$input['translation_id'],'title'=>$content['title'],'description'=>$input['description'],'tag'=>$content['tag'],'contentType'=>$content['contentType'],'content'=>$mapping,'ispublish'=>$content['ispublish'],'weight'=>$content['weight'],'uri'=>$content['uri']);
   		\Session::put('content_edit', $ct);
    	$countries=$this->contentManager->getAllCountries();
    	$lang=array();
    	foreach($countries as $country){
    		//fix up to limit the list of country
    		if($country['code']=='FR'|| $country['code']=='US' ||$country['code']=='GB'){
    			$lang[$country['code']]=$country['name_en'];
    		}
    	}
    	\Session::put('langages', $lang);
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
    	$response=null;
    	$response['template']=null;
    	if($input!='NULL' && !empty($input)){
	    	$allContentTypes=$this->contentTypeManager->getAllContentTypes($input);
	    	$contentItems=$this->contentTypeManager->getContentType($input);
			$response = array(array());
			$i=0;
	   		foreach ($contentItems as $items) {
	   		 	$response[$i][]=array(
	    			 'id' => $i,
	    			 'title'=>$items->getTableName(),
	    			 'fieldname'=>$items->getFieldName(),
	    			 'fieldtype'=>$items->getFieldType(),
	    			 'fielddescription'=>$items->getDescription(),
	    			 'fieldwidget'=>$items->getFieldWidget(),
	    	 		 'fieldvalue'=>$items->getFieldValue(),
	    	 		 'fieldrequired'=>$items->getFieldRequired()
	    	 	);
	    		$i=$i+1;
			}
	    	$response[$i]['template']=$allContentTypes->template;
       }
    //\Log::info($response);
	return $this->jsonResponse($response);
   }



	public function init(){
		$content_types=$this->listAllContentType();
		$options = array();
        $options['NULL']='';
		foreach ($content_types as $content_type)
		{
		     $options[$content_type->name] = $content_type->name;
		}
		\Session::flash('content_types', $options);
		return \View::make('cmsgroovel.pages.admin_content_management');
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

	
	//action called when you are in the list contents and you edit one
	private function translateContent(){
		$input =  \Input::get('q');
		$content=$this->contentManager->editContent($input['id'],$input['translation_id']);
		//mapping of data and type and widget
		$type=$this->contentTypeManager->findAllContentTypeByName($content['contentType']);
		
		$contentItems=$this->contentTypeManager->findContentTypeById($type->id);
		$mapping=array();
		$i=0;
		foreach ($contentItems as $items) {
			$map[$items->getFieldName()][]=array(
					'type'=>$items->getFieldType(),
					'required'=>$items->getFieldRequired(),
					'widget'=>$items->getFieldWidget(),
					'value'=>$items->getFieldValue()
			);
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
					'value'=>$items->getFieldValue(),
					'required'=>$items->getFieldRequired()
			);
			$i++;
		}
		$ct=array('id'=>$input['id'],'lang'=>$content['langage'],'duplicate'=>'yes','translation_id'=>null,'title'=>$content['title'],'description'=>$input['description'],'tag'=>$content['tag'],'contentType'=>$content['contentType'],'content'=>$mapping,'ispublish'=>$content['ispublish'],'weight'=>$content['weight'],'uri'=>$content['uri']);
		\Session::flash('content_edit', $ct);
		
		$countries=$this->contentManager->getAllCountries();
		$lang=array();
		foreach($countries as $country){
			//fix up to limit the list of country
			if($country['code']=='FR'|| $country['code']=='US' ||$country['code']=='GB'){
				$lang[$country['code']]=$country['name_en'];
			}
		}
		\Session::flash('langages', $lang);
		$uri=array();
		$uri['uri']= url('admin/content/editform', $parameters = array(), $secure = null);
		return $this->jsonResponse($uri);
	}

}
