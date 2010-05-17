<?php
/**
* This class manages the connection to the database and regroups all the queries
*/
class Database extends PDO{
	/* 
	 * Singleton 
	 */
	static $instance;
	
	private $dbType;
	private $db;
	private $host;
	private $user;
	private $passwd;
	
	function __construct($options){
		if (!empty(self::$instance)) {
			return $instance;
		}
	    foreach($options as $parameter=>$value){
            $this->{$parameter}=$value;
        }
		$dsn = $this->dbType.':host='.$this->host.';dbname='.$this->db;
		try{
		    parent::__construct($dsn, $this->user, $this->passwd);
		}catch (PDOException $e) {
			return $e->getMessage();
		}
		// Raise fatal error if there's a problem with the db
		PDO::setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}

	/*
	 * Return a connection instance after creating it if needed.
	 */
	static function getInstance($options=array()) {
        if (empty(self::$instance)) {
			if (empty($options)) throw new Exception('No parameters');
        	self::$instance = new Database($options);
       }
      return self::$instance;
   }
   
	/**
	* Get memo from DB
	*/
	function getMemo(){
		$sql = "SELECT content, update_date
				FROM memo";
		try{
			$query = parent::prepare($sql);
			$query->execute();
		}catch (PDOException $e) {
			return $e->getMessage();
		}
		$content = $query->fetch();
		return $content;
	}
	
	/**
	* Write new memo to DB
	*/
	function setMemo($memo){
		$sql = "UPDATE memo 
				SET content = :memo";
		try{
			$query = parent::prepare($sql);
			$query->execute(array(':memo' => $memo));
		}catch (PDOException $e) {
			return $e->getMessage();
		}
	}
	
	/**
	* return an array of EntryLists: [0=> [0=>id1, 1=>title1], 1=> ...]
	*/
	function getEntryLists(){
		$sql = "SELECT id_list, title, col, rank, collapsed
				FROM entrylist
				ORDER BY col, rank";
		try{
			$query = parent::prepare($sql);
			$query->execute();
		}catch (PDOException $e) {
			return $e->getMessage();
		}
		$content = $query->fetchAll();
		return $content;
	}	
	
	/**
	* return an array: [0=>[firstrow.content], 1=>[secondrow.content], ...]
	*/
	function getEntries($id_list){
		$sql = "SELECT id_entry, name, url, details 
				FROM entry 
				WHERE entry.id_list = :id_list";
		try{
			$query = parent::prepare($sql);
			$query->execute(array(':id_list' => $id_list));
		}catch (PDOException $e) {
			return $e->getMessage();
		}
		$content = $query->fetchAll();
		return $content;
	}

	/**
	* return an entry
	*/
	function getEntry($id_entry){
		$sql = "SELECT id_entry, name, url, details, creation_date, update_date
				FROM entry 
				WHERE id_entry = :id_entry";
		try{
			$query = parent::prepare($sql);
			$query->execute(array(':id_entry' => $id_entry));
		}catch (PDOException $e) {
			return $e->getMessage();
		}
		$content = $query->fetch();
		return $content;
	}	
	
	function getUser($username) {
		$sql = "SELECT password
    			FROM member
      			WHERE username = :username";
		try{
			$query = parent::prepare($sql);
			$query->execute(array(':username' => $username));
		}catch (PDOException $e) {
			return $e->getMessage();
		}	
		$content = $query->fetch();
		return $content;
	}
	
	function existsUser() {
		$sql = "SELECT username from user";
		try{
			$query = parent::prepare($sql);
			$query->execute();
		}catch (PDOException $e) {
			return $e->getMessage();
		}	
		$content = $query->fetch();
		return $content;		
	}
	
	function createNewUser($username, $password){
		$sql = "INSERT INTO user (username, password) 
				VALUES (:username, :password)";
		try{
			$query = parent::prepare($sql);
			$query->execute(array(':username' => $username,
								  ':password' => $password));
		}catch (PDOException $e) {
			return $e->getMessage();
		}		
	}
	
	function setNewEntry($id_list, $name, $url, $details){
		$sql = "INSERT INTO entry (id_list, name, url, details, creation_date) 
				VALUES (:id_list, :name, :url, :details, NOW())";
		try{
			$query = parent::prepare($sql);
			$query->execute(array(':id_list' => $id_list,
								  ':name' => $name,
								  ':url' => $url,
								  ':details' => $details));
		}catch (PDOException $e) {
			return $e->getMessage();
		}
	}	
	
	function lastInsertId() {
		try{
			$result = PDO::lastInsertId();			
		}catch (PDOException $e) {
			return $e->getMessage();
		}			
		return $result;
	}

