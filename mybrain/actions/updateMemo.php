<?php 
session_start();
if (!$_SESSION['logged']){
    echo "<script type='text/javascript'>window.location.replace('login.php');</script>";
	exit();
}

require_once('../init.php');
require_once("../lib/dao/memoDAO.php");

$content = $_POST['content'];
// Write content to DB
$memoDAO = new MemoDAO($db);
date_default_timezone_set('Europe/Paris');
$datetime = new DateTime();
$update_date = $datetime->format('Y-m-d h:i:s A');
$memo = new Memo($content, $update_date);
$memoDAO->save($memo);

echo "Saved today at ". date('h:i:s A');
?>