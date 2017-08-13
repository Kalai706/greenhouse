<?php
//DB
function dbInitialize()
	{
		global $db,$CFG;
		$db = new mysqli($CFG['db']['hostname'], $CFG['db']['username'], $CFG['db']['password'],$CFG['db']['name']);
		if ($db->connect_error) 
			{
    			die("Connection failed: " . $db->connect_error);
			}
	}
dbInitialize();
?>