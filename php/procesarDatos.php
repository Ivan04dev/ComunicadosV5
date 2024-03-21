<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    </head>
    <body>

<?php
    include 'conexion.php';

    if(isset($_POST['selectedValues'])){
        $datos = $_POST['selectedValues'];
        $datos_separados = explode(',', $datos);
        // echo gettype($datos_separados); :array

    
        function procesa_arreglo_ciudades($arreglo){
            $nuevo_arreglo = [];
            for($i = 0; $i < count($arreglo); $i++){
                if($arreglo[$i] !== 'Ejecutivo ATC' && 
                   $arreglo[$i] !== 'Ejecutivo Sr ATC' && 
                   $arreglo[$i] !== 'Jefe ATC' && 
                   $arreglo[$i] !== 'Jefe Regional ATC' && 
                   $arreglo[$i] !== 'Gerente ATC' && 
                   $arreglo[$i] !== 'izzi' && 
                   $arreglo[$i] !== 'wizz' && 
                   $arreglo[$i] !== 'wizz plus'){
                    $nuevo_arreglo[] = $arreglo[$i];
                }
            }
            return $nuevo_arreglo;
        }
    
        $nuevo_arreglo_ciudades = procesa_arreglo_ciudades($datos_separados);
        

        // echo gettype($nuevo_arreglo_ciudades);
        // print_r($nuevo_arreglo_ciudades);

        $ciudades_str = implode(',', $nuevo_arreglo_ciudades);

        // echo gettype($ciudades_str);
    
    } else {
        echo 'No tiene datos';
    }

    // exit;
    
    if(isset($_POST['titulo']) && isset($_POST['descripcion'])  && isset($_FILES['portada']) 
        && isset($_POST['puesto']) && isset($_POST['marca'])) {
    
        $titulo = $_POST['titulo'];
        $descripcion = $_POST['descripcion'];
        $portada = $_FILES['portada'];
        $archivo = $_FILES['archivo'];
        $puestosSeleccionados = $_POST['puesto'];
        $marcasSeleccionadas = $_POST['marca'];


        // echo gettype($puestosSeleccionados); :array 

        $nombre_portada = $portada['name'];
        $ruta_temporal = $portada['tmp_name'];
        $ruta_destino = 'C:/xampp/htdocs/uploads/' . $nombre_portada;

        /*
        // Verifica si se han enviado archivos
        if(isset($_FILES['archivo'])) {
            // Contador para mostrar el número de archivos subidos
            $numArchivos = count($_FILES['archivo']['name'], COUNT_NORMAL);
            
            // Iterar sobre cada archivo
            for($i = 0; $i < $numArchivos; $i++) {
                $nombreArchivo = $_FILES['archivo']['name'][$i];
                $tipoArchivo = $_FILES['archivo']['type'][$i];
                $tamanoArchivo = $_FILES['archivo']['size'][$i];
                $rutaTemporal = $_FILES['archivo']['tmp_name'][$i];
                $error = $_FILES['archivo']['error'][$i];

                // Insertar el nombre del archivo en la base de datos
                $sql = "INSERT INTO comunicados_tabla (archivo) VALUES ('$nombreArchivo')";
                
                // Mueve el archivo de la ruta temporal a una ubicación deseada
                $rutaDestino = 'uploads/' . $nombreArchivo;
                if(move_uploaded_file($rutaTemporal, $rutaDestino)) {
                    echo "El archivo $nombreArchivo se ha subido correctamente.<br>";
                } else {
                    echo "Hubo un error al subir el archivo $nombreArchivo.<br>";
                }
            }
        }
        */

        
        $nombre_archivo = $archivo['name'];
        $ruta_temporal_a = $archivo['tmp_name'];
        $ruta_destino_a = 'C:/xampp/htdocs/uploads/' . $nombre_archivo;
        

        if(move_uploaded_file($ruta_temporal, $ruta_destino)){
            echo "La portada se ha subido correctamente";
        } else {
            echo "Hubo un error al subir la portada";
        }

        if(move_uploaded_file($ruta_temporal_a, $ruta_destino_a)){
            echo "El archivo se ha subido correctamente";
        } else {
            echo "Hubo un error al subir el archivo";
        }
        

        $puestos_str = implode(',', $puestosSeleccionados);
        $marcas_str = implode(',', $marcasSeleccionadas);
    }

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

    if(validarDatos($titulo, $descripcion, $puestos_str, $marcas_str)) {
        $statement = $conexion->prepare("INSERT INTO comunicados_tabla(titulo, descripcion, portada, archivo, puesto, marca, ciudades) VALUES(?,?,?,?,?,?, ?)");
        $statement->bind_param("sssssss", $titulo, $descripcion, $nombre_portada, $nombre_archivo, $puestos_str, $marcas_str, $ciudades_str);
        $statement->execute();

        if($conexion->affected_rows <= 0) {
            $respuesta = ['error' => true];
        } else {
            $respuesta = ['success' => true]; // Indica el éxito de la inserción
        }
    } else {
        $respuesta = ['error' => true];
    }

    // ---------------------------------------------------------------------------------------------------------

    echo $titulo . "<br>";
    echo $descripcion;

    echo "<h2>Puestos Seleccionadas</h2> <br/>";

    // Verificar si se han enviado los valores seleccionados
    if (isset($_POST['valores_seleccionados'])) {
        // Obtener los valores seleccionados del campo oculto
        $valoresSeleccionados = explode(',', $_POST['valores_seleccionados']);

        // echo gettype($valoresSeleccionados); :array 

        // Escapar los valores seleccionados para prevenir inyección de SQL
        $valoresSeleccionadosEscapados = array();
        foreach ($valoresSeleccionados as $valor) {
            $valoresSeleccionadosEscapados[] = $conexion->real_escape_string($valor);
        }

        // echo gettype($valoresSeleccionadosEscapados); :array 

        // Construir la consulta SQL utilizando los valores seleccionados
        $sql = "SELECT * FROM atc_staff WHERE puesto IN ('" . implode("','", $valoresSeleccionadosEscapados) . "')";

        // Ejecutar la consulta
        $result = $conexion->query($sql);

        // Verificar si se encontraron resultados
        if ($result->num_rows > 0) {
            // Mostrar los resultados
            while ($row = $result->fetch_assoc()) {
                // Muestra los campos
                // echo $row["NOMBRE"] . $row["APPATERNO"] . $row["APMATERNO"] . "\t" . $row["USUARIORED"]. "\t" . $row["CORREO"] . "\t" . $row["PUESTO"]."<br>";
            }
        } else {
            echo "No se encontraron usuarios para los puestos seleccionados.";
        }

    } else {
        echo "No se han seleccionado valores.";
    }

    
    /*
    // var_dump($_POST['selectedValues']);
    $ciudades_str = $_POST['selectedValues'];

    // Verificar si $puestosSeleccionados es una cadena y convertirla a un array si es necesario
    if (is_string($puestosSeleccionados)) {
        $puestosSeleccionados = explode(',', $puestosSeleccionados);
    }

    // Luego, puedes utilizar implode correctamente
    $puestos_str = implode(',', $puestosSeleccionados);
    */

    echo "<h2>Puestos: </h2> <br/>";
    print_r($puestos_str); 
    echo "<h2>Marcas: </h2> <br/>";
    print_r($marcas_str);
    echo "<h2>Ciudades: </h2> <br/>";
    print_r($ciudades_str); 
    echo "<br /> <br /> <hr />";

    /*
    $puestos_array = [];

    foreach ($puestos_str as $valor) {
        $puestos_array[] = $conexion->real_escape_string($valor);
    }

    echo gettype($puestos_array);

    exit;
    */

    // Consulta dinámica a la DB 
    $sql_consulta = "SELECT nombre, appaterno, apmaterno, usuariored
    FROM atc_staff
    INNER JOIN atc_sucursal
    ON atc_staff.sucursal = atc_sucursal.sucursal
    WHERE puesto IN ('" . implode("','", $puestosSeleccionados) . "')";

    $sql_consulta_dos = "SELECT ciudad, marca
    FROM atc_sucursal
    INNER JOIN atc_staff
    ON atc_staff.sucursal = atc_sucursal.sucursal
    WHERE marca IN ('" . implode("','", $marcasSeleccionadas) . "')";


    $resultado = $conexion->query($sql);
    $resultado_dos = $conexion->query($sql_consulta_dos);

    var_dump($resultado_dos);

    // exit;

    // echo gettype($resultado); :object 

    // Verificar si se encontraron resultados
    if ($resultado->num_rows > 0) {
        // Mostrar los resultados
        while ($row = $resultado->fetch_assoc()) {
            // Muestra los campos
            echo $row["NOMBRE"]. "\t"  . $row["APPATERNO"]. "\t"  . $row["APMATERNO"] . "\t" . $row["USUARIORED"]. "\t" . $row['PUESTO']. "\t"  ."<br>";
        }
    } else {
        echo "No se encontraron usuarios para los puestos seleccionados.";
    }

    // Verificar si se encontraron resultados
    if ($resultado_dos->num_rows > 0) {
        // Mostrar los resultados
        while ($row = $resultado->fetch_assoc()) {
            // Muestra los campos
            echo $row["CIUDAD"]. "\t"  . $row["MARCA"]."<br>";
        }
    } else {
        echo "No se encontraron marcas";
    }

    exit;
    // var_dump($resultado);: object 

    ?>

   
        <table class="table table-stripered">
            <thead>
                <tr>
                    <th scope="col">Nombre</th>
                    <th scope="col">Usuario</th>
                    <th scope="col">Puesto</th>
                    <th scope="col">Ciudad</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    /*
                    $sql_consulta_staff = "SELECT nombre, appaterno, apmaterno, usuariored
                    FROM atc_staff AND
                    SELECT ciudad FROM atc_sucursal
                    INNER JOIN atc_sucursal
                    ON atc_staff.sucursal = atc_sucursal.sucursal
                    WHERE puesto IN ('" . implode("','", $puestosSeleccionados) . "') AND marca IN ('" . implode("','", $marcasSeleccionadas) . "') 
                    AND ciudad IN ('" . implode("','", $nuevo_arreglo_ciudades) . "')";
                    */

                    $sql_consulta_staff = "SELECT nombre, appaterno, apmaterno, usuariored
                    FROM atc_staff
                    WHERE puesto IN ('" . implode("','", $puestosSeleccionados) . "')
                    ";

                    $resultado = $conexion->query($sql_consulta_staff);

                    var_dump($resultado);
                    // print_r($resultado);
                    exit;
                
                    while ($row = $resultado->fetch_assoc()) : 
                ?>
                <tr>
                    <td><?php echo $row["NOMBRE"] . " " . $row["APPATERNO"] . " " . $row["APMATERNO"]; ?></td>
                    <td><?php echo $row["USUARIORED"]; ?></td>
                    <td><?php echo $row["PUESTO"]; ?></td>
                    <!-- <td><#?php echo $row["MARCA"]; ?></td> -->
                    <!-- <td>#<#?php echo $row["CIUDAD"]; ?></td> -->
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </body>
    </html>

    