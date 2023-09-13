<?php
// functions.php

// Función para obtener el valor del trabajo de una orden
function obtenerValorTrabajo($conn, $numero_orden) {
    $query = "SELECT valor_trabajo FROM ordenes_trabajo WHERE numero_orden = '$numero_orden'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['valor_trabajo'];
    } else {
        return "N/A"; // Valor por defecto si no se encuentra la orden
    }
}
?>
