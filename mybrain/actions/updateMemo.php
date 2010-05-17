<?php 
session_start();
if (!$_SESSION['logged']){
    header("Location: ..login.php");
}

require_once('../init.php');

$content = $_POST['content'];
// Write content to DB
$db->setMemo($content);
echo "Saved today at ". date('h:i:s A');
?>