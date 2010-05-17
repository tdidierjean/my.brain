<?php
class EntryList{
	static $default_col = 1;
	static $default_rank = 99;
    private $id;
    private $title;
	private $col;
	private $rank;
	private $collapsed;
    private $entries;
    private $main_tags;
    private $entries_tags;
	
    function __construct($id=0, 
						 $title="", 
						 $col=0, 
						 $rank=0, 
						 $collapsed=0){
        $this->id = $id;
        $this->title = $title;
		$this->col = $col;
		$this->rank = $rank;
		$this->collapsed = $collapsed;
    }

    function addEntry($newEntry){
		/*if (!isset($this->entries)){*/
			
        $this->entries[] = $newEntry;
    }
	/*
	function addTags($tags){
		foreach ($tags as $tag){
			if (!in_array($tag, $this->tags)){
				$this->tags[] = $tag;
			}
		}
	}
	*/
	
	function getEntriesTags(){
		return $this->entries_tags;
	}
	
	function setEntriesTags($refresh=false){
		if (!isset($this->entries_tags) || $refresh){
			$this->entries_tags = array();
			foreach ($this->entries as $entry){
				foreach ($entry->getTags() as $tag){
					if (!in_array($tag, $this->entries_tags)){
						$this->entries_tags[] = $tag;
					}
				}
			}
		}
	}

    function getId() {
    	return $this->id;
    }
    
    function getTitle(){
        return $this->title;
    }
	
	function getCol(){
		if (isset($this->col)){
			return $this->col;
		}
		return self::$default_col;
	}
	
	function getRank(){
		if (isset($this->rank)){
			return $this->rank;
		}
		return self::$default_rank;
	}
    
    function getEntries(){
        return $this->entries;
    }
    
    function setEntries($entries){
        $this->entries = $entries;
    }
	
	function getMainTags(){
		return $this->main_tags;
	}
	
	function setMainTags($tags){
		 $this->main_tags = $tags;
	}	
	
	function getCollapsed(){
		return $this->collapsed;
	}
}
?>
