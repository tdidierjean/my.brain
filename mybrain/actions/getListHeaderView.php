<?php
session_start();
if (!$_SESSION['logged']){
    echo "<script type='text/javascript'>window.location.replace('login.php');</script>";
	exit();
}

require_once('../init.php');
require_once("../lib/dao/entryListDAO.php");

$id_list = $_REQUEST['id_list'];
if (!$id_list){
	throw Exception("No id_list specified !");
}
$listDAO = new EntryListDAO($db);
$list = $listDAO->get($id_list);
?>
								
<div class="entryListName">
	<?php echo $list->getTitle();?>
</div> 
<div style='float:right'>
	<a class="iconCell newEntry" href="#">
		<img class="entryIcon" src="images/add.png" alt="add"/>
	</a>									
	<a class="iconCell editList" href="#">
		<img class="entryIcon" src="images/edit.png" alt="edit"/>
	</a>
</div>
