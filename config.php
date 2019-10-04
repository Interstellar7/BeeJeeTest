<?php
class Config {
	public $records_per_page = 3;
	public $link;
	public $tablename='tasks';
	private $hostname='localhost';
	private $username='databaseAdm';
	private $password='Ljjhg^841%qqlx';
    private $dbname='interstellar';	
	private $admin_login = 'admin';
	private $admin_password = '202cb962ac59075b964b07152d234b70';

	function check_authorization($login, $password_md5) {
		$check = false;
		if (($login == $this->admin_login) && ($password_md5 == $this->admin_password)) $check = true;
		return $check;
	}

	function __construct() {
		// connecting to database
		$this->link = mysqli_connect($this->hostname, $this->username, $this->password, $this->dbname);
		if (!$this->link) die("Connection failed: " . mysqli_connect_error());
		else mysqli_set_charset($link, "utf8");	
	}
}
?>