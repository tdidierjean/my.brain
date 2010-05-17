<?php
session_start();
if (!$_SESSION['logged']){
    header("Location: ../login.php");
}

require_once('../init.php');
require_once('../fonctions.php');

$id_list = $_REQUEST['id_list'];
if (!$id_list){
	throw Exception("No id_list specified !");
}

$list = $db->getEntryList($id_list);
?>

								
<div class="entryListName">
	<?php echo $list["title"];?>
</div> 
<div style='float:right'>
	<a class="iconCell newEntry" href="#">
		<img class="entryIcon" src="images/add.png" alt="add"/>
	</a>									
	<a class="iconCell editList" href="#">
		<img class="entryIcon" src="images/edit.png" alt="edit"/>
	</a>
</div>
