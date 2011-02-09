<?php
session_start();
if (!$_SESSION['logged']){
	echo "<script type='text/javascript'>window.location.replace('login.php');</script>";
	exit();
}

require_once('../init.php');
require_once('../lib/search/searchEngine.php');
require_once('../lib/Zend/Search/Lucene.php');
require_once('../lib/dao/entryDAO.php');


$id_entry = $_POST['id_entry'];

$index = Zend_Search_Lucene::open($CONFIG['indexPath']);
$searchEngine = new SearchEngine($db, $CONFIG['indexPath'], $index);

$entryDAO = new EntryDAO($db);
$entry = $entryDAO->get($id_entry);

// If no entry found => entry was deleted and must be removed from index
// If entry => entry was modified or created, index must be updated
if ($entry->getId() == 0){
	$searchEngine->removeEntry($id_entry);
}else{
	$searchEngine->updateEntry($entry);
}


$searchEngine->deleteEntry($id_entry);
?>