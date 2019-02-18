<?php

include 'Prueba.php';

class Controller{
    function insertar(){
        $prueba = new Prueba();
        $res = $prueba->select();

        return load('views/main.php', $res);
    }
}

?>