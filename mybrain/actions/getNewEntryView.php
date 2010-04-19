<?php
session_start();
if (!$_SESSION["logged"]){
    header("Location: ../login.php");
}

require_once("../init.php");
require_once("../fonctions.php");
require_once("../entryList.php");

if (!$_REQUEST["id_list"]){
	throw Exception("No id_list specified !");
}

$entry_list = EntryList::getFromDb($_REQUEST["id_list"]);
$tags = $entry_list->getTags();
$tags = implode (" ", $tags);

?>
<h3 class='accordion'><a href='#'>New entry</a></h3>
<div class='editForm'>
	<form>
		<div class="edit_line">
			<label for="entry_name" class="label_edit">Name </label>
			<br />
			<input name="entry_name" value="" />
		</div>
		<div class="edit_line">
			<label for="entry_url" class="label_edit">Url </label>
			<br />
			<input name="entry_url" value="" />
		</div>
		<div class="edit_line">
			<label for="entry_details" class="label_edit">Details </label>
			<br />
			<textarea name="entry_details" class="edit_textarea"></textarea>
		</div>
		<div class="edit_line">
			<label for="entry_tags" class="label_edit">Tags </label>
			<br />
			<input name="entry_tags" value="<?php echo $tags;?>" />
		</div>
		
		<a href="#" class="iconCell acceptNewEntry">
			<img src="images/accept.png" alt="Create"/>
		</a>
		<a href="#" class="iconCell cancelNewEntry">
			<img src="images/cross.png" alt="Cancel"/>
		</a>
	</form>
</div>
