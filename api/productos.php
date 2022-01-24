<?php
	header('Access-Control-Allow-Origin: *');  
	header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
	header("Content-Type: text/html; charset=utf-8");
	header("Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE");

$method = $_SERVER['REQUEST_METHOD'];
    include "../conectar.php";
    $mysqli = conectarDB();
    //sleep(1);	
	$JSONData = file_get_contents("php://input");
	$dataObject = json_decode($JSONData);    
    session_start();    

    $mysqli->set_charset('utf8');

    $productos = [];
    
  if ($nueva_consulta = $mysqli->prepare("SELECT *
  FROM productos
  INNER JOIN imagenesproductos
  ON productos.id_producto = imagenesproductos.imagen_id_producto
  INNER JOIN categoria
  ON productos.producto_id_categoria = categoria.id_categoria"
 )) {
        $nueva_consulta->execute();
        $resultado = $nueva_consulta->get_result();
        if ($resultado->num_rows >= 1) {

            while($row = $resultado->fetch_assoc()){
                $productos[] = (array('prodid'=>$row['id_producto'],'prodnombre'=>$row['producto_nombre'], 'proprecio'=>$row['producto_precio'], 'proprecioferta'=>$row['producto_precio_oferta'],  'prodstock'=>$row['producto_stock'], 'proddescripcion'=>$row['producto_descripcion'], 'prodcategoria'=>$row['producto_id_categoria'], 'produrl'=>$row['imagen_url'], 'prodcategoriaurl'=>$row['categoria_url'], 'prodstatus'=>$row['producto_status'], 'prodsku' =>$row['producto_sku'] ) );
            } 

            echo json_encode($productos);
        }
        else {
              echo json_encode(array('connection'=>false, 'error' => 'No existe ni un producto'));
        }
        $nueva_consulta->close();
      }
      else{
        echo json_encode(array('connection'=>false, 'error' => 'No se ha podido conectar'));
      }
 // }
$mysqli->close();
?>