<?php
//require_once('../init.php');
require_once('../lib/Zend/Search/Lucene.php');
require_once('../lib/search/entryDocument.php');
// doit plutot heriter de la classe lucene
class SearchEngine{
	private $indexPath;
	public $index;

	function __construct($indexPath){
	    $this->indexPath = $indexPath;
	    $this->index = Zend_Search_Lucene::open($this->indexPath);//$index;//parent::open($this->indexPath);
	}
	
	function removeEntry($id_entry){
		$hit = $this->index->find('id_entry:'.$id_entry);
		if (count($hit) == 1){
			$this->index->delete($hit[0]->id);
		}
	}
	
	function updateEntry(Entry $entry){
		$this->removeEntry($entry->getId());
		$this->addEntry($entry);
	}
	
	function addEntry(Entry $entry){
		$this->index->addDocument(new EntryDocument($entry));
	}
}