<?php
require_once("init.php");

$content = $db->getEntry($_REQUEST['id_entry']);
?>
<html>
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr">
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<head>
		<title>zoom</title>
		<link href="css/main.css" media="all" rel="stylesheet" type="text/css">
	</head>
	<body>
		<div id='small_page'>
			<h1><?php echo stripslashes($content['name']);?></h1>
			<h2><?php echo $content['url'];?></h2>
			<br />
			<textarea class="zoom"><?php echo stripslashes($content['details']);?></textarea>
		</div>
	</body>
</html>
