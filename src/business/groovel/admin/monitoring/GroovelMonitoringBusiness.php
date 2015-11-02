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

namespace Groovel\Cmsgroovel\business\groovel\admin\monitoring;
use Illuminate\Database\Eloquent\Model;
use models;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Connection;
use Monolog\Logger;
use Groovel\Cmsgroovel\business\groovel\admin\monitoring\GroovelMonitoringBusinessInterface;
use Groovel\Cmsgroovel\Elasticsearch\Client;
use Groovel\Cmsgroovel\config\ElasticSearchConnection;
use Elasticsearch\ClientBuilder;

class GroovelMonitoringBusiness implements GroovelMonitoringBusinessInterface{

	private $elasticsearch;
	
	public function __construct(ElasticSearchConnection $params)
	{
	
		//\Log::info(parse_url('http://localhost:9200'));
		$this->elasticsearch = ClientBuilder::create()->setHosts([$params->getConnection()])->build();
		//new Client($params->getConnection());
	}
	
	public function getElasticSearchStatus(){
		$status=false;
		try{
			//	$this->elasticsearch->ping();
			$results = $this->elasticsearch->cluster()->health();
		//	\Log::info($results);
			if(empty($results)){
				$status=false;
			}else if($results['status']=='green'||$results['status']=='yellow'){
				$status=true;
			}else if($results['status']=='red'){
				throw new \Elasticsearch\Common\Exceptions\ElasticsearchException;
			}
		}catch(\Elasticsearch\Common\Exceptions\ElasticsearchException $ex){
			$status=false;
		}
		
		return $status;
	}
	
	
	
	public function getElasticSearchPendingTasks(){
		return $this->elasticsearch->cluster()->pendingTasks();
	}	

	public function getElasticSearchStats(){
		return $this->elasticsearch->cluster()->stats();
	}
	
	public function getElasticSearchIndex(){
		return $this->elasticsearch->indices();
	}
	
	public function readLogFile(){
		$logpath=log_path();
		$data = file($logpath.'/'."laravel.log");
		$lines = implode("\r\n",array_slice($data,count($data)-101,100));
		//\Log::info($lines);
	}
	
	
}