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
use Groovel\Cmsgroovel\models\Layout;

class LayoutDao implements LayoutDaoInterface{

	public function save($langage,$title,$header,$footer,$type,$logo){
		$layout=new Layout;
		$layout->lang=$langage['code'];
		$layout->title=$title;
		$layout->layout=$type;
		$layout->header=base64_encode(serialize($header));
		$layout->footer=base64_encode(serialize($footer));
		$layout->logo=$logo;
		$layout->save();
		return $layout->id;
	}
	
	public function paginateAllLayouts(){
		$layouts=Layout::paginate(15);
		return $layouts;
	}
	
	public function delete($id){
		$layout=Layout::find($id);
        $layout->delete();
	}
	
	public function find($id){
		$layout= Layout::where('id','=',$id)->first();
		$layoutd=new Layout;
		$layoutd->lang=$layout['lang'];
		$layoutd->title=$layout['title'];
		$layoutd->layout=$layout['layout'];
		$layoutd->header=unserialize(base64_decode($layout['header']));
		$layoutd->footer=unserialize(base64_decode($layout['footer']));
		$layoutd->logo=$layout['logo'];
		return $layoutd;
	}
	
	public function findByNameAndLang($name,$lang){
		return Layout::where('title','=',$name)->where('lang','=',$lang)->first();
	}
	
	public function update($id,$codelang, $title, $header, $footer,$logo){
		$layoutd=Layout::find($id);
		$layoutd->lang=$codelang;
		$layoutd->title=$title;
		$layoutd->header=base64_encode(serialize($header));
		$layoutd->footer=base64_encode(serialize($footer));
		$layoutd->logo=$logo;
		$layoutd->save();
	}
	
	public function paginate($lang,$layout){
		$layouts=null;
		$convlayouts=[];
		if($lang!=null){
			$layouts=Layout::where('lang','=',$lang)->where('layout','=',$layout)->get();
		}else{
			$layouts=Layout::where('layout','=',$layout)->get();
		}
		foreach($layouts as $layout){
			$layoutd['lang']=$layout['lang'];
			$layoutd['title']=$layout['title'];
			$layoutd['layout']=$layout['layout'];
			$layoutd['header']=unserialize(base64_decode($layout['header']));
			$layoutd['footer']=unserialize(base64_decode($layout['footer']));
			$layoutd['logo']=$layout['logo'];
			array_push($convlayouts,$layoutd);
		}
		
		return $convlayouts;
	}


}