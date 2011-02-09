<?php
session_start();
if (!$_SESSION['logged']){
	echo "<script type='text/javascript'>window.location.replace('login.php');</script>";
	exit();
}

require_once('../init.php');
require_once('../lib/search/searchEngine.php');

$query = $_GET['query'];

$searchEngine = new SearchEngine($CONFIG['indexPath'], $db);

if (isset($query)){
    $entries = $searchEngine->search($query);
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

	