<?php
    
    // Variables de la conexion a la DB
    $mysqli = new mysqli("localhost","root","root","usuariosbd2");
    // echo "intentando conectar....";
    // Comprobamos la conexion
    if($mysqli->connect_errno) {
        die("Fallo la conexion");
    } else {
        //echo "Conexion exitosa";
    }