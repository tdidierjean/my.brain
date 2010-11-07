<?php 
/**
 * Included to display an Entry $entry
 */
?>
<div class="entry corners shadows" id="<?php echo $entry->getId()?>">
	<div class="entryTitle">
		<div class="entryName">
			<?php echo $entry->getName(); ?>
		</div>
		<?php 
		$tags = $entry->getTags();
		if ($tags):
			foreach ($tags as $tag):
				?>
				<div class="tagEle corners"><?php echo $tag->getTagText();?><img class="entryIcon" src="images/delete.png" alt="delete"/></div>
				<?php
			endforeach;
		endif;
		?>		
	</div>
	<br />
	<div class="entryContent hidden">
		<div class="entryUrl">
			<?php 
			if($entry->getUrl()){
			?>
				<a class="url" href="<?php echo $entry->getUrl();?>">
					<?php echo $entry->getShortenedUrl(35);?>
				</a>	
			<?php 
			}
			?>
		</div>
		<div class="entryDetails">
			<?php echo $entry->getDetailsHtmlDisplay();?>
		</div>
	</div>
</div>