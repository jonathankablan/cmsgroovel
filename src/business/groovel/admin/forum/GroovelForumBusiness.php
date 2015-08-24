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

namespace business\groovel\admin\forum;
use Illuminate\Database\Eloquent\Model;
use models;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Connection;
use business\groovel\admin\messages\GroovelUserMessageBusinessInterface;
use dao\ForumDaoInterface;
use dao\ForumDao;
use dao\UserDaoInterface;
use dao\UserDao;
use dao\ConfigurationDao;


class GroovelForumBusiness implements \GroovelForumBusinessInterface{
	
	private $forumDao;
	
	private $userDao;
	
	private $configDao;
	
	public function __construct(\ForumDaoInterface $forumDao,\UserDaoInterface $userDao,\ConfigurationDaoInterface $configDao)
	{
		$this->forumDao =$forumDao;
		$this->userDao =$userDao;
		$this->configDao=$configDao;
	}
    
	public function paginateForums(){
		return $this->forumDao->paginateForums();
	}
	
	public function createForum($name,$description){
		$this->forumDao->createForum($name,$description);
	}
	
	public function getNumberSubjects($name){
		return $this->forumDao->getNumberSubjects($name);
	}
	public function getNumberMessages($name){
		return $this->forumDao->getNumberMessages($name);
	}
	public function getLastMessage($name){
		return $this->forumDao->getLastMessage($name);
	}
	
	public function getAllAnswers($topicId,$forumId){
		return $this->forumDao->getAllAnswers($topicId,$forumId);
	}
	public function getLastAnswer($topicId,$forumId){
		return $this->forumDao->getLastAnswer($topicId,$forumId);
	}
	public function getNumberAnswers($topicId,$forumId){
		return $this->forumDao->getNumberAnswers($topicId,$forumId);
		
	}
	public function getAllTopics($forumName){
		return  $this->forumDao->getAllTopics($forumName);
	}
	
	public function saveTopic($topic,$question,$forumid,$pseudo){
		$this->forumDao->saveTopic($topic,$question,$forumid,$pseudo);
	}
	
	public function findTopic($topicId){
		return $this->forumDao->findTopic($topicId);
	}
	
	public function saveAnswer($pseudo,$message,$forumid,$topic_id){
		$this->forumDao->saveAnswer($pseudo,$message,$forumid,$topic_id);
	}
	
	public function deleteTopic($id){
		$this->forumDao->deleteTopic($id);
	}
	public function deleteForum($id){
		$this->forumDao->deleteForum($id);
	}
	public function deleteAnswer($id){
		$this->forumDao->deleteAnswer($id);
	}
	public function findForum($forumid){
		return 	$this->forumDao-> findForum($forumid);
	}
}