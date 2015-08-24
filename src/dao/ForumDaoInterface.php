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
interface ForumDaoInterface{
	public function paginateForums();
	public function createForum($name,$description);
	public function getNumberSubjects($forumName);
	public function getNumberMessages($forumName);
	public function getLastMessage($forumName);
	public function getAllAnswers($topicId,$forumId);
	public function getLastAnswer($topicId,$forumId);
	public function getNumberAnswers($topicId,$forumId);
	public function saveTopic($topic,$question,$forumid,$pseudo);
	public function findTopic($topicId);
	public function saveAnswer($pseudo,$message,$forumid,$topic_id);
	public function deleteTopic($id);
	public function deleteForum($id);
	public function deleteAnswer($id);
	public function findForum($forumid);
	
}