<?php
session_start();
if (!$_SESSION['logged']){
    echo "<script type='text/javascript'>window.location.replace('login.php');</script>";
	exit();
}

require_once('../init.php');
require_once("../lib/dao/entryDAO.php");

$id_entry = $_REQUEST['id_entry'];
if (!$id_entry){
	throw Exception("No id_entry specified !");
}

$entryDAO = new EntryDAO($db);
$entry = $entryDAO->get($id_entry);

include("../lib/view/entryView.php");
?>