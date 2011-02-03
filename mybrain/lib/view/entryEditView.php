<?php 
/**
 * Included to display an edit view for an Entry $entry
 */
?>
<div class="entry corners shadows" id="<?php echo $entry->getId()?>">
	<form>
		<div class="editLine">
			<label for="entryName" class="label_edit">Name </label>
			<br />
			<input name="entryName" class="required" value="<?php echo $entry->getName();?>" />
		</div>
		<div class="editLine">
			<label for="entryDetails" class="label_edit">Details </label>
			<br />
			<textarea id="edit" name="entryDetails" class="edit_textarea"><?php echo $entry->getDetails();?></textarea>
		</div>
		<div class="tagEditLine">
			<?php 
			$tags = $entry->getTags();
    		if ($tags):
    			foreach ($tags as $tag):
    				?>
    				<div class="tagEle tagEdit"><?php echo $tag->getTagText();?><img class="entryIcon deleteTag" src="images/delete.png" alt="delete"/></div>
    				<?php
    			endforeach;
    		endif;
    		?>
			<input name="entryTags" value="" />
			<a href="#" class="iconCell acceptEditEntry">
    			<img src="images/add.png" alt="Create"/>
    			<span>Add tag</span>
    		</a>
		</div>
		<div class="acceptLine">
    		<a href="#" class="iconCell acceptEditEntry">
    			<img src="images/accept.png" alt="Create"/>
    			<span>Accept</span>
    		</a>
    		<a href="#" class="iconCell cancelEditEntry">
    			<img src="images/cross.png" alt="Cancel"/>
    			<span>Cancel</span>
    		</a>
		</div>
	</form>
</div>
