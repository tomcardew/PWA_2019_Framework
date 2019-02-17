<?php

class Db{

    protected $db = "";
    protected $server = "";
    protected $dbname = "";
    protected $user = "";
    protected $pass = "";

    private $conn = NULL;

    public $table = "";

    public function __construct() {
        $this->set_up_connection();
        echo "Db class";
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
        if($this->db == "mysql"){
            $this->conn = new mysqli($this->server, $this->user, $this->pass);
            if($this->conn->connect_error) {
                die("Connection failed: " . $this->conn->connect_error);
            }
        }
    }

    //Close connections stablished between database and application
    public function close_connection(){
        $this->conn->close();
    }

    public function select_from_table($table, $columns, $conditions){
        $col = "";
        if(sizeof($columns)==0){
            $col = "*";
        }else{
            foreach($columns as &$value){
                if($col == ""){
                    $col = $value;
                }else{
                    $col = $col . ", " . $value;
                }
            }
        }
        $qry = "";
        if($conditions == null){
            $qry = "SELECT $col FROM $table";
        }else{
            $qry = "SELECT $col FROM $table WHERE $conditions";
        }
        // Get results
        $result = $this->conn->query($qry);
        if($result->num_rows > 0){
            return $result;
        }else{
            return null;
        }
    }

    public function insert_into(){

    }

    public function delete_where(){

    }

    public function update_where(){
        
    }

}

?>