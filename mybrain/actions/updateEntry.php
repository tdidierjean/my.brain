<?php 
/*
 * Create or Update an entry in the database
 */
session_start();
if (!$_SESSION['logged']){
    echo "<script type='text/javascript'>window.location.replace('login.php');</script>";
	exit();
}

require_once('../init.php');
require_once("../lib/dao/entryDAO.php");
require_once("../lib/model/tag.php");
require_once("../lib/search/searchEngine.php");

$id_entry = $_POST['id_entry'];
$name = $_POST['name'];
$details = $_POST['details'];
$tags = $_POST['tags'];

$entryDAO = new EntryDAO($db);

// Get the name of each tags and create Tag objects
$tags_array = Tag::fromStringArray(preg_split("/[\s,]+/", $tags));
$entry = new Entry($id_entry, $name, $details, "", "", $tags_array);
$entryDAO->save($entry);

// Update index
$searchEngine = new SearchEngine($CONFIG['indexPath'], $db);
$searchEngine->updateEntry($entry);

//return updated entry
echo json_encode($entry->getId());
?>