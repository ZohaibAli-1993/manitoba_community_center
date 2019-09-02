<?php  
  //will turn output buffering on
  ob_start(); 
  //session start
  session_start(); 
  
  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL); 

  //csrf token condition to check if its empty
  if(empty($_SESSION['csrf_token'])){

  	$_SESSION['csrf_token'] = md5( rand() );

  }
  //check condition if csrf_token match with form csrf_token or not
  if('POST' == $_SERVER['REQUEST_METHOD']) 
  {
  	 if(filter_input(INPUT_POST,'csrf_token') != $_SESSION['csrf_token']){

  	 	die('CSRF TOKEN MISMATCH');
  	 }
  }  
  //namespace autoload
  spl_autoload_register('my_autoload'); 
    function my_autoload($class) 
    {  
       $class=trim($class,'\\'); 
       $class=str_replace('\\','/',$class); 
       $class=$class . '.php'; 
       $file=__DIR__ . '/../' .$class;  
       
       if(file_exists($file)){ 
       require $file;
       }
    }   
  //  config file will run these files in the end
  require 'connect.php';
  require 'log.php';