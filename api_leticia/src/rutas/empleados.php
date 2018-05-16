<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
$app = new \Slim\App;
//obtener todos los productos
$app->get('/api/empleados', function(Request $request, Response $response){
$consulta = 'SELECT * FROM empleados';
    try{
        $db = new db();
        //conexion
        $db = $db->conectar();
        $ejecutar = $db->query($consulta);
        $empleados = $ejecutar->fetchAll(PDO::FETCH_OBJ);
        $db=null;
        echo json_encode($empleados);
    } catch (PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

//BUSCAR

$app->get('/api/empleado/{id}', function(Request $request, Response $response){
$id=$request->getAttribute('id');
$consulta = "SELECT * FROM empleados where id='$id'";
try{
$db = new db();
//conexion
$db = $db->conectar();
$ejecutar = $db->query($consulta);
$empleado = $ejecutar->fetchAll(PDO::FETCH_OBJ);
$db=null;
echo json_encode($empleado);
} catch (PDOException $e){
echo '{"error": {"text": '.$e->getMessage().'}';
}
});



//AGREGAR

$app->post('/api/crear', function(Request $request, Response $response){

    $id = $request->getParam('id');
    $nombre = $request->getParam('nombre');
    $direccion = $request->getParam('direccion');
    $telefono = $request->getParam('telefono');


    $sql = "INSERT INTO empleados (id,nombre,direccion,telefono)
    VALUES(:id,:nombre,:direccion,:telefono)";

try {
    $db = new db();
        //conexion
    $db = $db->conectar();


    $stmt = $db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':direccion', $direccion);
        $stmt->bindParam(':telefono', $telefono);
        $stmt->execute();


    echo json_encode('{"message": "Empleado Agregado con exito"}');


    }catch(PDOException $e){
        echo '{"error": ' . $e->getMessage() . '}';
    }
});

//DELETE

$app->delete('/api/eliminar/{id}',  function(Request $request, Response $response){

    $id = $request->getAttribute('id');

    $sql = "DELETE FROM empleados
            WHERE id = :id";

    try{
        $db = new db();
        $db = $db->conectar();
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $db = null;

        echo json_encode('{"message": "Empleado eliminado con exito"}');


    }catch(PDOException $e){
        echo '{"error": ' . $e->getMessage() . '}';
    }
});

//MODIFICAR

$app->put('/api/actualizar/{id}',  function(Request $request, Response $response){
    try{
$db = new db();
//conexion
$db = $db->conectar();
$ejecutar = $db->prepare("UPDATE empleados SET nombre=:nombre,direccion=:direccion,telefono=:telefono where id=:id ");


//Creamos un array para la inserccion
$ejecutar->execute(
array(':id'=>$request->getAttribute('id'),
':nombre'=>$request->getParam('nombre'),
':direccion'=>$request->getParam('direccion'),
':telefono'=>$request->getParam('telefono'))) ;

echo "Se ha actualizado correctamente el articulo";
//$producto = $ejecutar->fetchAll(PDO::FETCH_OBJ);
$db=null;
//echo json_encode($producto);
} catch (PDOException $e){
echo '{"error": {"text": '.$e->getMessage().'}';
}

//Al hacerlo de esta forma me dio un error en BBDD que no fui capaz de solucionar
/*
    $id = $request->getAttribute('id');

    $nombre = $request->getParam('nombre');
    $direccion = $request->getParam('direccion');
    $telefono = $request->getParam('telefono');

    $sql = "UPDATE empleados SET
            nombre = :nombre,
            direccion = :direccion,
            telefono = :telefono,
            WHERE id = :id";

    try{
        $db = new db();
        $db = $db->conectar();
        $stmt = $db->prepare($sql);
        //$stmt->bindParam(':id', $id);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':direccion', $direccion);
        $stmt->bindParam(':telefono', $telefono);
        $stmt->execute();

        echo json_encode('{"message": "Empleado Actualizado con exito"}');


    }catch(PDOException $e){
        echo '{"error": ' . $e->getMessage() . '}';
    }
    */
});

?>