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
use Groovel\Cmsgroovel\models\Messages;

class MessageDao implements MessageDaoInterface{

	
	public function getMessagesSentByUserPseudo($pseudo){
		return Messages::where('author','=',$pseudo)->paginate(15);
	}
	
	public function getMessagesReceivedByUserPseudo($pseudo){
		return Messages::where('recipient','=',$pseudo)->paginate(15);
	}
	
	public function getMessage($id){
		return Messages::find($id);
	}
	
	public function saveMessage($subject,$recipient,$author,$body){
		$message=new Messages();
		$message->subject=$subject;
		$message->recipient=$recipient;
		$message->author=$author;
		$message->body=$body;
		//$message->sent='1';
		$message->save();
	}
	
	public function deleteMessage($id){
		Messages::find($id)->delete();
	}
	
	public function getTotalMessage(){
		return \DB::table('messages')->count();
	}
	

}