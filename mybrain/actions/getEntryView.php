<?php
session_start();
if (!$_SESSION['logged']){
    header("Location: ../login.php");
}

require_once('../init.php');
require_once('../fonctions.php');

$id_entry = $_REQUEST['id_entry'];
if (!$id_entry){
	throw Exception("No id_entry specified !");
}

$entry = $db->getEntry($id_entry);

foreach($entry as $i => $field){
	$field = stripslashes($field);
	$entry[$i] = nl2br($field);
}
$tags = $db->getEntryTags($id_entry);
/*if ($tags){
	$entry['tags'] = implode(' ', $tags);//_array);
}
else{
	$entry['tags'] = "";
}*/
?>
<h3 class="customAccordion <?php echo $id_entry;?>"><a href="#"><?php echo $entry["name"];?></a></h3>
<div class="entryBody smallText <?php echo $id_entry;?>" name="<?php echo $id_entry;?>">								
	<?php if($entry["url"]):?>
		<a class="url" href="<?php echo $entry["url"];?>">
			<?php echo shortenUrl($entry["url"], 30);?>
		</a>
	<?php endif;?>
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
				<span><?php echo $tag;?></span>
				<?php
			endforeach;
		endif;
		?>
	</div>
	<div class="entryDetails">
		<?php echo $entry["details"];?>
	</div>
</div>