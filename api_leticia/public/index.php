<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '../vendor/autoload.php';
require '../src/config/db.php';

$app = new \Slim\App;
//tiene que estar aqui require '../src/rutas/empleados.php'; 
require '../src/rutas/empleados.php'; 
$app->get('/', function (Request $request, Response $response, array $args) {
    $response->getBody()->write("Página de gestión API REST de la aplicación de Leticia");

    return $response;
});

//require '../src/rutas/empleados.php';
$app->run();
?>
