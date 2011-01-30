<?php

class Entry{
    private $id;
    private $name; 
	private $details;
	private $creation_date;
	private $update_date;
	private $tags;

	function __construct($id=0, 
						 $name="", 
						 $details="", 
						 $creation_date="", 
						 $update_date="",
						 $tags=array()){
	    $this->id = $id;
	    $this->name = $name;
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
	
	function getDetails(){
		return stripslashes($this->details);
	}
	
	function getDetailsHtmlDisplay(){
		return nl2br(htmlspecialchars(stripslashes($this->details)));
	}
	
	function setDetails($text){
	    $this->details = $text;
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