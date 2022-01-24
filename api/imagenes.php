<?php
header('Access-Control-Allow-Origin: *');  
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Content-Type: text/html; charset=utf-8");

include "../conectar.php";

$conn = conectarDB();

$JSONData = file_get_contents("php://input");
$dataObject = json_decode($JSONData);   

$prods_imgs = $dataObject-> producto_imgs;

$conn->set_charset('utf8');

$response = [];

if($nueva_consulta = $conn->prepare("SELECT *
FROM imagenesproductos
WHERE imagen_id_producto = ? "
)){    
    $nueva_consulta->bind_param('s', $prods_imgs);
    $nueva_consulta->execute();
    $resultado = $nueva_consulta->get_result();

    if ($resultado->num_rows >= 1) {
        
        while($row = $resultado->fetch_assoc()){
            $response[] = array( 'id_img'=>$row['id_imagen'], 'id_prod' => $row['imagen_id_producto'], 'imagen_producto' => $row['imagen_url']);
        }
        echo json_encode($response);
        
    }
    else{
        echo "<p>0 results</p>";
    }
}

$conn->close();

?>