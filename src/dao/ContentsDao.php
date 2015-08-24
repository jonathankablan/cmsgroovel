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
namespace dao;


class ContentsDao implements \ContentsDaoInterface{

public function create($title,$data,$url,$grooveldescription,$contentType,$userid,$publish,$topPublish){
	$contents= new \Contents();
	$contents->name=$title;
	$contents->content=$data;
	$contents->url=$url;
	$contents->type_id=$contentType;
	$contents->author_id=$userid;
	$contents->ispublish=$publish;
	$contents->ontop=$topPublish;
	$contents->grooveldescription=$grooveldescription;
	$contents->save();
	return $contents;
}

public function delete($id){
	$content = \Contents::find($id);
	$content->delete();
}

public function find($id){
	return \Contents::find($id);
}


public function paginate(){
	return \Contents::orderBy('created_at', 'desc')->orderBy('ontop', 'desc')->paginate(15);
	
}


/*public function search($query = "")
{
	return \IndexContents::where('body', 'like', "%{$query}%")
	->orWhere('title', 'like', "%{$query}%")
	->get();
}*/


}