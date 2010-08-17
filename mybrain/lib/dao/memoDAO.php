<?php
require_once(ROOT."/lib/model/memo.php");

class MemoDAO{
	private $db;

	function __construct($db){
	    $this->db = $db;
	}

	function get(){
		$sql = "SELECT content, update_date
				FROM memo";
		try{
			$query = $this->db->prepare($sql);
			$query->execute();
		}catch (PDOException $e) {
			return $e->getMessage();
		}
		$query->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, "Memo");
		$memo = $query->fetch();
		return $memo;
	}
	
	function save($memo){

		$this->update($memo);
	}
	
	/**
	* Write new memo to DB
	*/
	function update($memo){
		$sql = "UPDATE memo 
				SET content = :content, update_date=NOW()";
		try{
			$query = $this->db->prepare($sql);
			$query->execute(array(':content' => $memo->getContent()));
		}catch (PDOException $e) {
			return $e->getMessage();
		}
	}
}