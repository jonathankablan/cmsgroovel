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

	public function add($tableName,$fieldNames,$descriptions,$types,$widget,$isnullable,$required){
 	  $type= $this->contentTypeDao->createType($tableName);
      $this->insertIntoContent_Types($tableName,$fieldNames,$descriptions,$types,$type->id,$widget,$isnullable,$required);
	}

    private function insertIntoContent_Types($tableName,$fieldNames,$descriptions,$types,$type,$widget,$isnullable,$required){
        for ($i = 0; $i <count($fieldNames); $i++){
        	$res=null;
        	$widgetid=null;
        	if($widget[$i]!='blank'){
        		$res=$this->widgetDao->findByName($widget[$i]);
        		$widgetid=$res->id;
        	}else{
        		$widgetid=-1;
        	}
        	
        	
          $this->contentTypeDao->create($tableName,$fieldNames[$i],$descriptions[$i],$types[$i],$type,$widgetid,$isnullable[$i],$required[$i]);
        }
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
   	foreach ($contentType as $items) {
			$map[$items->getId()]=array(
					'id'=>$items->getId(),
					'name'=>$items->getFieldName(),
					'type'=>$items->getFieldType(),
					'description'=>$items->getDescription(),
					'widget'=>$items->getFieldWidget(),
					'isnullable'=>$items->getFieldNullable(),
					'required'=>$items->getFieldRequired()
					
			);
		}
  	return $map;
   }
   
   public function deleteField($fieldName){
   	   $this->contentTypeDao->deleteField($fieldName);
   }
   
   public function paginateContentType(){
   	return  $this->contentTypeDao->paginateContentType();
   }
   
   public function update($title,$fieldIds,$fieldNames,$typeSelecteds,$widgetSelecteds,$descriptions,$isnullable,$required){
   	$index=0;
   	$index_max=count($fieldNames);
   	$tableName=null;
   	$type=null;
   	$contentTypePersist= $this->contentTypeDao->findContentTypeByName($title);
   	
   	$persistFields=array();
   	foreach ($contentTypePersist as $fields)
   	{
   		$persistFields[$fields['fieldName']]=$fields['fieldName'];
   	}
   	$updateFields=array();
   
   	for($i=0;$i<$index_max;$i++){
   		if(count($fieldIds)>$i){
   			$field_id=$fieldIds[$i];
   			$contentType=$this->contentTypeDao->findContentTypeByFieldId($field_id);
   			$contentType=$this->contentTypeDao->updateContentType($contentType,$fieldNames[$i],$typeSelecteds[$i],$widgetSelecteds[$i],$descriptions[$i],$isnullable[$i],$required[$i]);
   			$updateFields[$contentType->fieldName]=$contentType->fieldName;
   			$tableName=$contentType->tableName;
   			$type=$contentType->content_type;
   		}else{
  			$this->contentTypeDao->create($tableName,$fieldNames[$i],$descriptions[$i],$typeSelecteds[$i],$type,$widgetSelecteds[$i],$isnullable[$i],$required[$i]);
   		}
   	}
   
   	foreach($persistFields as $fieldTodelete){
   		if(!array_key_exists ($fieldTodelete,$updateFields) && count($updateFields)>0){
   			if($fieldTodelete!='groovelDescription'){
   				$this->contentTypeDao->deleteField($fieldTodelete);
   			}
   		}
   	}
   	return $title;
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