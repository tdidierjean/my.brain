<?php
require_once(ROOT."/lib/model/tag.php");

class TagDAO{
	private $db;

	function __construct($db){
	    $this->db = $db;
	}
	
	// Anciennement getByTagText.
	// Ajoute l'id à un objet tag si elle existe
	//Est-ce qu'on doit save l'objet sinon ?
	function attach($tag){
		if ($tag->getId()){
			return;
		}
		
		$sql = "SELECT id_tag as id
				FROM tags 
				WHERE tag_text = :tag_text";
		try{
			$query = $this->db->prepare($sql);
			$query->execute(array(":tag_text" => $tag->getTagText()));
		}catch (PDOException $e) {
			return $e->getMessage();
		}
		//$query->setFetchMode(PDO::FETCH_INTO, $tag);
		$result = $query->fetch(PDO::FETCH_ASSOC);//PDO::FETCH_INTO, $tag);
		if ($result){
			$tag->setId($result["id"]);
		}
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
	
	/**
	* Get all tags in db
	*/
	function getAll(){
		$sql = "SELECT id_tag, tag_text
				FROM tags";
		try{
			$query = $this->db->prepare($sql);
			$query->execute();
		}catch (PDOException $e) {
			return $e->getMessage();
		}
		
		// FETCH_PROPS_LATE => makes sure the class constructor is called before
		// the object variables are filled with data from db 
		$tags = $query->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, "Tag");
		return $tags;
	}
}