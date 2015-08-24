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
use Illuminate\Database\Eloquent\Model;
use handlers\ElasticSearchHandler;
use handlers\DatabaseSearchHandler;
use commons\ModelConstants;
class Contents extends Eloquent{


	protected $table = 'contents';


	public $timestamps = true;



	protected $fillable = array('author_id','type_id','name','grooveldescription','content','url','ispublish','ontop','updated_at','created_at');
	
	
	
	private static function deserialize($dataDb){
		$data=unserialize(base64_decode($dataDb));
		return $data;
	}
	
	private static function extractContent($binContent){
		$content=Contents::deserialize($binContent);
		return $content;
	}

	public static function boot()
	{
		parent::boot();
	
		Contents::updating(function($content)
		{
			$contentType=\AllContentTypes::find($content['type_id']);
			$author=$contentType->author;
			
			$username=$author->username;
			$pseudo=$author->pseudo;
			$data=array('id'=>$content['id'],'title'=>$content['name'],'author'=>$username,
					'pseudo'=>$pseudo,'url'=>$content['url'],'grooveldescription'=>$content['grooveldescription'],'created_at'=>$content['created_at'],'updated_at'=>$content['updated_at']);
			\Queue::push('handlers\DatabaseSearchHandler@update', array('type'=>ModelConstants::$contents,'data'=>$data));
			\Queue::push('handlers\ElasticSearchHandler@update', array('type'=>ModelConstants::$contents,'data'=>$data));
		});
		
		Contents::saved(function($content)
		{
					
			$data=Contents::extractContent($content['content']);
			$contentType=\AllContentTypes::find($content['type_id']);
			$author=$contentType->author;
				
			$username=$author->username;
			$pseudo=$author->pseudo;
			$data=array('id'=>$content['id'],'title'=>$content['name'],'author'=>$username,
					'pseudo'=>$pseudo,'url'=>$content['url'],'grooveldescription'=>$content['grooveldescription'],'created_at'=>$content['created_at'],'updated_at'=>$content['updated_at']);
			\Queue::push('handlers\DatabaseSearchHandler@create', array('type'=>ModelConstants::$contents,'data'=>$data));
			\Queue::push('handlers\ElasticSearchHandler@create', array('type'=>ModelConstants::$contents,'data'=>$data));
					
			
		});
		
		Contents::deleting(function($content)
		{
			$data=Contents::extractContent($content['content']);
			$contentType=\AllContentTypes::find($content['type_id']);
			$author=$contentType->author;
			
			$username=$author->username;
			$pseudo=$author->pseudo;
			$data=array('id'=>$content['id'],'title'=>$content['name'],'author'=>$username,
					'pseudo'=>$pseudo,'url'=>$content['url'],'grooveldescription'=>$content['grooveldescription'],'created_at'=>$content['created_at'],'updated_at'=>$content['updated_at']);
			
			\Queue::push('handlers\DatabaseSearchHandler@delete', array('type'=>ModelConstants::$contents,'data'=>$data));
			\Queue::push('handlers\ElasticSearchHandler@delete', array('type'=>ModelConstants::$contents,'data'=>$data));
		});
	}
	
	public function type(){
		return $this->belongsTo('AllContentTypes');
	}

	 public function author()
    {
        return $this->belongsTo('User');
    }
    
    public function getId()
    {
    	return $this->attributes['id'];
    }
}