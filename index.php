<?php
require_once "utils/archivos.php";
require_once "utils/funciones.php";

$method = $_SERVER['REQUEST_METHOD'];
$path = $_SERVER['PATH_INFO'];

$path = (explode('/',$path));

switch($path[1])
{
    case 'usuario':
        pathUsuario($method);
    break;
    case 'login':
        pathLogin($method);
    break;
    case 'materia':
        pathMateria($method);
    break;
    case 'profesor':
        pathProfesor($method);
    break;
    case 'asignacion':
        pathAsignacion($method);
    break;
    case 'turno':
        // pathTurno($method);
    break;
    case 'stats':
        // pathStats($method);
    break;
    default:
    echo "Path erroneo";
    break;
}
die();