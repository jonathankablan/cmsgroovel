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
use Elasticsearch\Client;
use config\ElasticSearchConnection;
use Guzzle\Common\Exception\ExceptionCollection;
use Elasticsearch\Common\Exceptions\Curl\CouldNotConnectToHost;
use Elasticsearch\Common\Exceptions\ElasticsearchException;

class ElasticSearchDao implements \ElasticSearchDaoInterface{

	private $elasticsearch;
	
	public function __construct(\config\ElasticSearchConnection $params)
	{
		$this->elasticsearch = new Client($params->getConnection());
	}
	
	/**
	 * @param string $query = ""
	 * @return Collection
	 */
	public function search($query = "",$type="",$index="")
	{
		$items = $this->searchOnElasticsearch($query,$type,$index);
	
		return $this->buildCollection($items);
	}
	

	/**
	 * @param string $query
	 * @result array
	 */
	private function searchOnElasticsearch($params,$type,$index)
	{
		
		$params['index'] = $index;
		$params['type']  = $type;
		$items = $this->elasticsearch->search($params);
		return $items;
	}
	
	
	private function buildCollection($items)
	{
		$tot=array();
		if($items['hits']['total']>0){
			for($i=0;$i<$items['hits']['total'];$i++){
			    array_push($tot,array_merge(array('type'=>$items['hits']['hits'][$i]['_type']),$items['hits']['hits'][$i]['_source']));
			}
		}
		return $tot;
	}
	
}