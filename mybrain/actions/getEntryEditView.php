<?php
session_start();
if (!$_SESSION['logged']){
    echo "<script type='text/javascript'>window.location.replace('login.php');</script>";
	exit();
}

require_once("../init.php");
require_once("../lib/dao/entryDAO.php");

if (isset($_REQUEST["id_entry"]) && $_REQUEST["id_entry"]){
	$entryDAO = new EntryDAO($db);
	$entry = $entryDAO->get($_REQUEST["id_entry"]);
}else{
	$entry = new Entry();
}

include("../lib/view/entryEditView.php");
?>
<!--  
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
			<textarea id="edit" name="entry_details" class="edit_textarea"><?php echo $entry->getDetails();?></textarea>
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
-->
