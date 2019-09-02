<?php
/**
*Interface class
*/

namespace classes;

interface ILogger
{

  
   /**
   * abstract function in interface class with no body
   * @return void
   * @param  $event
   */
    public function write($event);
}
