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

interface GroovelContentManagerBusinessInterface{

	public function addContent($title,$data,$description,$tag,$langage,$contentType,$userid,$publish,$weight);
	public function getContent($name);
	public function editContent($contentid,$contentTranslationid);
    public function paginateContent($langage);
    public function deleteContent($id,$translation_id);
    public function getFieldRequired($contentype);
    public function paginateFullContentDeserialize($langage=null,$layout=null);
    public function getContentTypeNameById($id);
    public function getContentTypeNameOfContent($contentid);
    public function getAllCountries();
    public function find($refcontentid,$lang); 
    public function getPageTemplateElementsByType($type,$langage);
    public function getPageTemplateElementsByTitleAndType($title,$type,$langage);
    public function paginateAllContent();
    public function findContentTranslation($refid);
   /* public function checkUrlUnique($idcontent,$url);*/
    
    
    
 
}


