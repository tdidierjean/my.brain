<?php 
session_start();
if (!$_SESSION['logged']){
    header("Location: ../login.php");
}

require_once('../init.php');

$title = $_POST['list_title'];
$col = $_POST['list_col'];
$rank = $_POST['list_rank'];
$tags = $_POST['list_tags'];

// Write entry to DB
$db->setNewEntryList($title, $col, $rank);

// Get ID of just created list
$id_list = $db->lastInsertId();
//$entry = $db->getEntry($id_entry);
echo json_encode($id_list);

//Create and attach tags
$tags = preg_split("/[\s,]+/", $tags);

foreach ($tags as $tag){
	$db->addTagToEntryList($id_list, $tag);
}

?>

<?php 
session_start();
if (!$_SESSION['logged']){
    echo "<script type='text/javascript'>window.location.replace('login.php');</script>";
	exit();
}

require_once("../init.php");
require_once("../lib/dao/listDAO.php");

$title = $_POST['list_title'];
$col = $_POST['list_col'];
$rank = $_POST['list_rank'];
$tags = $_POST['list_tags'];

$listDAO = new EntryListDAO($db);
$list = new EntryList(0, $title, $col, $rank);
// EntryList will be created id db and its ID will be updated
$listDAO->save($list);

//Create and attach tags
$tags = preg_split("/[\s,]+/", $tags);
foreach ($tags as $tag_text){
	$entryDAO->addTagToEntry($entry->getId(), strtolower($tag_text));
}

//Return the id of the created entry
echo json_encode($entry->getId());
?>