<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $patente = $_POST['patente'];
    $nombre_cliente = $_POST['nombre_cliente'];
    $descripcion = $_POST['descripcion'];
    $fecha = $_POST['fecha'];
    $valor_trabajo = $_POST['valor_trabajo'];
    $descuento = $_POST['descuento'];
    $estado = $_POST['estado'];
    $kilometraje = $_POST['kilometraje']; // Agregamos el campo "kilometraje"

    // Realiza la conexión a la base de datos y realiza la inserción
    $servername = "localhost";
    $username = "root";
    $password = "Multi*1234";
    $dbname = "taller_mecanico";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    // Inserta los valores en la base de datos
    $insert_query = "INSERT INTO ordenes_trabajo (patente, nombre_cliente, descripcion, fecha, valor_trabajo, descuento, estado, kilometraje) VALUES ('$patente', '$nombre_cliente', '$descripcion', '$fecha', '$valor_trabajo', '$descuento', '$estado', '$kilometraje')";

    if ($conn->query($insert_query) === TRUE) {
        header("Location: listado_ordenes.php"); // Redirige al listado de órdenes
    } else {
        echo "Error al crear la orden: " . $conn->error;
    }

    $conn->close();
}
?>
