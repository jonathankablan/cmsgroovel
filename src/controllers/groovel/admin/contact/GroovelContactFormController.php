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


namespace controllers\groovel\admin\contact;
use Illuminate\Database\Eloquent\Model;
use controllers\groovel\admin\common\GroovelController;
use Monolog\Logger;
use controllers\groovel\admin\common\GroovelFormController;


class GroovelContactFormController extends GroovelFormController {
	
	private $messageManager;
	
	private $config;
	
	protected $userManager;
	
	public function __construct(\GroovelUserManagerBusinessInterface $userManager,\GroovelUserMessageBusinessInterface $messageManager,\GroovelConfigurationBusinessInterface $config)
	{
	
		$this->messageManager=$messageManager;
		$this->config=$config;
		$this->userManager=$userManager;
	}
	
	
	public function validateForm($params){
		parent::checkToken();
		if(!parent::checkPOSTStatus()){
			sleep(rand(2, 5)); // delay spammers a bit
			header("HTTP/1.0 403 Forbidden");
			exit;
		}
		
		if(\Request::is('contact/post')){
			$this->checkToken();
			$rules['username']='required';
			$rules['email']='required|email';
			$rules['message']='required';
			$rules['subject']='required';
			$validation = \Validator::make(\Input::all(), $rules);
		    if($validation->fails()){
				$validation->getMessageBag()->add('messages', 'Please check errors');
				$messages=$validation->messages();
				$formatMess=null;
				foreach ($messages->all() as $message)
				{
					$formatMess=$message.'- '.$formatMess;
				}
				return $this->jsonResponse($formatMess,false,true,true);
			}
			$adminusers=$this->userManager->getAllUsersAdmin();
			foreach ($adminusers as $admin){
				$this->messageManager->sendMessage(\Input::get('subject').' from '.\Input::get('email'), $admin, \Input::get('username'),\Input::get('message'));
			}
			
			return $this->jsonResponse(array('Message has been sent'),false,true,false);
		}else{
			
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