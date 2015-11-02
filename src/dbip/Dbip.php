<?php namespace Groovel\Cmsgroovel\dbip;

class DBIP_Exception extends \Exception {

}


class Dbip {

	const TYPE_COUNTRY = 1;
	const TYPE_CITY = 2;
	const TYPE_LOCATION = 3;
	const TYPE_ISP = 4;
	const TYPE_FULL = 5;

private $db;
	
	public function __construct(\PDO $db) {

		ini_set ('max_execution_time', 0);
		$this->db = $db;
		$this->db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

	}
	
	public function Import_From_CSV($filename, $type, $table_name = "dbip_lookup", $progress_callback = null) {
	
		switch ($type) {
	
			case self::TYPE_COUNTRY:
				$fields = array("ip_start", "ip_end", "country");
				break;
	
			case self::TYPE_CITY:
				$fields = array("ip_start", "ip_end", "country", "stateprov", "city");
				break;
	
			case self::TYPE_LOCATION:
				$fields = array("ip_start", "ip_end", "country", "stateprov", "city", "latitude", "longitude", "timezone_offset", "timezone_name");
				break;
	
			case self::TYPE_ISP:
				$fields = array("ip_start", "ip_end", "country", "isp_name", "connection_type", "organization_name");
				break;
	
			case self::TYPE_FULL:
				$fields = array("ip_start", "ip_end", "country", "stateprov", "city", "latitude", "longitude", "timezone_offset", "timezone_name", "isp_name", "connection_type", "organization_name");
				break;
	
			default:
				throw new DBIP_Exception("invalid database type");
	
		}
	
		if (!file_exists($filename)) {
			throw new DBIP_Exception("file {$filename} does not exists");
		}
	
		$q = $this->Prepare_Import($table_name, $fields);
		$f = @fopen($filename, "r");
	
		if (!is_resource($f)) {
			throw new DBIP_Exception("cannot open {$filename} for reading");
		}
	
		$nrecs = 0;
	
		while ($r = fgetcsv($f)) {
	
			foreach ($r as $k => $v) {
				switch ($fields[$k]) {
					case "connection_type":
						$r[$k] = $v ?: null;
						break;
					case "latitude":
					case "longitude":
					case "timezone_offset":
						$r[$k] = (float)$v;
						break;
					case "isp_name":
					case "organization_name":
						$r[$k] = substr($v, 0, 128);
						break;
					case "city":
					case "stateprov":
						$r[$k] = substr($v, 0, 80);
						break;
					case "timezone_name":
						$r[$k] = substr($v, 0, 64);
						break;
					default:
						$r[$k] = stripslashes($v);
				}
			}
			$r[] = self::Addr_Type($r[0]);
			$r[0] = inet_pton($r[0]);
			
			$r[1] = inet_pton($r[1]);
			$this->Import_Row($q, $r);
				
			if ((($nrecs % 100) === 0) && is_callable($progress_callback)) {
				call_user_func($progress_callback, $nrecs);
			}
				
			$nrecs++;
			/*if($nrecs>5){
				return;
			}*/
	
		}
	
		fclose($f);
		$this->Finalize_Import();
	
		return $nrecs;
	
	}

	protected function Prepare_Import($table_name, $fields) {

	try {

			if ($this->db->query("select count(*) as cnt from `{$table_name}`")->fetchObject()->cnt) {
				throw new DBIP_Exception("table {$table_name} is not empty");
			}
			
			$this->db->setAttribute(\PDO::ATTR_EMULATE_PREPARES, false);
			$this->db->beginTransaction();
			$q = $this->db->prepare("insert into `{$table_name}` (" . implode(",", $fields) . ",addr_type) values (" . implode(",", array_fill(0, count($fields), "?")) . ",?)");

			return $q;

		} catch (PDOException $e) {

			throw new DBIP_Exception("database error: {$e->getMessage()}");

		}
	
	}

	protected function Finalize_Import() {

		$this->db->commit();

	}

	protected function Import_Row($res, $row) {

		return $res->execute($row);
	
	}

	protected function Do_Lookup($table_name, $addr_type, $addr_start) {

		$q = mysql_query("select * from `{$table_name}` where addr_type = '{$addr_type}' and ip_start <= '" . mysql_real_escape_string($addr_start) . "' order by ip_start desc limit 1", $this->db);
		$r = mysql_fetch_object($q);
		mysql_free_result($q);

		return $r;
	
	}
	
	static private function Addr_Type($addr) {
	
		if (ip2long($addr) !== false) {
			return "ipv4";
		} else if (preg_match('/^[0-9a-fA-F:]+$/', $addr) && @inet_pton($addr)) {
			return "ipv6";
		} else {
			throw new DBIP_Exception("unknown address type for {$addr}");
		}
	
	}
}