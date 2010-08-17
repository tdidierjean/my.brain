<?php
class Memo{
	private $content;
	private $update_date;
	
	function __construct($content,
						 $update_date=""){
		$this->content = $content;
		$this->update_date = $update_date;
	}
	
	function getContent(){
		return $this->content;
	}
	
	function setContent($content){
		$this->content = $content;
	}
}