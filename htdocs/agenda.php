<!DOCTYPE html>
<html lang="en">
<head>
    <title>Mini-agenda</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

    <!-- Importar Bootstrap desde CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
        integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2"
        crossorigin="anonymous"> 

    <!-- Importar jQuery desde CDN -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
        crossorigin="anonymous"></script> 
    
    <!-- Importar Bootstrap Bundle desde CDN (incluye Popper.js) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx"
        crossorigin="anonymous"></script> 

    <!-- Estilos CSS -->
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
            margin: 20px;
        }

        /* Contenedor principal */
        #container {
            max-width: 800px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        /* Estilo para las tablas */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        /* Estilo para celdas de datos y encabezados de tabla */
        td, th {
            border: 1px solid #dee2e6;
            padding: 8px;
            text-align: center;
        }

        /* Estilo adicional para encabezados de tabla */
        th {
            font-weight: bold;
            background-color: #e9ecef;
        }
        /* Estilo para la fecha */
        .fecha {
            font-size: 1.2em; /* Tamaño de fuente más grande */
            font-weight: bold; /* Texto en negrita */
            color: #007bff; /* Color azul similar al de los botones */
        }

        /* Estilo para botones */
        input[type="button"] {
            margin-top: 25px; /* Ajusta el margen entre los botones si es necesario */
            display: inline-block; /* Hace que los botones se muestren en línea */
            margin-right: 10px; /* Ajusta el margen entre los botones si es necesario */
            background-color: #007bff;
            color: #ffffff;
            padding: 6px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type="button"]:hover {
            background-color: #0056b3;
        }

        /* Estilo para el calendario */
        #calendar {
            text-align: center;
            margin-top: 20px;
        }

    </style>
</head>

<body>
  <a href="index.php">Volver</a>
  <div id="container">

    <!-- Contenido de la página -->
    <div id="calendar"></div>
    <br><br>

    <?php
    // Incluye el miniscript que abre la base de datos.
    include("inc/fechas.php");

    // Incluye el miniscript de tratamiento de fechas
    include("inc/usarBD.php");

    // Consulta para obtener las citas del día
    $consulta = "SELECT cita.id_cita, usuarios2.nombre, usuarios2.dni, cita.fecha_cita, cita.tipo_cita, cita.comentario, cita.hora_inicio, cita.hora_fin, cita.facturada
        FROM cita
        INNER JOIN usuarios2 ON cita.dni = usuarios2.dni
        WHERE cita.fecha_cita = '".$fechaEnCurso."'
        ORDER BY cita.fecha_cita";

    $hacerConsulta = $conexion->query($consulta);
    $numeroDeCitasDelDia = $hacerConsulta->num_rows;

echo ("<div>Tienes las siguientes Citas: ".$numeroDeCitasDelDia."</div><br>");

    ?>

    <!-- Formulario de retorno -->
    <form action="agenda.php" method="post" name="retorno" id="retorno">
        <input type="hidden" name="fechaEnCurso" id="fechaEnCurso" value="<?php echo($fechaEnCurso); ?>">
    </form>

    <!-- Información sobre la agenda del día -->
    AGENDA DEL DÍA:
  
    <!-- Información sobre la agenda del día -->
    <span class="fecha">
        <?php echo ($diaActual." del ".$mesActual." de ".$annioActual); ?>
    </span>

    <!-- Formulario principal de citas -->
    <form action="" method="post" name="formularioCitasPrincipal" id="formularioCitasPrincipal">
        <input type="hidden" name="fechaEnCurso" id="fechaEnCurso" value="<?php echo($fechaEnCurso); ?>">
        <table>
            <tr><th>CITAS</th></tr>
        </table>
        <hr>

        <?php
        // Muestra las citas del día si hay alguna
        if ($numeroDeCitasDelDia > 0) {
          echo ("<table>");
          
          // Cabecera de la tabla
          echo ("<tr>");
          echo ("<th>Nombre</th>");
          echo ("<th>DNI</th>");
          echo ("<th>Hora Inicio</th>");
          echo ("<th>Hora Inicio</th>");
          echo ("<th>Hora Fin</th>");
          echo ("<th>Tipo Cita</th>");
          echo ("<th>Comentario</th>");
          echo ("<th>¿Facturada?</th>");
          echo ("<th>Seleccionar</th>");
          echo ("</tr>");
      
          while ($cita = $hacerConsulta->fetch_assoc()) {
              echo ("<tr>");
              echo ("<td>".$cita["nombre"]."</td>");
              echo ("<td>".$cita["dni"]."</td>");
              echo ("<td>".$cita["fecha_cita"]."</td>");
              echo ("<td>".$cita["hora_inicio"]."</td>");
              echo ("<td>".$cita["hora_fin"]."</td>");
              echo ("<td>".$cita["tipo_cita"]."</td>");
              echo ("<td>".$cita["comentario"]."</td>");
              echo ("<td>".$cita["facturada"]."</td>");
              echo ("<td><input type='radio' id='citaSeleccionada' name='citaSeleccionada' value='".$cita["id_cita"]."'></td>");
              echo ("</tr>");
          }
          echo ("</table>");
          echo ("<input name='borrarCita' type='button' id='borrarCita' value='Eliminar Cita' onClick='javascript:saltar(\"eliminarCita.php\");'>");
          echo ("<input name='cambiarCita' type='button' id='cambiarCita' value='Modificar cita' onClick='javascript:saltar(\"cambiarCita.php\");'>");
      }      
        // Botones adicionales
        echo ("<input name='nuevaCita' type='button' id='nuevaCita' value='Agregar cita' onClick='javascript:saltar(\"agregarCita.php\");'>");
        echo ("<input name='cambiarFecha' type='button' id='cambiarFecha' value='Otro día' onClick='javascript:saltar(\"cambiarFecha.php\");'><br>");
        ?>
    </form>
  </div>
