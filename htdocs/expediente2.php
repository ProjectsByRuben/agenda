<?php
// expediente.php

// Obtener el DNI del empleado de la URL
$dniEmpleado = $_GET['dni'];

// Conéctate a la base de datos (reemplaza 'tu_host', 'tu_usuario', 'tu_contraseña' y 'tu_base_de_datos' con tus propios valores)
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "usuariosbd";

// Crear conexión
$conexion = new mysqli($servername, $username, $password, $dbname);

// Verifica la conexión
if ($conexion->connect_error) {
    die('Error de conexión: ' . $conexion->connect_error);
}

// Consulta SQL para obtener el nombre del empleado
$sqlNombre = "SELECT nombre FROM usuarios2 WHERE dni = '$dniEmpleado'";

// Ejecuta la consulta para obtener el nombre
$resultadoNombre = $conexion->query($sqlNombre);

// Verifica si hay resultados
if ($resultadoNombre->num_rows > 0) {
    // Obtiene el nombre del empleado
    $filaNombre = $resultadoNombre->fetch_assoc();
    $nombreEmpleado = $filaNombre['nombre'];

    // Consulta SQL para obtener más datos de las citas y expediente del empleado
    $sqlCitas = "SELECT c.id_cita, e.num_expediente, e.fecha_expediente, c.fecha_cita, c.hora_inicio, c.hora_fin, c.tipo_cita, c.facturada, c.comentario 
                 FROM expediente e 
                 INNER JOIN cita c ON e.dni = c.dni 
                 WHERE c.dni = '$dniEmpleado'";

    // Ejecuta la consulta
    $resultadoCitas = $conexion->query($sqlCitas);

    // Verifica si hay resultados
    if ($resultadoCitas->num_rows > 0) {
        // Muestra la tabla con los datos de las citas y expediente
        echo "<h2>Expediente del empleado $nombreEmpleado (DNI: $dniEmpleado)</h2>";
        echo "<table border='1'>
                <thead>
                    <tr>
                        <th>Num Expediente</th>
                        <th>Fecha Expediente</th>
                        <th>ID Cita</th>
                        <th>Fecha Cita</th>
                        <th>Hora Inicio</th>
                        <th>Hora Fin</th>
                        <th>Tipo Cita</th>
                        <th>Facturada</th>
                        <th>Comentario de la Cita</th>
                    </tr>
                </thead>
                <tbody>";
        // Itera sobre los resultados de las citas y construye el comentario
        $comentarioExpediente = "";
        while ($filaCita = $resultadoCitas->fetch_assoc()) {
            echo "<tr>
                    <td>{$filaCita['num_expediente']}</td>
                    <td>{$filaCita['fecha_expediente']}</td>
                    <td>{$filaCita['id_cita']}</td>
                    <td>{$filaCita['fecha_cita']}</td>
                    <td>{$filaCita['hora_inicio']}</td>
                    <td>{$filaCita['hora_fin']}</td>
                    <td>{$filaCita['tipo_cita']}</td>
                    <td>{$filaCita['facturada']}</td>
                    <td>{$filaCita['comentario']}</td>
                  </tr>";

            // Concatena los datos al comentario
            $comentarioExpediente .= "ID Cita: {$filaCita['id_cita']} - Fecha Cita: {$filaCita['fecha_cita']} - Hora Inicio: {$filaCita['hora_inicio']} - Hora Fin: {$filaCita['hora_fin']} - Tipo Cita: {$filaCita['tipo_cita']} - Facturada: {$filaCita['facturada']} - Comentario: {$filaCita['comentario']}\n";
        }

        echo "</tbody></table>";

        // Botón para guardar los datos en el expediente
        echo "<form action='guardar_expediente.php' method='post'>";
        echo "<input type='hidden' name='dniEmpleado' value='$dniEmpleado'>";
        echo "<input type='hidden' name='comentarioExpediente' value='$comentarioExpediente'>";
        echo "<button type='submit'>Guardar en Expediente</button>";
        echo "</form>";

        // Botón para volver a pacientes.html
        echo "<br><a href='pacientes.html'>Volver a Pacientes</a>";

    } else {
        // Si no hay resultados, muestra un mensaje
        echo "<p>No hay citas para el empleado $nombreEmpleado (DNI: $dniEmpleado)</p>";
    }
} else {
    // Si no hay resultados en la consulta del nombre, muestra un mensaje
    echo "<h2>Empleado no encontrado con DNI: $dniEmpleado</h2>";
}

// Cierra la conexión a la base de datos
$conexion->close();
?>