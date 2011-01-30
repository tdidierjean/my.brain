<?php
require_once(ROOT.'/lib/Zend/Search/Lucene.php');
require_once(ROOT.'/lib/search/entryDocument.php');
require_once(ROOT.'/lib/dao/entryDAO.php');
require_once(ROOT.'/lib/dao/configDAO.php');

// doit plutot heriter de la classe lucene
class SearchEngine{
	private $indexPath;
	private $db;
	public $index;

	function __construct($indexPath, $db){
	    $this->indexPath = $indexPath;
	    $this->db = $db;
	    $this->index = Zend_Search_Lucene::open($this->indexPath);//$index;//parent::open($this->indexPath);
	    
	    Zend_Search_Lucene_Analysis_Analyzer::setDefault(
		    new Zend_Search_Lucene_Analysis_Analyzer_Common_Utf8_CaseInsensitive());

        Zend_Search_Lucene_Search_Query_Wildcard::setMinPrefixLength(0);
	}
	
	/**
	 * Remove an entry from the index
	 * @param int $id_entry
	 */
	function removeEntry($id_entry){
		$hit = $this->index->find('id_entry:'.$id_entry);
		if (count($hit) == 1){
			$this->index->delete($hit[0]->id);
		}
	}
	
	/**
	 * Update an entry in the index
	 * @param Entry $entry
	 */
	function updateEntry(Entry $entry){
		$this->removeEntry($entry->getId());
		$this->addEntry($entry);
	}
	
	/**
	 * Add an entry to the index
	 * @param Entry $entry
	 */
	function addEntry(Entry $entry){
		$this->index->addDocument(new EntryDocument($entry));
	}
	
	/**
	 * Search for matches in the index
	 * @param string $query
	 * @return Entries[]
	 */
	function search($query){    	
	    $entryDAO = new EntryDAO($this->db);
        $configDAO = new ConfigDAO($this->db);
        $config = $configDAO->get();
        
        if ($query != ""){
        	$query = trim($query);
        	if (!preg_match('/\*$/', $query)){
        	    $query .= "*";
        	}
        	try {
        		$hits = $this->index->find($query);
        	}
        	catch (Zend_Search_Lucene_Exception $ex) {
        		$hits = array();
        	}
        	$config->setLastSearch($query);
        	$configDAO->save($config);
        	
        	$entries = array();
        	if($hits){
        		foreach ($hits as $hit){
        			$entries[] = $entryDAO->get($hit->id_entry);
        		}
        	}
        }else{
        	$entries = $entryDAO->getAll();
        }
        
        return $entries;
	}
	
}