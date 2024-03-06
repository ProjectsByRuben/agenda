<?php
        $cons_usuario="root";
        $cons_contra="root";
        $cons_base_datos="usuariosbd";
        $cons_equipo="localhost";
    
        $conexion = mysqli_connect($cons_equipo,$cons_usuario,$cons_contra,$cons_base_datos);
        if(!$conexion)
        {
          echo "<h3>No se ha podido conectar PHP - MySQL, verifique sus datos.</h3><hr><br>";
        }      
        
  
  
  //echo("estoy en usarBD");
  //$conexion = mysql_connect("localhost","root","root");
  //$baseDeDatos = mysql_select_db("agenda",$conexion);
  
?>
