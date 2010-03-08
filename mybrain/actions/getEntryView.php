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
	$entry[$i] = htmlspecialchars($field, ENT_QUOTES);
}
$tags = $db->getEntryTags($id_entry);
/*if ($tags){
	$entry['tags'] = implode(' ', $tags);//_array);
}
else{
	$entry['tags'] = "";
}*/
?>
<div id="h3_replace"><?php echo $entry["name"];?></div>

<?php if($entry["url"]):?>
	<a class="url" href="<?php echo $entry["url"];?>">
		<?php echo shortenUrl($entry["url"], 26);?>
	</a>
<?php endif;?>
<div style='float:right'>
	<a class="iconCell" href="zoom_popup.php?id_entry=<?php echo $id_entry;?>" rel="#overlay"> 
		<img class="entryIcon" src="images/zoom.png" alt="zoom"/>
	</a>													
	<img class="entryIcon" src="images/pencil.png" alt="edit" onclick="editEntry(this)"/>
	<a class="iconCell deleteEntry" href="#">
		<img class="entryIcon" src="images/text_minus.png" alt="delete"/>
	</a>
</div>
<p>
	<?php echo $entry["details"];?>
	<div class="tags">
		<?php 
		if ($tags):
			foreach ($tags as $tag):
				?>
				<span class="hidden"><?php echo $tag;?></span>
				<?php
			endforeach;
		endif;
		?>
	</div>
</p>