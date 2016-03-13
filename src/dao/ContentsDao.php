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
use DB;
class ContentsDao implements ContentsDaoInterface{

public function create($description,$contentType,$userid,$publish,$weight=null){
	$contents= new Contents();
	$contents->description=$description;
	$contents->type_id=$contentType;
	$contents->author_id=$userid;
	$contents->ispublish=$publish;
	if($weight==null){
		$contents->weight=0;
	}else{
		$contents->weight=$weight;
	}
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

public function paginate($langage=null,$layout=null){
	$contents=null;
	if($langage!=null){
		$contents = DB::table('contents')
		->join('contents_translation', 'contents.id', '=', 'contents_translation.refcontentid')
		->join('all_contents_type', 'all_contents_type.id', '=', 'contents.type_id')
		->join('users', 'users.id', '=', 'contents.author_id')
		->select('contents.id as content_id','contents.*', 'contents_translation.id as translation_id','contents_translation.*','all_contents_type.name as type','users.pseudo as author')
		->where('contents.ispublish','=',1)
		->where('contents_translation.lang','=',$langage)
		->where('all_contents_type.name','=',$layout)
		->orderBy('contents.weight','desc')
		->orderBy('contents.created_at', 'desc')->get();
	
	}else {
		$contents = DB::table('contents')
		->join('contents_translation', 'contents.id', '=', 'contents_translation.refcontentid')
		->join('all_contents_type', 'all_contents_type.id', '=', 'contents.type_id')
		->join('users', 'users.id', '=', 'contents.author_id')
		->select('contents.id as content_id','contents.*', 'contents_translation.id as translation_id','contents_translation.*','all_contents_type.name as type','users.pseudo as author')
		->where('contents.ispublish','=',1)
		->where('all_contents_type.name','=',$layout)
		->orderBy('contents.weight','desc')
		->orderBy('contents.created_at', 'desc')->get();
	
	}
	return  $contents;
}

public function paginateAll($langage=null){
	$contents=null;
	if($langage!=null){
		$contents = DB::table('contents')
		->join('contents_translation', 'contents.id', '=', 'contents_translation.refcontentid')
		->join('all_contents_type', 'all_contents_type.id', '=', 'contents.type_id')
		->join('users', 'users.id', '=', 'contents.author_id')
		->select('contents.id as content_id','contents.*', 'contents_translation.id as translation_id','contents_translation.*','all_contents_type.name as type','users.pseudo as author')
		->where('contents_translation.lang','=',$langage)
		->orderBy('contents.weight','desc')
		->orderBy('contents.created_at', 'desc')
		->paginate(15);
	}else {
		$contents = DB::table('contents')
		->join('contents_translation', 'contents.id', '=', 'contents_translation.refcontentid')
		->join('all_contents_type', 'all_contents_type.id', '=', 'contents.type_id')
		->join('users', 'users.id', '=', 'contents.author_id')
		->select('contents.id as content_id','contents.*', 'contents_translation.id as translation_id','contents_translation.*','all_contents_type.name as type','users.pseudo as author')
		->orderBy('contents.weight','desc')
		->orderBy('contents.created_at', 'desc')
		->paginate(15);
	}
	return  $contents;
	
}


public function getContentByTitleAndType($title,$type){
	$contentType=AllContentTypes::where('name','=',$type)->first();
	$contents= Contents::where('type_id','=',$contentType->id)->orderBy('weight','desc')->get();
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

}

public function getContentByType($type){
	$contentType=AllContentTypes::where('name','=',$type)->first();
	$contents= Contents::where('type_id','=',$contentType->id)->orderBy('weight','desc')->get();
	$result=array();
	foreach($contents as $content){
		array_push($result,$content->translation);
	}
	return $result;
}

	public function checkUrlUnique($idcontent,$url){
		$exist=Contents::where('id',"!=",$idcontent)->where('url','=',$url)->first();
		if($exist!=null){
			return false;
		}else return true;
}

}