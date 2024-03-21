<?php 
    # Función implode() - Convierte un arreglo en una cadena separada por un delimitador
    $meses = array("Enero", "Febrero", "Marzo");
    echo gettype($meses) . "<br />";
    $meses_str = implode(",", $meses);
    echo gettype($meses_str) . "<br />";
    echo $meses_str . "<br />";

    # Función explode() - Divide una cadena de texto en un arreglo separada por un delimitador
    $meses_array = [];
    $meses_array = explode(',', $meses_str);
    echo gettype($meses_array);

    foreach($meses_array as $mes){
        echo $mes . "<br />";
    }