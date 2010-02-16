<?php 
session_start();
if (!$_SESSION['logged']){
    header("Location: ../login.php");
}

require_once('../init.php');

$id_list = $_POST['id_list'];
$name = $_POST['name'];
$url = $_POST['url'];
$details = $_POST['details'];
$tags = $_POST['tags'];

// Write entry to DB
$db->setNewEntry($id_list, $name, $url, $details);

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