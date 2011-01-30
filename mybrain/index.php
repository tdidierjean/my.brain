<?php
session_start();
if (!isset($_SESSION['logged']) || !$_SESSION['logged']){
    header("Location: login.php");
	exit();
}
require_once('init.php');
require_once('lib/dao/configDAO.php');
require_once('lib/dao/memoDAO.php');
require_once('lib/dao/entryDAO.php');
require_once('lib/dao/tagDAO.php');
require_once('lib/search/searchEngine.php');

// retrieve config
$configDAO = new ConfigDAO($db);
$config = $configDAO->get();

// retrieve memo from db and remove slashes that were added when inserting into db
$memoDAO = new MemoDAO($db);
$memo = $memoDAO->get();

$last_search = "";
switch ($config->getDefaultSearch()) {
    case 'last_search':
        $searchEngine = new SearchEngine($CONFIG['indexPath'], $db);
        $last_search = $config->getLastSearch();
        $entries = $searchEngine->search($last_search);
        break;
    
    case 'all':
        $entryDAO = new EntryDAO($db);
        $entries = $entryDAO->getAll();      
        break;
        
    case 'none':
        $entries = array();
        break;
    
    default:
        break;
}

$tagDAO = new TagDAO($db);
$content['all_tags'] = $tagDAO->getAll();

// build the view
require('view.php');
?>


