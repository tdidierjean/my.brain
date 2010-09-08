<?php
require_once('init.php');
session_start();// get user info
$user = $db->getUser($_REQUEST['username']);								
/****************************************
          Check password
****************************************/
if (!$user || (md5($_REQUEST['password']) != $user['password'])) {
	header("Location: login.php?no_session=1");
	exit();
}
$_SESSION['logged'] = true;
header("Location: index.php");
?>