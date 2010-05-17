<?php 
session_start();
if (!$_SESSION['logged']){
    header("Location: ../login.php");
}

require_once('../init.php');

$id_list = $_POST['id_list'];
$title = $_POST['title'];
$col = $_POST['col'];
$rank = $_POST['rank'];
$tags = $_POST['tags'];

// Write content to DB
$err = $db->updateEntryList($id_list, $title, $col, $rank);
if ($err){
	echo json_encode($err);
	exit();
}

// Update tags
$tags_to_remove = array();
$tags_to_add = array();

$new_tags = preg_split("/[\s,]+/", $tags);
$old_tags = $db->getEntryListTags($id_list);
$tags_array = array();

if ($old_tags){
	foreach ($old_tags as $old_tag){
		// Which tags will be removed ?
		if (!in_array($old_tag, $new_tags)){
			$res = $db->removeTagFromEntryList($id_list, $old_tag);
					echo json_encode($res);
		}
	}	
}
	
// Which tags will be added ?
foreach ($new_tags as $new_tag){
	if (!in_array($new_tag, $old_tags)){
		$db->addTagToEntryList($id_list, $new_tag);
	}
}

//return updated entry
//echo json_encode($id_list);
?>