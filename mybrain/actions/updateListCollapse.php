<?php 
session_start();
if (!$_SESSION['logged']){
    echo "<script type='text/javascript'>window.location.replace('login.php');</script>";
	exit();
}

require_once('../init.php');
require_once("../lib/dao/entryListDAO.php");

$id_list = $_POST['id_list'];
$collapsed = $_POST['collapsed'];

// Write content to DB
$listDAO = new EntryListDAO($db);
$list = $listDAO->get($id_list);
$list->setCollapsed($collapsed);
$listDAO->save($list);

?>