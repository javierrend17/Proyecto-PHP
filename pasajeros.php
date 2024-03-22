
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservaciones</title>
</head>
<body>
    <h2>Formulario de Reservaciones</h2>
    <form action="" method="POST">
        <label for="nombre">Nombre:</label><br>
        <input type="text" id="nombre" name="nombre" required><br>

        <label for="apellido">Apellido:</label><br>
        <input type="text" id="apellido" name="apellido" required><br>

        <label for="correo">Correo electrónico:</label><br>
        <input type="email" id="correo" name="correo" required><br>

        <label for="asientos">Asientos:</label><br>
        <input type="number" id="asientos" name="asientos" required><br>

        <?php
            echo '<label for="ruta">Ruta:</label><br>';
            echo '<select name="ruta" id="ruta" required>';
            $rutas = json_decode(file_get_contents('https://sheetdb.io/api/v1/mcxxj5s0yoew7?sheet=rutas'));
            if ($rutas == null) {
                echo"<option value='' disabled selected>No hay rutas</option>";
            } else {
                echo"<option value='' disabled selected>Seleccione una opción</option>";
                foreach ($rutas as $ruta) {
                    echo '<option>' . $ruta->nombre . '</option>';
                }
            }
            echo '</select><br><br>';
            echo '<button type="submit" name="reservar">Reservar</button><br><br>';
            
            $url = 'https://sheetdb.io/api/v1/mcxxj5s0yoew7?sheet=pasajeros';

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                echo "Se estan procesando sus datos...<br>";
                
                $nombre = $_POST['nombre'];
                $apellido = $_POST['apellido'];
                $email = $_POST['correo'];
                $asientos = $_POST['asientos'];
                $ruta = $_POST['ruta'];
                $total = 0;

                foreach ($rutas as $r) {
                    if ($r -> nombre === $ruta) {
                        $total = $asientos * ($r -> precio);
                        break;
                    }
                }
            
                $data = array(
                    'nombre' => $nombre,
                    'apellido' => $apellido,
                    'ruta' => $ruta,
                    'asientos' => $asientos,
                    'email' => $email,
                    'total' => $total
                );

                $options = array(
                    'http' => array(
                        'method'  => 'POST',
                        'header'  => 'Content-type: application/json',
                        'content' => json_encode($data)
                    )
                );

                $context  = stream_context_create($options);
                $result = file_get_contents($url, false, $context);
            
            
                if ($result === false) {
                    echo "Error al enviar los datos a la API";
                } else {
                    echo "Los datos se enviaron correctamente a la API";
                }
            }
        ?> 
    </form>
</body>
</html>
