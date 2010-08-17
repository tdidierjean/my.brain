<?php
session_start();
if (!$_SESSION['logged']){
    echo "<script type='text/javascript'>window.location.replace('login.php');</script>";
	exit();
}

require_once('../init.php');
require_once("../lib/dao/entryDAO.php");

$id_entry = $_REQUEST['id_entry'];
if (!$id_entry){
	throw Exception("No id_entry specified !");
}

$entryDAO = new EntryDAO($db);
$entry = $entryDAO->get($id_entry);
$tags = $entry->getTags();

?>
<h3 class="customAccordion <?php echo $id_entry;?>"><a href="#"><?php echo $entry->getName();?></a></h3>
<div class="entryBody smallText <?php echo $id_entry;?>" name="<?php echo $id_entry;?>">								
	<div style='float:right'>
		<a class="iconCell" href="zoom_popup.php?id_entry=<?php echo $id_entry;?>" rel="#overlay"> 
			<img class="entryIcon" src="images/zoom.png" alt="zoom"/>
		</a>			
		<a class="iconCell editEntry" href="#">
			<img class="entryIcon" src="images/edit.png" alt="edit"/>
		</a>
		<a class="iconCell deleteEntry" href="#">
			<img class="entryIcon" src="images/delete.png" alt="delete"/>
		</a>
	</div>
	<div class="entryTags">
		<?php 
		if ($tags):
			foreach ($tags as $tag):
				?>
				<span><?php echo $tag->getTagText();?></span>
				<?php
			endforeach;
		endif;
		?>
	</div>
	<?php if($entry->getUrl()):?>
		<a class="url" href="<?php echo $entry->getUrl();?>">
			<?php echo $entry->shortenUrl($entry->getUrl(), 35);?>
		</a>
	<?php endif;?>
	<div class="entryDetails">
		<?php echo $entry->getDetailsHtmlDisplay();?>
	</div>
</div>