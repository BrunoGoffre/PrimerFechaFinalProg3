<?php

require_once "cliente.php";
require_once "materia.php";
require_once "profesor.php";
require_once "Token.php";
require_once "asignacion.php";





function jump($count = 1)
{
    $i = 0;
    while ($i <= $count) {
        echo "<br>";
        $i++;
    }
}

function extDeFile($file)
{
    $array = (explode('.', $file['name']));
    return array_pop($array);
}

function object_sorter($clave, $orden = null)
{
    return function ($a, $b) use ($clave, $orden) {
        $result =  ($orden == "DESC") ? strnatcmp($b->$clave, $a->$clave) :  strnatcmp($a->$clave, $b->$clave);
        return $result;
    };
}

function pathUsuario($method)
{
    if ($method == 'POST') {

        $email = $_POST['email'] ?? "Falta email";
        $clave = $_POST['password'] ?? "Falta password";
        $foto = $_FILES['imagen']['name'] ?? "";
        $ruta =  "users.xxx";


        if (!empty($foto)) {
            $fotoNew = Archivos::saveFile($_FILES['imagen'], "fotos", "jpg")[1];
        } else {
            $fotoNew = "Falta foto.";
        }
        $cliente = new Cliente($email, password_hash($clave, PASSWORD_DEFAULT), $fotoNew);
        echo $cliente;
        Archivos::guardarJson($ruta, $cliente);
    } else {
        echo "Metodo no permitido";
    }
}

function pathLogin($method)
{
    if ($method == 'POST') {

        $email = $_POST['email'] ?? "Error";
        $clave = $_POST['password'] ?? "Error";

        $ruta =  "users.xxx";
        $flag = false;

        $list = Archivos::obtenerJson($ruta);

        if (isset($list) > 0) {
            foreach ($list as $a) {
                if ($a->_email == $email && password_verify($clave, $a->_password)) {
                    echo "Login de " . $a->_email . " correcto.";
                    jump();

                    echo "Clave:<br>" . Token::GenerarToken($a->_email);
                    $flag = true;
                }
            }
            if (!$flag) {
                echo "No se encontro a nadie con el usuario y clave indicada.";
            }
        } else {
            echo "No se cargo nada.";
        }
    } else {
        echo "Metodo no permitido";
    }
}

function pathMateria($method){
    if ($method == 'POST') {
        $ruta =  "materias.xxx";
        $headers = getallheaders();
        $token = $headers['token'] ?? "";

        if (Token::autenticarToken($token, "", "Token incorrecto") == false) {
            return;
        }

        $nombre = $_POST['nombre'] ?? null;
        $cuatrimestre = $_POST['cuatrimestre'] ?? null;

        if ($nombre != null && $cuatrimestre != null){

            $list = Archivos::obtenerJson($ruta);
            
            $id = materia::generarId($list);
            $materia = new materia($id, $nombre, $cuatrimestre);
            echo $materia;
            Archivos::guardarJson($ruta, $materia);
        }else{
            echo "Error en los parametros";
        }
    } else if ($method == 'GET'){
        $ruta =  "materias.xxx";
        $headers = getallheaders();
        $token = $headers['token'] ?? "";

        if (Token::autenticarToken($token, "", "Token incorrecto") == false) {
            return;
        }
        $list = Archivos::obtenerJson($ruta);
        echo "Materias: <br><br>";
        foreach($list as $a)
        {
            echo $a->_nombre . "<br>" . $a->_cuatrimestre. "<br>";
            jump();
        }
    }
    else{
        echo "Metodo no permitido";
    }
}

function pathProfesor($method){
    $headers = getallheaders();
    $token = $headers['token'] ?? "";

    if ($method == 'POST') {
        $ruta =  "profesores.xxx";
        $flag = false;

        if (Token::autenticarToken($token, "", "Token incorrecto") == false) {
            return;
        }

        $nombre = $_POST['nombre'] ?? "Error";
        $legajo = $_POST['legajo'] ?? "Error";

        $list = Archivos::obtenerJson($ruta);
        if (isset($list)) {
            foreach ($list as $a) {
                if ($a->_legajo == $legajo) {
                    echo "Legajo cargado previamente.";
                    $flag = true;
                }
            }
        }
        if($flag == false){
            $profesor = new Profesor($nombre,$legajo);
            echo $profesor;
            Archivos::guardarJson($ruta, $profesor);
        }
    } else if ($method == 'GET') {
        $ruta =  "profesores.xxx";
        $headers = getallheaders();
        $token = $headers['token'] ?? "";

        if (Token::autenticarToken($token, "", "Token incorrecto") == false) {
            return;
        }
        $list = Archivos::obtenerJson($ruta);
        echo "Profesores: <br><br>";
        foreach($list as $a)
        {
            echo $a->_nombre . "<br>" . $a->_legajo. "<br>";
            jump();
        }
    }else{
        echo "Metodo no permitido";
    }
}

function pathAsignacion($method){
    if ($method == 'POST') {

        $headers = getallheaders();
        $token = $headers['token'] ?? "";
        $ruta =  "materia-profesores.xxx";

        if (Token::autenticarToken($token, "", "Token incorrecto") == false) {
            return;
        }

        $legajoProfesor = $_POST['legajoProfesor'] ?? null;
        $idMateria = $_POST['idMateria'] ?? null;
        $turno = $_POST['turno'] ?? null;

        $lista = Archivos::obtenerJson($ruta);
        if (($legajoProfesor == null || $idMateria == null) && ($turno != "manana" && $turno != "noche")){
            echo "Error al ingresar el datos";
            return;
        }
        if (isset($lista)){
            foreach($lista as $a){
                if ($a->_legajoProfesor == $legajoProfesor && $a->_idMateria == $idMateria && $a->_turno == $turno){
                    echo "Error, Legajo Ingresado";
                    return;
                }
            }
        }
            
        $asignacion = new Asignacion($legajoProfesor,$idMateria,$turno);
        Archivos::guardarJson($ruta, $asignacion);
        echo $asignacion;


    } else if ($method == 'GET') {
        $headers = getallheaders();
        $token = $headers['token'] ?? "";
        $ruta =  "materia-profesores.xxx";

        if (Token::autenticarToken($token, "", "Token incorrecto") == false) {
            return;
        }

        $lista = Archivos::obtenerJson($ruta);

    } else {
        echo "Metodo no permitido";
    }
}
//--------------------------------------//