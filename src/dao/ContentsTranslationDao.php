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
use Groovel\Cmsgroovel\models\ContentsTranslation;
use Groovel\Cmsgroovel\models\Contents;


class ContentsTranslationDao implements ContentsTranslationDaoInterface{

//public function create($title,$data,$url,$grooveldescription,$contentType,$userid,$publish,$topPublish){
public function create($refid,$title,$data,$grooveldescription,$langage){
	$contents= new ContentsTranslation();
	$contents->refcontentid=$refid;
	$contents->name=$title;
	$contents->content=$data;
	$contents->lang=$langage;
	$contents->grooveldescription=$grooveldescription;
	$contents->save();
	return $contents;
}

public function delete($id){
	$content = ContentsTranslation::find($id);
	$content->delete();
}

public function find($id){
	return ContentsTranslation::find($id);
}


public function findTranslation($refcontentid,$lang){
	return ContentsTranslation::where('refcontentid','=',$refcontentid)->where('lang','=',$lang)->first();
}

}