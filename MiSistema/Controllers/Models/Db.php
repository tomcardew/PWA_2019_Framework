<?php

class Db{

    //Clase de conexión, debe contener únicamente lo necesario para conectarse y cerrar la conexión
    //a la base de datos

    protected static $dbs = "";
    protected static $server = "";
    protected static $dbname = "";
    protected static $user = "";
    protected static $pass = "";

    public function __construct() {
        $this->set_up_connection();
    }
    
    private function set_up_connection(){
        //Read external settings json file
        $string = file_get_contents('/../../settings.json', true);
        //Create json iterator
        $jsonIterator = new RecursiveIteratorIterator(new RecursiveArrayIterator(json_decode($string, TRUE)), RecursiveIteratorIterator::SELF_FIRST);
        //Read iterator for each key found
        foreach($jsonIterator as $key => $val ) {
            if(is_array($val)) {
                //to-do as we find new arrays
                $this->db = $key;
            }else{
                //to-do as we find final values
                if($key == "name"){
                    $this->dbname = $val;
                }else if($key == "user"){
                    $this->user = $val;
                }else if($key == "pass"){
                    $this->pass = $val;
                }else{
                    $this->server = $val;
                }
            }
        }
    }

    public function connect(){
        $this->pass = "";
        $conn = new mysqli($this->server, $this->user, $this->pass);
        if($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        return $conn;
    }
}

?>