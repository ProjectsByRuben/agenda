<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>

        <div class="modal" id="miModal">
          <div class="modal-dialog">
            <div class="modal-content">
           
              <!-- Cabecera del Modal -->
              <div class="modal-header">
                <h4 class="modal-title">Citas</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
              </div>
             
              <!-- Contenido del Modal -->
              <div class="modal-body">
               
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th scope="col">Fecha cita</th>
                      <th scope="col">Comentario</th>
                      
                    </tr>
                  </thead>
                  <tbody id="tbodyData">
                  <?php
                    include './api2/conexion.php';
                    $dniEmpleado = $_GET['dni'];
 
                    $sqls = "SELECT * FROM cita WHERE dni='$dniEmpleado'";
 
                    $query = $mysqli->prepare($sqls);
 
                    $query->execute();
 
                    $res = $query->get_result();
 
                    while($row = $res->fetch_assoc()){
                    ?>
                    <tr>
                        <td> <?php echo $row['fecha_cita']?></td>
                        <td> <?php echo $row['comentario']?></td>
                    </tr>
                    <?php
                    }
                    ?>
                  </tbody>
                </table>
 
              </div>
             
              <!-- Pie del Modal -->
              <div class="modal-footer">
                <!-- Botón para cerrar el modal -->
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
              </div>
             
            </div>
          </div>
        </div>

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
    $mysqli = new mysqli($servername, $username, $password, $dbname);

    // Verifica la conexión
    if ($mysqli->connect_error) {
        die('Error de conexión: ' . $mysqli->connect_error);
    }

    // Consulta SQL para obtener el nombre del empleado
    $sqlNombre = "SELECT nombre FROM usuarios2 WHERE dni = '$dniEmpleado'";

    // Ejecuta la consulta para obtener el nombre
    $resultadoNombre = $mysqli->query($sqlNombre);

    // Verifica si hay resultados
    if ($resultadoNombre->num_rows > 0) {
        // Obtiene el nombre del empleado
        $filaNombre = $resultadoNombre->fetch_assoc();
        $nombreEmpleado = $filaNombre['nombre'];

        // Consulta SQL para obtener más datos de las citas y expediente del empleado
        $sqlCitas = "SELECT * FROM expediente
                    WHERE dni = '$dniEmpleado'";

        // Ejecuta la consulta
        $resultadoCitas = $mysqli->query($sqlCitas);

        // Verifica si hay resultados
        if ($resultadoCitas->num_rows > 0) {
            // Muestra la tabla con los datos de las citas y expediente
            echo "<h2>Expediente del empleado $nombreEmpleado (DNI: $dniEmpleado)</h2>";
            echo "<form method='post' action='guardar_expediente.php'>";
            echo "<table border='1'>
                    <thead>
                        <tr>
                            <th>Num Expediente</th>
                            <th>Fecha Expediente</th>
                            <th>Tipo Expediente</th>
                            <th>Comentario</th>
                        </tr>
                    </thead>
                    <tbody>";

            while ($filaCita = $resultadoCitas->fetch_assoc()) {
                echo "<tr>
                        <td>{$filaCita['num_expediente']}</td>
                        <td>{$filaCita['fecha_expediente']}</td>
                        <td>{$filaCita['tipo_expediente']}</td>
                        <td><input type='text' name='comentario[]' value='{$filaCita['comentario']}'/></td>
                        </tr>";
            }

            echo "</tbody></table>";

            // Input oculto para enviar el DNI
            echo "<input type='hidden' name='dni' value='$dniEmpleado'>";

            // Botón para guardar los datos en el expediente
            echo "<button type='submit' class='btn btn-info'>Actualizar Comentario</button>";
            ?>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#miModal">
                Ver citas
            </button>
            <?php

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
    $mysqli->close();
    ?>

</body>
</html>
