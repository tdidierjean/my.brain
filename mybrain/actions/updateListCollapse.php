<?php 
session_start();
if (!$_SESSION['logged']){
    header("Location: ../login.php");
}

require_once('../init.php');

$id_list = $_POST['id_list'];
$collapsed = $_POST['collapsed'];

// Write content to DB
$err = $db->updateEntryListCollapse($id_list, $collapsed);
if ($err){
	echo json_encode($err);
	exit();
}
?>