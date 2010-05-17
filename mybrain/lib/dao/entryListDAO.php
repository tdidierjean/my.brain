<?php
require_once(ROOT."/lib/model/entryList.php");
require_once(ROOT."/lib/dao/tagDAO.php");

class EntryListDAO{
	private $db;

	function __construct($db){
	    $this->db = $db;
	}
	
	function get($id){
		$sql = "SELECT id_list as id, title, col, rank, collapsed
				FROM entrylist
				WHERE id_list = :id";
			
		try{
			$query = $this->db->prepare($sql);
			$query->execute(array(':id' => $id));
		}catch (PDOException $e) {
			return $e->getMessage();
		}
		$list = $query->fetch(PDO::FETCH_CLASS, "EntryList");

		$this->getMainTags($entry->getId());	
		
		return $entry;
	}

	/**
	* Return an array of EntryList objects
	*/
	function getAll(){
		$sql = "SELECT id_list as id, title, col, rank, collapsed
				FROM entrylist
				ORDER BY col, rank";
		try{
			$query = $this->db->prepare($sql);
			$query->execute();
		}catch (PDOException $e) {
			return $e->getMessage();
		}
		$lists = $query->fetchAll(PDO::FETCH_CLASS, "EntryList");
		
		// Retrieve the main tags for each list
		foreach ($lists as $list){
			$this->getMainTags($list);
		}
	
		return $lists;
	}

	function save($list){
		if ($list->getId()){
			$this->update($list);
		} else {
			$this->insert($list);
		}
	}

	/*
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
	}*/	

	/**
	* Get the tags linked to an entry list
	*/
	function getMainTags($list){
		$sql = "SELECT tags.id_tag as id, tags.tag_text
				FROM list2tag
				INNER JOIN tags
				ON list2tag.id_tag = tags.id_tag
				WHERE list2tag.id_list = :id";
		try{
			$query = $this->db->prepare($sql);
			$query->execute(array(':id' => $list->getId()));
		}catch (PDOException $e) {
			return $e->getMessage();
		}
		$tags = $query->fetchAll(PDO::FETCH_CLASS, "Tag");
		$list->setMainTags($tags);
	}

/*
	function getTags($id){
		$sql = "SELECT tag_text
				FROM entry2tag
				INNER JOIN tags
				ON entry2tag.id_tag = tags.id_tag
				WHERE entry2tag.id_entry = :id";
		
		try{
			$query = $this->db->prepare($sql);
			$query->execute(array(':id' => $id));
		}catch (PDOException $e) {
			return $e->getMessage();
		}
		$content = $query->fetchAll(PDO::FETCH_COLUMN, 0);
		return $content;
	}
*/
	
	private function update($entry){
		$sql = "UPDATE entrylist
				SET title = :title, col = :col, rank = :rank
				WHERE id_list = :id_list";
		try{
			$query = parent::prepare($sql);
			$query->execute(array(':id_list' => $id_list,
								  ':title' => $list->getTitle(),
								  ':col' => $list->getCol(),
								  ':rank' => $list->getRank()));
		}catch (PDOException $e) {
		    return $e->getMessage();
		}
	}

	
	private function insert($list){
		$sql = "INSERT INTO entrylist (title, col, rank) 
				VALUES (:title, :col, :rank)";
		try{
			$query = parent::prepare($sql);
			$query->execute(array(':title' => $list->getTitle(),
								  ':col' => $list->getCol(),
								  ':rank' => $list->getRank()));
		}catch (PDOException $e) {
		    return $e->getMessage();
		}
		$id = $this->db->lastInsertId();
		$list->setId($id);
	}	

/*	
	function addTagToEntry($id_entry, $tag_text){
		$tagDAO = new TagDAO($this->db);
		$tag = $tagDAO->getByTagText($tag_text);

		// Create tag if it doesn't exist
		if (!$tag){
			$tag = new Tag(0, $tag_text);
			$tagDAO->save($tag);
		}
		$this->attachTagToEntry($id_entry, $tag->getId());
	}	
*/
/*	
	function attachTagToEntry($id_entry, $id_tag){
		$sql = "INSERT INTO entry2tag (id_entry, id_tag)
				VALUES (:id_entry, :id_tag)";
		try{
			$query = $this->db->prepare($sql);
			$query->execute(array(':id_entry' => $id_entry,
								  ':id_tag' => $id_tag));
		}catch (PDOException $e) {
			return $e->getMessage();
		}		
	}
*/	
}
?>