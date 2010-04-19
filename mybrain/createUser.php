<?php
require_once('init.php');

$username = $_POST['username'];
$password = $_POST['password'];
$password2 = $_POST['password2'];

// User already exists ?
$user = $db->existsUser();

if (!$user && $password == $password2){
	$db->createNewUser($username, md5($password));
}

header("Location: index.php");
?>