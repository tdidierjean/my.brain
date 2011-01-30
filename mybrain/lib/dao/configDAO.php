<?php
require_once(ROOT."/lib/model/config.php");

class ConfigDAO{
	private $db;

	function __construct($db){
	    $this->db = $db;
	}
	
	/**
	 * Return a Config object filled with data from the database
	 * @return Config
	 */
	function get(){
		$sql = "SELECT default_search, last_search
				FROM config";
		try{
			$query = $this->db->prepare($sql);
			$query->execute();
		}catch (PDOException $e) {
			return $e->getMessage();
		}
		
		$query->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, "Config");
		$config = $query->fetch();
		return $config;
	}

	function save($config){
		$this->update($config);
	}
	
	private function update($config){
		$sql = "UPDATE config
				SET default_search = :default_search, last_search = :last_search";
		try{
			$query = $this->db->prepare($sql);
			$query->execute(array(':default_search' => $config->getDefaultSearch(),
								  ':last_search' => $config->getLastSearch()));
		}catch (PDOException $e) {
		    return $e->getMessage();
		}
	}
}