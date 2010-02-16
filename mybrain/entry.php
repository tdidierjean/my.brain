<?php
require_once("init.php");
class Entry{
    private $id;
    private $name;
	private $url;
	private $details;
	private $creation_date;
	private $update_date;
	private $tags=array();

	function __construct($id, $name, $url, $details, $creation_date=null, $update_date=null){
	    $this->id = $id;
	    $this->name = $name;
	    $this->url = $url;
	    $this->details = $details;
		$this->creation_date = $creation_date;
		$this->update_date = $update_date;
	}
	
	function getId() {
		return $this->id;
	}

	function getName(){
	    return $this->name;
	}
	
	
	function getUrl(){
		return $this->url;
	}
	
	function getDetails(){
		return $this->details;
	}
        
	function getTags(){
		if (!$this->tags){
			$this->tags = $this->getTagsFromDb();
		}
		return $this->tags;
    }
	
	function setTags($tags){
		$this->tags = $tags;
	}
	
	private function getTagsFromDb(){
		$db = Database::getInstance();
		$tags = $db->getEntryTags($this->id);
		return $tags;
	}
}
?>