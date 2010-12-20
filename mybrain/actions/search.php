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

$query = $_REQUEST['query'];

$searchEngine = new SearchEngine($db);

Zend_Search_Lucene_Analysis_Analyzer::setDefault(
		new Zend_Search_Lucene_Analysis_Analyzer_Common_Utf8_CaseInsensitive());

Zend_Search_Lucene_Search_Query_Wildcard::setMinPrefixLength(0);
$index = Zend_Search_Lucene::open($CONFIG['indexPath']);
$entryDAO = new EntryDAO($db);
		
if (isset($_GET['query']) && $_GET['query'] != ""){
	$query = trim($query);
	$query .= "*";
	try {
		$hits = $index->find($query);
	}
	catch (Zend_Search_Lucene_Exception $ex) {
		$hits = array();
	}
	
	$entries = array();
	if($hits){
		foreach ($hits as $hit){
			//try{
				$entries[] = $entryDAO->get($hit->id_entry);
			//}
			//catch ()
		}
	}
}else{
	$entries = $entryDAO->getAll();
}
	
?>
<div id="entriesList">
	<?php 
	foreach($entries as $entry){ 
		if (is_a($entry,"Entry")){
			include('../lib/view/entryView.php');
		}
	}
	?>
</div>

	