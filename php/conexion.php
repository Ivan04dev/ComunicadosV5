<?php
    // Datos de conexión a la base de datos
    $host = "localhost"; // Cambia esto por tu host si es diferente
    $usuario = "root"; // Cambia esto por tu usuario de la base de datos
    $password = ""; // Cambia esto por tu contraseña
    $base_datos = "comunicados"; // Cambia esto por el nombre de tu base de datos

    // Crear una conexión a la base de datos
    $conexion = new mysqli($host, $usuario, $password, $base_datos);

    // Verificar la conexión
    if ($conexion->connect_error) {
        die("Error en la conexión: " . $conexion->connect_error);
    } 

    // echo "Conexión exitosa";