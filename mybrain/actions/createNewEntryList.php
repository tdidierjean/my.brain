<?php 
session_start();
if (!$_SESSION['logged']){
    header("Location: ../login.php");
}

require_once('../init.php');

$title = $_POST['list_title'];
$col = $_POST['list_col'];
$rank = $_POST['list_rank'];
$tags = $_POST['list_tags'];

// Write entry to DB
$db->setNewEntryList($title, $col, $rank, $tags);

// Get ID of just created entry
$id_entry = $db->lastInsertId();
$entry = $db->getEntry($id_entry);
echo json_encode($entry);

//Create and attach tags
$tags = preg_split("/[\s,]+/", $tags);

foreach ($tags as $tag){
	$db->addTagToEntry($id_entry, $tag);
}

?>