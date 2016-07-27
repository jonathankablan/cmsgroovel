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

class MessageTest extends TestCase
{
    	
    public function testExample()
    {
        $this->assertTrue(true);
    }
  
    
    public function testDeleteMessage()
    {
    	/*to init the test with jwt**/
    	$user=User::where("username",'=','john')->first();
    	$token = JWTAuth::fromUser($user);
    	LogConsole::debug($token);
    	$request = Request::create('/api/deleteMessage', 'GET', ['token' => $token]);
    	JWTAuth::setRequest($request);
    	
    	$msg= Messages::where("subject",'=','test')->first();
    	if($msg==null){
    		$message=new Messages();
    		$message->subject='test';
    		$message->recipient='john';
    		$message->author='test';
    		$message->body='hello!';
    		//$message->sent='1';
    		$msg=$message->save();
    		$msg= Messages::where("subject",'=','test')->first();
    	}
    
    	$messages=$this->post('/api/deleteMessage?token='.$token.'&author='.$user->pseudo.'&id='.$msg->id);
    	//dd($messages);
    	$this->assertNotEmpty($messages);
    }
    
    
    
    public function testSendMessage()
    {
    	/*to init the test with jwt**/
    	$user=User::where("username",'=','john')->first();
    	$token = JWTAuth::fromUser($user);
    	LogConsole::debug($token);
    	$request = Request::create('/api/sendmessage', 'GET', ['token' => $token]);
    	JWTAuth::setRequest($request);
    	 
    	$messages=$this->post('/api/sendmessage?token='.$token.'&subject='.'encoretest'.'&recipient='.'john'.'&author='.'moi'.'&body='.'ceci est un test');
    	//dd($messages);
    	$this->assertNotEmpty($messages);
    }
    
    
    public function testGetMessages()
    {
    	/*to init the test with jwt**/
    	$user=User::where("username",'=','john')->first();
    	$token = JWTAuth::fromUser($user);
       	$request = Request::create('/api/getMessages', 'GET', ['token' => $token]);
    	JWTAuth::setRequest($request);
    	
    	$messages=$this->get('/api/getMessages?token='.$token);
    	//dd($messages);
    	$this->assertNotEmpty($messages);
    }
    
    public function testEditMessage()
    {
    	/*to init the test with jwt**/
    	$user=User::where("username",'=','john')->first();
    	$token = JWTAuth::fromUser($user);
    	
    	$msg= Messages::where("subject",'=','test')->first();
    	if($msg==null){
	    	$message=new Messages();
			$message->subject='test';
			$message->recipient='john';
			$message->author='test';
			$message->body='hello!';
			//$message->sent='1';
			$msg=$message->save();
			$msg= Messages::where("subject",'=','test')->first();
    	}
    	
    	
    	$request = Request::create('/api/editMessage', 'GET', ['token' => $token,'id'=>$msg->id]);
    	JWTAuth::setRequest($request);
    	 
    	$message=$this->get('/api/editMessage?token='.$token.'&id='.$msg->id);
    	//LogConsole::debug(print_r($messages,true));
    	 
    	$this->assertNotEmpty($message);
    }
}
