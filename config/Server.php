<?php

require_once ('includes/config.php');
require_once (ROOT_PATH.'config/includes/functions.php');
require_once (ROOT_PATH.'config/controllers/ServerController.php');

class Server {

  /*  --------------------  INITIALIZATION  --------------------  */
  public static ServerController $control;
  public static bool $connected = false;

  public function __construct()
  {
    self::$control = new ServerController();

    if (self::$control->connected && self::$control->database->connected) {
      self::$connected = true; //! TEMP -> will replace with user auth login check
      return true;
    }

    die("Fatal Error: Unable to connect to server.\n");
  }


  /*  -----------------------  GENERAL  -----------------------  */
  /**
   * * Ends server connection
   */
  public function end() 
  {
    if (self::$connected) {
      ValidationController::$validated = false;
      self::$control->database->connected = false;
      self::$control->connected = false;
      self::$connected = false;
      Database::$connection = null;
      return true;
    }

    return false;
  }


  /*  ----------------------  JAVASCRIPT  ----------------------  */

  /**
   * * Console logs output [ JS ]
   * @param $output -> desired javascript output
   * @param bool $with_script_tags
   */
  public static function consoleLog($output, $with_script_tags = true)
  {
    $js_code = 'console.log(' . json_encode($output, JSON_HEX_TAG) .
        ');';
    if ($with_script_tags) {
      $js_code = '<script>' . $js_code . '</script>';
    }
    echo $js_code;
  }

  /**
   * * Alerts output [ JS ]
   * @param $output -> desired javascript output
   * @param bool $with_script_tags
   */
  public static function alert($output, $with_script_tags = true)
  {
    $js_code = 'alert(' . json_encode($output, JSON_HEX_TAG) .
        ');';
    if ($with_script_tags) {
      $js_code = '<script>' . $js_code . '</script>';
    }
    echo $js_code;
  }
}

