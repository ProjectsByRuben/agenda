<?php
// guardar_expediente.php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recibir los datos del formulario
    $dniEmpleado = $_POST['dni'];
    $nuevosComentarios = $_POST['comentario'];

    // Conéctate a la base de datos (reemplaza 'tu_host', 'tu_usuario', 'tu_contraseña' y 'tu_base_de_datos' con tus propios valores)
    $servername = "localhost";
    $username = "root";
    $password = "root";
    $dbname = "usuariosbd";

    // Crear conexión
    $mysqli = new mysqli($servername, $username, $password, $dbname);

    // Verifica la conexión
    if ($mysqli->connect_error) {
        die('Error de conexión: ' . $mysqli->connect_error);
    }

    // Itera sobre los nuevos comentarios y actualiza la base de datos
    foreach ($nuevosComentarios as $indice => $comentario) {
        $numExpediente = $_POST['num_expediente'][$indice];

        // Actualiza el comentario en la base de datos
        $sqlUpdate = "UPDATE expediente SET comentario = '$comentario' WHERE dni = '$dniEmpleado'";
        $mysqli->query($sqlUpdate);
    }

    // Cierra la conexión a la base de datos
    $mysqli->close();

    // Redirecciona de nuevo a la página de expediente
    header("Location: expediente.php?dni=$dniEmpleado");
    exit();
}
?>
