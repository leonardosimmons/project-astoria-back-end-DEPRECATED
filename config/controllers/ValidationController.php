<?php

class ValidationController
{
  public static bool $validated;

  function __construct() 
  {
    self::$validated = false;
  }

  /*  --------------------  FORM VALIDATION  -------------------- */

  /**
   * First Name validation
   * @param $field
   * @return string
   */
  public function firstName($field)
  {
    return ($field === "") ? "First Name is required.\n" : "";
  }

  /**
   * Last Name validation
   * @param $field
   * @return string
   */
  public function lastName($field)
  {
    return ($field === "") ? "Last Name is required.\n" : "";
  }

  /**
   * User Name validation
   * @param $field
   * @return string
   */  
  public function userName($field)
  {
    switch($field) 
    {
      case "":
        return "Username is required.\n";
      case (strlen($field) < 5):
        return "Username must be at least 5 characters long.\n";
      case (preg_match("/\W/",  $field)):
        return "Username must only contain letters, numbers and -.\n";
      default:
        return "";
    }
  }

  /**
   * Password validation
   * @param $field
   * @return string
   */  
  public function password($field)
  {
    switch($field)
    {
      case "":
        return "No Password has been entered.\n";
      case (strlen($field) < 6):
        return "Password must be at least 6 characters long.\n";
      case !preg_match("/[a-z]/", $field):
      case !preg_match("/[A-Z]/", $field):
      case !preg_match("/[0-9]/", $field):
        return "Passwords require at least (1) of each chacter: a-z, A-Z, 0-9.\n";
      default:
        return "";
    }
  }

  /**
   * Age validation
   * @param $field
   * @return string
   */  
  public function age($field)
  {
    switch($field)
    {
      case "":
        return "Must enter an age.\n";
      case !is_numeric($field):
        return "Please enter a number for the age.\n";
      case $field < 21:
      case $field > 110:
        return "Must enter an age between 21 and 110.\n";
      default:
        return "";
    }
  }

  /**
   * Email validation
   * @param $field
   * @return string
   */  
  public function email($field)
  {
    switch($field)
    {
      case "":
        return "No Email address was entered.\n";
      case (!((
        strpos($field, ".") > 0) || (
        strpos($field, "@") > 0)) && 
        preg_match("/[^a-zA-Z0-9_-]/", $field));
        return "The Email address entered is invalid.\n";
      default:
        return "";
    }
  }
}


?>
