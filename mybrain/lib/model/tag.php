<?php

class Tag{
    public $id;
	public $tag_text;
	
	function __construct($id=0, 
						 $tag_text="")
	{
	    $this->id = $id;
	    $this->tag_text = strtolower($tag_text);
	}
	
	/**
	* Return an array of Tag objects from an array of tag names
	*/
	static function fromStringArray($input){
		$tags_array = array();
		foreach ($input as $tag_text){
			$tag_text = strtolower($tag_text);
			$tags_array[] = new Tag(0, $tag_text);
		}
		return $tags_array;
	}
	
	function getId() {
		return $this->id;
	}

	function setId($id) {
		$this->id = $id;
	}
	
	function getTagText(){
	    return $this->tag_text;
	}
	
	function setTagText($tag_text){
	    $this->tag_text = $tag_text;
	}
}