</body>

<script language="javascript" type="text/javascript">

  // Función para crear el calendario
  function createCalendar(elem, year, month, day) {
    let mon = month - 1; // Los meses en JS son 0..11, no 1..12
    let d = new Date(year, mon);
    
    cadena = '<br><br><h1>'+year+'-'+month+'-'+day+'</h1><br><br>';
    
    let table = cadena + '<table><tr><th>MO</th><th>TU</th><th>WE</th><th>TH</th><th>FR</th><th>SA</th><th>SU</th></tr><tr>';

    // Espacios en la primera línea
    // Desde lunes hasta el primer día del mes
    // * * * 1  2  3  4
    for (let i = 0; i < getDay(d); i++) {
      table += '<td></td>';
    }

    // <td> con el día  (1 - 31)
    while (d.getMonth() == mon) {
      table += '<td>' + d.getDate() + '</td>';

      if (getDay(d) % 7 == 6) { // Domingo, último día de la semana --> nueva línea
        table += '</tr><tr>';
      }

      d.setDate(d.getDate() + 1);
    }

    // Espacios después del último día del mes hasta completar la última línea
    // 29 30 31 * * * *
    if (getDay(d) != 0) {
      for (let i = getDay(d); i < 7; i++) {
        table += '<td></td>';
      }
    }

    // Cerrar la tabla
    table += '</tr></table>';
    table2 = "";

    for (let $i = 1; $i <= 31; $i++) {
      if ($i == day) {
        table2 = table.replace("<td>"+$i+"</td>", "<td><input type=\"button\" style=\"background-color:black;color:white\" value=\""+$i+"\" onClick=\"cambiarDia(this.value)\"></td>");
      } else {
        table2 = table.replace("<td>"+$i+"</td>", "<td><input type=\"button\" value=\""+$i+"\" onClick=\"cambiarDia(this.value)\"></td>");
      }
      
      table = table2;
    }
    
    elem.innerHTML = table2;
  }

  // Función para obtener el número de día desde 0 (lunes) a 6 (domingo)
  function getDay(date) {
    let day = date.getDay();
    if (day == 0) day = 7; // Hacer domingo (0) el último día
    return day - 1;
  }
  
  // Función para cambiar el día
  function cambiarDia(num) {
    var $fecha=document.getElementById("fechaEnCurso").value;
    alert("La antigua fecha es: "+ $fecha);
    
    $annioActual=$fecha.substring(0,4);
    $mesActual=$fecha.substring(5,7);
    $diaActual=num;
    
    if ($diaActual.length == 1) {
      $diaActual="0"+$diaActual;
    }
    
    $fec= $annioActual + "-"+ $mesActual + "-" + $diaActual;
    alert("La fecha seleccionada es "+ $fec);
    
    document.getElementById("fechaEnCurso").value = $fec;
    document.retorno.submit();
  }

  /* La siguiente función de JavaScript envía el formulario a la página que corresponda al botón pulsado. */
  /* Es un truco para tener un solo formulario con el action parametrizable dependiendo del botón que se pulsa */
  function saltar(pagina){
    // Actualiza el action del formulario y fuerza el submit
    document.formularioCitasPrincipal.action = pagina;
    document.formularioCitasPrincipal.submit();
  }
  /* Aquí termina la función de envío del formulario. */

  // Obtener la fecha actual
  var $fecha=document.getElementById("fechaEnCurso").value;
  var $annioActual="";
  var $mesActual="";

  $annioActual=$fecha.substring(0,4);
  $mesActual=$fecha.substring(5,7);
  $diaActual=$fecha.substring(8,10);

  createCalendar(calendar, $annioActual, $mesActual, $diaActual);

</script>
</html>