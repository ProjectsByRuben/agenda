<?php

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");

//echo "estamos en agregarUsuario...";
require "./conexion.php";

$json = file_get_contents("php://input");

$objEmpleado = json_decode($json);
//echo $objEmpleado; mira

$fechaActual = date("Y-m-d");

$sql = "INSERT INTO usuarios2(dni, nombre, apellidos, genero, fecha, email, direccion, telefono) VALUES('$objEmpleado->dni','$objEmpleado->nombre','$objEmpleado->apellidos', '$objEmpleado->genero', '$objEmpleado->fecha', '$objEmpleado->email', '$objEmpleado->direccion', '$objEmpleado->telefono')";

$query = $mysqli->query($sql);

// Obtener el último ID insertado en la tabla usuarios2
$ultimoID = $mysqli->insert_id;

// Insertar un nuevo expediente asociado al último empleado insertado
$sqlExpediente = "INSERT INTO `expediente` (`num_expediente`, `comentario`, `fecha_expediente`, `tipo_expediente`, `dni`) VALUES (NULL, 'Expediente creado', '$fechaActual', 'G', '$objEmpleado->dni')";
$queryExpediente = $mysqli->query($sqlExpediente);

//$jsonRespuesta = array('msg2' => 'OK');
$jsonRespuesta = array('msg1' => 'OK', 'msg2' => 'Chachi', 'msg3' => 'Guay');
echo json_encode($jsonRespuesta);
//return $jsonRespuesta
