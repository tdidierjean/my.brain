<?php 
session_start();
if (!$_SESSION['logged']){
    echo "<script type='text/javascript'>window.location.replace('login.php');</script>";
	exit();
}

require_once("../init.php");
require_once("../lib/dao/entryDAO.php");

$id_entry = $_POST['id'];

$entryDAO = new EntryDAO($db);
$entry = $entryDAO->delete($id_entry);
?>