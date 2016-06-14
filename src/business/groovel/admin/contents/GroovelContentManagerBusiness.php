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

namespace Groovel\Cmsgroovel\business\groovel\admin\contents;
use Illuminate\Database\Eloquent\Model;
use models;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Connection;
use Monolog\Logger;
use Groovel\Cmsgroovel\business\groovel\admin\contents\GroovelContentManagerBusinessInterface;
use Groovel\Cmsgroovel\dao\ContentsDaoInterface;
use Groovel\Cmsgroovel\dao\ContentsDao;
use Groovel\Cmsgroovel\dao\ContentTypeDaoInterface;
use Groovel\Cmsgroovel\dao\ContentTypeDao;
use Groovel\Cmsgroovel\dao\RouteDaoInterface;
use Groovel\Cmsgroovel\dao\RouteDao;
use Groovel\Cmsgroovel\dao\CountryDaoInterface;
use Groovel\Cmsgroovel\dao\CountryDao;
use Groovel\Cmsgroovel\dao\ContentsTranslationDaoInterface;
use Groovel\Cmsgroovel\dao\ContentsTranslationDao;
use Groovel\Cmsgroovel\dao\CommentsDao;
use Groovel\Cmsgroovel\dao\CommentsDaoInterface;

class GroovelContentManagerBusiness implements GroovelContentManagerBusinessInterface{

	private $contentDao;
	private $routeDao;
	private $contentTypeDao;
	private $countryDao;
	private $contentTranslationDao;
	private $commentDao;
	
	public function __construct(ContentsDaoInterface $contentDao,RouteDaoInterface $routeDao,ContentTypeDaoInterface $contentTypeDao,CountryDaoInterface $countryDao,ContentsTranslationDaoInterface $contentTranslationDao,CommentsDaoInterface $commentDao)
	{
		$this->contentDao =$contentDao;
		$this->routeDao = $routeDao;
		$this->contentTypeDao =$contentTypeDao;
		$this->countryDao=$countryDao;
		$this->contentTranslationDao=$contentTranslationDao;
		$this->commentDao=$commentDao;
	}
	
	public function findContentTranslation($refid){
		return $this->contentTranslationDao->find($refid);
	}
	
	public function getAllCountries(){
		return $this->countryDao->all();
	}
	

	public function addContent($title,$data,$description,$tag,$langage,$contentType,$userid,$publish,$weight,$uri){
		 $contents= $this->contentDao->create($description,$contentType,$userid,$publish,$weight,$uri);
		 $contentsTranslation=$this->contentTranslationDao->create($contents->id, $title, $data, $tag, $langage);
		 return $contentsTranslation->getId();
	}  

 
	public function getContentTypeNameById($id){
		return $this->contentTypeDao->getContentTypeNameById($id);
	}
	
	
	public function getContent($name){
		$content=$this->contentDao->find($name);
		return $this->deserialize($content['content']);
	}
	
	
	public function editContent($contentid,$contentTranslationid){
		$contentTranslation= $this->contentTranslationDao->find($contentTranslationid);
		$comments=array();
		foreach($contentTranslation->comments as $comm){
			array_push($comments,['author_picture'=>$comm->author->picture,'author_pseudo'=>$comm->author->pseudo,'comment'=>unserialize(base64_decode($comm->comment)),'created_at'=>$comm->created_at,'updated_at'=>$comm->updated_at]);
		}
		$content= $this->contentDao->find($contentTranslation->refcontentid);
		$blob=$this->deserialize($contentTranslation['content']);
		$res=array('contentid'=>$contentid,'contenttranslationid'=>$contentTranslationid,'title'=>$contentTranslation->name,'langage'=>$contentTranslation->lang,'description'=>$content['description'],'tag'=>$contentTranslation->tag,'contentType'=>$content->type->name,'content'=>$blob,'ispublish'=>$content->ispublish,'weight'=>$content->weight,'uri'=>$content->uri,'author'=>$content->author->pseudo,'created_at'=>$contentTranslation->created_at,'comments'=>$comments);
		return $res;
	}
	
