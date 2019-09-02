<?php

/**
* Validation class
*/
class Validator
{
    //private variable with empty string
    private $errors = [];

    /**
     * Ensure a value is provided for required field
     * @param  String $field the field name
     * @return void
     */
    public function required($field)
    {
        if (empty(filter_input(INPUT_POST, $field))) {
             $this->setError($field, $field.' is a required field');
        }
    }
   
    /**
     * Function is used to validate the email
     * @param  String $field the field name
     * @return void
     */
    public function email($field)
    {
        //if email not valid
        if (!filter_input(INPUT_POST, $field, FILTER_VALIDATE_EMAIL)) {
            $this->setError($field, ' Please provide valid email address');
        }
          //set error
    }
    
    /**
     * It is used to validate the integer values
     * @param  String $field the field name
     * @return void
     */
    public function integerFunc($field)
    {

        //if email not valid
        if (!filter_input(INPUT_POST, $field, FILTER_VALIDATE_INT)) {
            $this->setError($field, ' Please provide valid number');
        }
          //set error
    }
    
    /**
     * String function used to validate the string
     * @param  String $field the field name
     * @return void
     */
    public function stringFunc($field)
    {
        if (!filter_var($_POST[$field], FILTER_SANITIZE_STRING)) {
            $this->setError($field, $field.' Please provide  valid string');
        }
    }
     
    /**
     * post code validator function
     * @param  String $field the field name
     * @return void
     */
    public function postal($field)
    {
        if (!preg_match("/^([a-zA-Z]{1})([0-9]{1})([a-zA-Z]{1})([\s]?)([0-9]{1})([a-zA-Z]{1})  ([0-9]{1})$/", filter_input(INPUT_POST, $field))) {
            $this->setError($field, $field.' is not valid');
        }
    } 

    
    /**
     * password validator function
     * @param  String $field the field name
     * @return void
     */
    public function passfunc($field)
    {
        if (!preg_match("/(?=.*[[:punct:]]+)(?=.*[A-Z]+)(?=.*[0-9]).{8,}/", filter_input(INPUT_POST, $field))) {
            $this->setError($field, $field.'is not valid');
        }
        
          //set error
    }   

    /**
     * cvv validator function
     * @param  field number
     * @return void
    */
    public function cvv($field)
    {
        if (!preg_match("/^[0-9]{1,3}$/", filter_input(INPUT_POST, $field))) {
            $this->setError($field, $field.' is not valid and it must be three digit number');
        }
        
          //set error
    }  
    /**
     * card numbervalidator function
     * @param  field number
     * @return void
    */
    public function card_num($field)
    {
        if (!preg_match("/^[0-9]{1,10}$/", filter_input(INPUT_POST, $field))) {
            $this->setError($field, $field.' is not valid ');
        }
        
          //set error
    }
    /**
    * match password validator function
    * @param  number $field1 and $field2
    * @return void
    */
    public function matchPassword($field1, $field2)
    {
     
        if (filter_input(INPUT_POST, $field1)!=filter_input(INPUT_POST, $field2)) {
            $this->setError('match', ' Password does not match');
        }
        //set error
    }
    
    /**
     * Time creted or updated validator function
     * @param  String $field the field name
     * @return void
     */
    public function testTime($field)
    {
      
        if (!preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", filter_input(INPUT_POST, $field))) {
            $this->setError($field, '  does not match');
        }
        //set error
    }


    /**
     * Return the errors array
     * @return Array
     */
    public function errors()
    {
        return $this->errors;
    }
    
    /**
     * Set error to the session
     * @param  String $field the field name and message
     * @return void
     */
 
    private function setError($field, $message)
    {
        if (empty($this->errors[$field])) {
            $this->errors[$field] = $message;
        }
    }
}//close class
