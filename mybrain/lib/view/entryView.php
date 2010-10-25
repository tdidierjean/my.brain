<?php 
/**
 * Included to display an Entry $entry
 */
?>
<h3 class="customAccordion <?php echo $entry->getId()?>"><a href="#"><?php echo $entry->getName(); ?></a></h3>
<div class="entryBody smallText <?php echo $entry->getId()?>" name="<?php echo $entry->getId()?>">								
	<div style='float:right'>
		<a class="iconCell editEntry" href="#">
			<img class="entryIcon" src="images/edit.png" alt="edit"/>
		</a>
		<a class="iconCell deleteEntry" href="#">
			<img class="entryIcon" src="images/delete.png" alt="delete"/>
		</a>
	</div>

	<div class="entryTags">
		<?php 
		$tags = $entry->getTags();
		if ($tags):
			foreach ($tags as $tag):
				?>
				<!--  <span><?php echo $tag->getTagText();?></span>-->
				<div class="tagEle corners"><?php echo $tag->getTagText();?><img class="entryIcon" src="images/delete.png" alt="delete"/></div>
				<?php
			endforeach;
		endif;
		?>
	</div>
	<?php if($entry->getUrl()):?>
		<a class="url" href="<?php echo $entry->getUrl();?>">
			<?php echo $entry->getShortenedUrl(35);?>
		</a>
	<?php endif;?>
	<div class="entryDetails">
		<?php echo $entry->getDetailsHtmlDisplay();?>
	</div>
</div>