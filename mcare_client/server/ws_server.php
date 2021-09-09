#!/php -q
<?php  
// Run from command prompt > php -q ws_server.php
include "phpwebsocket.php";

$server_ip="127.0.0.1"; 

class ws_server extends phpWebSocket{
   function process($user,$msg){
    $c=0;
  	$this->say("(user: ".$user->id.") msg> ".$msg);
    switch($msg){
	  case "ping" :  $this->send($user->socket,"pong"); break; 
      
      case "time"  : 
         while(true){
            $this->send($user->socket,"server time is ".date("H:i:s"));
            sleep(1);
         }
         //break;
	  case "id" : 	$this->send($user->socket,"You are user: ".$user." \r\n");    break;
	  case "users":  $list="User's List \r\n";
						foreach($this->users as $u)
						   $list.="user #".++$c.". $u \r\n";
						   
						$this->send($user->socket,$list); 
					 break;
					
      case "bye"   : $this->send($user->socket,"bye");                               
						$this->disconnect($user->socket);
						break;
      default      : $this->send($user->socket,$msg." not understood - ".date("H:i:s") );              break;
    }
  }
}
$master = new ws_server($server_ip,8080);