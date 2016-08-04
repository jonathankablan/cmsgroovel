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


namespace Groovel\Cmsgroovel\Http\Controllers\groovel\admin\comments;
use Illuminate\Database\Eloquent\Model;
use Groovel\Cmsgroovel\Http\Controllers\groovel\admin\common\GroovelController;
use Monolog\Logger;
use Groovel\Cmsgroovel\Http\Controllers\groovel\admin\common\GroovelFormController;
use Groovel\Cmsgroovel\business\groovel\admin\comments\GroovelCommentBusinessInterface;
use Groovel\Cmsgroovel\business\groovel\admin\comments\GroovelCommentBusiness;

/**
 * Manage comments on post blogs
 */

class GroovelCommentController extends GroovelFormController {
	
	private $commentManager;
	
	
	public function __construct(GroovelCommentBusinessInterface $commentManager)
	{
		$this->commentManager=$commentManager;
	}
	
	
	public function validateForm($params){
		if(\Request::is('comment/post')){
			$user=\Auth::user();
			$id=$this->commentManager->save(\Input::get('comment'),$user,\Input::get('contenttranslationid'));
			return $this->jsonResponse(array('msg'=>'Comment has been posted','commentid'=>null),false,true,false);
			
		}else if(\Request::is('comment/delete')){
			$messages=$this->commentManager->delete(\Input::get('commentid'));
			return $this->jsonResponse(array('Comment has been deleted'),false,true,false);
		}
	}
	
	public function processForm(){}
	
	


	public function jsonResponse($param, $print = false, $header = true,$error=false) {
		if (is_array($param) && !$error) {
			$out = array(
					'success' => true
			);
	
			if (array_key_exists('datas',$param) && is_array($param['datas']) ) {
				$out['datas'] = $param['datas'];
				unset($param['datas']);
				$out = array_merge($out, $param);
			} else {
				$out['datas'] = $param;
			}
	
		}else if (is_bool($param) &&!$error) {
			$out = array(
					'success' => $param
			);
		} else if($error) {
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