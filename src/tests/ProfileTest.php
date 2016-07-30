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

class ProfileTest extends TestCase
{
    	
    public function testExample()
    {
        $this->assertTrue(true);
    }
  
    
    public function testUpdateEmailProfile()
    {
    	/*to init the test with jwt**/
    	$user=User::where("username",'=','john')->first();
    	$token = JWTAuth::fromUser($user);
    	$request = Request::create('/api/updateEmailProfile', 'GET', ['token' => $token]);
    	JWTAuth::setRequest($request);
    	
    	$profile=$this->post('/api/updateEmailProfile?token='.$token.'&email='.'emailnew@com');
    	//dd($messages);
    	$this->assertNotEmpty($profile);
    }
    
    
    
    public function testResetPasswordProfile()
    {
    	/*to init the test with jwt**/
    	$user=User::where("username",'=','john')->first();
    	$token = JWTAuth::fromUser($user);
    	$request = Request::create('/api/resetPasswordProfile', 'GET', ['token' => $token]);
    	JWTAuth::setRequest($request);
    	 
    	$profile=$this->post('/api/resetPasswordProfile?token='.$token.'&password='.'passwordnew');
    	//dd($messages);
    	$this->assertNotEmpty($profile);
    }
    
    
    public function testGetProfile()
    {
    	/*to init the test with jwt**/
    	$user=User::where("username",'=','john')->first();
    	$token = JWTAuth::fromUser($user);
       	$request = Request::create('/api/getProfile', 'GET', ['token' => $token]);
    	JWTAuth::setRequest($request);
    	
    	$profile=$this->get('/api/getProfile?token='.$token);
    	//dd($messages);
    	$this->assertNotEmpty($profile);
    }
    
   
}
