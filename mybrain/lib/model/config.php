<?php
class Config{
	private $default_search;
	private $last_search;
	
	function __construct($default_search="",
						 $last_search=""){
		$this->default_search = $default_search;
		$this->last_search = $last_search;
	}
	
	function getDefaultSearch(){
		return ($this->default_search);
	}
	
	function setDefaultSearch($default_search){
		$this->default_search = $default_search;
	}
	
	function getLastSearch(){
		return $this->last_search;
	}
	
	function setLastSearch($last_search){
		$this->last_search = $last_search;
	}
}