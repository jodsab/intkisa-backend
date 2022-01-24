<?php
header('Access-Control-Allow-Origin: *');  
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Content-Type: text/html; charset=utf-8");

include "../conectar.php";

$conn = conectarDB();

$JSONData = file_get_contents("php://input");
$dataObject = json_decode($JSONData);   

$conn->set_charset('utf8');

$user_nombre = $dataObject-> user_nombre;

if ($nueva_consulta = $conn->prepare("SELECT carrito_producto_nombre
FROM carritos
INNER JOIN users
ON carritos.carrito_user_nombre = users.user_nombre
WHERE carritos.carrito_user_nombre = ?"
)) {
    $nueva_consulta->bind_param('s', $user_nombre);
    $nueva_consulta->execute();
    $resultado = $nueva_consulta->get_result();

    if ($resultado->num_rows >= 1) {
        $datos = $resultado->fetch_assoc();
        echo json_encode(array('carrito'=>true,'nproductos'=> $resultado->num_rows));
    }
    else{
        echo json_encode(array('carrito'=>false, 'error' => 'Carrito vacio o no existe'));
    }
    
}


$conn->close();

?>