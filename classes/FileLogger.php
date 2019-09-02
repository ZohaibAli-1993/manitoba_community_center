<?php
/**
 * File writting class
*/
//namespace class
namespace classes;

use classes\ILogger;

class FileLogger implements ILogger
{

  
    private $file;
    
    /**
    *Constructor for file logger class
    * @return void
    * @param   $file
    */
    public function __construct($file)
    {
          $this->file=$file;
    }

    /**
    * write function to write on file
    * @return void
    * @param   $event
    */

    public function write($event)
    {
        //file write function
        file_put_contents($this->file, $event.PHP_EOL, FILE_APPEND);
    }
}
