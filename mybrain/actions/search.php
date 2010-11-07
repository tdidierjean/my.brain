<?php
session_start();
if (!$_SESSION['logged']){
	echo "<script type='text/javascript'>window.location.replace('login.php');</script>";
	exit();
}

require_once('../init.php');
require_once('../lib/search/searchEngine.php');
require_once('Zend/Search/Lucene.php');
require_once('../lib/dao/entryDAO.php');


$query = $_REQUEST['query'];

$searchEngine = new SearchEngine($db);

Zend_Search_Lucene_Analysis_Analyzer::setDefault(
		new Zend_Search_Lucene_Analysis_Analyzer_Common_Utf8_CaseInsensitive());


$query = isset($_GET['query']) ? $_GET['query'] : '';
$query = trim($query);
$query .= "*";

$index = Zend_Search_Lucene::open($CONFIG['indexPath']);

try {
	$hits = $index->find($query);
}
catch (Zend_Search_Lucene_Exception $ex) {
	$hits = array();
}

$entryDAO = new EntryDAO($db);


if($hits){
	$entries = array();
	foreach ($hits as $hit){
		$entries[] = $entryDAO->get($hit->id_entry);
		/*$entries[] = new Entry($hit->id, 
							 $hit->name, 
							 $hit->url, 
							 $hit->details); */
	}
	
	?>
	<div id="entriesList">
		<?php 
		foreach($entries as $entry){ 
			include('../lib/view/entryView.php');
		}
		?>
	</div>
	<?php
}
?>
	