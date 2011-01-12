<?php 
/**
 * Included to display an edit view for an Entry $entry
 */
?>
<link rel="stylesheet" type="text/css" href="../css/wmd.css" />
<script type="text/javascript" src="../js/showdown.js"></script>


<div class="entry corners shadows" id="<?php echo $entry->getId()?>">
	<form>
		<div class="edit_line">
			<label for="entry_name" class="label_edit">Name </label>
			<br />
			<input name="entry_name" class="required" value="<?php echo $entry->getName();?>" />
		</div>
		<div class="edit_line">
			<label for="entry_url" class="label_edit">Url </label>
			<br />
			<input name="entry_url" value="<?php echo $entry->getUrl();?>" />
		</div>
		<div class="edit_line">
			<label for="entry_details" class="label_edit">Details </label>
			<br />
			<div id="wmd-button-bar"></div>
			<textarea id="wmd-input" name="entry_details" class="edit_textarea"><?php echo $entry->getDetails();?></textarea>
			<div id="wmd-preview"></div>
		</div>
		<div class="edit_line">
			<label for="entry_tags" class="label_edit">Tags </label>
			<br />
			<input name="entry_tags" value="<?php echo $entry->getImplodedTags();?>" />
		</div>
		
		<a href="#" class="iconCell acceptEditEntry">
			<img src="images/accept.png" alt="Create"/>
		</a>
		<a href="#" class="iconCell cancelEditEntry">
			<img src="images/cross.png" alt="Cancel"/>
		</a>
	</form>
</div>
<script type="text/javascript" src="../js/wmd.js"></script>

