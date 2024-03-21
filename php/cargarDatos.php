<?php
    // Conectar a la base de datos y realizar la consulta
    include 'conexion.php';

    // Obtener las marcas seleccionadas desde la solicitud AJAX
    $selectedBrands = $_POST['marcas'];

    // Consultar las divisiones, regiones y ciudades correspondientes a las marcas seleccionadas
    $query = "SELECT DISTINCT division, region, ciudad FROM atc_sucursal WHERE marca IN ('" . implode("','", $selectedBrands) . "') AND UPPER(division) NOT IN ('METRO SUR', 'METROSUR') ORDER BY division ASC";

    // Ejecuta la consulta 
    $result = mysqli_query($conexion, $query);

    // Construye una estructura de datos para almacenar divisiones, regiones y ciudades
    $divisiones = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $division = $row['division'];
        $region = $row['region'];
        $ciudad = $row['ciudad'];
        
        // Agregar la ciudad a la región correspondiente
        if (!isset($divisiones[$division])) {
            $divisiones[$division] = [];
        }
        if (!isset($divisiones[$division][$region])) {
            $divisiones[$division][$region] = [];
        }
        if (!in_array($ciudad, $divisiones[$division][$region])) {
            $divisiones[$division][$region][] = $ciudad;
        }
    }

    // Devolver la estructura de datos como respuesta
    echo json_encode($divisiones);