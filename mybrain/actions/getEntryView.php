<?php
session_start();
if (!$_SESSION['logged']){
    echo "<script type='text/javascript'>window.location.replace('login.php');</script>";
	exit();
}

require_once('../init.php');
require_once("../lib/dao/entryDAO.php");

$id_entry = $_REQUEST['id_entry'];
if (!isset($id_entry)){
	throw new Exception("No id_entry specified !");
}

$entryDAO = new EntryDAO($db);
$entry = $entryDAO->get($id_entry);

if ($entry->getId() != 0){
    include("../lib/view/entryView.php");
}   
?>