<?php

require 'Main.php';
// require 'Models/Db.php';
require 'Models/Table.php';

class Home extends Main {
	
	public function __construct() {
		// Code
	}

	public function load() {
		$this->loadView('main');
	}

}

?>