<?php
/**
* Database write class
*/
//namespace class
namespace classes;

use classes\ILogger;

class DatabaseLogger implements ILogger
{

    //protected variable
    protected $dbh;

    /**
    * Constructor for Databaselogger class
    * @param $dbh
    * @return void
    */
    public function __construct(\PDO $dbh)
    {
        $this->dbh=$dbh;
    }

    /**
    * write function to put data inside the database
    * @param   event
    * @return void
    */
    public function write($event)
    {
        //create query
         $query = 'INSERT INTO  
                    log
                    (event)
                    VALUES 
                    (:event)';
        //parameters
        $params = array(':event' =>$event);
        //prepare query with parameters
        $stmt =$this->dbh->prepare($query);
        //excute the query
        $stmt->execute($params);
    }
}
