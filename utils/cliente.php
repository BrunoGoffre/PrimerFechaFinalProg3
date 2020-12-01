<?php

class Cliente{
    public $_email;
    public $_password;
    public $_foto;

    function __construct($email,$password,$foto){
        $this->_email = $email;
        $this->_password = $password;
        $this->_foto = $foto;
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
        return "Email: " . $this->_email . "<br>Tipo: " . $this->_password . "<br>Foto: " . $this->_foto . "<br><br>";
    }
}