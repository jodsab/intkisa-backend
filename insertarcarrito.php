<?php
header('Access-Control-Allow-Origin: *');  
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Content-Type: text/html; charset=utf-8");

include "../conectar.php";

$conn = conectarDB();

$JSONData = file_get_contents("php://input");
$dataObject = json_decode($JSONData);   

$user_nombre = $dataObject-> user_nombre;
$carrito_fecha = $dataObject-> carrito_fecha;
$carrito_producto = $dataObject-> carrito_producto;
$carrito_precio =   $dataObject-> carrito_precio;


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "INSERT INTO carritos (carrito_user_nombre,carrito_fecha_venta, carrito_producto_nombre, carrito_precio) 
VALUES ('$user_nombre', '$carrito_fecha', '$carrito_producto', '$carrito_precio')";

if($conn->query($sql) == TRUE){
    //echo "Nuevo carrito agregado";
    echo json_encode(array('registro'=>true, 'msj' => 'Producto agregado al carrito exitosamente.'));
} else{
    //echo "Error: " . $sql . "<br>" . $conn-> error;
    echo json_encode(array('registro'=>false, 'msj' => 'Error al agregar producto.'));
}

$conn->close();

?>