	public function editContentByUri($url,$lang){
		$content=$this->contentDao->findByUri($url);
		$contentTranslation= $this->contentTranslationDao->findTranslation($content->id,$lang);
		$comments=array();
		foreach($contentTranslation->comments as $comm){
			array_push($comments,['author_picture'=>$comm->author->picture,'author_pseudo'=>$comm->author->pseudo,'comment'=>unserialize(base64_decode($comm->comment)),'created_at'=>$comm->created_at,'updated_at'=>$comm->updated_at]);
		}
		$blob=$this->deserialize($contentTranslation['content']);
		$res=array('contentid'=>$content->id,'contenttranslationid'=>$contentTranslation->id,'title'=>$contentTranslation->name,'langage'=>$contentTranslation->lang,'description'=>$content['description'],'tag'=>$contentTranslation->tag,'contentType'=>$content->type->name,'content'=>$blob,'ispublish'=>$content->ispublish,'weight'=>$content->weight,'uri'=>$content->uri,'author'=>$content->author->pseudo,'created_at'=>$contentTranslation->created_at,'comments'=>$comments);
		return $res;
	}

	
   public function deserialize($dataDb){
   	$data=unserialize(base64_decode($dataDb));
   	$res=array();
   	foreach($data as $key=>$value){
   		if(!is_array($value)){
   			$res[$key]=html_entity_decode($value);
   		}else{
   			$res[$key]=$value;
   		}
   	}
    return $res;
   }


   public function serialize($content){
  	 return base64_encode(serialize($content));
   }
   
   public function paginateContent($langage=null){
   	return $this->contentDao->paginate($langage);
   }
   
   public function paginateAllContent(){
   	return $this->contentDao->paginateAll();
   }

   public function deleteContent($id,$translation_id){
   	    if($id==null){
   	    	$cttrans=$this->contentTranslationDao->find($translation_id);
   	    	$id=$cttrans->refcontentid;
   	    }
   	   $this->contentTranslationDao->delete($translation_id);
   	   $content=$this->contentDao->find($id);
   	   $translations=$content->translation;
   	   if(count($translations)==0){
	   	$this->contentDao->delete($id);
   	   }
   }
   
   public function getFieldRequired($contentype){
   	  $fields_required=array();
   	  $fields=$this->contentTypeDao->findContentTypeByName($contentype);
   	  foreach($fields as $field){
   	  	if($field['required']=='1'){
   	  		$fields_required[$field['fieldName']]=$field['fieldName'];
   	  	}
   	  }
   	  return $fields_required;
   }

   /**function to call in the controller to get contents by langage**/
   public function paginateFullContentDeserialize($langage=null,$layout=null){
   	$res= $this->contentDao->paginate($langage,$layout);
   	$result=array();
   	foreach ($res as $contentTranslation){
   				array_push($result,$this->editContent($contentTranslation->refcontentid,$contentTranslation->id));
   	}
   	return $result;
   }
   
   public function getContentTypeNameOfContent($contentid){
   	  $content=$this->contentDao->find($contentid);
   	  return $this->contentTypeDao->find( $content->type_id);
   }
   
   public function find($refcontentid,$lang){
   	return $this->contentTranslationDao->findTranslation($refcontentid,$lang);
   }
   
   
   /**to put elements contents in different sections in the page sidebar head **/
   public function getPageTemplateElementsByTitleAndType($title,$type,$langage){
   		$res=$this->contentDao->getContentByTitleAndType($title, $type);
   		$result=array();
   		$ctref=null;
   		foreach ($res as $translation){
   			if($ctref==null){
   				$ctref=$this->contentDao->find($translation->first()->refcontentid);
   			}
   			if($translation->first()->lang==$langage){
		   			$merge=$this->editContent($translation->first()->refcontentid,$translation->first()->id);
		   			$merge['type']=$ctref->name;
		   			array_push($result,$merge);
   				}
   		}
   		return $result;
   }
   
   public function getPageTemplateElementsByType($type,$langage){
   	$contentTranslations=$this->contentDao->getContentByType($type);
   	$result=array();
   	$ctref=null;
   	foreach ($contentTranslations as $contentTranslation){
   		if($ctref==null){
   			$ctref=$this->contentDao->find($contentTranslation->first()->refcontentid);
   		}
   		if($ctref->ispublish==1 && $contentTranslation->first()->lang==$langage){
   			$contenttype=$this->contentTypeDao->find( $ctref->type_id);
   			$merge=$this->editContent($contentTranslation->first()->refcontentid,$contentTranslation->first()->id);
   			$merge['type']=$contenttype->name;
   			array_push($result,$merge);
   		}
   	}
   	return $result;
   }
   
 
}