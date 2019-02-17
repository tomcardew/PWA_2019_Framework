<?php

require 'Main.php';
require 'Models/Model.php';

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