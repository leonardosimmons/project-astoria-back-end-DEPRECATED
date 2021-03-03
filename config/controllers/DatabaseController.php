<?php

class Database
{
  /*  -----------------  INITIALIZATION  -----------------  */
  public static ?PDO $connection;
  public bool $connected = false;
  private array $login = array();

  public function __construct()
  {
    if (self::$connection = $this->connect()) {
      return $this->connected = true;
    }

    return false;
  }

  /*  ------------------  CONNECTION  ------------------  */

  /**
   * * Sets database login information
   */
  private function setLoginInfo()
  {
    $fh = fopen(LOGIN_INFO, 'r');
    $line = fread($fh, 50);
    fclose($fh);
    $words = explode("\n", $line);

    $i = 1;
    foreach ($words as $word) {
      switch($i)
      {
        case 1:
          $this->login['hostname'] = onlyAlpha(preg_replace("/\s+/", "", $word));
          break;
        case 2:
          $this->login['username'] = onlyAlpha(preg_replace("/\s+/", "", $word));
          break;
        case 3:
          $this->login['password'] = onlyAlpha(preg_replace("/\s+/", "", $word));
          break;
        case 4:
          $this->login['database'] = onlyAlpha(preg_replace("/\s+/", "", $word));
          break;
        default:
          break;
      }
      ++$i;
    }
    
    if ($this->login['database']) {
      return true;
    } 

    return false;
  }

  /**
   * * Connects to database
   */
  private function connect()
  {
    $conn = null;
    $this->setLoginInfo();

    try {
      $conn = new PDO('mysql:host=' . $this->login['hostname'] . ';dbname=' . $this->login['database'], $this->login['username'], $this->login['password']);
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch (PDOException $err){
      echo 'Connection Error: ' . $err->getMessage();
    }

    return $conn;
  }
};

?>
