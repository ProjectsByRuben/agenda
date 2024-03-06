<?php
// Se incluye el miniscript que abre la base de datos.
  include ("inc/usarBD.php");
// Se toman todos los datos necesarios del formulario de modificaciones.
  $nuevaHoraInicio=$_POST["hora_inicio"].":".$_POST["minutos_inicio"];
  $nuevaHoraFin=$_POST["hora_fin"].":".$_POST["minutos_fin"];
  $nuevaFecha=$_POST["annio"]."-".$_POST["mes"]."-".$_POST["dia"];
// Se monta y ejecuta la consulta de actualizaci�n.
$consulta = "UPDATE cita SET fecha_cita='".$nuevaFecha."', hora_inicio='".$nuevaHoraInicio."', hora_fin='".$nuevaHoraFin."', comentario='".$_POST["comentario"]."', facturada=".$_POST["facturada"]." WHERE id_cita=".$_POST["citaSeleccionada"].";";

  $hacerConsulta = $conexion->query($consulta);

  //$hacerConsulta=mysql_query($consulta, $conexion);
// Se liberan recursos y se cierra la base de datos.
  //@mysql_free_result($hacerConsulta);
  //mysql_close ($conexion);
?>
<html>
  <head>
    <script language="javascript" type="text/javascript">
/* Cuando se ha cargado la p�gina (ya se ha hecho la actualizaci�n) se vuelve a
index, pasando la fecha en curso como un campo oculto.*/
      function volver(){
        document.retorno.submit();
      }
    </script>
  </head>
  <body onLoad="javascript:volver();">
<!-- El siguiente formulario es para volver a index xon la fecha en curso. -->
    <form action="agenda.php" method="post" name="retorno" id="retorno">
	  <input type="hidden" name="fechaEnCurso" id="fechaEnCurso" value="<?php echo ($_POST['fechaEnCurso']);?>">
	</form>
  </body>
</html>
