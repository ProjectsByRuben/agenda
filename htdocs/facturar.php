<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<?php
// Verifica si el parámetro dni está presente en la URL
if (isset($_GET['dni'])) {
    $dni = $_GET['dni'];

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

    // Consulta SQL para obtener citas no facturadas según el DNI, incluyendo la información de la tabla tipocita
    $sql = "SELECT c.id_cita, c.fecha_cita, c.hora_inicio, tc.tipo_cita, c.comentario, tc.importe 
            FROM cita c
            INNER JOIN tipocita tc ON c.tipo_cita = tc.tipo_cita
            WHERE c.dni = '$dni' AND c.facturada = 0";

    $result = $conn->query($sql);

    // Verifica si se obtuvieron resultados
    if ($result->num_rows > 0) {
        echo "<h2>Citas no facturadas para el usuario con DNI $dni:</h2>";
        echo "<form action='procesar_seleccion.php' method='post'>"; // Agregamos un formulario para procesar la selección
        echo "<input type='hidden' name='dni' value='$dni'>"; // Campo oculto para pasar el DNI
        echo "<table border='1'>
            <tr>
                <th>ID Cita</th>
                <th>Fecha Cita</th>
                <th>Hora Inicio</th>
                <th>Tipo Cita</th>
                <th>Asunto</th>
                <th>Importe</th>
                <th>Seleccionar</th>
            </tr>";

        // Imprime los datos en la tabla con checkboxes
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                <td>" . $row['id_cita'] . "</td>
                <td>" . $row['fecha_cita'] . "</td>
                <td>" . $row['hora_inicio'] . "</td>
                <td>" . $row['tipo_cita'] . "</td>
                <td>" . $row['comentario'] . "</td>
                <td>" . $row['importe'] . "</td>
                <td><input type='checkbox' name='citas_seleccionadas[]' value='" . $row['id_cita'] . "'></td>
            </tr>";
        }

        echo "</table>";
        echo "<input type='submit' value='Facturar Citas Seleccionadas'>"; // Agregamos un botón para enviar el formulario
        echo "</form>";

        // Agrega un botón para volver a pacientes.html
        echo "<br>";
        echo "<a href='pacientes.html'><button>Volver a Pacientes</button></a>";
    } else {
        echo "<h2>No hay citas no facturadas para el usuario con DNI $dni.</h2>";
        // Agrega un botón para volver a pacientes.html
        echo "<br>";
        echo "<a href='pacientes.html'><button>Volver a Pacientes</button></a>";
    }

    // Cierra la conexión
    $conn->close();
}
?>

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
 
                    $sqls = "SELECT * FROM cita WHERE dni='$dniEmpleado' and facturada=0";
 
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

        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#miModal">
                Ver citas sin facturar
            </button>


            <div class="modal" id="miModal2">
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
 
                    $sqls = "SELECT * FROM cita WHERE dni='$dniEmpleado' and facturada=1";
 
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

        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#miModal2">
                Ver citas facturadas
            </button>