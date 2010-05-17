<?php
require_once(ROOT."/lib/model/entry.php");
require_once(ROOT."/lib/dao/tagDAO.php");

class EntryDAO{
	private $db;

	function __construct($db){
	    $this->db = $db;
	}
	
	function get($id){
		$sql = "SELECT id_entry as id, name, url, details, creation_date, update_date
				FROM entry 
				WHERE id_entry = :id";
			
		try{
			$query = $this->db->prepare($sql);
			$query->execute(array(':id' => $id));
		}catch (PDOException $e) {
			return $e->getMessage();
		}
		$entry = $query->fetch(PDO::FETCH_CLASS, "Entry");

		$tags = $this->getTags($entry->getId());
		$entry->setTags($tags);		
		
		return $entry;
	}
	
	function getByList($id_list){
		$sql = "SELECT entry.id_entry as id, entry.name, entry.url, entry.details, entry.creation_date, entry.update_date
				FROM entry 
				JOIN entry2tag ON entry2tag.id_entry = entry.id_entry
				JOIN list2tag ON list2tag.id_list = :id_list
				WHERE entry2tag.id_tag = list2tag.id_tag";
		try{
			$query = $this->db->prepare($sql);
			$query->execute(array(':id_list' => $id_list));
		}catch (PDOException $e) {
			return $e->getMessage();
		}

		$entries = $query->fetchAll(PDO::FETCH_CLASS, "Entry");

		foreach ($entries as $entry){
			$this->getTags($entry);
		}

		return $entries;
	}
	
	function save($entry){
		if ($entry->getId()){
			$this->update($entry);
		} else {
			$this->insert($entry);
		}
	}
	
	function delete($id){
		$sql = "DELETE entry, entry2tag 
				FROM entry
				LEFT JOIN entry2tag 
				ON entry2tag.id_entry = entry.id_entry
				WHERE entry.id_entry= :id";
		try{
			$query = $this->db->prepare($sql);
			$query->execute(array(':id' => $id));
		}catch (PDOException $e) {
			return $e->getMessage();
		}			
	}	

	function getTags($entry){
		$sql = "SELECT tags.id_tag as id, tags.tag_text
				FROM entry2tag
				INNER JOIN tags
				ON entry2tag.id_tag = tags.id_tag
				WHERE entry2tag.id_entry = :id";
		
		try{
			$query = $this->db->prepare($sql);
			$query->execute(array(':id' => $entry->getId()));
		}catch (PDOException $e) {
			return $e->getMessage();
		}
		$tags = $query->fetchAll(PDO::FETCH_CLASS, "Tag");
		$entry->setTags($tags);
	}
	
	private function update($entry){
		$sql = "UPDATE entry
				SET name = :name, url = :url, details = :details, update_date = NOW()
				WHERE id_entry = :id_entry";
		try{
			$query = $this->db->prepare($sql);
			$query->execute(array(':id_entry' => $entry->getId(),
								  ':name' => $entry->getName(),
								  ':url' => $entry->getUrl(),
								  ':details' => $entry->getDetails()));
		}catch (PDOException $e) {
		    return $e->getMessage();
		}
	}
	
	private function insert($entry){
		$sql = "INSERT INTO entry (id_list, name, url, details, creation_date, update_date) 
				VALUES (5, :name, :url, :details, NOW(), NOW())";
		try{
			$query = $this->db->prepare($sql);
			$query->execute(array(':name' => $entry->getName(),
								  ':url' => $entry->getUrl(),
								  ':details' => $entry->getDetails()));
		}catch (PDOException $e) {
		    return $e->getMessage();
		}
		$id = $this->db->lastInsertId();
		$entry->setId($id);
		
		foreach($entry->getTags() as $tag){
			$this->insertTag($tag);
			$this->attachTagToEntry($entry, $tag);
		}
	}	
	
	private function insertTag($tag){
		$tagDAO = new TagDAO($this->db);
		$tagDAO->getByTagText($tag);

		// Insert tag if it doesn't exist in db
		if (!$tag->getId()){
			$tagDAO->save($tag);
		}
	}	
	
	function updateTagLinks($entry){
		$sql = "SELECT tags.id_tag as id, tags.tag_text
				FROM entry2tag, tags 
				WHERE entry2tag.id_entry = :id
				AND entry2tag.id_tag = tags.id_tag";
		/*$sql = "SELECT id_tag
				FROM entry2tag
				WHERE id_entry = :id";*/
		try{
			$query = $this->db->prepare($sql);
			$query->execute(array(':id' => $entry->getId()));
		}catch (PDOException $e) {
			return $e->getMessage();
		}			
	
		$old_tags = $query->fetchAll(PDO::FETCH_CLASS, "Tag");
		$new_tags = $entry->getTags();
		//$new_tag_texts = $entry->getArrayOfTagTexts();
		// if link is in db but not in object -> delete link in db
		deleteTagLinks($entry, array_diff($old_tag_texts, $new_tag_texts));
		// if link is in object but not in db -> create link in db
		createTagLinks($entry, array_diff($new_tag_texts, $old_tag_texts));
	}
	
	private function attachTagToEntry($entry, $tag){
		$sql = "INSERT INTO entry2tag (id_entry, id_tag)
				VALUES (:id_entry, :id_tag)";
		try{
			$query = $this->db->prepare($sql);
			$query->execute(array(':id_entry' => $entry->getId(),
								  ':id_tag' => $tag->getId()));
		}catch (PDOException $e) {
			return $e->getMessage();
		}		
	}

	function createTagLinks($entry, $tag_texts){
		$sql = "DELETE entry2tag 
				FROM entry2tag, tags 
				WHERE id_entry = :id_entry
				AND tags.tag_text = :tag_text
				AND entry2tag.id_tag = tags.id_tag";
		try{
			$query = parent::prepare($sql);
			foreach ($tag_texts as $tag_text){
				$query->execute(array(':id_entry' => $entry->getId(),
									  ':tag_text' => $tag_text));
			}						 
		}catch (PDOException $e) {
			return $e->getMessage();
		}			
	}
	
	function deleteTagLinks($entry, $tag_texts){
		$sql = "DELETE entry2tag 
				FROM entry2tag, tags 
				WHERE id_entry = :id_entry
				AND tags.tag_text = :tag_text
				AND entry2tag.id_tag = tags.id_tag";
		try{
			$query = parent::prepare($sql);
			foreach ($tag_texts as $tag_text){
				$query->execute(array(':id_entry' => $entry->getId(),
									  ':tag_text' => $tag_text));
			}						 
		}catch (PDOException $e) {
			return $e->getMessage();
		}			
	}
	
	/**
	* Get all the entries for which none of their tags are linked to an entry list
	*/
	function getOrphans(){
		$sql = "SELECT DISTINCT entry.id_entry as id, entry.name, entry.url, entry.details, entry.creation_date, entry.update_date
				FROM entry 
				WHERE entry.id_entry NOT IN (
					SELECT DISTINCT entry2tag.id_entry
					FROM entry2tag
					WHERE entry2tag.id_tag IN (
						SELECT DISTINCT list2tag.id_tag 
						FROM list2tag
					)
				)";

		try{
			$query = $this->db->prepare($sql);
			$query->execute();
		}catch (PDOException $e) {
			return $e->getMessage();
		}
		$entries = $query->fetchAll(PDO::FETCH_CLASS, "Entry");
		foreach ($entries as $entry){
			$this->getTags($entry);
		}
		return $entries;
	}
}
?>