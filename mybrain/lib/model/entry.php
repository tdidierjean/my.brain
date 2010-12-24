<?php

class Entry{
    private $id;
    private $name; 
	private $url;
	private $details;
	private $creation_date;
	private $update_date;
	private $tags;

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
		$this->tags = $tags;
	}
	
	function getId() {
		return $this->id;
	}

	function setId($id) {
		$this->id = $id;
	}
	
	function getName(){
	    return htmlspecialchars(stripslashes($this->name)) 	;
	}
	
	function getUrl(){
		return htmlspecialchars($this->url);
	}
	
	function getShortenedUrl($max_size){
		return $this->shortenUrl($this->getUrl(), $max_size);
	}
	
	function getDetails(){
		return stripslashes($this->details);
	}
	
	function getDetailsHtmlDisplay(){
		return nl2br(htmlspecialchars(stripslashes($this->details)));
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
	
	/*
	 * Return a string containing the tag texts for the entry, separated
	 * by a delimiter.
	 */
	function getImplodedTags($delimiter=" "){
		$s = "";
		foreach ($this->getTags() as $tag){
			$s .= $tag->getTagText() . $delimiter;
		}
		$s = rtrim($s);
		return $s;	
	}
}
?>