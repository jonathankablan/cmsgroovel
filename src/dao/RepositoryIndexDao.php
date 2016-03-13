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
use Groovel\Cmsgroovel\models\RepositoryIndex;


class RepositoryIndexDao implements RepositoryIndexDaoInterface{

	public function create($type,$id,$data,$title,$description){
	    $index= new RepositoryIndex();
		$index->type=$type;
		$index->refid=$id;
		$index->data=$data;
		$index->title=$title;
		$index->description=$description;
		$index->save();
	}

	public function update($type,$id,$data,$title,$description){
		$index=RepositoryIndex::find($id);
		if($index==null){
			$index= new RepositoryIndex();
			$index->type=$type;
			$index->refid=$id;
			$index->data=$data;
			$index->title=$title;
			$index->description=$description;
			$index->save();
		}else{
			$index->type=$type;
			$index->refid=$id;
			$index->data=$data;
			$index->title=$title;
			$index->description=$description;
			$index->save();
		}
	}
	
	public function findByRefId($id){
		$index = RepositoryIndex::where('refid', '=', $id)->first();
		return $index;
	}
	
	public function delete($id){
		$index=$this->findByRefId($id);
		if($index!=null){
			$index->delete();
		}
	}
	
	public function search($body){
		return RepositoryIndex::where('data', 'LIKE', '%'.$body.'%')->get();
	}
	
}