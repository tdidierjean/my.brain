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
	
	function getUser($username) {
		$sql = "SELECT password
    			FROM user
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
	
	function lastInsertId() {
		try{
			$result = PDO::lastInsertId();			
		}catch (PDOException $e) {
			return $e->getMessage();
		}			
		return $result;
	}
}	