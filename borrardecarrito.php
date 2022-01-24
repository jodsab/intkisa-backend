<?php
header('Access-Control-Allow-Origin: *');  
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Content-Type: text/html; charset=utf-8");
include "conectar.php";
$conn = conectarDB();

$JSONData = file_get_contents("php://input");
$dataObject = json_decode($JSONData);   

$conn->set_charset('utf8');

$user_nombre = $dataObject-> carrito_user_nombre;
$id_carrito = $dataObject-> id_carrito;
$carrito_producto = $dataObject-> carrito_producto_nombre;

/* if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} */

/* if($nueva_consulta = $conn->prepare("DELETE FROM carritos WHERE carrito_user_nombre='$user_nombre' AND id_carrito='$id_carrito' AND carrito_producto_nombre='$carrito_producto'"
)){
    $nueva_consulta->execute();
    $resultado = $nueva_consulta -> get_result();

    echo json_encode(array('estado'=>true ));
} */

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "DELETE FROM carritos
WHERE carrito_user_nombre='$user_nombre' 
AND id_carrito='$id_carrito' 
AND carrito_producto_nombre='$carrito_producto'";

if(mysqli_query($conn, $sql)){
    echo json_encode(array('estado'=>true ));
} else{
    echo json_encode(array('estado'=>false ));
}

/* if($conn->query($sql) == TRUE){

    echo json_encode(array('estado'=>true ));
} else{
    echo json_encode(array('estado'=>false ));

} */

$conn->close();

?>