<html>
  <head>
  <script language="javascript" type="text/javascript">
    function volver(){
      document.retorno.submit();
    }
  </script>
  </head>
  <body onLoad="javascript:volver();">
  <?php
// Se incluye el miniscript de tratamiento de fechas
  include ("inc/fechas.php");
// Se incluye el miniscript que abre la base de datos.
  include ("inc/usarBD.php");
  print_r($_POST);
// Se crea la hora, a partir de las horas y minutos establecidos en el formulario de nueva cita.
  $horaDeCita=$_POST["hora_inicio"].":".$_POST["minutos"];
  $facturada=0;
  if(isset($_POST["facturada"])){
    $facturada=1;
  }
  $dni=$_POST["dni"];
// Se monta la consulta para grabar una nueva cita.
  $consulta="INSERT INTO cita (fecha_cita, hora_inicio, facturada, comentario, dni) VALUES ('$fechaEnCurso','$horaDeCita',$facturada,'".$_POST["comentario"]."',$dni);";
// Se ejecuta la consulta.
echo $consulta;
  $stmt = $conexion->prepare($consulta);
  $stmt->execute();
  $stmt->close();
  
  
  //$hacerConsulta=mysql_query ($consulta,$conexion);
  // Se liberan recursos y se cierra la base de datos.
  //@mysql_free_result($hacerConsulta);
  //mysql_close($conexion);
  ?>
  <form action="agenda.php" name="retorno" id="retorno" method="post">
    <input type="hidden" name="fechaEnCurso" id="fechaEnCurso" value="<?php echo ($fechaEnCurso); ?>">
  </form>
  </body>
</html>
