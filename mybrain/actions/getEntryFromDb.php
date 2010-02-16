<?php 
session_start();
if (!$_SESSION['logged']){
    header("Location: ../login.php");
}

require_once('../init.php');

$id_entry = $_REQUEST['id_entry'];
if (!$id_entry){
	throw Exception("No id_entry specified !");
}

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
echo json_encode($entry);

?>