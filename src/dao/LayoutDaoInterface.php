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

interface LayoutDaoInterface{

	public function save($langage,$title,$header,$footer,$layout,$logo);
	public function paginateAllLayouts();
	public function delete($id);
	public function find($id);
	public function findByNameAndLang($name,$lang);
	public function update($id,$codelang, $title, $header, $footer,$logo);
	public function paginate($lang,$layout);
	

}