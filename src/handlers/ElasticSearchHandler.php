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
namespace handlers;
use commons\ModelConstants;
use Elasticsearch\Client;
use config\ElasticSearchConnection;
use Guzzle\Common\Exception\ExceptionCollection;
use Elasticsearch\Common\Exceptions\Curl\CouldNotConnectToHost;
use Elasticsearch\Common\Exceptions\ElasticsearchException;
use business\groovel\admin\monitoring\GroovelMonitoringBusiness;
use business\groovel\admin\monitoring\GroovelMonitoringBusinessInterface;

class ElasticSearchHandler
{
	private $elasticsearch;
	
	private $monitor;
	
	private $config;
	
	public function __construct(\config\ElasticSearchConnection $params,\GroovelMonitoringBusinessInterface $monitor,\GroovelConfigurationBusinessInterface $config)
	{
		
		$this->elasticsearch = new Client($params->getConnection());
		$this->monitor=$monitor;
		$this->config=$config;
	}
	
	
	
	
	public function create($job, $data)
	{  
		if($this->config->isElasticSearchEnable()=='1'){
			$status=$this->monitor->getElasticSearchStatus();
			if($status){
					$index=null;
					if(ModelConstants::$contents==$data['type']){
						$index='contents';
					}else if(ModelConstants::$user==$data['type']){
						$index='users';
					}
					try{
					$this->elasticsearch->index([
							'index' => $index,
							'type' => $data['type'],
							'id' => $data['data']['id'],
							'body' => $data['data']
					]);}catch(\Elasticsearch\Common\Exceptions\Missing404Exception $e){
						\Log::info($e);
					}
			}
		}
	}
	
	public function update($job, $data)
	{
		$index=null;
		if(ModelConstants::$contents==$data['type']){
			$index='contents';
		}else if(ModelConstants::$user==$data['type']){
			$index='users';
		}
		if($this->config->isElasticSearchEnable()=='1'){
			try{
				$this->elasticsearch->index([
					'index' => $index,
					'type' => $data['type'],
					'id' => $data['data']['id'],
					'body' => $data['data']
			]);
			}catch(\Elasticsearch\Common\Exceptions\Missing404Exception $e){
				\Log::info($e);
			}catch(\Elasticsearch\Common\Exceptions\Curl\CouldNotConnectToHost $c){
				\Log::info($c);
			}
		}
	}
	
	
	public function delete($job, $data)
	{
		$index=null;
		if(ModelConstants::$contents==$data['type']){
			$index='contents';
		}else if(ModelConstants::$user==$data['type']){
			$index='users';
		}
		
		if($this->config->isElasticSearchEnable()=='1'){
			try{
				$this->elasticsearch->delete([
						'index' =>  $index,
						'type' =>$data['type'],
						'id' => $data['data']['id']
				]);
			}catch(\Elasticsearch\Common\Exceptions\Missing404Exception $e){
				\Log::info($e);
			}
		}
	}
	
	
	
	
	
	
}