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

namespace config;
class ElasticSearchConnection implements GroovelConnectionInterface{
	
	private $connections=array();
	 
	public function __construct(){
		$connections['hosts'] = array (
				'localhost:9200',                 // IP + Port
				/*'192.168.1.2',                      // Just IP
				 'mydomain.server.com:9201',         // Domain + Port
		'mydomain2.server.com',             // Just Domain
		'https://localhost',                // SSL to localhost
		'https://192.168.1.3:9200',         // SSL to IP + Port
		'http://user:pass@localhost:9200',  // HTTP Basic Auth
		'https://user:pass@localhost:9200',  // SSL + HTTP Basic Auth*/
		);
	
		//return $connections;
	}
	
	public function getConnection(){
		return $this->connections;
	}
}