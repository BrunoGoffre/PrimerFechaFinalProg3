<?php

class materia
{
    public $_id;
    public $_nombre;
    public $_cuatrimestre;

    function __construct($id, $nombre, $cuatrimestre)
    {
        $this->_id = $id;
        $this->_nombre = $nombre;
        $this->_cuatrimestre = $cuatrimestre;
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
        return "id: " . $this->_id . "Nombre: " . $this->_nombre . "<br>Tipo: " . $this->_cuatrimestre;
    }

    public static function generarId($lista)
    {
        $i = 0;
        if (isset($lista)) {

            foreach ($lista as $a) {
                if ($a->_id > $i) {
                    $i = $a->_id;
                }
            }
            return $i+1;
        }else{
            return $i;
        }

    }
}
