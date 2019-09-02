<?php

/**
 * Escape string for general use in HTML
 * @param  String $string data to be sanitized
 * @return String
 */
function e($string)
{
    return htmlentities($string, null, 'UTF-8');
}

/**
 * Escape string for use in attribute (quotes entitized)
 * @param  String $string data to be sanitized
 * @return String
 */
function e_attr($string)
{
    return htmlentities($string, ENT_QUOTES, 'UTF-8');
} 

/**
 * Escape string for use in attribute (quotes entitized)
 * @param  String $string data to be sanitized
 * @return String
 */
function clean($field)
{   
    //if post field is not empty
    if (!empty($_POST[$field])) {
        return htmlentities($_POST[$field], ENT_QUOTES, "UTF-8");
    } else {
        return '';
    }
} 

/**
 * Flash function used to display messages
 * @param  type and message are two parametres used to set values in session
 * @return
 */
function setFlash($type, $message)
{
    $_SESSION['message'] = [$type, $message];
} 


/**
 * get PST 
 * @param  value 
 * @return value
 */
function getPst($sub)
{
	return $sub * .07; 
} 

/**
 * get get value
 * @param  value 
 * @return value
 */
function getGST($sub)
{
	return $sub * .05;
}

