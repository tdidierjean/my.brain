<?php
// doit plutot heriter de la classe lucene
class SearchEngine{
	private $db;

	function __construct($db){
	    $this->db = $db;
	}
	
	function search($query){
		
	}
}