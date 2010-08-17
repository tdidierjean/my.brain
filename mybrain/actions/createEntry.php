<?php 
session_start();
if (!$_SESSION['logged']){
    echo "<script type='text/javascript'>window.location.replace('login.php');</script>";
	exit();
}

require_once('../init.php');
require_once("../lib/dao/entryDAO.php");
require_once("../lib/dao/tagDAO.php");

$name = $_POST['name'];
$url = $_POST['url'];
$details = $_POST['details'];
$tags_string = $_POST['tags'];

$entryDAO = new EntryDAO($db);
$entry = new Entry(0, $name, $url, $details);

//Create and attach tags
$tags_array = preg_split("/[\s,]+/", $tags_string);
$tags = Tag::fromStringArray($tags_array);
$entry->setTags($tags);

// Entry will be created id db and its ID will be updated
$entryDAO->save($entry);

//Return the id of the created entry
echo json_encode($entry->getId());
?>