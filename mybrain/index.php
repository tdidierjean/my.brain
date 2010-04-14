<?php
//nothing
session_start();
if (!isset($_SESSION['logged']) || !$_SESSION['logged']){
    header("Location: login.php");
	exit();
}
require_once('init.php');
require_once('fonctions.php');
require_once('entryList.php');
require_once('entry.php');

// retrieve memo from db and remove slashes that were added when inserting into db
$memo = $db->getMemo();
$content['memo'] = stripslashes($memo["content"]);
//$datetime_memo = $memo["update_date"];
$content['memo_date'] = $memo["update_date"];

// retrieve entry lists from db
foreach ($db->getEntryLists() as $entry_list_array){
    $list = new EntryList($entry_list_array['id_list'], 
    					  stripslashes($entry_list_array['title']), 
    					  $entry_list_array['col'], 
    					  $entry_list_array['rank'],
    					  $entry_list_array['collapsed']);
	$list->addTags($db->getEntryListTags($entry_list_array['id_list']));
	$entry_lists[] = $list;
}

// retrieve entries from db and relate them to entry lists
foreach($entry_lists as $entry_list){
    //$entries_array = $db->getEntries($entry_list->getId());
	$entries_array = $db->getListTaggedEntries($entry_list->getId());
    if (!empty($entries_array)){
        foreach ($entries_array as $entry_array){
            $entry = new Entry($entry_array['id_entry'], 
							   stripslashes($entry_array['name']), 
							   $entry_array['url'], 
							   nl2br(stripslashes($entry_array['details'])));
			$entry_tags = $entry->getTags();
			$entry_list->addTagsEntries($entry_tags);
            $entry_list->addEntry($entry);
        }
    }
}

// build an entrylist with the remaining entries (orphans)
$list_orphans = new EntryList("", "Orphan entries", 1, 5, 0);
$entries_array = $db->getEntriesNotDisplayed();
if (!empty($entries_array)){
	foreach ($entries_array as $entry_array){
		$entry = new Entry($entry_array['id_entry'], 
						   stripslashes($entry_array['name']), 
						   $entry_array['url'], 
						   stripslashes($entry_array['details']));
		$entry_tags = $entry->getTags();
		$list_orphans->addTagsEntries($entry_tags);
		$list_orphans->addEntry($entry);
	}
}
$entry_lists[] = $list_orphans;

$content['entry_lists'] = $entry_lists;

// build the view
require('view.php');

// bind events
?>


