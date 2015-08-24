<?php namespace tests;
use Packagist\Api\Client;

require 'C:/HOMEWARE/logiciels/EasyPHP-DevServer-14.1VC11/data/localweb/projects/groovel/vendor/autoload.php';

class FooTest extends \PHPUnit_Framework_Testcase
{
	public function setup()
	{
		
	}

    public function testSomethingIsTrue()
    {
       // $this->assertTrue(true);

    $client = new \Packagist\Api\Client();
    	/*$packages = $client->all();
    	var_export($packages);*/
    	

    	$package = $client->get('sylius/sylius');
    	
    	printf(
    	'Package %s. %s.',
    	$package->getName(),
    	$package->getDescription()
    	);
    	
    	
    	 
    }

}