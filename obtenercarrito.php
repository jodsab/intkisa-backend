<?php
header('Access-Control-Allow-Origin: *');  
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Content-Type: text/html; charset=utf-8");

include "conectar.php";

$conn = conectarDB();

$JSONData = file_get_contents("php://input");
$dataObject = json_decode($JSONData);   

$user_nombre = $dataObject-> user_nombre;

$conn->set_charset('utf8');

$response = [];

if($nueva_consulta = $conn->prepare("SELECT carrito_user_nombre, id_carrito, carrito_producto_nombre, carrito_precio
FROM carritos
INNER JOIN users
ON carritos.carrito_user_nombre = users.user_nombre
WHERE carritos.carrito_user_nombre = ?"
)){    
    $nueva_consulta->bind_param('s', $user_nombre);
    $nueva_consulta->execute();
    $resultado = $nueva_consulta->get_result();

    if ($resultado->num_rows >= 1) {
        
        while($row = $resultado->fetch_assoc()){
            $response[] = array( 'usernombre'=>$row['carrito_user_nombre'], 'idprod' => $row['id_carrito'] ,'producto' =>$row['carrito_producto_nombre'], 'precio' =>$row['carrito_precio']);
        }
        echo json_encode($response);
        
    }
    else{
        echo "<p>0 results</p>";
    }
}

$conn->close();

?>