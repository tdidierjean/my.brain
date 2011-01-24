<?php
$CONFIG['dbType'] = 'mysql';
$CONFIG['host'] = 'localhost';
$CONFIG['user'] = 'root';
$CONFIG['password'] = '';
$CONFIG['db'] = 'artificiwbrain';

// Get root path with '/' separators, even on windows
if (DIRECTORY_SEPARATOR=='/')
    $absolute_path = dirname(__FILE__);
else
    $absolute_path = str_replace('\\', '/', dirname(__FILE__));

define('ROOT', $absolute_path);

$CONFIG['indexPath'] = ROOT.'/docIndex';

// Add lib folder to include path, necessary for Lucene
$libPath = PATH_SEPARATOR . ROOT . '/lib/';
set_include_path(get_include_path() . $libPath);
?>