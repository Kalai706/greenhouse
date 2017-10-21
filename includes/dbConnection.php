<?php
//DB
function dbInitialize()
	{
		global $db,$db2,$CFG;
		$db = new mysqli($CFG['db']['hostname'], $CFG['db']['username'], $CFG['db']['password'],$CFG['db']['name']);
		$db2 = new mysqli($CFG['db']['hostname2'], $CFG['db']['username2'], $CFG['db']['password2'],$CFG['db']['name2']);
		//echo $CFG['db']['hostname'].">>>".$CFG['db']['username'].">>>".$CFG['db']['password'].">>>".$CFG['db']['name2'];
		
		if ($db->connect_error) 
			{
    			die("Connection failed: " . $db->connect_error);
			}
		if (!isset($CFG['db']['name2']) || $db2->connect_error) 
			{
    			die("Connection failed: " . $db2->connect_error);
			}
	}
dbInitialize();
?>