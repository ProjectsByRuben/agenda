<?php
// Verifica si se ha enviado el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verifica si se han seleccionado citas
    if (isset($_POST['citas_seleccionadas']) && is_array($_POST['citas_seleccionadas'])) {
        // Recupera el DNI del campo oculto
        if (isset($_POST['dni'])) {
            $dni = $_POST['dni'];
        } else {
            // Manejar el caso en el que el DNI no esté presente
            die("Error: DNI no encontrado.");
        }

        // Realiza la conexión a la base de datos (Asegúrate de ajustar los valores según tu configuración)
        $servername = "localhost";
        $username = "root";
        $password = "root";
        $dbname = "usuariosbd";

        $conn = new mysqli($servername, $username, $password, $dbname);

        // Verifica la conexión
        if ($conn->connect_error) {
            die("Conexión fallida: " . $conn->connect_error);
        }

        // Prepara la fecha actual para inserción en la tabla facturar
        $fecha_facturacion = date("Y-m-d");

        // Array para almacenar mensajes
        $messages = [];

        foreach ($_POST['citas_seleccionadas'] as $id_cita) {
            $id_cita = $conn->real_escape_string($id_cita);

            // Validar que el ID de la cita no sea '0'
            if ($id_cita !== '0') {
                // Realiza el update para marcar la cita como facturada
                $sqlUpdate = "UPDATE cita SET facturada = 1 WHERE id_cita = '$id_cita'";
                $conn->query($sqlUpdate);

                // Realiza la inserción en la tabla facturar
                $sqlInsert = "INSERT INTO factura (dni, id_cita, fecha) VALUES ('$dni', '$id_cita', '$fecha_facturacion')";
                $conn->query($sqlInsert);

                // Verifica si ocurrió algún error en la inserción
                if ($conn->error) {
                    $messages[] = "Error al facturar la cita con ID $id_cita: " . $conn->error;
                } else {
                    $messages[] = "Cita con ID $id_cita facturada correctamente.";
                }
            } else {
                // Manejar el caso en que el ID de la cita sea '0'
                $messages[] = "Error: ID de cita no válido.";
            }
        }

        // Cierra la conexión
        $conn->close();
        
        // Mostrar mensajes de éxito o error después del bucle
        foreach ($messages as $message) {
            if (strpos($message, "Error") !== false) {
                echo "<p style='color: red;'>$message</p>";
            } else {
                echo "<p style='color: green;'>$message</p>";
            }
        }
    } else {
        $errorMessage = "No se han seleccionado citas para facturar.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado de Facturación</title>
</head>
<body>

<!-- Agregar un botón para volver a facturar.php -->
<a href="facturar.php?dni=<?php echo $dni; ?>"><button>Volver a Facturar</button></a>

</body>
</html>
