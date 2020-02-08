<?php
require_once("config.php");
class np_bdd{
	private $_dns;
	private $_user;
	private $_password;
	protected $_db;

	public function __construct()
	{
		try{
			$this->_dns = NP__DNS;
			$this->_user = NP__USER;
			$this->_password = NP__PSW;

			$this->_db = new PDO($this->_dns, $this->_user, $this->_password);
		}catch (PDOException $e) {
	        throw new Exception("Connection failed: " . $e->getMessage());
		}
		date_default_timezone_set('America/Mexico_City');
	}
}