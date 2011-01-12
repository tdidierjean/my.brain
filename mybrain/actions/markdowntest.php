<?php
session_start();
if (!$_SESSION['logged']){
    echo "<script type='text/javascript'>window.location.replace('login.php');</script>";
	exit();
}

require_once("../init.php");
require_once("../lib/dao/entryDAO.php");

if (isset($_REQUEST["id_entry"]) && $_REQUEST["id_entry"]){
	$entryDAO = new EntryDAO($db);
	$entry = $entryDAO->get($_REQUEST["id_entry"]);
}else{
	$entry = new Entry();
}

include("../lib/view/markdownviewtest.php");
?>