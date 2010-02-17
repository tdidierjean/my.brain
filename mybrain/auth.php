<?php
require_once('init.php');
session_start();// get user info
$utilisateur = $db->getUtilisateur($_REQUEST['username']);								
/****************************************
          Check password
****************************************/
if (!$utilisateur || (md5($_REQUEST['password']) != $utilisateur['password'])) {
	header("Location: login.php");
	exit();
}
$_SESSION['logged'] = true;
header("Location: index.php");
?>