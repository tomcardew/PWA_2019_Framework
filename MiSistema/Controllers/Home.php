<?php

require 'Main.php';
require 'Models/Db.php';

class Home extends Main {
	
	public function __construct() {
		// Code
	}

	public function load() {
		$obj = new Db();
		$this->loadView('main');
	}

}

?>