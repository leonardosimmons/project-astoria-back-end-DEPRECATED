<?php

require_once (ROOT_PATH.'config/controllers/DatabaseController.php');
require_once (ROOT_PATH.'config/controllers/ValidationController.php');

class ServerController
{

  /*  --------------------  INITIALIZATION  --------------------  */
  public Database $database;
  public ValidationController $validate;
  public bool $connected = false;
  public static bool $reset = false;

  function __construct()
  {
    $this->initServer();
    if ($this->connected) {
      return true;
    }

    return die("Fatal Error: Unable to connect to server controller.");
  }


  /*  ----------------------  CONNECTION  ----------------------  */

  /**
   * * Begins server initialization
   */
  protected function initServer()
  {
    if ($this->database = new Database()) {
      $this->validate = new ValidationController();
      return $this->connected = true;
      // add cookie updates here
    }

    return die("Fatal Error: Unable to connect to database.");
  }


  /*  --------------------  SERIALIZATION  ---------------------  */
  
  /**
   * * Encrypts entered string [ basic ]
   * @param $string
   * @return string
   */
  public function hashString($string)
  {
    $string = sanitizeString($string, 6);
    return hash('ripemd128', $string);
  }

  /*  ---------------------  IP ADDRESS  ----------------------  */

  /**
   * * Get's the current user's ip address
   */
  public function getIpAddr()
  {
    return $this->getRealIpAddress();
  }

  /**
   * * Gets the user's actual ip address (despite proxy)
   */
  private function getRealIpAddress() 
  {
    $ip = null;
    switch($_SERVER)
    {
      case !empty($_SERVER['HTTP_CLIENT_IP']):
        $ip = $_SERVER['HTTP_CLIENT_IP'];
        break;
      case !empty($_SERVER['HTTP_X_FORWARDED_FOR']):
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        break;
      default:
        $ip = $_SERVER['REMOTE_ADDR'];
        break;
    }

    return sanitizeString($ip, 6);
  }
}


?>