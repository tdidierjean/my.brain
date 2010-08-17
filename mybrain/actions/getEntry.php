<?php 
/* NOT USED*/
session_start();
if (!$_SESSION['logged']){
    header("Location: ../login.php");
}

require_once('../init.php');
require_once('../lib/dao/entryDAO.php');

$id_entry = $_REQUEST['id_entry'];
if (!$id_entry){
	throw Exception("No id_entry specified !");
}

$entryDAO = new EntryDAO();

$entry = $entryDAO->get($id_entry);
/*foreach($entry as $i => $field){
	$entry[$i] = htmlspecialchars($field, ENT_QUOTES);
}*/
$tags = $entry->getTags();
if ($tags){
	$entry->setTags(implode(' ', $tags));
}

echo json_encode($entry);

/*
$entry = $db->getEntry($id_entry);
foreach($entry as $i => $field){
	$entry[$i] = htmlspecialchars($field, ENT_QUOTES);
}
$tags = $db->getEntryTags($id_entry);
if ($tags){
	$entry['tags'] = implode(' ', $tags);//_array);
}
else{
	$entry['tags'] = "";
}
echo json_encode($entry);*/

?>