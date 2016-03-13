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
namespace Groovel\Cmsgroovel\dao;

interface ContentTypeDaoInterface{

public function find($contentTypeid);

public function createType($tableName,$template);

public function create($title,$fieldName,$fielddescription,$fieldtype,$fieldvalue,$widgetid,$fieldrequired,$reftypeid);

public function findContentTypeByName($tableName);

public function findAllContentType();

public function findContentTypeById($id);

 public function deleteField($fieldName);

 public function paginateContentType();
 
 public function findContentTypeByFieldId($id);
 
 public function updateContentType($contentType,$fieldName,$typeSelected,$widgetSelected,$description,$isnullable,$required);
 
 public function findAllContentTypeByName($contentTypeName);
 
 public function getAllContentTypes($name);

 public function findContentsByType($contenttype);
 
 public function findAllSystemContentType();
 
 public function getContentTypeNameById($id);

}