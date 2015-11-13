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
use Groovel\Cmsgroovel\models\Contents;
use Groovel\Cmsgroovel\models\ContentTypes;
use Groovel\Cmsgroovel\models\AllContentTypes;
use Groovel\Cmsgroovel\models\ContentsTranslation;

class ContentsDao implements ContentsDaoInterface{

public function create($url,$contentType,$userid,$publish,$topPublish){
	$contents= new Contents();
	$contents->url=$url;
	$contents->type_id=$contentType;
	$contents->author_id=$userid;
	$contents->ispublish=$publish;
	$contents->ontop=$topPublish;
	$contents->save();
	return $contents;
}

public function delete($id){
	$content = Contents::find($id);
	$content->delete();
}

public function find($id){
	return Contents::find($id);
}

public function paginate($langage=null){
	if($langage!=null){
		return  ContentsTranslation::where('lang','=',$langage)->orderBy('created_at', 'desc')->paginate(15);
	}
	return Contents::orderBy('created_at', 'desc')->orderBy('ontop', 'desc')->paginate(15);
}


public function getContentByTitleAndType($title,$type){
	$contentType=AllContentTypes::where('name','=',$type)->first();
	$contents= Contents::where('type_id','=',$contentType->id)->get();
	$result=array();
	foreach($contents as $content){
		if($content->ispublish==1){
			foreach($content->translation as $translation){
			 if($translation->name==$title){
			  	array_push($result,$translation);
			 }
			}
		}
	}
	return $result;
	
	return Contents::where('name','=',$title)->where('type_id','=',$contentType->id)->get();
}

public function getContentByType($type){
	$contentType=AllContentTypes::where('name','=',$type)->first();
	$contents= Contents::where('type_id','=',$contentType->id)->get();
	$result=array();
	foreach($contents as $content){
		array_push($result,$content->translation);
	}
	return $result;
}



}