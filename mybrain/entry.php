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

	function __construct($id=0, 
						 $name="", 
						 $url="", 
						 $details="", 
						 $creation_date="", 
						 $update_date=""){
	    $this->id = $id;
	    $this->name = $name;
	    $this->url = $url;
	    $this->details = $details;
		$this->creation_date = $creation_date;
		$this->update_date = $update_date;
	}
	
	static function getFromDb($id_entry){
		$db = Database::getInstance();
		$fetchedLine = $db->getEntry($id_entry);
		return new Entry($fetchedLine["id_entry"], 
						  $fetchedLine["name"],
						  $fetchedLine["url"], 
						  $fetchedLine["details"],
						  $fetchedLine["creation_date"],
						  $fetchedLine["update_date"]);
	}
	
	function getId() {
		return $this->id;
	}

	function getName(){
	    return stripslashes($this->name);
	}
	
	function getUrl(){
		return $this->url;
	}
	
	function getDetails(){
		return stripslashes($this->details);
	}
	
	function getDetailsHtmlDisplay(){
		return nl2br(stripslashes($this->details));
	}
	
	function getCreationDate(){
		return $this->creation_date;
	}

	function getUpdateDate(){
		return $this->update_date;
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
	
	/**
	* Return a shortened url(string) no longer than max_size
	*/
	static function shortenUrl($url, $max_size){

		$url = str_ireplace("http://", "", $url);

		if (strlen($url) > $max_size){
			return substr($url, 0, $max_size-3) . "...";
		}
		else{
			return $url;
		}
	}

}
?>