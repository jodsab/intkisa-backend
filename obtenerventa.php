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

if($nueva_consulta = $conn->prepare("SELECT id_venta, venta_id_producto, venta_estado, venta_nombre_usuario, venta_productos, venta_precio, venta_celular, venta_direccion, venta_email, venta_fecha
FROM ventas
INNER JOIN users
ON ventas.venta_nombre_usuario = users.user_nombre
WHERE ventas.venta_nombre_usuario = ?"
)){    
    $nueva_consulta->bind_param('s', $user_nombre);
    $nueva_consulta->execute();
    $resultado = $nueva_consulta->get_result();

    if ($resultado->num_rows >= 1) {
        
        while($row = $resultado->fetch_assoc()){
            $response[] = array( 'idventa'=>$row['id_venta'], 'vidprod' => $row['venta_id_producto'] ,'vestado' =>$row['venta_estado'], 'vnombreusuario' =>$row['venta_nombre_usuario'], 'vproducto' =>$row['venta_productos'], 'vprecio' =>$row['venta_precio'], 'vcelular' =>$row['venta_celular'], 'vdireccion' =>$row['venta_direccion'], 'vemail' =>$row['venta_email'], 'vfecha' =>$row['venta_nombre_usuario']);
        }
        echo json_encode($response);
        
    }
    else{
        echo "<p>0 results</p>";
    }
}

$conn->close();

?>