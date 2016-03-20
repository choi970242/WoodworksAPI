<?php

class DBHelper{
	
	protected $db;
	
	public function DBHelper(){
		include 'cfg.php';
		$this->db = new PDO($host,$username,$password);
		$this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}
	
	public function getInstance(){
		return $this->db;
		//return 'corn';
	}
}

?>