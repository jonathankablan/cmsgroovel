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

namespace Groovel\Cmsgroovel\business\groovel\admin\comments;
use Illuminate\Database\Eloquent\Model;
use models;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Connection;
use Groovel\Cmsgroovel\business\groovel\admin\comments\GroovelCommentBusinessInterface;
use Groovel\Cmsgroovel\dao\CommentsDaoInterface;
use Groovel\Cmsgroovel\dao\CommentsDao;


class GroovelCommentBusiness implements GroovelCommentBusinessInterface{
	
	private $commentDao;
	
		
	public function __construct(CommentsDaoInterface $commentDao)
	{
		$this->commentDao =$commentDao;
	}
    
	public function find($contenttransid){}
	
	public function save($comment,$user,$contenttransid){
		$this->commentDao->save($comment,$user,$contenttransid);
	}
	public function delete($id){}
}