	function updateEntry($id_entry, $name, $url, $details){
		$sql = "UPDATE entry
				SET name = :name, url = :url, details = :details, update_date = NOW()
				WHERE id_entry = :id_entry";
		try{
			$query = parent::prepare($sql);
			$query->execute(array(':id_entry' => $id_entry,
								  ':name' => $name,
								  ':url' => $url,
								  ':details' => $details));
		}catch (PDOException $e) {
		    return $e->getMessage();
		}
	}	
	
	function getEntryTags($id_entry){
		$sql = "SELECT tag_text
				FROM entry2tag
				INNER JOIN tags
				ON entry2tag.id_tag = tags.id_tag
				WHERE entry2tag.id_entry = :id_entry";
		
		try{
			$query = parent::prepare($sql);
			$query->execute(array(':id_entry' => $id_entry));
		}catch (PDOException $e) {
			return $e->getMessage();
		}
		$content = $query->fetchAll(PDO::FETCH_COLUMN, 0);
		return $content;
	}
	
	function addTagToEntry($id_entry, $tag_text){
		$tag_text = strtolower($tag_text);
		/*$sql = "SELECT id_tag, tag_text
				FROM tags
				WHERE tag_text = :tag_text";
		try{
			$query = parent::prepare($sql);
			$query->execute(array(':tag_text' => $tag_text));
		}catch (PDOException $e) {
			return $e->getMessage();
		}	*/
		$id_tag = $this->getTagId($tag_text);
		if (!$id_tag){
			$this->createTag($tag_text);
			$id_tag = $this->getTagId($tag_text);
		}
		$this->attachTagToEntry($id_entry, $id_tag);
	}	
	
	function createTag($tag_text){
		$tag_text = strtolower($tag_text);
		$sql = "INSERT INTO tags (tag_text)
				VALUES (:tag_text)";
		try{
			$query = parent::prepare($sql);
			$query->execute(array(':tag_text' => $tag_text));
		}catch (PDOException $e) {
			return $e->getMessage();
		}		
	}	
	
	function attachTagToEntry($id_entry, $id_tag){
		$sql = "INSERT INTO entry2tag (id_entry, id_tag)
				VALUES (:id_entry, :id_tag)";
		try{
			$query = parent::prepare($sql);
			$query->execute(array(':id_entry' => $id_entry,
								  ':id_tag' => $id_tag));
		}catch (PDOException $e) {
			return $e->getMessage();
		}		
	}
	
	function getTagId($tag_text){
		$tag_text = strtolower($tag_text);
		$sql = "SELECT id_tag 
				FROM tags 
				WHERE tag_text = :tag_text";
		try{
			$query = parent::prepare($sql);
			$query->execute(array(':tag_text' => $tag_text));
		}catch (PDOException $e) {
			return $e->getMessage();
		}
		$tag = $query->fetch();
		return $tag['id_tag'];
	}
	
	/**
	 * Delete an entry and any link to tags it may have
	 * 
	 * @param $id_entry
	 * @return unknown_type
	 */
	function removeEntry($id_entry){
		$sql = "DELETE entry, entry2tag 
				FROM entry
				LEFT JOIN entry2tag 
				ON entry2tag.id_entry = entry.id_entry
				WHERE entry.id_entry= :id_entry";
		try{
			$query = parent::prepare($sql);
			$query->execute(array(':id_entry' => $id_entry));
		}catch (PDOException $e) {
			return $e->getMessage();
		}			
	}		
	/**
	* Remove the link between a tag and an entry
	*/
	function removeTagFromEntry($id_entry, $tag_text){
		$sql = "DELETE entry2tag 
				FROM entry2tag, tags 
				WHERE id_entry = :id_entry
				AND tags.tag_text = :tag_text
				AND entry2tag.id_tag = tags.id_tag";
		try{
			$query = parent::prepare($sql);
			$query->execute(array(':id_entry' => $id_entry,
								  ':tag_text' => $tag_text));
		}catch (PDOException $e) {
			return $e->getMessage();
		}			
	}
	/**
	* Get 
	*/
	function getEntryList($id_list){
		$sql = "SELECT entrylist.id_list, entrylist.title, entrylist.col, entrylist.rank 
				FROM entrylist
				WHERE id_list = :id_list";
		try{
			$query = parent::prepare($sql);
			$query->execute(array(':id_list' => $id_list));
		}catch (PDOException $e) {
			return $e->getMessage();
		}
		$content = $query->fetch();
		return $content;
	}
	
	/**
	* Update the content of an entry list
	*/
	function updateEntryList($id_list, $title, $col, $rank){
		$sql = "UPDATE entrylist
				SET title = :title, col = :col, rank = :rank
				WHERE id_list = :id_list";
		try{
			$query = parent::prepare($sql);
			$query->execute(array(':id_list' => $id_list,
								  ':title' => $title,
								  ':col' => $col,
								  ':rank' => $rank));
		}catch (PDOException $e) {
		    return $e->getMessage();
		}
	}	

