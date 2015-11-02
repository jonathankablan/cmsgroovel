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

class GroovelContentManagerBusiness implements GroovelContentManagerBusinessInterface{

	private $contentDao;
	private $routeDao;
	private $contentTypeDao;
	private $countryDao;
	private $contentTranslationDao;
	
	public function __construct(ContentsDaoInterface $contentDao,RouteDaoInterface $routeDao,ContentTypeDaoInterface $contentTypeDao,CountryDaoInterface $countryDao,ContentsTranslationDaoInterface $contentTranslationDao)
	{
		$this->contentDao =$contentDao;
		$this->routeDao = $routeDao;
		$this->contentTypeDao =$contentTypeDao;
		$this->countryDao=$countryDao;
		$this->contentTranslationDao=$contentTranslationDao;
	}
	
	public function getAllCountries(){
		return $this->countryDao->all();
	}
	
	public function createUrlView($title,$url,$contentTypeid){
		$name=$this->contentTypeDao->find($contentTypeid);
		$this->routeDao->create($title,$url,$name);
	}

	public function addContent($title,$data,$url,$grooveldescription,$langage,$contentType,$userid,$publish,$topPublish){
		 $contents= $this->contentDao->create($url,$contentType,$userid,$publish,$topPublish);
		 //$this->contentDao->create($title,$data,$url,$grooveldescription,$contentType,$userid,$publish,$topPublish);
		 $contentsTranslation=$this->contentTranslationDao->create($contents->id, $title, $data, $grooveldescription, $langage);
		 $this->createUrlView($title,$url,$contentType);
		 return $contentsTranslation->getId();
	}  

 
	public function getContentTypeNameById($id){
		return $this->contentTypeDao->getContentTypeNameById($id);
	}
	
	
	public function getContent($name){
		$content=$this->contentDao->find($name);
		//\Log::info($content);
		return $this->deserialize($content['content']);
	}
	
	
	public function editContent($contentid,$contentTranslationid){
		$contentTranslation= $this->contentTranslationDao->find($contentTranslationid);
		$content= $this->contentDao->find($contentTranslation->refcontentid);
		//\Log::info($content);
		
		$blob=$this->deserialize($contentTranslation['content']);
		//\Log::info($blob);
		$res=array('title'=>$contentTranslation->name,'langage'=>$contentTranslation->lang,'url'=>$content['url'],'groovelDescription'=>$contentTranslation->grooveldescription,'contentType'=>$content->type_id,'content'=>$blob,'ispublish'=>$content->ispublish,'ontop'=>$content->ontop);
		//\Log::info($res);
		return $res;
	}

	
   public function deserialize($dataDb){
   	$data=unserialize(base64_decode($dataDb));
    return $data;
   }


   public function serialize($content){
	 return base64_encode(serialize($content));
   }
   
   public function paginateContent(){
   	return $this->contentDao->paginate();
   }

   public function deleteContent($id,$translation_id){
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
   public function paginateFullContentDeserialize($langage){
   	$res= $this->contentDao->paginate($langage);
   	$result=array();
   	foreach ($res as $contentTranslation){
   			if($contentTranslation->content->ispublish==1){
   				array_push($result,$this->editContent($contentTranslation->refcontentid,$contentTranslation->id));
   			}
   	}
   	
   //	\Log::info($result);
   	return $result;
   }
   
   public function getContentTypeNameOfContent($contentid){
   	  $content=$this->contentDao->find($contentid);
   	  return $this->contentTypeDao->find( $content->type_id);
   }
   
   
   /**to put elements contents in different sections in the page sidebar head **/
   public function getPageTemplateElements($title,$type){
   		$res=$this->contentDao->getContentByTitleAndType($title, $type);
   		$result=array();
   		foreach ($res as $content){
   			if($content->ispublish==1){
   				$contenttype=$this->contentTypeDao->find( $content->type_id);
   				$merge=$this->editContent($content->id)['content'];
   				$merge['type']=$contenttype->name;
   				array_push($result,$merge);
   			}
   		}
   		//	\Log::info($result);
   		return $result;
   }
   
 public function find($refcontentid,$lang){
 	return $this->contentTranslationDao->findTranslation($refcontentid,$lang);
 }
}