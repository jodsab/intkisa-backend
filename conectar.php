<?php
header('Access-Control-Allow-Origin: *');  
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Content-Type: text/html; charset=utf-8");
$method = $_SERVER['REQUEST_METHOD'];

function conectarDB(){

  $servidor = "127.0.0.1:3306";
  $usuario = "u224475469_camilo";
  $password = "Camilodbintikisa1";
  $bd = "u224475469_intikisaperu";
  //$bd = "cajaherr_datos";
  

    $conexion = mysqli_connect($servidor, $usuario, $password,$bd);

        if($conexion){
            echo "";
        }else{
            echo 'Ha sucedido un error inexperado en la conexion de la base de datos';
        }

    return $conexion;
}
?>