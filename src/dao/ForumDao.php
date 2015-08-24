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
namespace dao;


class ForumDao implements \ForumDaoInterface{

	public function paginateForums(){
		return \Forums::all();
	}
	public function createForum($name,$description){
		$forum=new \Forums();
		$forum->name=$name;
		$forum->description=$description;
		$forum->save();
	}
	
	public function getNumberSubjects($forumName){
		$Forum=\Forums::where('name','=',$forumName)->first();
		return \ForumQuestions::where('forum_id','=',$Forum->id)->count();
	}
	
	public function getNumberMessages($forumName){
		$forum=\Forums::where('name','=',$forumName)->first();
		$total=\ForumQuestions::where('forum_id','=',$forum->id)->count();+\ForumAnswers::where('forum_id','=',$forum->id)->count();
		return $total;
	}
	
	public function getLastMessage($forumName){
		$forum=\Forums::where('name','=',$forumName)->first();
		return \ForumAnswers::where('forum_id','=',$forum->id)->orderby('created_at', 'desc')->first();
	}
	
	public function getAllTopics($forumName){
		$forum=\Forums::where('name','=',$forumName)->first();
		return \ForumQuestions::where('forum_id','=',$forum->id)->get();
	}
	
	public function getAllAnswers($topicId,$forumId){
		return \ForumAnswers::where('forum_id','=',$forumId)->where('question_id','=',$topicId)->get();
	}
	
	public function getLastAnswer($topicId,$forumId){
		return \ForumAnswers::where('forum_id','=', $forumId)->where('question_id', $topicId)->orderby('created_at', 'desc')->first();
	}
	
	public function getNumberAnswers($topicId,$forumId){
		return \ForumAnswers::where('forum_id','=',$forumId)->where('question_id','=',$topicId)->count();
	}
	
	public function saveTopic($subject,$question,$forumid,$pseudo){
		$topic= new \ForumQuestions();
		$topic->forum_id=$forumid;
		$topic->question=$question;
		$topic->topic=$subject;
		$topic->pseudo=$pseudo;
		$topic->save();
	}
	
	public function findTopic($topicId){
		return \ForumQuestions::find($topicId);
	}

	public function saveAnswer($pseudo,$message,$forumid,$topic_id){
		$answer= new \ForumAnswers();
		$answer->forum_id=$forumid;
		$answer->question_id=$topic_id;
		$answer->pseudo=$pseudo;
		$answer->answer=$message;
		$answer->save();
	}
	
	
	public function deleteTopic($id){
		$topic= \ForumQuestions::find($id);
		if($topic!=null){
			$topic->delete();
		}
	}
	
	public function deleteForum($id){
		$forum=	\Forums::find($id);
		if($forum!=null){
			$forum->delete();
		}
	}
	public function deleteAnswer($id){
		$answer=\ForumAnswers::find($id);
		if($answer!=null){
			$answer->delete();
		}
	}
	
	public function findForum($forumid){
		return 	\Forums::find($forumid);
	}
	
	
	
	

}