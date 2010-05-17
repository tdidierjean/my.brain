<?php
session_start();
if (!$_SESSION["logged"]){
    header("Location: ../login.php");
}

require_once("../init.php");
require_once("../entry.php");

$id_entry = $_REQUEST["id_entry"];
if (!$id_entry){
	throw Exception("No id_entry specified !");
}

$entry = Entry::getFromDb($id_entry);
$tags = $entry->getTags();
$tags = implode (" ", $tags);

?>
<div class='editForm'>
	<form>
		<div class="edit_line">
			<label for="entry_name" class="label_edit">Name </label>
			<br />
			<input name="entry_name" value="<?php echo $entry->getName();?>" />
		</div>
		<div class="edit_line">
			<label for="entry_url" class="label_edit">Url </label>
			<br />
			<input name="entry_url" value="<?php echo $entry->getUrl();?>" />
		</div>
		<div class="edit_line">
			<label for="entry_details" class="label_edit">Details </label>
			<br />
			<textarea name="entry_details" class="edit_textarea"><?php echo $entry->getDetails();?></textarea>
		</div>
		<div class="edit_line">
			<label for="entry_tags" class="label_edit">Tags </label>
			<br />
			<input name="entry_tags" value="<?php echo $tags;?>" />
		</div>
		
		<a href="#" class="iconCell acceptEditEntry">
			<img src="images/accept.png" alt="Create"/>
		</a>
		<a href="#" class="iconCell cancelEditEntry">
			<img src="images/cross.png" alt="Cancel"/>
		</a>
	</form>
</div>

