<?php

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
						 $update_date="",
						 $tags=array()){
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

	function setId($id) {
		$this->id = $id;
	}
	
	function getName(){
	    return stripslashes($this->name);
	}
	
	function getUrl(){
		return $this->url;
	}
	
	function getShortenedUrl($max_size){
		return $this->shortenUrl($this->url, $max_size);
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
		return $this->tags;
	}	
	
	function setTags($tags){
		$this->tags = $tags;
	}
	
	function getArrayOfTagTexts(){
		$tag_texts = array();
		foreach ($tags as $tag){
			$tags_texts[] = $tag->getTagText();
		}
		return $tag_texts;
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