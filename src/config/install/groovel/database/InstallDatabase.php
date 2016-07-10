<?php

namespace Groovel\Cmsgroovel\config\install\groovel\database;

use Log;
use Illuminate\Http\Request;
use Composer\Composer\Console\Application;
use Composer\Composer\Command\UpdateCommand;
use Symfony\Component\Console\Input\ArrayInput;
use App\Http\Controllers\Controller;
use Cache;
use DB;
use Artisan;


class InstallDatabase
{
    private static $LARAVEL_VERSION="5.2.31";
    private static $logs_line=0;
    private static $status_install="started";
    private static $sqlfile="groovel.sql";
	private static $base_path_config_install=null;
    

	public function installDB(){
		$dbUsername = env('DB_USERNAME');
		
		$dbName = env('DB_DATABASE');
		
		$dbPassword = env('DB_PASSWORD');
		
		$dbPort = env('DB_PORT');
		
		$dbHost = env('DB_HOST');
		\Log::info($dbUsername.' '.$dbPassword.' '.$dbName.' '.$dbHost.' '.$dbPort);
		
		if($this->testConnection($dbHost,$dbPort,$dbUsername,$dbPassword)){
			if($this->testDatabaseExist($dbHost,$dbPort,$dbUsername,$dbPassword,$dbName)!=1){
			    $this->createDatabase($dbHost,$dbPort,$dbUsername,$dbPassword,$dbName);
				$this->loadSqlFile($dbHost,$dbPort,$dbUsername,$dbPassword,$dbName);
				$this->createAccount("john","john","john@emailme.com","john",$dbHost,$dbPort,$dbUsername,$dbPassword,$dbName);
			}
		}
		
	}
	
	
	
	private function createAccount($username,$pseudo,$email,$password,$dbHost,$dbPort,$dbUsername,$dbPassword,$dbName){
		try {
			Log::info("create account");
			$cnx =new \PDO("mysql:host=".$dbHost.";port=".$dbPort.";dbname=".$dbName,$dbUsername,$dbPassword);
			$sql='INSERT INTO USERS(pseudo,username,email,password,activate) values('.'\''.$pseudo.'\''.','.'\''.$username.'\''.','.'\''.$email.'\''.','.'\''. \Hash::make($password).'\''.','.'1'.')';
	    	$res=$cnx->exec($sql);
		    $sql='select * from USERS WHERE PSEUDO ='.'\''.$pseudo.'\'';
			$resultats=$cnx->query($sql);
			$resultats->setFetchMode(\PDO::FETCH_OBJ);
			$userid=null;
			while( $resultat = $resultats->fetch() )
			{    
			        Log::info ('Utilisateur : '.$resultat->id);
			        $userid=$resultat->id;
			}
			$resultats->closeCursor();
			
			$sql='select count(*) from USER_ROLES WHERE userid ='.'\''.$userid.'\'';
			$resultats=$cnx->query($sql)->fetchColumn();
			if($resultats==0){
			//add admin role
				$sql='INSERT INTO USER_ROLES(userid,roleid) values('.'\''.$userid.'\''.','.'1'.')';
				$res=$cnx->exec($sql);
			}
		}catch (\PDOException $dbex) {
			Log::error("Erreur de connexion : " . $dbex->getMessage() );
		}
	}
	
	
	private function loadSqlFile($host,$port,$username,$password,$databasename){
		
		try {
			Log::info("load sql");
			$cnx =new \PDO("mysql:host=".$host.";port=".$port.";dbname=".$databasename,$username, $password);
			$sql = file_get_contents(base_path().'/vendor/groovel/cmsgroovel/sql/' .self::$sqlfile);
			$res=$cnx->exec($sql);
			Log::info($res);
		}
		catch (PDOException $dbex) {
			Log::error("Erreur de connexion : " . $dbex->getMessage() );
		}
			
	}
	
	
	
	private function createDatabase($host,$port,$username,$password,$db){
		try {
			$dbh = new \PDO("mysql:host=".$host.";port=".$port,$username, $password);
			$dbh->exec("CREATE DATABASE IF NOT EXISTS `$db`;
					DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
					GRANT ALL ON `$db`.* TO '. $username.'@'.$host;
					FLUSH PRIVILEGES;")
					or die(print_r($dbh->errorInfo(), true));
			Log::info("create database success!");
		} catch (PDOException $e) {
			Log::error($e->getMessage());
			die("DB ERROR: ". $e->getMessage());
		}
	}
	
	private function testDatabaseExist($host,$port,$username,$password,$databasename){
	try {
			$dbh = new \PDO("mysql:host=".$host.";port=".$port."dbname=".$databasename,$username, $password);
			//$result = $dbh->query("SELECT version()");
			$stmt=$dbh->prepare("SELECT COUNT(*) FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = ?");
			$stmt->execute(array($databasename));
			$res=$stmt->fetchColumn();
			return $res;
		} catch(\Exception $e){
			Log::error($e->getMessage());
			return false;
		}
	}
	
	private function testConnection($host,$port,$username,$password){
		try {
			$dbh = new \PDO("mysql:host=".$host.";port=".$port,$username, $password);
			return true;
		} catch(\Exception $e){
			Log::error($e->getMessage());
			return false;
		}
	}
	
	
	
	
	
}
