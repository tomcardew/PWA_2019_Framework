<?php

if(isset($argv[1])){ //Checo que el php se llame con php creator.php database $nombre
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
    }else if ($argv[1] == "view"){ //Checo que el php se llame php creator.php view $nombre
        echo "Creating view...\n";
        create_view($argv[2]);
        echo "View created\n";
    }
}

function create_view($view_name){
    //View file creation
    echo "\n\nInsert name of the view: ";
    $vname = stream_get_line(STDIN, 1024, PHP_EOL);
    $file = fopen("Resources/Views/$view_name.php", "w") or die("Unable to create file");
    $content =
    "<!DOCTYPE html>
    <html>
    <head>
        <title>$vname</title>
        <style>
            <?php include_once '/../Styles/bootstrap.min.css' ?>
            <?php include_once '/../Styles/style.css' ?>
        </style>
    </head>
    <body>
        <div class='row'>
            <div class='col-sm d-flex justify-content-center'>
                <h1>Bienvenido a la vista $vname</h1>
            </div>
        </div>
    </body>
    <script>
	    <?php include_once '/../Scripts/bootstrap.min.js' ?>
    </script>
    </html>";
    fwrite($file, $content);
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
    $sql = "CREATE TABLE IF NOT EXISTS $name (";
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

    //Table file creation
    $file = fopen("Controllers/Models/$name.php", "w") or die("Unable to create file");
    $content = "<?php\nrequire 'Db_table.php';\n\nclass $name extends Db_table{\n"; /*\n}\n?>*/
    for($i=0; $i<count($columns); $i++){
        $type = "0";
        if($columns[$i][1] == "text"){
            $type = "\"\"";
        }
        $content = $content . "\tpublic $" . $columns[$i][0] . " = $type;\n";
    }
    $columns_array = "";
    for($i=0; $i<count($columns); $i++){
        if($i==count($columns)-1){  
            $columns_array .= "'" . $columns[$i][0] . "'";
        }else{
            $columns_array .= "'" . $columns[$i][0] . "', ";
        }
    }
    $content = $content . "\n\tpublic function __construct(){\n\t\t\$this->table = \"$name\";\n\t\t\$this->dbname = \"$db_name\";\n\t\t\$this->columns=[$columns_array];\n\t}\n}\n?>";
    fwrite($file, $content);
}

?>