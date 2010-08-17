<?php 
session_start();
if (!$_SESSION['logged']){
    echo "<script type='text/javascript'>window.location.replace('login.php');</script>";
	exit();
}

require_once('../init.php');
require_once("../lib/dao/tagDAO.php");

$tagDAO = new TagDAO($db);
$tags = $tagDAO->getTags();

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