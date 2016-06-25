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

namespace Groovel\Cmsgroovel\business\groovel\admin\messages;
use Illuminate\Database\Eloquent\Model;
use models;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Connection;
use Groovel\Cmsgroovel\business\groovel\admin\messages\GroovelUserMessageBusinessInterface;
use Groovel\Cmsgroovel\dao\MessageDaoInterface;
use Groovel\Cmsgroovel\dao\MessageDao;
use Groovel\Cmsgroovel\dao\UserDaoInterface;
use Groovel\Cmsgroovel\dao\UserDao;
use Groovel\Cmsgroovel\dao\ConfigurationDao;
use Groovel\Cmsgroovel\dao\ConfigurationDaoInterface;


class GroovelUserMessageBusiness implements GroovelUserMessageBusinessInterface{
	
	private $messageDao;
	
	private $userDao;
	
	private $configDao;
	
	public function __construct(MessageDaoInterface $messageDao,UserDaoInterface $userDao,ConfigurationDaoInterface $configDao)
	{
		$this->messageDao =$messageDao;
		$this->userDao =$userDao;
		$this->configDao=$configDao;
	}
    
	public function getMessagesReceivedByUserPseudo($pseudo){
		return $this->messageDao->getMessagesReceivedByUserPseudo($pseudo);
	}
	
	public function getMessagesSentByUserPseudo($pseudo){
		return $this->messageDao->getMessagesSentByUserPseudo($pseudo);
	}
 	
	public function sendMessage($subject,$recipient,$author,$body){
		$this->messageDao->saveMessage($subject,$recipient,$author,$body);
		$auth=\Auth::user();
		if(!empty($auth)){
			if(\Auth::user()->notification_email_enable==1){
				if($this->configDao->isEmailEnable()==0){
					// don t send message
				}else{
					$dest=$this->userDao->getUserByPseudo($recipient);
					\Mail::send('cmsgroovel.pages.email.email', array('pseudo'=>$dest->pseudo,'body'=>$body,'author'=>$author), function($message) use ($dest,$subject){
						$message->to($dest->email, $dest->username)->subject($subject);
					});
				}
			}
		}else{
			if($this->configDao->isEmailEnable()==0){
				//don t send message
				
			}else{
				$dest=$this->userDao->getUserByPseudo($recipient);
				\Mail::send('cmsgroovel.pages.email.email', array('pseudo'=>$dest->pseudo,'body'=>$body,'author'=>$author), function($message) use ($dest,$subject) {
					$message->to($dest->email, $dest->username)->subject($subject);
				});
			}
				
		}
	}
	
	public function deleteMessage($id){
		$this->messageDao->deleteMessage($id);
	}
	
	public function isUserExist($pseudo){
		$user=$this->userDao->getUserByPseudo($pseudo);
		if($user==null){
			return false;
		}else return true;
	}
	
	public function getMessage($id){
		return $this->messageDao->getMessage($id);
	}
	
	public function changeStatusMessage($status,$id){
		$this->messageDao->changeStatusMessage($status,$id);
	}
	
	public function countNewMessage($pseudo){
		return $this->messageDao->countNewMessage($pseudo);
	}
}