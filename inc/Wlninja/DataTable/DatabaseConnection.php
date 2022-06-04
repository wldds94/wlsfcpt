<?php
namespace Wlninja\DataTable;

use \PDO;

class DatabaseConnection
{	
	//private $connection;
	private $host;
	private $dbname;
	private $dbcharset;
	private $dbuser;
	private $password;

	public function __construct()
	{
		require_once(ABSPATH . 'wp-config.php');
		$this->host = DB_HOST;
		$this->dbname = DB_NAME;
		$this->dbcharset = DB_CHARSET;
		$this->dbuser = DB_USER;
		$this->password = DB_PASSWORD;
		//$this->connection = setConnection();
	}

	private function setConnection()
	{
		$host_string = 'mysql:host=' . $this->host . ';dbname='. $this->dbname .';charset='. $this->dbcharset;
		$pdo = new \PDO($host_string, $this->dbuser, $this->password);
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		return $pdo;
	}

	public function getConnection()
	{
		return $this->setConnection();
	}

}