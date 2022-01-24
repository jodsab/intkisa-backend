<?php
header('Access-Control-Allow-Origin: *');  
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Content-Type: text/html; charset=utf-8");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE");
include "conectar.php";
$conn = conectarDB();

$JSONData = file_get_contents("php://input");
$dataObject = json_decode($JSONData);   

$conn->set_charset('utf8');

$user_nombre = $dataObject-> carrito_user_nombre;

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "DELETE FROM carritos
WHERE carrito_user_nombre = '$user_nombre'";

$statement = $conn -> prepare($sql);

$statement->execute();

/* if(mysqli_query($conn, $sql)){
    echo json_encode(array('estado'=>true ));
} else{
    echo json_encode(array('estado'=>false ));
} */


$conn->close();

?>