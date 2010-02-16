<?php 
session_start();
if (!$_SESSION['logged']){
    header("Location: ../login.php");
}

require_once('../init.php');

$id_entry = $_POST['id'];

// Remove content from db
$db->removeEntry($id_entry);
?>