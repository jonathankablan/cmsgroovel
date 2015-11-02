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


namespace Groovel\Cmsgroovel\Http\Controllers\groovel\admin\forum;
use Illuminate\Database\Eloquent\Model;
use Groovel\Cmsgroovel\Http\Controllers\groovel\admin\common\GroovelController;
use Monolog\Logger;
use Groovel\Cmsgroovel\Http\Controllers\groovel\admin\common\GroovelFormController;
use Groovel\Cmsgroovel\business\groovel\admin\forum\GroovelForumBusiness;
use Groovel\Cmsgroovel\business\groovel\admin\forum\GroovelForumBusinessInterface;
use Groovel\Cmsgroovel\business\groovel\admin\users\GroovelUserManagerBusiness;
use Groovel\Cmsgroovel\business\groovel\admin\users\GroovelUserManagerBusinessInterface;
use Groovel\Cmsgroovel\business\groovel\admin\configuration\GroovelConfigurationBusiness;
use Groovel\Cmsgroovel\business\groovel\admin\configuration\GroovelConfigurationBusinessInterface;


class GroovelForumController extends GroovelFormController {
	
	private $forumManager;
	
	private $config;
	
	private $userManager;
	
	public function __construct(GroovelForumBusinessInterface $forumManager,GroovelConfigurationBusinessInterface $config,GroovelUserManagerBusinessInterface $userManager)
	{
	
		$this->forumManager=$forumManager;
		$this->config=$config;
		$this->userManager=$userManager;
	}
	
	public function init($params){
	//	\Log::info(\Input::get('view'));
	//	\Log::info($params);
	$view=null;
	if(array_key_exists('view', \Input::all())){
		$view=\Input::get('view');
	}
	$allforums=array();
	$forums=$this->forumManager->paginateForums();
	foreach($forums as $forum){
		$forumName=$forum->name;
		$allforums[$forum->id]=array('forum_id'=>$forum->id,'forum_name'=>$forum->name,'forum_description'=>$forum->description,'subjects'=>$this->forumManager->getNumberSubjects($forumName),
				'messages'=>$this->forumManager->getNumberMessages($forumName),'lastMessage'=>$this->forumManager->getLastMessage($forumName));
	}
		if($view!=null){
			$params=$view;
		}
		return \View::make($params,['forums'=>$allforums]);
	}
	
