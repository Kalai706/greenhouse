<?php
require_once('config/config.inc.php');
session_start();
// Unset all of the session variables.
$_SESSION = array();
// If it's desired to kill the session, also delete the session cookie.
// Note: This will destroy the session, and not just the session data!
if (isset($_COOKIE[session_name()]))
	{
	   setcookie(session_name(), '', time()-42000, '/');
	}
setcookie($CFG['cookie']['starting_text'].'_user_name', '', time()+60*60*24*365, '/');
setcookie($CFG['cookie']['starting_text'].'_token', '', time()+60*60*24*365, '/');
// Finally, destroy the session.
session_destroy();
session_write_close();
setcookie($CFG['cookie']['starting_text'].'_bba', '', time()-42000, '/');
$server = $_SERVER['HTTP_USER_AGENT'];
Redirect2Url(getUrl('index'));
?>