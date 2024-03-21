<?php
    // Incluir el archivo de conexión a la base de datos
    include 'conexion.php';

    // Verificar si se han enviado los datos necesarios desde el formulario
    if(isset($_POST['titulo']) && isset($_POST['descripcion']) && isset($_FILES['portada']) 
        && isset($_POST['puesto']) && isset($_POST['marca']) && isset($_POST['ciudades'])) {
    
        // Obtener los datos del formulario
        $titulo = $_POST['titulo'];
        $descripcion = $_POST['descripcion'];
        $portada = $_FILES['portada'];
        $archivo = $_FILES['archivo'];
        $puestosSeleccionados = $_POST['puesto'];
        $marcasSeleccionadas = $_POST['marca'];
        # $ciudadesSeleccionadas = $_POST['ciudades']; // Nuevas ciudades seleccionadas

        // var_dump($ciudadesSeleccionadas);
        // exit;

        // Procesar la portada
        $nombre_portada = $portada['name'];
        $ruta_temporal = $portada['tmp_name'];
        $ruta_destino = 'C:/xampp/htdocs/uploads/' . $nombre_portada;

        // Mover la portada a la ubicación deseada
        if(move_uploaded_file($ruta_temporal, $ruta_destino)){
            echo "La portada se ha subido correctamente";
        } else {
            echo "Hubo un error al subir la portada";
        }

        // Procesar el archivo
        $nombre_archivo = $archivo['name'];
        $ruta_temporal_a = $archivo['tmp_name'];
        $ruta_destino_a = 'C:/xampp/htdocs/uploads/' . $nombre_archivo;

        // Mover el archivo a la ubicación deseada
        if(move_uploaded_file($ruta_temporal_a, $ruta_destino_a)){
            echo "El archivo se ha subido correctamente";
        } else {
            echo "Hubo un error al subir el archivo";
        }

        # echo gettype($ciudadesSeleccionadas); string

        // Convertir los arrays de puestos y marcas seleccionadas a cadenas
        $puestos_str = implode(',', $puestosSeleccionados);
        $marcas_str = implode(',', $marcasSeleccionadas);

        // Dividir las cadenas separadas por comas en arrays
        $puestos_array = explode(',', $puestos_str);
        $marcas_array = explode(',', $marcas_str);

        // // Iterar sobre los arrays resultantes
        // for ($i = 0; $i < count($puestos_array); $i++) {
        //     echo $puestos_array[$i] . "<br>";
        // }

        // for ($i = 0; $i < count($marcas_array); $i++) {
        //     echo $marcas_array[$i] . "<br>";
        // }

        // Convertir el array de ciudades seleccionadas a una cadena
        # $ciudades_str = implode(',', $ciudadesSeleccionadas);

        exit;

        // Validar los datos
        function validarDatos($titulo, $descripcion, $puestos_str, $marcas_str) {
            if($titulo == '') {
                return false;
            } elseif($descripcion == '') {
                return false;
            } elseif($puestos_str == '') {
                return false;
            } elseif($marcas_str == '') {
                return false;
            }

            return true;
        }

        // Si los datos son válidos, insertarlos en la base de datos
        if(validarDatos($titulo, $descripcion, $puestos_str, $marcas_str)) {
            $statement = $conexion->prepare("INSERT INTO comunicados_tabla(titulo, descripcion, portada, archivo, puesto, marca) VALUES(?,?,?,?,?,?)");
            $statement->bind_param("ssssss", $titulo, $descripcion, $nombre_portada, $nombre_archivo, $puestos_str, $marcas_str);
            $statement->execute();

            if($conexion->affected_rows <= 0) {
                $respuesta = ['error' => true];
            } else {
                $respuesta = ['success' => true]; // Indica el éxito de la inserción
            }
        } else {
            $respuesta = ['error' => true];
        }

        // print_r($ciudades_str);
    }

   
?>