	public function validateForm($params){
		if(\Request::is('admin/forum/form')){
			if(\Session::get('user_privileges')!=null){ 
				if(\Session::get('user_privileges')['role']=='ADMIN'){
					return \View::make('cmsgroovel.pages.forum.forum_form');
				}
			}
		}else if(\Request::is('forum/create')){
			parent::checkToken();
			if(!parent::checkPOSTStatus()){
				sleep(rand(2, 5)); // delay spammers a bit
				header("HTTP/1.0 403 Forbidden");
				exit;
			}
			
			if(\Session::get('user_privileges')!=null){
				if(\Session::get('user_privileges')['role']=='ADMIN'){
					$rules['name']='required|unique:forums,name';
					$rules['description']='required';
					$validation = \Validator::make(\Input::all(), $rules);
					if($validation->passes() && \Session::get('user_privileges')['role']=='ADMIN'){
						$this->forumManager->createForum(\Input::get('name'), \Input::get('description'));
						return $this->jsonResponse(array('Forum has been created'),false,true,false);
					}else{
						$validation->getMessageBag()->add('messages', 'Please check errors');
						$messages=$validation->messages();
						$formatMess=null;
						foreach ($messages->all() as $message)
						{
							$formatMess=$message.'- '.$formatMess;
						}
						return $this->jsonResponse($formatMess,false,true,true);
					}
				}
			}
		}else if(\Request::is('forum') && array_key_exists('forumName', \Input::all())){
			//\Log::info(\Input::all());
			$rules['id']='required|exists:forums';
			$rules['forumName']='required';
			$validation = \Validator::make(\Input::all(), $rules);
			if($validation->passes()){
				$forumId=\Input::get('id');
				//$topics=$this->forumManager-> getAllTopics(\Input::get('forumName'));
				$topics=$this->forumManager-> getAllTopics($forumId);
				$topicsAll=array();
				foreach($topics as $topic){
					$topicId=$topic->id;
					$numberAnswers=$this->forumManager->getNumberAnswers($topicId, $forumId);
					$lastAnswer=$this->forumManager->getLastAnswer($topicId, $forumId);
					//\Log::info($topicId.' '.$forumId);
					$topicsAll[$topic->id]=['topic_id'=>$topic->id,'topic'=>$topic->topic,'question'=>$topic->question,'number_answers'=>$numberAnswers,'lastanswer'=>$lastAnswer];
				}
				$view=$params;
				if(array_key_exists('view', \Input::all())){
					$view=\Input::get('view');
				}
				//\Log::info($view);
				//'groovelcms.pages.forum.forums'
				return  \View::make($view,['forumid'=>$forumId,'forumName'=>\input::get('forumName'),'topics'=>$topicsAll]);
			}else{
				$validation->getMessageBag()->add('messages', 'Please check errors');
				$messages=$validation->messages();
				$formatMess=null;
				foreach ($messages->all() as $message)
				{
					$formatMess=$message.'- '.$formatMess;
				}
				return $this->jsonResponse($formatMess,false,true,true);
			}
		}else if(\Request::is('forum/topic')&& array_key_exists('forumid', \Input::all())){
			//\Log::info(\Input::all());
			$rules['id']='required|exists:forum_question';
			$rules['forumid']='required';
			$validation = \Validator::make(\Input::all(), $rules);
			if($validation->passes()){
				$topicsAll=array();
				$topicId=\Input::get('id');
				$topic=$this->forumManager->findTopic($topicId);
				$forumId=\Input::get('forumid');
				$answers=$this->forumManager->getAllAnswers($topicId, $forumId);
				$i=0;
				foreach($answers as $answer){
					$answer_author=$this->userManager->getUserByPseudo($answer->pseudo);
					$answer['answer_author']=$answer_author;
					$answers[$i]=$answer;
					//array_merge(array($answer),array('answer_author'=>$answer_author));
					$i++;
				}
				$topic_author=$this->userManager->getUserByPseudo($topic->pseudo);
				//\Log::info($answers);
				$view=$params;
				if(array_key_exists('view', \Input::all())){
					$view=\Input::get('view');
				}
				return  \View::make($view,['forumid'=>$forumId,'topic_date'=>$topic->created_at,'topic_id'=>$topicId,'topic'=>$topic->topic,'question'=>$topic->question,'topic_author'=>$topic_author,'answers'=>$answers]);
			}else{
				$validation->getMessageBag()->add('messages', 'Please check errors');
				$messages=$validation->messages();
				$formatMess=null;
				foreach ($messages->all() as $message)
				{
					$formatMess=$message.'- '.$formatMess;
				}
				return $this->jsonResponse($formatMess,false,true,true);
			}
		}else if(\Request::is('forum/topic/post')){
			parent::checkToken();
			if(!parent::checkPOSTStatus()){
				sleep(rand(2, 5)); // delay spammers a bit
				header("HTTP/1.0 403 Forbidden");
				exit;
			}
			$rules['subject']='required';
			$rules['message']='required';
			$validation = \Validator::make(\Input::all(), $rules);
			if($validation->passes()){
				$this->forumManager->saveTopic(\Input::get('subject'),\Input::get('message'),\Input::get('forum_id'),\Auth::user()->pseudo);
				return $this->jsonResponse(array('topic has been submitted'),false,true,false);
			}else{
				$validation->getMessageBag()->add('messages', 'Please check errors');
				$messages=$validation->messages();
				$formatMess=null;
				foreach ($messages->all() as $message)
				{
					$formatMess=$message.'- '.$formatMess;
				}
				return $this->jsonResponse($formatMess,false,true,true);
			}
		}else if(\Request::is('forum/topic/reply/post')){
			parent::checkToken();
			if(!parent::checkPOSTStatus()){
				sleep(rand(2, 5)); // delay spammers a bit
				header("HTTP/1.0 403 Forbidden");
				exit;
			}
			$rules['message']='required';
			$validation = \Validator::make(\Input::all(), $rules);
			if($validation->passes()){
				$this->forumManager->saveAnswer(\Auth::user()->pseudo,\Input::get('message'),\Input::get('forum_id'),\Input::get('topic_id'));
				return $this->jsonResponse(array('answer has been submitted'),false,true,false);
			}else{
				$validation->getMessageBag()->add('messages', 'Please check errors');
				$messages=$validation->messages();
				$formatMess=null;
				foreach ($messages->all() as $message)
				{
					$formatMess=$message.'- '.$formatMess;
				}
				return $this->jsonResponse($formatMess,false,true,true);
			}
		}else if (\Request::is('forum/delete') && \Session::get('user_privileges')['role']=='ADMIN'){
			$input = \Input::get('q');
			$forum= $this->forumManager->findForum($input['id']);
			$count=$this->forumManager->getNumberMessages($forum->name);
			if($count>0){
				return $this->jsonResponse(array('can not delete forum there are some messages to delete before'),false,true,true);
			}
            $this->forumManager->deleteForum($input['id']);	
         	return $this->jsonResponse(array('done'),false,true,false);
        }else if (\Request::is('forum/topic/delete')&& \Session::get('user_privileges')['role']=='ADMIN'){
			$input = \Input::get('q');
			$topic= $this->forumManager->findTopic($input['id']);
			$count=$this->forumManager->getNumberAnswers($topic->id,$topic->forum_id);
			if($count>0){
				return $this->jsonResponse(array('can not delete topic there are some messages to delete before'),false,true,true);
			}
         	$this->forumManager->deleteTopic($input['id']);	
         	return $this->jsonResponse(array('done'),false,true,false);
         	
        }else if (\Request::is('forum/topic/answer/delete') &&\Session::get('user_privileges')['role']=='ADMIN'){
        	$input = \Input::all();
		    $this->forumManager->deleteAnswer($input['answerid']);	
		    $forumId=$input['forumid'];
		    $forum= $this->forumManager->findForum( $forumId);
		    $topics=$this->forumManager-> getAllTopics($forumId);
		    $topicsAll=array();
		    foreach($topics as $topic){
		    	$topicId=$topic->id;
		    	$numberAnswers=$this->forumManager->getNumberAnswers($topicId, $forumId);
		    	$lastAnswer=$this->forumManager->getLastAnswer($topicId, $forumId);
		    	//\Log::info($topicId.' '.$forumId);
		    	$topicsAll[$topic->id]=['topic_id'=>$topic->id,'topic'=>$topic->topic,'question'=>$topic->question,'number_answers'=>$numberAnswers,'lastanswer'=>$lastAnswer];
		    }
		    $view=$params;
		    if(array_key_exists('view', \Input::all())){
		    	$view=\Input::get('view');
		    }
		    return  \View::make($view,['forumid'=>$forumId,'forumName'=>\input::get('forumName'),'topics'=>$topicsAll]);
		    
	      
        }else {
        	return  \View::make('cmsgroovel.pages.pagenotauthorized');
        }
        
		return $this->processForm();
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