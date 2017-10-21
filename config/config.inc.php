<?php
session_start();
ini_set('default_charset','UTF-8');
// Turn off all error reporting
error_reporting(0);
//error_reporting(E_ALL);
$CFG['parse_time']['start'] = explode(' ', microtime());
//@todo improve time zone settings
if (function_exists('date_default_timezone_set')) //dirty hack for < 5.1.0
	date_default_timezone_set('Asia/Calcutta');
$host = '';
$folder_names_arr = array();
$relative_modules_arr = array();
$CFG['site']['modules_arr'] = array('');
$site_url_arr = array_merge($folder_names_arr , $relative_modules_arr);
if (isset($_SERVER['HTTP_HOST'])) //some says that this might not be set in IIS
		$host = $_SERVER['HTTP_HOST'];
	else if (isset($_SERVER['SERVER_NAME']))
		$host = $_SERVER['SERVER_NAME'];
$CFG['site']['host'] = $host;
 $CFG['site']['url'] = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://'
                       . $host
                       . str_replace(
					   			$site_url_arr,
					   			'',
								substr($_SERVER['SCRIPT_NAME'], 0, strrpos($_SERVER['SCRIPT_NAME'], '/')+1)
							);
$CFG['site']['url'] = strrpos($CFG['site']['url'], '/')==strlen($CFG['site']['url'])-1?$CFG['site']['url']:$CFG['site']['url'].'/';
$slash = (stripos(php_sapi_name(), 'apache')!==false) ? '/' : DIRECTORY_SEPARATOR;
$CFG['site']['project_path'] = str_replace(
									array('\\') + $site_url_arr,
									array('/' ) + array_fill(0, count($folder_names_arr) + count($CFG['site']['modules_arr']), '' ),
								    substr($_SERVER['SCRIPT_FILENAME'], 0, strrpos($_SERVER['SCRIPT_FILENAME'], $slash)+1)
								);
$CFG['site']['project_path'] = strrpos($CFG['site']['project_path'], '/')==strlen($CFG['site']['project_path'])-1?$CFG['site']['project_path']:$CFG['site']['project_path'].'/';
$CFG['site']['project_path_relative'] = str_replace(
											array_merge(array('common/', 'admin/'), $relative_modules_arr),
											'',
											substr($_SERVER['SCRIPT_NAME'], 0, strrpos($_SERVER['SCRIPT_NAME'], '/')+1)
										);
$CFG['site']['project_path_relative'] = strrpos($CFG['site']['project_path_relative'], '/')==strlen($CFG['site']['project_path_relative'])-1?$CFG['site']['project_path_relative']:$CFG['site']['project_path_relative'].'/';
$CFG['site']['script_name'] = substr($_SERVER['SCRIPT_NAME'], strrpos($_SERVER['SCRIPT_NAME'], '/')+1);

require_once($CFG['site']['project_path'].'config/config_db.inc.php');
require_once($CFG['site']['project_path'].'config/config.url.php');
require_once($CFG['site']['project_path'].'config/config_tables.inc.php');
require_once($CFG['site']['project_path'].'functions/dbConnection.php');
require_once($CFG['site']['project_path'].'functions/function.php');

//rewrite_mode
$CFG['rewrite_mode'] =  'normal';
//Path Settings
$CFG['site']['image']['path'] = $CFG['site']['url'].'images/';
$CFG['site']['css']['path'] = $CFG['site']['url'].'css/';
$CFG['site']['js']['path'] = $CFG['site']['url'].'js/';

//Home Page grid tabels
$CFG['site']['grid']['home'] = array('stg_garden1','stg_garden2','stg_garden3','stg_garden4','stg_garden5','stg_garden6');
$CFG['site']['alert_grid']['default'] = 'alerts'; //default table to show when the page load at first time
//Every Pages limit
$CFG['site']['home']['limit'] = 30;

//Pages desc limit
$CFG['site']['home']['title'] = 30;
$CFG['site']['home']['desc'] = 300;
$CFG['site']['home']['desc_pattern'] = '/[\x00-\x1F\x80-\xFF]/';
?>