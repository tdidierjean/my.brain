<?php
require_once(ROOT."/lib/model/entryList.php");
require_once(ROOT."/lib/dao/tagDAO.php");

class EntryListDAO{
	private $db;

	function __construct($db){
	    $this->db = $db;
	}
	
	/**
	* Link a tag to an entry list
	*/
	private function linkTagToEntryList($list, $tag){
		$sql = "INSERT INTO list2tag (id_list, id_tag)
				VALUES (:id_list, :id_tag)";
		try{
			$query = $this->db->prepare($sql);
			$query->execute(array(':id_list' => $list->getId(),
								  ':id_tag' => $tag->getId()));
		}catch (PDOException $e) {
			return $e->getMessage();
		}		
	}	
	
	private function insertTag($tag){
		$tagDAO = new TagDAO($this->db);
		$tagDAO->attach($tag);

		// Insert tag if it doesn't exist in db
		if (!$tag->getId()){
			$tagDAO->save($tag);
		}
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
		$query->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, "EntryList");
		$list = $query->fetch();

		$this->getMainTags($list);	
		
		return $list;
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

		// FETCH_PROPS_LATE => makes sure the class constructor is called before
		// the object variables are filled with data from db 
		$lists = $query->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, "EntryList");

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
		$tags = $query->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, "Tag");
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
	
	private function update($list){
		$sql = "UPDATE entrylist
				SET title = :title, col = :col, rank = :rank, collapsed = :collapsed
				WHERE id_list = :id_list";
		try{
			$query = $this->db->prepare($sql);
			$query->execute(array(':id_list' => $list->getId(),
								  ':title' => $list->getTitle(),
								  ':col' => $list->getCol(),
								  ':rank' => $list->getRank(),
								  ':collapsed' => $list->getCollapsed()));
		}catch (PDOException $e) {
		    return $e->getMessage();
		}
		$this->updateTagLinks($list);
	}

	/*
	 * Create or remove links to tag in db for a modified list 
	 */
	function updateTagLinks($list){
		$sql = "SELECT tags.id_tag as id, tags.tag_text
				FROM list2tag, tags 
				WHERE list2tag.id_list = :id
				AND list2tag.id_tag = tags.id_tag";

		try{
			$query = $this->db->prepare($sql);
			$query->execute(array(':id' => $list->getId()));
		}catch (PDOException $e) {
			return $e->getMessage();
		}			
		
		$old_tags = $query->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, "Tag");
		$new_tags = $list->getMainTags();
		
		$tags_to_delete = array();
		$tags_to_create = array();
		
		foreach ($old_tags as $old_tag){
			$delete = True;
			foreach ($new_tags as $new_tag){
				if ($old_tag->getTagText() == $new_tag->getTagText()){
					$delete = False;
					break;
				}
			}
			if ($delete === True){
				$tags_to_delete[] = $old_tag;
			}
		}

		foreach ($new_tags as $new_tag){
			$delete = True;
			foreach ($old_tags as $old_tag){
				if ($new_tag->getTagText() == $old_tag->getTagText()){
					$delete = False;
					break;
				}
			}
			if ($delete === True){
				$tags_to_create[] = $new_tag;
			}
		}	
		
		// if link is in db but not in object -> delete link in db
		if ($tags_to_delete){
			$this->deleteTagLinks($list, $tags_to_delete);
		}
		// if link is in object but not in db -> create link in db
		if ($tags_to_create){
			$this->createTagLinks($list, $tags_to_create);
		}
	}

	function deleteTagLinks($list, $tags){
		
		$sql = "DELETE list2tag 
				FROM list2tag, tags 
				WHERE id_list = :id_list
				AND tags.tag_text = :tag_text
				AND list2tag.id_tag = tags.id_tag";
		try{
			$query = $this->db->prepare($sql);
			foreach ($tags as $tag){
				$query->execute(array(':id_list' => $list->getId(),
									  ':tag_text' => $tag->getTagText()));
			}						 
		}catch (PDOException $e) {
			return $e->getMessage();
		}			
	}
	
	/*
	 * Link a list and an array of tags in db, after creating the tags if needed.
	 */
	function createTagLinks($list, $tags){

		foreach ($tags as $tag){
			$this->insertTag($tag);
			$this->linkTagToEntryList($list, $tag);
		}
	}
	
	private function insert($list){
		$sql = "INSERT INTO entrylist (title, col, rank) 
				VALUES (:title, :col, :rank)";
		try{
			$query = $this->db->prepare($sql);
			$query->execute(array(':title' => $list->getTitle(),
								  ':col' => $list->getCol(),
								  ':rank' => $list->getRank()));
		}catch (PDOException $e) {
		    return $e->getMessage();
		}
		$id = $this->db->lastInsertId();
		$list->setId($id);
		
		foreach($list->getMainTags() as $tag){
			$this->insertTag($tag);
			$this->linkTagToEntryList($list, $tag);
		}
	}	

/*	
	function addTagToEntry($id_entry, $tag_text){
		$tagDAO = new TagDAO($this->db);
		$tag = $tagDAO->attach($tag_text);

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