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

namespace Groovel\Cmsgroovel\Http\Controllers\groovel\admin\search;
use Illuminate\Database\Eloquent\Model;
use models;
use Groovel\Cmsgroovel\Http\Controllers\groovel\admin\common\GroovelFormController;
use Groovel\Cmsgroovel\business\groovel\admin\contents\GroovelContentTypeManagerBusiness;
use Groovel\Cmsgroovel\business\groovel\admin\contents\GroovelContentTypeManagerBusinessInterface;
use Groovel\Cmsgroovel\business\groovel\admin\configuration\GroovelConfigurationBusiness;
use Groovel\Cmsgroovel\business\groovel\admin\configuration\GroovelConfigurationBusinessInterface;
use Groovel\Cmsgroovel\business\groovel\admin\search\GroovelSearchManagerBusiness;
use Groovel\Cmsgroovel\business\groovel\admin\search\GroovelSearchManagerBusinessInterface;
use Groovel\Cmsgroovel\commons\ModelConstants;

class GroovelSearchEngineController extends GroovelFormController {

	
	protected $searchManager;
	
	protected $configManager;
	
	public function __construct(GroovelSearchManagerBusinessInterface $searchManager,GroovelConfigurationBusinessInterface $configManager)
	{
		$this->searchManager=$searchManager;
		$this->configManager=$configManager;
		$this->beforeFilter('auth');
	}
	
	

	public function processForm(){
		$this->checkToken();
		$messages=\Input::all();
		$w=\Input::get('search');
		$result=null;
		if($this->configManager->isElasticSearchEnable()!=1){
			$result= $this->searchManager->search($w);
		}else {
			$index_contents='contents';
			$index_users='users';
		    $result=array();
			$params=array();
			$fields=['title','author','pseudo'];
			$query=$w;
			$query_string=["fields"=>$fields,"query"=>$query,"use_dis_max"=>true];
			$params['body']['query']=['query_string'=>$query_string];
		    $contents=$this->searchManager->searchWithElastics($params,ModelConstants::$contents ,$index_contents);
		    if(!empty($contents)){
				array_push($result,$contents);
		    }
			
			$params=array();
			$fields=['title','pseudo'];
			$query=$w;
			$query_string=["fields"=>$fields,"query"=>$query,"use_dis_max"=>true];
			$params['body']['query']=['query_string'=>$query_string];
			$users=$this->searchManager->searchWithElastics($params,ModelConstants::$user, $index_users);
			if(!empty($users)){
				array_push($result,$users);
			}
		}
		$jsonarray=array();
		foreach($result as $res){
			if($this->configManager->isElasticSearchEnable()!=1){
				$jsondata=json_encode(array('refid'=>$res['refid'],'title'=>$res['title'],'type'=>$res['type'],'data'=>$res['data'],'url'=>$res['url'],'created_at'=>$res['created_at'],'updated_at'=>$res['updated_at']));
				array_push($jsonarray, $jsondata);
			}else{
				for($i=0;$i<count($res);$i++){
				  $jsondata=json_encode(array('refid'=>$res[$i]['id'],'title'=>$res[$i]['title'],'type'=>$res[$i]['type'],'data'=>'none','url'=>$res[$i]['url'],'created_at'=>$res[$i]['created_at'],'updated_at'=>$res[$i]['updated_at']));
				  array_push($jsonarray, $jsondata);
				}
			}
		} 
		$headers=array('Content-type'=> 'application/json; charset=utf-8');
		return \Response::json($jsonarray);//,200,$headers,JSON_UNESCAPED_UNICODE);
		}
	
	public function validateForm($params)
	{
	  	return $this->processForm();
	}

	
	

	public function jsonResponse($param, $error=false) {
	   $out;
	   if($error) {
			$out = array(
					'success' => false,
					'errors' => array(
							'reason' => $param
					)
			);
		}
	
		$out = json_encode($out);
	
		if ($print) {
			if ($header) header('Content-type: application/json');
	
			echo $out;
			return;
		}
	
		return $out;
	}
	

}
