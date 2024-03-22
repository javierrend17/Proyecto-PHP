<!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Formulario de Rutas</title>
    </head>
    <body>
        <h2>Formulario de Rutas</h2>
        <form action="" method="post">
            <label for="id">ID:</label><br>
            <input type="text" id="id" name="id" required><br>

            <label for="nombre">Nombre:</label><br>
            <input type="text" id="nombre" name="nombre" required><br>

            <label for="destinos">Destinos:</label><br>
            <input type="text" id="destinos" name="destinos" required><br>

            <label for="horario">Horario:</label><br>
            <input type="text" id="horario" name="horario" required><br>

            <label for="precio">Precio:</label><br>
            <input type="number" id="precio" name="precio" required><br><br>

            <input type="submit" value="Enviar">
        </form>
    </body>
</html>


<?php

    class Ruta {
        public $id;
        public $nombre;
        public $destinos;
        public $horario;
        public $precio;

        public function __construct($id, $nombre, $destinos, $horario, $precio) {
            $this->id = $id;
            $this->nombre = $nombre;
            $this->destinos = $destinos;
            $this->horario = $horario;
            $this->precio = $precio;
        }

        public static function crearRuta($id, $nombre, $destinos, $horario, $precio) {
            return new Ruta($id, $nombre, $destinos, $horario, $precio);
        }



    }

    $url = 'https://sheetdb.io/api/v1/mcxxj5s0yoew7?sheet=rutas';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $id = $_POST['id'];
        $nombre = $_POST['nombre'];
        $destinos = $_POST['destinos'];
        $horario = $_POST['horario'];
        $precio = $_POST['precio'];
    
        $data = array(
            'id' => $id,
            'nombre' => $nombre,
            'destinos' => $destinos,
            'horario' => $horario,
            'precio' => $precio
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
    
    
        if ($result === FALSE) {
            echo "Error al enviar los datos a la API";
        } else {
            echo "Los datos se enviaron correctamente a la API";
        }
    } else {
        echo "No se ha enviado ningún formulario<br><br>";
    }

    $response = file_get_contents($url);
    $array = json_decode($response, true);

    if ($array !== null) {
        echo '<table border="1">';
        echo '<tr><th>ID</th><th>Nombre</th><th>Destinos</th><th>Horario</th><th>Precio</th></tr>';
        foreach ($array as $value) {
            echo '<tr>';
            echo '<td>' . $value['id'] . '</td>';
            echo '<td>' . $value['nombre'] . '</td>';
            echo '<td>' . $value['destinos'] . '</td>';
            echo '<td>' . $value['horario'] . '</td>';
            echo '<td>' . $value['precio'] . '</td>';
            echo '</tr>';
        }
        echo '</table>';
    } else {
        echo 'No se pudo obtener la información de la API.';
    }
?>