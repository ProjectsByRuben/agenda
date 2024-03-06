<html>
  <head>
    <title>Grabar una nueva cita</title>
    <script language="javascript" type="text/javascript">
      function mandar(resultado) {
        console.log(resultado);
        if (resultado) {
          document.formularioNuevaCita.action = "grabarNuevaCita.php";
        } else {
          document.formularioNuevaCita.action = "agenda.php";
        }
        document.formularioNuevaCita.submit();
      }
    </script>
  </head>

  <body>
    <?php
      // Se incluye el miniscript de tratamiento de fechas
      include ("inc/fechas.php");
      // Se muestra la fecha en curso.
      echo ("CITA PARA EL DÍA: ".$diaActual." del ".$mesActual." de ".$annioActual.salto);
    ?>
    <form action="" method="post" name="formularioNuevaCita" id="formularioNuevaCita">
      <input type="hidden" name="fechaEnCurso" id="fechaEnCurso" value="<?php echo($fechaEnCurso); ?>">
      <table width="500" border="0" cellspacing="0" cellpadding="2">
        <tr>
          <td width="73">Hora inicio:</td>
          <td width="73">Hora fin:</td> <!-- Nuevo campo -->
          <td width="427">Cita:</td>
        </tr>
        <tr>
          <td>
            <select name="hora_inicio" id="hora_inicio">
              <?php
                for ($i=0;$i<24;$i++){
                  echo ("<OPTION VALUE='");
                  printf ("%02s",$i);
                  echo ("'>");
                  printf("%02s",$i);
                  echo ("</OPTION>".salto);
                }
              ?>
            </select>
          </td>
          <td>
            <select name="hora_fin" id="hora_fin"> <!-- Nuevo campo -->
              <?php
                for ($i=0;$i<24;$i++){
                  echo ("<OPTION VALUE='");
                  printf ("%02s",$i);
                  echo ("'>");
                  printf("%02s",$i);
                  echo ("</OPTION>".salto);
                }
              ?>
            </select>
          </td>
          <td rowspan="3"><textarea name="comentario" cols="50" rows="5" id="comentario"></textarea></td>
        </tr>
        <tr>
          <td>Minutos inicio:</td>
          <td>Minutos fin:</td> <!-- Nuevo campo -->
        </tr>
        <tr>
          <td>
            <select name="minutos_inicio" id="minutos_inicio">
              <?php
                for ($i=0;$i<51;$i+=10){
                  echo ("<OPTION VALUE='");
                  printf ("%02s",$i);
                  echo ("'>");
                  printf("%02s",$i);
                  echo ("</OPTION>".salto);
                }
              ?>
            </select>
          </td>
          <td>
            <select name="minutos_fin" id="minutos_fin"> <!-- Nuevo campo -->
              <?php
                for ($i=0;$i<51;$i+=10){
                  echo ("<OPTION VALUE='");
                  printf ("%02s",$i);
                  echo ("'>");
                  printf("%02s",$i);
                  echo ("</OPTION>".salto);
                }
              ?>
            </select>
          </td>
          <td>
            <input type="checkbox" name="facturada" id="facturada"><label for="facturada">Facturada</label>
            <select name="dni" id="dni"></select>
          </td>
        </tr>
      </table>
      <table width="500" height="44" border="0" cellpadding="0" cellspacing="0">
        <tr align="center">
          <td width="248"><input name="grabarCita" type="button" id="grabarCita" value="Grabar la cita" onClick="javascript:mandar(true);"></td>
          <td width="252"><input name="anularCita" type="button" id="anularCita" value="Cancelar" onClick="javascript:mandar(false);"></td>
        </tr>
      </table>
    </form>
    <script>
      function verPacientes() {
        let pacientes = document.getElementById('dni');
        fetch('/api2/obtenerUsuario.php').then(response => response.json())
          .then(data => {
            let html = "";
            for (let i = 0; i < data.length; i++) {
              const element = data[i];
              console.log(element.dni, ' ', element.nombre, ' ',element.apellidos);
              html += `<option value="${element.dni}">${element.nombre} ${element.apellidos}</option>`;
            }
            pacientes.innerHTML = html;
          })
          .catch(error => console.error(error))
      }
      verPacientes();
    </script>
  </body>
</html>
