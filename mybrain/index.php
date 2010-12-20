<?php
session_start();
if (!isset($_SESSION['logged']) || !$_SESSION['logged']){
    header("Location: login.php");
	exit();
}
require_once('init.php');
require_once('lib/dao/memoDAO.php');
require_once('lib/dao/entryDAO.php');
require_once('lib/dao/tagDAO.php');

// retrieve memo from db and remove slashes that were added when inserting into db
$memoDAO = new MemoDAO($db);
$memo = $memoDAO->get();

// retrieve entries from db and relate them to entry lists
$entryDAO = new EntryDAO($db);
$entries = $entryDAO->getAll();

$tagDAO = new TagDAO($db);
$content['all_tags'] = $tagDAO->getAll();

// build the view
require('view.php');
?>


