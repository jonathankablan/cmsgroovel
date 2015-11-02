<?php namespace Groovel\Cmsgroovel\dbip;
use Groovel\Cmsgroovel\dbip\DBIP_Exception;

class DbLocateCities{
	
	private $db;
	
	public function __construct(\PDO $db) {
	
		ini_set ('max_execution_time', 0);
		$this->db = $db;
		$this->db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
	
	}
	

	/*
	public function Import_From_CSV($filename,$table_name = "location_cities", $progress_callback = null) {
		if (!file_exists($filename)) {
			throw new DBIP_Exception("file {$filename} does not exists");
		}
		
		//$q = $this->Prepare_Import($table_name, $fields);
		$f = @fopen($filename, "r");
		
		if (!is_resource($f)) {
			throw new DBIP_Exception("cannot open {$filename} for reading");
		}
		
		$nrecs = 0;
		
		while ($r = fgetcsv($f)) {
			$import=array();
			//$r = array_map("utf8_encode", $r); //added
			//echo $r;
			if($nrecs>0){
				foreach ($r as $k => $v) {
					switch ($k) {
						case 0://country
							$import['country'] = $v ?: null;
							break;
						
						case 4://langue
								$import['language'] = $v ?: null;
								break;
						case 5://city
							$city=null;
							if($v!=null){
								$city=explode(',',$v);
							}
							if(count($city)>1){
								
							$import['city'] = str_replace( array( '\''), ' ',$city[1]);
							}else{
								$import['city'] =null;
							}
							break;
						case 6: //"latitude":
							$import['latitude'] = $v ?: null;
							break;
						case 7://"longitude":
							$import['longitude'] = $v ?: null;
						    break;
						
						default:
							break;
					}
					
				} 
			
				$this->db->beginTransaction();
				$this->db->setAttribute(\PDO::ATTR_EMULATE_PREPARES, false);
				\Log::info("insert into" .' '.$table_name.' '. "(country, city,language ,latitude, longitude) VALUES ". "(".$import['country'].",".$import['city'].",".$import['language'].",".$import['latitude'].",".$import['longitude'].")");
				$q = $this->db->prepare("insert into" .' '.$table_name.' '. "(country, city,language,latitude, longitude) VALUES ". "(".'\''.$import['country'].'\''.",".'\''.$import['city'].'\''.",".'\''.$import['language'].'\''.",".'\''.$import['latitude'].'\''.",".'\''.$import['longitude'].'\''.")");
				
				$this->Import_Row($q);
					
			}
			
			$nrecs++;
		}
		
		fclose($f);
		$this->Finalize_Import();
		
		return $nrecs;
	
	}
	*/
	
	protected function Finalize_Import() {
	
		$this->db->commit();
	
	}
	
	
	protected function Import_Row($row) {
	
		return $row->execute();
	
	}
	
	
	public function Import_From_CSV($filename,$table_name = "location_cities_world", $progress_callback = null) {
		if (!file_exists($filename)) {
			throw new DBIP_Exception("file {$filename} does not exists");
		}
		$f = @fopen($filename, "r");
	
		if (!is_resource($f)) {
			throw new DBIP_Exception("cannot open {$filename} for reading");
		}
		$nrecs = 0;
		$this->db->beginTransaction();
		$this->db->setAttribute(\PDO::ATTR_EMULATE_PREPARES, false);
		
		while ($r = fgetcsv($f)) {
			$r=explode(';',$r[0]);
			\Log::info($r);
			$import=array();
			$import['country'] = $r[1];
			$import['city'] = str_replace( array( '\''), ' ',$r[2]);
			$import['latitude'] = $r[3];
			$import['longitude'] = $r[4];
			
		//	\Log::info($import);
		//	\Log::info("insert into" .' '.$table_name.' '. "(country, city,latitude, longitude) VALUES ". "(".'\''.$import['country'].'\''.",".'\''.$import['city'].'\''.",".'\''.$import['latitude'].'\''.",".'\''.$import['longitude'].'\''.")");
			$q = $this->db->prepare("insert into" .' '.$table_name.' '. "(country, city,latitude, longitude) VALUES ". "(".'\''.$import['country'].'\''.",".'\''.$import['city'].'\''.",".'\''.$import['latitude'].'\''.",".'\''.$import['longitude'].'\''.")");
			$this->Import_Row($q);
			$nrecs++;
		}
		fclose($f);
		$this->Finalize_Import();
		return $nrecs;
	
	}
}