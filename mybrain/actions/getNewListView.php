<?php
require_once("../lib/model/entryList.php");
$list = new EntryList(0, "New List", "2", "2");
?>

<div class="entryList corners shadows newListDiv">
	<div class="entryListHeader corners">
		<div class='editForm'>
			<form>
				<div class="edit_line">
						<label for="list_title" class="label_edit">Title </label>
					<br />
						<input name="list_title" value="<?php echo $list->getTitle();?>" />
				</div>
				<div class="edit_line">
						<label for="list_col" class="label_edit">Column </label>
					<br />
						<input name="list_col" value="<?php echo $list->getCol();?>" />
				</div>
				<div class="edit_line">
						<label for="list_rank" class="label_edit">Rank </label>
					<br />
						<input name="list_rank" value="<?php echo $list->getRank();?>" />
				</div>
				<div class="edit_line">
						<label for="list_tags" class="label_edit">Tags </label>
					<br />
						<input name="list_tags" value="" />
				</div>
				<a href="#" class="iconCell acceptCreateList">
					<img src="images/accept.png" alt="Create"/>
				</a>
				<a href="#" class="iconCell cancelCreateList">
					<img src="images/cross.png" alt="Cancel"/>
				</a>
			</form>
		</div>
	</div>
</div>
