<?php
require_once('config.php');
require_once('database.php');

$db = Database::getInstance(Array('dbType'=>$CONFIG['dbType'], 
									'host'=>$CONFIG['host'], 
									'db'=>$CONFIG['db'], 
									'user'=>$CONFIG['user'], 
									'passwd'=>$CONFIG['password'])
									);



