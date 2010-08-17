<?php
session_start();

if (!$_SESSION['logged']){
    echo "<script type='text/javascript'>window.location.replace('login.php');</script>";
	exit();
}

require_once("../init.php");
require_once("../lib/dao/entryListDAO.php");

if (!isset($_REQUEST["id_list"]) || !$_REQUEST["id_list"]){
	throw Exception("Missing arguments !");
}

$listDAO = new EntryListDAO($db);
$entry_list = $listDAO->get($_REQUEST["id_list"]);
if (!$entry_list){
	echo "This list does not exist.";
	exit;
}
$tags = $entry_list->getMainTags();

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
			<input name="entry_tags" value="<?php 
				if ($tags){
					sort($tags);
					foreach ($tags as $tag){
						echo $tag->getTagText();
					}
				}
				?>" />
		</div>
		
		<a href="#" class="iconCell acceptNewEntry">
			<img src="images/accept.png" alt="Create"/>
		</a>
		<a href="#" class="iconCell cancelNewEntry">
			<img src="images/cross.png" alt="Cancel"/>
		</a>
	</form>
</div>
