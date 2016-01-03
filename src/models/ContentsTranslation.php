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
namespace Groovel\Cmsgroovel\models;
use Illuminate\Database\Eloquent\Model;
use  Groovel\Cmsgroovel\handlers\ElasticSearchHandler;
use  Groovel\Cmsgroovel\handlers\DatabaseSearchHandler;
use  Groovel\Cmsgroovel\commons\ModelConstants;
use  Groovel\Cmsgroovel\models\Contents;

class ContentsTranslation extends Model{


	protected $table = 'contents_translation';


	public $timestamps = true;



	protected $fillable = array('refcontentid','name','content','tag','lang','updated_at','created_at');
	
		
	private static function deserialize($dataDb){
		$data=unserialize(base64_decode($dataDb));
		return $data;
	}
	
	private static function extractContent($binContent){
		$content=ContentsTranslation::deserialize($binContent);
		return $content;
	}

	public static function boot()
	{
		parent::boot();
	
		static::updated(function($contentTranslation)
		{
			$content=Contents::find($contentTranslation['refcontentid']);
			$contentType=AllContentTypes::find($content['type_id']);
			$author=$contentType->author;
			
			$username=$author->username;
			$pseudo=$author->pseudo;
			$data=array('id'=>$content['id'],'title'=>$contentTranslation['name'],'langage'=>$contentTranslation['lang'],'author'=>$username,
					'pseudo'=>$pseudo,'url'=>$content['url'],'tag'=>$contentTranslation['tag'],'created_at'=>$contentTranslation['created_at'],'updated_at'=>$contentTranslation['updated_at']);
			\Queue::push('Groovel\Cmsgroovel\handlers\DatabaseSearchHandler@update', array('type'=>ModelConstants::$contents,'data'=>$data));
			\Queue::push('Groovel\Cmsgroovel\handlers\ElasticSearchHandler@update', array('type'=>ModelConstants::$contents,'data'=>$data));
		});
		
		static::saved(function($contentTranslation)
		{
			//\Log::info($contentTranslation);		
			$data=ContentsTranslation::extractContent($contentTranslation['content']);
			$content=Contents::find($contentTranslation['refcontentid']);
			$contentType=AllContentTypes::find($content['type_id']);
			$author=$contentType->author;
				
			$username=$author->username;
			$pseudo=$author->pseudo;
			$data=array('id'=>$content['id'],'title'=>$contentTranslation['name'],'langage'=>$contentTranslation['lang'],'author'=>$username,
					'pseudo'=>$pseudo,'url'=>$content['url'],'tag'=>$contentTranslation['tag'],'created_at'=>$contentTranslation['created_at'],'updated_at'=>$contentTranslation['updated_at']);
			//\Log::info($data);
			\Queue::push('Groovel\Cmsgroovel\handlers\DatabaseSearchHandler@create', array('type'=>ModelConstants::$contents,'data'=>$data));
			\Queue::push('Groovel\Cmsgroovel\handlers\ElasticSearchHandler@create', array('type'=>ModelConstants::$contents,'data'=>$data));
					
			
		});
		
		ContentsTranslation::deleting(function($contentTranslation)
		{
			$data=ContentsTranslation::extractContent($contentTranslation['content']);
			$content=Contents::find($contentTranslation['refcontentid']);
			$contentType=AllContentTypes::find($content['type_id']);
			$author=$contentType->author;
			
			$username=$author->username;
			$pseudo=$author->pseudo;
			$data=array('id'=>$content['id'],'title'=>$content['name'],'author'=>$username,
					'pseudo'=>$pseudo,'url'=>$content['url'],'tag'=>$content['tag'],'created_at'=>$content['created_at'],'updated_at'=>$content['updated_at']);
			
			\Queue::push('Groovel\Cmsgroovel\handlers\DatabaseSearchHandler@delete', array('type'=>ModelConstants::$contents,'data'=>$data));
			\Queue::push('Groovel\Cmsgroovel\handlers\ElasticSearchHandler@delete', array('type'=>ModelConstants::$contents,'data'=>$data));
		});
	}
	
	
	public function content(){
		return $this->belongsTo('Groovel\Cmsgroovel\models\Contents','refcontentid');
	}
	
	public function type(){
		return $this->belongsTo('Groovel\Cmsgroovel\models\AllContentTypes');
	}

	 public function author()
    {
        return $this->belongsTo('Groovel\Cmsgroovel\models\User');
    }
    
    public function getId()
    {
    	return $this->attributes['id'];
    }
}