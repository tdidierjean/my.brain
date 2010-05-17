<?php 
session_start();
if (!$_SESSION['logged']){
    header("Location: ../login.php");
}

require_once('../init.php');

$id_list = $_REQUEST['id_list'];
if (!$id_list){
	throw Exception("No id_list specified !");
}

$list = $db->getEntryList($id_list);

$tags = $db->getEntryListTags($id_list);
/*foreach($list as $i => $field){
	$entry[$i] = htmlspecialchars($field, ENT_QUOTES);
}*/
$list["tags"] = $tags;
echo json_encode($list);

?>