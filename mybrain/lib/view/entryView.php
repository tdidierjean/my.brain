<?php 
/**
 * Included to display an Entry $entry
 */
require_once(ROOT.'/lib/markdown.php');
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
				<div class="tagEle"><?php echo $tag->getTagText();?><img class="entryIcon deleteTag" src="images/delete.png" alt="delete"/></div>
				<?php
			endforeach;
		endif;
		?>		
	</div>
	<br />
	<div class="entryContent hidden">
		<div class="entryOptions">
			<a class="iconCell editEntry" href="#">
				<img class="entryIcon" src="images/edit.png" alt="edit"/>
			</a>
			<a class="iconCell deleteEntry" href="#">
				<img class="entryIcon" src="images/delete.png" alt="delete"/>
			</a>			
		</div> 	
		<br />
		<div class="entryDetails">
			<?php echo Markdown($entry->getDetails());?>
		</div>
	</div>
</div>
<script type="text/javascript">
//Stolen from StackOverflow. Find all </code><pre><code> 
//elements on the page and add the "prettyprint" style. If at least one 
//prettyprint element was found, call the Google Prettify prettyPrint() API.
//http://sstatic.net/so/js/master.js?v=6523
function styleCode() 
{
 if (typeof disableStyleCode != "undefined") 
 {
     return;
 }

 var a = false;

 $("pre code").parent().each(function() 
 {
     if (!$(this).hasClass("prettyprint")) 
     {
         $(this).addClass("prettyprint");
         a = true
     }
 });
 
 if (a) { prettyPrint(); } 
}
$(document).ready(styleCode());
</script>
