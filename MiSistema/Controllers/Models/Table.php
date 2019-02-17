<?php

abstract class Table extends Db{

    protected $sql = "";

    public function __construct(){
        create_table();
    }

    protected function create_table(){
        // Create connection
        $conn = new mysqli("localhost", "root", "", $this->dbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        if ($conn->query($this->sql) === TRUE) {
            echo "\nTable $name created successfully";
        } else {
            echo "\nError creating table: " . $conn->error;
        }

        $conn->close();
    }

}

?>