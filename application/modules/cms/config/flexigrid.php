<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
/*
|--------------------------------------------------------------------------
| Json header params
|--------------------------------------------------------------------------
*/

// this sets the expiration for 24 hours from now.
$days = 1;
$seconds = 60 * 60 * 24 * $days;
$today = time();
$date_expires = strftime("%a, %e %b %Y %H:%M:%S", $today + $seconds);

$config['json_header'] = array(
"Expires: " . $date_expires . " GMT",
"Last-Modified: " . gmdate( "D, d M Y H:i:s" ) . "GMT",
"Cache-Control: no-cache, must-revalidate",
"Pragma: no-cache",
"Content-type: text/x-json");

$config['ajax_header'] = array(
"Expires: " . $date_expires . " GMT",
"Last-Modified: " . gmdate( "D, d M Y H:i:s" ) . "GMT",
"Cache-Control: no-cache, must-revalidate",
"Pragma: no-cache",
"Content-type: text/plain");

/*
|--------------------------------------------------------------------------
| Starting page number
|--------------------------------------------------------------------------
*/
$config['page_number'] = 1;

/*
|--------------------------------------------------------------------------
| Default number of records per page
|--------------------------------------------------------------------------
*/
$config['per_page'] = 10;
