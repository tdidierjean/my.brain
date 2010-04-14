<?php
session_start();
if (!$_SESSION["logged"]){
    header("Location: ../login.php");
}

require_once("../init.php");
require_once("../fonctions.php");

$id_list = $_REQUEST["id_list"];
if (!$id_list){
	throw Exception("No id_list specified !");
}

$list = $db->getEntryList($id_list);
$tags = $db->getEntryListTags($id_list);
$tags = implode (" ", $tags);
?>
<div class='editForm'>
	<form>
		<div class="edit_line">
				<label for="list_title" class="label_edit">Title </label>
			<br />
				<input name="list_title" value="<?php echo $list["title"];?>" />
			</td>
		</div>
		<div class="edit_line">
				<label for="list_col" class="label_edit">Column </label>
			<br />
				<input name="col" value="<?php echo $list["col"];?>" />
		</div>
		<div class="edit_line">
				<label for="list_rank" class="label_edit">Rank </label>
			<br />
				<input name="list_rank" value="<?php echo $list["rank"];?>" />
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

