<?php

if(isset($argv[1])){
	if($argv[1] == "database"){
        echo "Database setup started...\n";
        if(isset($argv[2])){
            echo "\n\nCreating " . $argv[2] . " database...";
            create_database($argv[2]);
            echo "\n\nInsert number of tables: ";
            $ntablas = stream_get_line(STDIN, 1024, PHP_EOL);
            for($i=0; $i<$ntablas; $i++){
                create_table($i+1, $argv[2]);
            }
        }else{
            echo "You must set db name";
        }
	}
}

function create_database($db_name){
    //Database manager settings
    $user = "root";
    $pass = "";
    $server = "localhost";
    // Create connection
    $conn = new mysqli($server, $user, $pass);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 
    
    // Create database
    $sql = "CREATE DATABASE $db_name";
    if ($conn->query($sql) === TRUE) {
        echo "Database created successfully";
    } else {
        echo "Error creating database: " . $conn->error;
    }
    
    $conn->close();
}

function create_table($nt, $db_name){
    //Database manager settings
    $user = "root";
    $pass = "";
    $server = "localhost";
    echo "\n\nInsert name of table #$nt: ";
    $name = stream_get_line(STDIN, 1024, PHP_EOL);
    echo "\nInsert number of columns: ";
    $ncol = stream_get_line(STDIN, 1024, PHP_EOL);
    $columns = array();
    for($i=1; $i<($ncol+1); $i++){
        echo "\n\nInsert name of column #$i: ";
        $nc = stream_get_line(STDIN, 1024, PHP_EOL);
        echo "Insert type ([0]: Integer, [1]: Text): ";
        $type = stream_get_line(STDIN, 1024, PHP_EOL);
        if($type==0){
            $type = "int";
        }else if($type==1){
            $type = "text";
        }
        array_push($columns, array($nc, $type));
    }
    // Create connection
    $conn = new mysqli($server, $user, $pass, $db_name);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 

    // sql to create table
    $sql = "CREATE TABLE $name (";
    // creating columns dinamically
    for($i=0; $i<count($columns); $i++){
        if($i==(count($columns) - 1)){
            $sql = $sql . $columns[$i][0] . " " . $columns[$i][1] . ")";
        }else{
            $sql = $sql . $columns[$i][0] . " " . $columns[$i][1] . ", ";
        }
    }

    if ($conn->query($sql) === TRUE) {
        echo "\nTable $name created successfully";
    } else {
        echo "\nError creating table: " . $conn->error;
    }

    $conn->close();
}

?>