<?php 
session_start();
if (!$_SESSION['logged']){
    header("Location: ../login.php");
}

require_once('../init.php');

$tags = $db->getAllTags();

$list_tags = array();
if ($_REQUEST["id_list"]){
	$list_tags = $db->getEntryListTags($_REQUEST["id_list"]);
}
?>
<div class="tag_container">
	<?php
	foreach ($tags as $tag){
		if (in_array($tag["tag_text"], $list_tags)){
			$class = "tag_header selected";
		}
		else{
			$class = "tag_header";
		}
		?>
		<span class=<?php echo $class;?>>
			<?php echo $tag["tag_text"];?>
		</span>
		<?php
	}
	?>
</div>