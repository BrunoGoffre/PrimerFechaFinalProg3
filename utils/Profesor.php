<?php

class Profesor{
    public $_nombre;
    public $_legajo;

    function __construct($nombre,$legajo){
        $this->_nombre = $nombre;
        $this->_legajo = $legajo;
    }
    public function __get($name)
    {
        return $this->$name; 
    }

    public function __set($name, $value)
    {
        $this->$name = $value;
    }
    
    public function __toString()
    {
        return "nombre: " . $this->_nombre . "<br>Tipo: " . $this->_legajo . "<br><br>";
    }
}