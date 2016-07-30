<?php
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use JWTAuth;
use App\Http\Requests;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Groovel\Cmsgroovel\models\User;
use Groovel\Cmsgroovel\log\LogConsole;
use GuzzleHttp\json_decode;
use Groovel\Cmsgroovel\models\Messages;

class ContentTest extends TestCase
{
    	
    public function testExample()
    {
        $this->assertTrue(true);
    }
  
    
  
    public function testGetContents()
    {
     	$messages=$this->get('/api/getContents'.'?lang='.'FR');
    	dd($messages);
    	$this->assertNotEmpty($messages);
    }
    
    
}
