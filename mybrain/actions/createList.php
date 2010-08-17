<?php 
session_start();
if (!$_SESSION['logged']){
    echo "<script type='text/javascript'>window.location.replace('login.php');</script>";
	exit();
}

require_once("../init.php");
require_once("../lib/dao/entryListDAO.php");
require_once("../lib/dao/tagDAO.php");

$title = $_POST['title'];
$col = $_POST['col'];
$rank = $_POST['rank'];
$tags_string = $_POST['tags'];

$listDAO = new EntryListDAO($db);
$list = new EntryList(0, $title, $col, $rank);
//Create and attach tags
$tags_array = preg_split("/[\s,]+/", $tags_string);
$tags = Tag::fromStringArray($tags_array);
$list->setMainTags($tags);

// EntryList will be created id db and its ID will be updated
$listDAO->save($list);

//Return the id of the created entry
echo json_encode($list->getId());
?>