<?php
session_start();
if (!$_SESSION['logged']){
    echo "<script type='text/javascript'>window.location.replace('login.php');</script>";
	exit();
}

require_once("../init.php");
require_once("../lib/dao/entryListDAO.php");

$id_list = $_REQUEST["id_list"];
if (!$id_list){
	throw Exception("No id_list specified !");
}

$listDAO = new EntryListDAO($db);
$list = $listDAO->get($id_list);
$tags = $list->getImplodedTags();
?>

<div class='editForm'>
	<form>
		<div class="edit_line">
				<label for="list_title" class="label_edit">Title </label>
			<br />
				<input name="list_title" value="<?php echo $list->getTitle();?>" />
			</td>
		</div>
		<div class="edit_line">
				<label for="list_col" class="label_edit">Column </label>
			<br />
				<input name="col" value="<?php echo $list->getCol();?>" />
		</div>
		<div class="edit_line">
				<label for="list_rank" class="label_edit">Rank </label>
			<br />
				<input name="list_rank" value="<?php echo $list->getRank();?>" />
		</div>
		<div class="edit_line">
				<label for="list_rank" class="label_edit">Tags </label>
			<br />
				<input name="list_tags" value="<?php echo $tags;?>" />
		</div>
		<a href="#" class="iconCell acceptEditList">
			<img src="images/accept.png" alt="Create"/>
		</a>
		<a href="#" class="iconCell cancelEditList">
			<img src="images/cross.png" alt="Cancel"/>
		</a>
	</form>
</div>