<?php
// Redireccionar si no se ha seleccionado una cita
if (!isset($_POST["citaSeleccionada"])) {
    header("Location: agenda.php?error=CitaNoSeleccionada");
    exit();
}

// Incluir scripts necesarios
include("inc/fechas.php");
include("inc/usarBD.php");

// Mostrar la fecha en curso
echo ("CITA PARA EL DÍA: " . $diaActual . " del " . $mesActual . " de " . $annioActual . salto);

// Preparar y ejecutar la consulta SQL con consulta preparada
$consulta = $conexion->prepare("SELECT cita.*, usuarios2.nombre 
             FROM cita
             INNER JOIN usuarios2 ON cita.dni = usuarios2.dni
             WHERE cita.id_cita = ?");
$consulta->bind_param("s", $_POST["citaSeleccionada"]);
$consulta->execute();
$datosDeLaCita = $consulta->get_result()->fetch_array();


// Obtener la hora de inicio y fin actuales
$horaInicioActual = substr($datosDeLaCita["hora_inicio"], 0, 5);
$horaFinActual = substr($datosDeLaCita["hora_fin"], 0, 5);

/* Se asignan los datos actuales de la cita a variables de memoria, se libera el cursor y se cierra la BBDD. */
$horaActual = substr($datosDeLaCita["hora_inicio"], 0, 2);
$minutoActual = substr($datosDeLaCita["hora_inicio"], 3, 2);
$horaFinActual = substr($datosDeLaCita["hora_fin"], 0, 2);
$minutoFinActual = substr($datosDeLaCita["hora_fin"], 3, 2);
$comentarioActual = $datosDeLaCita["comentario"];
$facturadaActual = $datosDeLaCita["facturada"];
$dniActual = $datosDeLaCita["dni"];
?>

<html>
<head>
    <title>Cambiar una cita existente</title>
    <script language="javascript" type="text/javascript">
        /* Coloca los datos de la cita actual en los campos del formulario. */
        function mostrarDatos() {
            document.getElementById("dia").value = "<?php echo ($diaActual); ?>";
            document.getElementById("mes").value = "<?php echo ($mesActual); ?>";
            document.getElementById("annio").value = "<?php echo ($annioActual); ?>";
            document.getElementById("hora_inicio").value = "<?php echo ($horaActual); ?>";
            document.getElementById("minutos_inicio").value = "<?php echo ($minutoActual); ?>";
            document.getElementById("hora_fin").value = "<?php echo ($horaFinActual); ?>";
            document.getElementById("minutos_fin").value = "<?php echo ($minutoFinActual); ?>";
            document.getElementById("comentario").value = "<?php echo ($comentarioActual); ?>";
            document.getElementById("dni").value = "<?php echo ($dniActual); ?>";
            
            // Verificar el valor de facturada y marcar/desmarcar el checkbox
            var facturadaValue = "<?php echo ($facturadaActual); ?>";
            document.getElementById("facturada").checked = (facturadaValue == 1);
        }

        /* Envía el formulario a donde proceda. */
        function mandar(resultado) {
            // Establecer el valor de facturada en el campo oculto
            document.getElementById("facturada").value = document.getElementById("facturadaCheckbox").checked ? 1 : 0;

            if (resultado) {
                document.formularioNuevaCita.action = "grabarCambios.php";
            } else {
                document.formularioNuevaCita.action = "agenda.php";
            }
            document.formularioNuevaCita.submit();
        }
    </script>
</head>

<body onLoad="javascript:mostrarDatos();">
    <form action="" method="post" name="formularioNuevaCita" id="formularioNuevaCita">
        <input type="hidden" name="fechaEnCurso" id="fechaEnCurso" value="<?php echo ($fechaEnCurso); ?>">
        <input type="hidden" name="citaSeleccionada" id="citaSeleccionada" value="<?php echo ($_POST["citaSeleccionada"]); ?>">
        <table width="500" border="0" cellspacing="0" cellpadding="4">
            <tr>
                <td width="44">Fecha:</td>
                <td width="240">
                    <select name="dia" id="dia">
                        <?php
                        for ($i = 1; $i <= 31; $i++) {
                            echo ("<OPTION VALUE='");
                            printf("%02s", $i);
                            echo ("'>");
                            printf("%02s", $i);
                            echo ("</OPTION>" . salto);
                        }
                        ?>
                    </select>
                    /
                    <select name="mes" id="mes">
                        <?php
                        $meses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
                        foreach ($meses as $key => $mes) {
                            $numeroMes = str_pad($key + 1, 2, "0", STR_PAD_LEFT);
                            echo ("<option value='" . $numeroMes . "'>" . $mes . "</option>" . salto);
                        }
                        ?>
                    </select>
                    /
                    <select name="annio" id="annio">
                        <?php
                        for ($i = 2020; $i <= 2040; $i++) echo ("<OPTION VALUE='" . $i . "'>" . $i . "</OPTION>" . salto);
                        ?>
                    </select>
                </td>
                <td width="40">Hora inicio:</td>
                <td width="144">
                    <select name="hora_inicio" id="hora_inicio">
                        <?php
                        for ($i = 0; $i < 24; $i++) {
                            echo ("<OPTION VALUE='");
                            printf("%02s", $i);
                            echo ("'>");
                            printf("%02s", $i);
                            echo ("</OPTION>" . salto);
                        }
                        ?>
                    </select>
                    :
                    <select name="minutos_inicio" id="minutos_inicio">
                        <?php
                        for ($i = 0; $i < 51; $i += 10) {
                            echo ("<OPTION VALUE='");
                            printf("%02s", $i);
                            echo ("'>");
                            printf("%02s", $i);
                            echo ("</OPTION>" . salto);
                        }
                        ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td width="40">Hora fin:</td>
                <td width="144">
                    <select name="hora_fin" id="hora_fin">
                        <?php
                        for ($i = 0; $i < 24; $i++) {
                            echo ("<OPTION VALUE='");
                            printf("%02s", $i);
                            echo ("'>");
                            printf("%02s", $i);
                            echo ("</OPTION>" . salto);
                        }
                        ?>
                    </select>
                    :
                    <select name="minutos_fin" id="minutos_fin">
                        <?php
                        for ($i = 0; $i < 51; $i += 10) {
                            echo ("<OPTION VALUE='");
                            printf("%02s", $i);
                            echo ("'>");
                            printf("%02s", $i);
                            echo ("</OPTION>" . salto);
                        }
                        ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td colspan="4">Comentario de la cita: </td>
            </tr>
            <tr>
                <td colspan="4">
                    <textarea name="comentario" cols="70" rows="5" wrap="VIRTUAL" id="comentario"></textarea>
                </td>
            </tr>
            <tr>
            <td>
                <input type="checkbox" name="facturadaCheckbox" id="facturadaCheckbox"><label for="facturadaCheckbox">Facturada</label>
                <input type="hidden" name="facturada" id="facturada" value="">
            </td>
        </tr>
        <tr>
            <td colspan="2">Nombre del Paciente: <?php echo $datosDeLaCita["nombre"]; ?></td>
        </tr>
        </table>
        <table width="500" height="44" border="0" cellpadding="0" cellspacing="0">
            <tr align="center">
                <td width="248">
                    <input name="grabarCita" type="button" id="grabarCita" value="Grabar cambios" onClick="javascript:mandar(true);">
                </td>
                <td width="252">
                    <input name="anularCita" type="button" id="anularCita" value="Descartar los cambios" onClick="javascript:mandar(false);">
                </td>
            </tr>
        </table>
    </form>
</body>
</html>