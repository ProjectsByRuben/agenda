<?php
header('Access-Control-Allow-Origin: *'); // Permite solicitudes desde cualquier origen
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method"); // Configura los encabezados permitidos
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE"); // Configura los métodos HTTP permitidos
header("Allow: GET, POST, OPTIONS, PUT, DELETE"); // Configura los métodos HTTP permitidos

require "conexion.php"; // Incluye el archivo que contiene la conexión a la base de datos

// Asegúrate de obtener los datos correctos de la solicitud
$objId = json_decode(file_get_contents("php://input")); // Obtiene los datos JSON de la solicitud

// Verifica si se recibieron datos JSON válidos y si se proporcionó el campo 'idUsuario'
if (!$objId || !isset($objId->idUsuario)) {
    http_response_code(400); // Establece el código de respuesta a 400 (Bad Request)
    echo json_encode(array("error" => "Datos de entrada no válidos."));
    exit(); // Finaliza el script PHP
}

$sql = "SELECT * FROM cita WHERE dni='$objId->idUsuario'"; // Construye la consulta SQL para obtener citas del usuario
$query = $mysqli->query($sql); // Ejecuta la consulta en la base de datos

$datos = array(); // Inicializa un array para almacenar los resultados de la consulta

while ($resultado = $query->fetch_assoc()) {
    $datos[] = $resultado; // Almacena cada fila de resultados en el array
}

echo json_encode($datos); // Convierte los resultados a formato JSON y los devuelve como respuesta
?>