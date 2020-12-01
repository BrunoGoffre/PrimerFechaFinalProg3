<?php

class Asignacion{
    public $_legajoProfesor;
    public $_idMateria;
    public $_turno;

    function __construct($legajoProfesor,$idMateria,$turno){
        $this->_legajoProfesor = $legajoProfesor;
        $this->_idMateria = $idMateria;
        $this->_turno = $turno;
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
        return "legajoProfesor: " . $this->_legajoProfesor . "<br>Tipo: " . $this->_idMateria . "<br>turno: " . $this->_turno . "<br><br>";
    }
}