<?php
//DB
function dbInitialize()
	{
		global $db,$CFG,$db2;
		$db = new mysqli($CFG['db']['hostname'], $CFG['db']['username'], $CFG['db']['password'],$CFG['db']['name']);
		if ($db->connect_error) 
			{
    			die("Connection failed: " . $db->connect_error);
			}
			
		$db2 = new mysqli($CFG['db']['hostname2'], $CFG['db']['username2'], $CFG['db']['password2'],$CFG['db']['name2']);	
		if (!isset($CFG['db']['name2']) || $db2->connect_error) 
			{
    			die("Connection failed: " . $db2->connect_error);
			}
	}
dbInitialize();
?>