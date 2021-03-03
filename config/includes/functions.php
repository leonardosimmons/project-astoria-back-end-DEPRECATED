<?php

/*  --------------------  DATE/TIME  --------------------  */

/**
 * * Check Default Timezone
 * -- checks the user's current timezone against the current set timezone
*/
function checkDefaultTimezone()
{
  $tz = date_default_timezone_get();
  if (strcmp($tz, ini_get('date.timezone'))) {
    echo 'Script timezone and ini-set timezone match.';
    return false;
  } else {
    echo 'Script timezone and ini-set timezone match.';
    return true;
  }
}

  /*  --------------------  RAND GENS  --------------------  */

  /**
   * Generates a random string with the specified length
   * Chars are chosen from the provided [optional] list
   * @param int $length
   * @param string $list
   * @return string
   */
  function simpleRandString($length=16, $list="0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ"){
    mt_srand((double)microtime()*1000000);
    $newString="";

    if($length>0){
      while(strlen($newString)<$length){
        $newString.=$list[mt_rand(0, strlen($list)-1)];
      }
    }
    return $newString;
  }

  /**
   * Generates a random string with the specified length
   * Includes: a-z, A-Z y 0-9
   * @param int $length
   * @return string
   */
  function randString($length=16) {
    $newString="";
    if($length>0) {
      while(strlen($newString)<$length) {
        $num = mt_rand(0,61);
        if ($num < 10) {
          $newString.=chr($num+48);
        } elseif ($num < 36) {
          $newString.=chr($num+55);
        } else {
          $newString.=chr($num+61);
        }
      }
    }
    return $newString;
  }


/*  ---------------------  PRINT  ---------------------  */

/**
 * * Error -> [ console.log ]
 * -- Logs to console that an error has occured
 */
function error($output, $with_script_tags = true)
{
  $js_code = 'console.log("error: ' . json_encode($output, JSON_HEX_TAG) .
      ');';
  if ($with_script_tags) {
    $js_code = '<script>' . $js_code . '</script>';
  }
  echo $js_code;
}



/*  -----------------  SANITIZATION  -----------------  */

/**
 * * Only alphanumeric characters
 * -- returns filtered string containing only alphanumeric characters and '.'
 */
function onlyAlpha($string)
{
  $string = strtolower(preg_replace("[^A-Za-z0-9.]", "", $string));
  return $string;
}

/**
 * * Sanitize String
 * --  Sanitizes string based on desired security level --
 * @param $string -> string set to be sanitized
 * @param $level  -> security level of sanitization (levels 1-6)
 * @return string -> Fully sanitized version of string
 */
function sanitizeString($string, $level)
{
  switch ($level)
  {
    case 1:
      $string = htmlspecialchars($string);
      break;
    case 2:
      $string = htmlspecialchars($string, ENT_QUOTES);
      break;
    case 3:
      $string = stripslashes($string);
      $string = strip_tags($string);
      $string = htmlspecialchars($string, ENT_QUOTES);
      break;
    case 4:
      $string = htmlentities($string);
      break;
    case 5:
      $string = htmlentities($string, ENT_QUOTES);
      break;
    case 6:
      $string = stripslashes($string);
      $string = strip_tags($string);
      $string = htmlentities($string, ENT_QUOTES);
      break;
    default:
      break;
  }
  return $string;
}
