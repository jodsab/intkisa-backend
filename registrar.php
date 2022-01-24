<?php
	header('Access-Control-Allow-Origin: *');  
	header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
	header("Content-Type: text/html; charset=utf-8");
	header("Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE");
	include "conectar.php";
    $conn = conectarDB();

	$JSONData = file_get_contents("php://input");
	$dataObject = json_decode($JSONData);  
	
	$user_fecha_registro= $dataObject-> user_fecha;
	$user_nombre= $dataObject-> user_nombre;
	$user_celular= $dataObject-> user_celular;
	$user_direccion= $dataObject-> user_direccion;
	$user_email= $dataObject-> user_email;
	$user_password = $dataObject-> user_password;	

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$sql = "INSERT INTO users (user_fecha_registro, user_nombre, user_password, user_celular, user_direccion, user_email)
SELECT * FROM (SELECT '$user_fecha_registro' AS user_fecha_registro,'$user_nombre' AS user_nombre, '$user_password' AS user_password, '$user_celular' AS user_celular, '$user_direccion' AS user_direccion, '$user_email' as user_email) AS tmp
WHERE NOT EXISTS (
	SELECT user_nombre FROM users WHERE user_nombre = '$user_nombre'
) LIMIT 1";

if ($conn->query($sql) == TRUE) {
	$resultado = $conn->query($sql);
	echo json_encode(array('registro'=>true, 'msj' => 'Usuario registrado con exito.'));
  
} else {
  	echo json_encode(array('registro'=>false, 'msj' => 'Nombre de usuario existente'));
}

$conn->close();

?>