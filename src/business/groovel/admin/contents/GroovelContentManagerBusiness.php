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

namespace business\groovel\admin\contents;
use Illuminate\Database\Eloquent\Model;
use models;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Connection;
use Monolog\Logger;
use business\groovel\admin\contents\GroovelContentManagerBusinessInterface;
use dao\ContentsDaoInterface;
use dao\ContentsDao;
use dao\ContentTypeDaoInterface;
use dao\ContentTypeDao;
use dao\RouteDaoInterface;
use dao\RouteDao;

class GroovelContentManagerBusiness implements \GroovelContentManagerBusinessInterface{

	private $contentDao;
	private $routeDao;
	private $contentTypeDao;
	
	public function __construct(\ContentsDaoInterface $contentDao,\RouteDaoInterface $routeDao,\ContentTypeDaoInterface $contentTypeDao)
	{
		$this->contentDao =$contentDao;
		$this->routeDao = $routeDao;
		$this->contentTypeDao =$contentTypeDao;
	}
	
	public function createUrlView($title,$url,$contentTypeid){
		$name=$this->contentTypeDao->find($contentTypeid);
		$this->routeDao->create($title,$url,$name);
	}

	public function addContent($title,$data,$url,$grooveldescription,$contentType,$userid,$publish,$topPublish){
		 $contents= $this->contentDao->create($title,$data,$url,$grooveldescription,$contentType,$userid,$publish,$topPublish);
		 $this->createUrlView($title,$url,$contentType);
		 return $contents->getId();
	}  

 
	public function getContentTypeNameById($id){
		return $this->contentTypeDao->getContentTypeNameById($id);
	}
	
	
	public function getContent($name){
		$content=$this->contentDao->find($name);
		\Log::info($content);
		return $this->deserialize($content['content']);
	}
	
	
	public function editContent($contentid){
		$content= $this->contentDao->find($contentid);
		//\Log::info($content);
		$blob=$this->deserialize($content['content']);
		//\Log::info($blob);
		$res=array('title'=>$content->name,'url'=>$content['url'],'groovelDescription'=>$content->grooveldescription,'contentType'=>$content->type_id,'content'=>$blob,'ispublish'=>$content->ispublish,'ontop'=>$content->ontop);
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

   public function deleteContent($id){
	   $this->contentDao->delete($id);
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

   public function paginateFullContentDeserialize(){
   	$res= $this->contentDao->paginate()->getItems();
   	$result=array();
   	foreach ($res as $content){
   		if($content->ispublish==1){
   			array_push($result,$this->editContent($content->id)['content']);
   		}
   	}
   //	\Log::info($result);
   	return $result;
   }
   
   public function getContentTypeNameOfContent($contentid){
   	  $content=$this->contentDao->find($contentid);
   	  return $this->contentTypeDao->find( $content->type_id);
   	
   }
}