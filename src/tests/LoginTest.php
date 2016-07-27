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

class LoginTest extends TestCase
{
    	
    public function testExample()
    {
        $this->assertTrue(true);
    }
    
    public function testAuthenticate()
    {
       $this->post('/api/authenticate', ['username' => 'john', 'password' =>  'john'])->seeJsonStructure(['token']);
    	
    }
    
    public function testSignUp()
    {
   		$usr=User::where('username','=','johntest')->first();
   		if($usr!=null){
   			$usr->delete();
   		}
    	$this->post('/api/auth/signup',['username' => 'johntest','email'=>'emailme@com', 'password' =>  'johntest'])->seeJsonContains(['msg'=>'account created!']);
     	 
    }
    
   
    
    
}