	/**
	* Get all entries which share at least one tag with the given list
	*/
	function getListTaggedEntries($id_list){
		$sql = "SELECT entry.id_entry, entry.name, entry.url, entry.details
				FROM entry 
				JOIN entry2tag ON entry2tag.id_entry = entry.id_entry
				JOIN list2tag ON list2tag.id_list = :id_list
				WHERE entry2tag.id_tag = list2tag.id_tag";

		try{
			$query = parent::prepare($sql);
			$query->execute(array(':id_list' => $id_list));
		}catch (PDOException $e) {
			return $e->getMessage();
		}
		$content = $query->fetchAll(PDO::FETCH_ASSOC);
		return $content;
	}
	
	/**
	* Get all tags in db
	*/
	function getAllTags(){
		$sql = "SELECT id_tag, tag_text
				FROM tags";
		try{
			$query = parent::prepare($sql);
			$query->execute();
		}catch (PDOException $e) {
			return $e->getMessage();
		}
		$content = $query->fetchAll(PDO::FETCH_ASSOC);
		return $content;
	}
	
	/**
	* Get the tags linked to an entry list
	*/
	function getEntryListTags($id_list){
		$sql = "SELECT tag_text
				FROM list2tag
				INNER JOIN tags
				ON list2tag.id_tag = tags.id_tag
				WHERE list2tag.id_list = :id_list";
		try{
			$query = parent::prepare($sql);
			$query->execute(array(":id_list" => $id_list));
		}catch (PDOException $e) {
			return $e->getMessage();
		}
		$content = $query->fetchAll(PDO::FETCH_COLUMN, 0);
		return $content;
	}	

	/**
	* Link a tag to an entry_list, after creating the tag if necessary
	*/
	function addTagToEntryList($id_list, $tag_text){
		$id_tag = $this->getTagId($tag_text);
		if (!$id_tag){
			$this->createTag($tag_text);
			$id_tag = $this->getTagId($tag_text);
		}
		$this->attachTagToEntryList($id_list, $id_tag);
	}	

	/**
	* Link a tag to an entry
	*/
	function attachTagToEntryList($id_list, $id_tag){
		$sql = "INSERT INTO list2tag (id_list, id_tag)
				VALUES (:id_list, :id_tag)";
		try{
			$query = parent::prepare($sql);
			$query->execute(array(':id_list' => $id_list,
								  ':id_tag' => $id_tag));
		}catch (PDOException $e) {
			return $e->getMessage();
		}		
	}
	
	/**
	* Remove the link between a tag and an entry list
	*/
	function removeTagFromEntryList($id_list, $tag_text){
		$sql = "DELETE list2tag 
				FROM list2tag, tags 
				WHERE id_list = :id_list
				AND tags.tag_text = :tag_text
				AND list2tag.id_tag = tags.id_tag";
		try{
			$query = parent::prepare($sql);
			$query->execute(array(':id_list' => $id_list,
								  ':tag_text' => $tag_text));
		}catch (PDOException $e) {
			return $e->getMessage();
		}			
	}
	
	/**
	* Get all the entries for which none of their tags are linked to an entry list
	*/
	function getEntriesNotDisplayed(){
		$sql = "SELECT DISTINCT entry.id_entry, entry.name, entry.url, entry.details
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
			$query = parent::prepare($sql);
			$query->execute();
		}catch (PDOException $e) {
			return $e->getMessage();
		}
		$content = $query->fetchAll(PDO::FETCH_ASSOC);
		return $content;	
	}

	/**
	* Create an entry list
	*/
	function setNewEntryList($title, $col, $rank){
		$sql = "INSERT INTO entrylist (title, col, rank) 
				VALUES (:title, :col, :rank)";
		try{
			$query = parent::prepare($sql);
			$query->execute(array(':title' => $title,
								  ':col' => $col,
								  ':rank' => $rank));
		}catch (PDOException $e) {
			return $e->getMessage();
		}
	}	
	
	/**
	 * Update collapsed status of an entry list
	 * @param $id_list
	 * @param $collapsed
	 * @return unknown_type
	 */
	function updateEntryListCollapse($id_list, $collapsed){
		$sql = "UPDATE entrylist
				SET collapsed = :collapsed
				WHERE id_list = :id_list";
		try{
			$query = parent::prepare($sql);
			$query->execute(array(':id_list' => $id_list,
								  ':collapsed' => $collapsed));
		}catch (PDOException $e) {
		    return $e->getMessage();
		}
	}
}	