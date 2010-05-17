<?php
require_once(ROOT."/lib/model/tag.php");

class TagDAO{
	private $db;

	function __construct($db){
	    $this->db = $db;
	}
	
	function getByTagText($tag){
		$sql = "SELECT id_tag as id, tag_text
				FROM tags 
				WHERE tag_text = :tag_text";
		try{
			$query = $this->db->prepare($sql);
			$query->execute(array(":tag_text" => $tag->getTagText()));
		}catch (PDOException $e) {
			return $e->getMessage();
		}
		$query->setFetchMode(PDO::FETCH_INTO, $tag);
		$tag = $query->fetch();//PDO::FETCH_INTO, $tag);
	}
	
	function save($tag){
		if ($tag->getId()){
			$this->update($tag);
		} else {
			$this->insert($tag);
		}
	}
	
	function insert($tag){
		//$tag_text = strtolower($tag_text);
		$sql = "INSERT INTO tags (tag_text)
				VALUES (:tag_text)";
		try{
			$query = $this->db->prepare($sql);
			$query->execute(array(':tag_text' => $tag->getTagText()));
		}catch (PDOException $e) {
			return $e->getMessage();
		}		
		$id = $this->db->lastInsertId();
		$tag->setId($id);
	}	
	
	function update($tag){
		// Not implemented
	}
}