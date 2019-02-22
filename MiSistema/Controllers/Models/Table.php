<?php

require 'Db.php';

class Table extends Db{

    //Debo especificar nombre de la tabla, array de columnas y funciones para las operaciones
    //SCRUD y estas deben ser genéricas
    private $conn = null;

    protected $table = "tabla"; //Table name
    protected $columns; //Columns array

    function __construct(){
        parent::__construct();
    }

    public function select(){
        $conn = $this->connect();
        $qry = "SELECT *  FROM $this->table";
        $result = $conn->query($qry);
        $conn->close();
        return $result;
    }

    public function selectColumns($columns, $condition){
        $conn = $this->connect();
        $qry = "SELECT ";
        for($i=0; $i<sizeof($columns); $i++){
            if($i == (sizeof($columns)-1)){
                $qry .= $columns[$i];
            }else{
                $qry .= $columns[$i] . ", ";
            }
        }
        $qry = $qry . " FROM $this->table WHERE $condition";
        $result = $conn->query($qry);
        $conn->close();
        return $result;
    }

    public function insertInto($data){ //Array with values to insert
        $conn = $this->connect();
        $qry = "INSERT INTO $this->table VALUES(";
        for($i=0; $i<sizeof($data); $i++){
            if($i == (sizeof($data)-1)){
                $qry .= $data[$i] . ")";
            }else{
                $qry .= $data[$i] . ", ";
            }
        }
        if ($conn->query($qry) === TRUE) {
            $conn->close();
            return true;
        } else {
            $conn->close();
            return false;
        }
    }

    public function deleteWhere($condition){ //String with condition, example: 'id = 2'
        $conn = $this->connect();
        $qry = "DELETE FROM $this->table WHERE $condition";
        if ($conn->query($qry) === TRUE) {
            $conn->close();
            return true;
        } else {
            $conn->close();
            return false;
        }
    }

    public function updateWhere($set, $condition){ //Example: "lastname='Jim'","id=2"
        $conn = $this->connect();
        $qry = "UPDATE $this->table SET $set WHERE $condition";
        if ($conn->query($qry) === TRUE) {
            $conn->close();
            return true;
        } else {
            $conn->close();
            return false;
        }
    }

}

?>