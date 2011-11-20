<?php

/*
 * After a successful login through the CI accounts module
 * this logs the user in on Moodle.  This consists of setting
 * up a PHP session which will be recognized by Moodle as a 
 * logged in session, and syncing the Moodle database user record
 * with the user record in the a3m_account and a3m_account_details
 * tables.
 */

function moodle_autologin($account_id) {
  global $USER;
  global $CFG;

  $CI =& get_instance();
  
  // Get Moodle configuration.
  require_once($CI->config->item('base_dir').'learn/config-bridge.php');
  
  // Get the Moodle database abstraction layer to work.
  require_once($CFG->libdir.'/setuplib.php');
  preconfigure_dbconnection();
  require_once($CFG->libdir .'/adodb/adodb.inc.php'); // Database access functions
  $db = &ADONewConnection($CFG->dbtype);
  $db->null2null = 'A long random string that will never, ever match something we want to insert into the database, I hope. \'';
  $dbconnected = $db->Connect($CFG->dbhost,$CFG->dbuser,$CFG->dbpass,$CFG->dbname);
  $db->SetFetchMode(ADODB_FETCH_ASSOC);

  // Load some more Moodle libraries.
  require_once($CFG->libdir.'/dmllib.php');
  require_once($CFG->libdir.'/accesslib.php');

  // Get user details for session.
  $query = $CI->db->get_where('a3m_account', array('id'=>$account_id));
  $account = $query->row();
  $query = $CI->db->get_where('a3m_account_details', array('account_id'=>$account_id));
  $details = $query->row();
  $user->id = $account->id;
  $user->password = $account->password;
  $user->username = $account->username;
  $user->firstname = $details->firstname;
  $user->lastname = $details->lastname;
  $user->name = $details->firstname.' '.$details->lastname;
  $user->email = $account->email;

  // Insert/replace user into Moodle user table 
  $sql = "replace into {$CFG->dbname}.{$CFG->prefix}user"
	."(id, auth, confirmed, mnethostid, username, password, firstname,"
	."lastname, email, lastlogin, currentlogin, lastip)"
	." values ({$user->id}, 'email', 1, 1, '{$user->username}', '{$user->password}',"
	." '{$user->firstname}', '{$user->lastname}', '{$user->email}',"
	." unix_timestamp(), unix_timestamp(), '{$_SERVER['REMOTE_ADDR']}')";
  $CI->db->query($sql);

  // Set Moodle user preferences.
  $user->preference = array();
  if (!isguestuser($user)) {
	$preferences = get_records('user_preferences', 'userid', $user->id);
	foreach ($preferences as $preference)
	  $user->preference[$preference->name] = $preference->value;
  }

  // Set Moodle user capabilities.
  check_enrolment_plugins($user);
  load_all_capabilities();

  // Start PHP session.  (CI does not use PHP sessions, so this does not
  // collide with CI).
  session_name('MoodleSession');
  ini_set('session.save_path', $CFG->dataroot.'/sessions');
  session_start();

  // Save session.
  $_SESSION['USER'] = $user;
  $_SESSION['SESSION']->session_test = random_string('alnum', 10);
  setcookie('MoodleSessionTest', $_SESSION['SESSION']->session_test, 0, '/');
  session_commit();

  return true;
}

/*
 * Logs the user out of Moodle.
 */

function moodle_autologout() {
  session_name('MoodleSession');
  unset($_SESSION['USER']);
  unset($_SESSION['SESSION']);
  session_destroy();

  setcookie('MoodleSessionTest','',time()-3600,'/');
  setcookie('MoodleSession', '', time()-3600, '/');
  return true;
}

/*
 * Stubs of Moodle functions so that we don't have to load the entire Moodle library
 * containing these functions, which would result in name-space collisions.
 */

function debugging() {
  return false;
}
function isguestuser($user) {
  return $user->username != 'guest';
}
function notify($message, $style='notifyproblem', $align='center', $return=false) {
  error_log("Message not displayed in moodle_helper.php: $message");
}
