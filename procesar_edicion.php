<?php
session_start();

// ...

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $orden_id = $_POST['orden_id'];
    $descripcion = $_POST['descripcion'];
    $fecha = $_POST['fecha'];
    $valor_trabajo = $_POST['valor_trabajo'];
    $descuento = $_POST['descuento'];
    $estado = $_POST['estado'];
    $patente = $_POST['patente'];
    $nombre_cliente = $_POST['nombre_cliente'];
    $kilometraje = $_POST['kilometraje']; // Agrega esta línea

    $servername = "localhost";
    $username = "root";
    $password = "Multi*1234";
    $dbname = "taller_mecanico";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    // Sentencia preparada para la actualización
    $query = "UPDATE ordenes_trabajo SET descripcion=?, fecha=?, valor_trabajo=?, descuento=?, estado=?, patente=?, nombre_cliente=?, kilometraje=? WHERE id=?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssddssssi", $descripcion, $fecha, $valor_trabajo, $descuento, $estado, $patente, $nombre_cliente, $kilometraje, $orden_id);

    if ($stmt->execute()) {
        // Actualización exitosa
        header("Location: listado_ordenes.php"); // Redireccionar al listado de órdenes
        exit();
    } else {
        // Error en la actualización
        echo "Error al actualizar la orden: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    header("Location: editar_ordenes.php?id=$orden_id"); // Redireccionar en caso de acceso directo a procesar_edicion.php
    exit();
}

