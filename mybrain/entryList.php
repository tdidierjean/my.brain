<?php
require_once("init.php");

class EntryList{
	static $default_col = 1;
	static $default_rank = 99;
    private $id;
    private $title;
	private $col;
	private $rank;
    private $entries = array();
    private $tags = array();
    private $tags_entries = array();
	
    function __construct($id, $title, $col, $rank){
        $this->id = $id;
        $this->title = $title;
		$this->col = $col;
		$this->rank = $rank;
    }
        
    function addEntry($newEntry){
        $this->entries[] = $newEntry;
    }
	
	function addTags($tags){
		foreach ($tags as $tag){
			if (!in_array($tag, $this->tags)){
				$this->tags[] = $tag;
			}
		}
	}
	
	function addTagsEntries($tags){
		foreach ($tags as $tag){
			if (!in_array($tag, $this->tags_entries)){
				$this->tags_entries[] = $tag;
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
    
	function getTags(){
		return $this->tags;
	}

	function getTagsEntries(){
		return $this->tags_entries;
	}
	
}
?>
	    
