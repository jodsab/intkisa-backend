<?php
header('Access-Control-Allow-Origin: *');  
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Content-Type: text/html; charset=utf-8");
$method = $_SERVER['REQUEST_METHOD'];
    include "conectar.php";
    $mysqli = conectarDB();
    //sleep(1);	
	$JSONData = file_get_contents("php://input");
	$dataObject = json_decode($JSONData);    
    session_start();    
    $mysqli->set_charset('utf8');
	    
	$usuario = $dataObject-> user_nombre;
	$pas =	$dataObject-> user_password;
    
  if ($nueva_consulta = $mysqli->prepare("SELECT
  id_user, user_fecha_registro, user_nombre, user_password, user_celular, user_direccion, user_email 
  FROM users 
  WHERE user_nombre = ?"
 )) {
        $nueva_consulta->bind_param('s', $usuario);
        $nueva_consulta->execute();
        $resultado = $nueva_consulta->get_result();
        if ($resultado->num_rows >= 1) {
            $datos = $resultado->fetch_assoc();
             $encriptado_db = $datos['user_password'];
            if ($pas == $encriptado_db)
            {
                $_SESSION['usuario'] = $datos['user_id_nombre'];
                echo json_encode(array('conectado'=>true,'usuario'=>$datos['id_user'], 'nombre'=>$datos['user_nombre'],  'password'=>$datos['user_password'], 'celular'=>$datos['user_celular'], 'direccion'=>$datos['user_direccion'], 'email'=>$datos['user_email']  ) );
              }

               else {

                 echo json_encode(array('conectado'=>false, 'error' => 'La clave es incorrecta, vuelva a intentarlo.'));
                    }
        }
        else {
              echo json_encode(array('conectado'=>false, 'error' => 'El usuario no existe.'));
        }
        $nueva_consulta->close();
      }
      else{
        echo json_encode(array('conectado'=>false, 'error' => 'No existe Login'));
      }
 // }
$mysqli->close();
?>