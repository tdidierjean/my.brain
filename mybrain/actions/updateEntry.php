<?php 
session_start();
if (!$_SESSION['logged']){
    header("Location: ../login.php");
}

require_once('../init.php');
require_once("../lib/dao/entryDAO.php");

$id_entry = $_POST['id_entry'];
$name = $_POST['name'];
$url = $_POST['url'];
$details = $_POST['details'];
$tags = $_POST['tags'];

$entryDAO = new EntryDAO($db);
$entry = new Entry($id_entry, $name, $url, $details);
$entryDAO->save($entry);

/*
// Write content to DB
$err = $db->updateEntry($id_entry, $name, $url, $details);
if ($err){
	echo json_encode($err);
	exit();
}
*/

// Update tags
$tags_to_remove = array();
$tags_to_add = array();

$new_tags = preg_split("/[\s,]+/", $tags);
$old_tags = $db->getEntryTags($id_entry);
$tags_array = array();

if ($old_tags){
	foreach ($old_tags as $old_tag){
		// Which tags will be removed ?
		if (!in_array($old_tag, $new_tags)){
			$res = $db->removeTagFromEntry($id_entry, $old_tag);
		}
	}	
}
	
// Which tags will be added ?
foreach ($new_tags as $new_tag){
	if (!in_array($new_tag, $old_tags)){
		$db->addTagToEntry($id_entry, $new_tag);
	}
}

//return updated entry
echo json_encode($id_entry);
?>