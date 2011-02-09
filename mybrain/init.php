<?php
require_once('config.php');
require_once('database.php');

$db = Database::getInstance(Array('dbType'=>$CONFIG['dbType'], 
									'host'=>$CONFIG['host'], 
									'db'=>$CONFIG['db'], 
									'user'=>$CONFIG['user'], 
									'passwd'=>$CONFIG['password'])
									);
									
// Add lib folder to include path, necessary for Lucene
$libPath = PATH_SEPARATOR . ROOT . '/lib/';
set_include_path(get_include_path() . $libPath);
?>