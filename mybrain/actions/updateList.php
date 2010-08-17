<?php 
session_start();
if (!$_SESSION['logged']){
    echo "<script type='text/javascript'>window.location.replace('login.php');</script>";
	exit();
}

require_once('../init.php');
require_once("../lib/dao/entryListDAO.php");
require_once("../lib/dao/tagDAO.php");

$id_list = $_POST['id_list'];
$title = $_POST['title'];
$col = $_POST['col'];
$rank = $_POST['rank'];
$tags = $_POST['tags'];

// Write content to DB
$listDAO = new EntryListDAO($db);
// Get the name of each tags and create Tag objects
$tags_array = Tag::fromStringArray(preg_split("/[\s,]+/", $tags));
$list = new EntryList($id_list, $title, $col, $rank, 0, $tags_array);
$listDAO->save($list);
?>