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


namespace Groovel\Cmsgroovel\Http\Controllers\groovel\admin\messages;
use Illuminate\Database\Eloquent\Model;
use Groovel\Cmsgroovel\Http\Controllers\groovel\admin\common\GroovelController;
use Monolog\Logger;
use Groovel\Cmsgroovel\Http\Controllers\groovel\admin\common\GroovelFormController;
use Groovel\Cmsgroovel\business\groovel\admin\messages\GroovelUserMessageBusinessInterface;
use Groovel\Cmsgroovel\business\groovel\admin\messages\GroovelUserMessageBusiness;
use Groovel\Cmsgroovel\business\groovel\admin\configuration\GroovelConfigurationBusiness;
use Groovel\Cmsgroovel\business\groovel\admin\configuration\GroovelConfigurationBusinessInterface;

class GroovelMessageController extends GroovelFormController {
	
	private $messageManager;
	
	private $config;
	
	public function __construct(GroovelUserMessageBusinessInterface $messageManager,GroovelConfigurationBusinessInterface $config)
	{
	
		$this->messageManager=$messageManager;
		$this->config=$config;
	}
	
	
	public function validateForm($params){
		if(\Request::is('messages/compose')){
			return \View::make('cmsgroovel.pages.email.compose_messages');
		}else if(\Request::is('messages/list')){
			$messages=$this->messageManager->getMessagesReceivedByUserPseudo(\Auth::user()['pseudo']);
			return \View::make('cmsgroovel.pages.email.list_messages',['messages'=>$messages]);
		}else if(\Request::is('messages/send')){
			$this->checkToken();
			$rules['recipient']='required';
			$rules['subject']='required';
			$validation = \Validator::make(\Input::all(), $rules);
			if($validation->passes()){
				if(!$this->messageManager->isUserExist(\Input::get('recipient'))){
					$validation->getMessageBag()->add('messages', 'Please check errors');
					$validation->getMessageBag()->add('user', 'user does not exist');
					$messages=$validation->messages();
					$formatMess=null;
					foreach ($messages->all() as $message)
					{
						$formatMess=$message.'- '.$formatMess;
					}
					return $this->jsonResponse($formatMess,false,true,true);
				}
			}else if($validation->fails()){
				$validation->getMessageBag()->add('messages', 'Please check errors');
				$messages=$validation->messages();
				$formatMess=null;
				foreach ($messages->all() as $message)
				{
					$formatMess=$message.'- '.$formatMess;
				}
				return $this->jsonResponse($formatMess,false,true,true);
			}
			$this->messageManager->sendMessage(\Input::get('subject'), \Input::get('recipient'), \Auth::user()['pseudo'],\Input::get('body'));
			return $this->jsonResponse(array('Message has been sent'),false,true,false);
		}else if(\Request::is('messages/edit')){
			$uri=array();
			$uri['uri']= url('messages/read', $parameters = array(), $secure = null);
			$message=$this->messageManager->getMessage(\Input::get('q')['id']);
			\Session::flash('message',$message);
			return $this->jsonResponse($uri);
		}else if(\Request::is('messages/delete')){
			$this->messageManager->deleteMessage(\Input::get('q')['id']);
			return $this->jsonResponse(array('Message has been deleted'),false,true,false);
		}else if(\Request::is('messages/reply')){
			$uri=array();
			$uri['uri']= url('messages/compose', $parameters = array(), $secure = null);
			\Session::flash('reply_user',\Input::get('author'));
			\Session::flash('reply_subject',\Input::get('subject'));
			return $this->jsonResponse($uri);
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