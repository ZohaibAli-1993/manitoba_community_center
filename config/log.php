<?php 
use classes\ILogger; 
use classes\DatabaseLogger; 
use classes\FileLogger;  
$logfile=__DIR__ . '/../storage/log.text' ;  
$logsqlite=__DIR__ . '/../storage/log.sqlite' ;   
include __DIR__ . '/../config/config_functions.php';

//create class objects
//$logger=new FileLogger($logfile); 
$logger=new DatabaseLogger($dbh); 
//$logger=new DatabaseLogger(new PDO('sqlite:'.$logsqlite)); 

 
function log_event(ILogger $logger) {  

//request browser info
$ua=getBrowser();
$browser= "Browser-Name: " . $ua['name'] . " " ."Version:". $ua['version'] . " on " .$ua['platform'] . " reports: " . $ua['userAgent']; 
// default time set according to winnipeg
date_default_timezone_set ('America/Winnipeg'); 
//request_url,date/time,ip address, HTTP status
$event='CREATED_AT:'.date('Y/m/d H:i:s',$_SERVER['REQUEST_TIME']).'  '. 
       'REQUEST_URI:'.$_SERVER['REQUEST_URI'].'  '. 
       $browser.'  '. 
       'IP_ADDRESS'.getUserIpAddr().'  '. 
       'HTTP_STATUS:'.http_response_code(); 

//check condition favicon
if(!strpos($event,'favicon')){ 
	
	$logger->write($event); 
	
}
}   
// function call event
log_event($logger);
