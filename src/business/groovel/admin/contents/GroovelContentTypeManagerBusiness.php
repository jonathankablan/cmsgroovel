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
use Groovel\Cmsgroovel\business\groovel\admin\contents\GroovelContentTypeManagerBusinessInterface;
use Groovel\Cmsgroovel\dao\ContentsDaoInterface;
use Groovel\Cmsgroovel\dao\ContentsDao;
use Groovel\Cmsgroovel\dao\ContentTypeDaoInterface;
use Groovel\Cmsgroovel\dao\ContentTypeDao;
use Groovel\Cmsgroovel\dao\WidgetDaoInterface;
use Groovel\Cmsgroovel\dao\WidgetDao;

class GroovelContentTypeManagerBusiness implements GroovelContentTypeManagerBusinessInterface{
	
	private $contentDao;
	private $contentTypeDao;
	private $widgetDao;
	
	public function __construct(ContentsDaoInterface $contentDao,ContentTypeDaoInterface $contentTypeDao,WidgetDaoInterface $widgetDao)
	{
		$this->contentDao =$contentDao;
		$this->contentTypeDao =$contentTypeDao;
		$this->widgetDao =$widgetDao;
	}

	
	public function createContentType($title){
		$type= $this->contentTypeDao->createType($title);
		return $type;
	}
	
	public function addField($title,$fieldname,$fielddescription,$fieldtype,$fieldvalue,$fieldwidget,$fieldrequired,$reftypeid){
		$widgetid=null;
		if(!empty($fieldwidget)){
			$res=$this->widgetDao->findByName($fieldwidget);
			if($res==null){
				$widgetid=-1;
			}else{
				$widgetid=$res->id;
			}
		}else{
			$widgetid=-1;
		}
		$this->contentTypeDao->create($title,$fieldname,$fielddescription,$fieldtype,$fieldvalue,$widgetid,$fieldrequired,$reftypeid);
	}
	
   public function getContentType($tableName){
    	return $this->contentTypeDao->findContentTypeByName($tableName);
     }


   public function getListContentType(){
   	return $this->contentTypeDao->findAllContentType();
   }
   
   public function getListSystemContentType(){
   	return $this->contentTypeDao->findAllSystemContentType();
   }
   
 
   public function editContentType($contentid){
   	$contentType= $this->contentTypeDao->findContentTypeById($contentid);
   	$fields= array();
   	foreach ($contentType as $items) {
   		    $widget=null;
   		    if($items->hasWidget!=null){
   		    	$widget=$items->hasWidget->getName();
   		    }
   		  	array_push($fields,array(
					'id'=>$items->getId(),
					'name'=>$items->getFieldName(),
					'type'=>$items->getFieldType(),
					'description'=>$items->getDescription(),
					'widget'=>$widget,
					'fieldvalue'=>$items->getFieldValue(),
					'required'=>$items->getFieldRequired())
			);
		}
  	return $fields;
   }
   
  
   
   public function paginateContentType(){
   	return  $this->contentTypeDao->paginateContentType();
   }
   
  
    
   public function deleteContentType($name){
   	  $contentType=$this->contentTypeDao->findContentTypeByName($name);
   	  if($contentType!=null){
   	  	foreach($contentType as $type){
   	  		$type->delete();
   	  	}
   	  	$allContentType=$this->contentTypeDao->getAllContentTypes($name);
   	  	$allContentType->delete();
   	  }
   }
   
   public function existContents($contenttype){
   	  $contents=$this->contentTypeDao->findContentsByType($contenttype);
   	  if(count($contents)>0){
   	  	return true;
   	  }else return false;
   }
   
   public function getWidget($id){
   	return $this->widgetDao->find($id);
   }
   
   public function find($id){
   	return $this->contentTypeDao->find($id);
   }
   
   public function findAllContentTypeByName($name){
   	return $this->contentTypeDao->findAllContentTypeByName($name);
   }
   
   public function findContentTypeById($id){
   	return $this->contentTypeDao->findContentTypeById($id);
   }
   
   
}