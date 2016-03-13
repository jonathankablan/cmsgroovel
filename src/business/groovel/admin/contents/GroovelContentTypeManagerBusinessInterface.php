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

interface GroovelContentTypeManagerBusinessInterface{

	public function getContentType($tableName);
	public function getListContentType();
	public function editContentType($contentid);
	public function paginateContentType();
	public function createContentType($title,$template);
	public function addField($title,$fieldname,$fielddescription,$fieldtype,$fieldvalue,$fieldwidget,$fieldrequired,$reftypeid);
	public function deleteContentType($name);
	public function existContents($contenttype);
	public function getWidget($id);
	public function find($id);
	public function  getListSystemContentType();
	public function findAllContentTypeByName($name);
	public function findContentTypeById($id);
	public function getContentTypeNameById($id);
	public function getAllContentTypes($name);
}
