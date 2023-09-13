<?php
session_start();
if (isset($_SESSION['username'])) {
  // Conexión a la base de datos
  $servername = "localhost";
  $username = "root";
  $password = "Multi*1234";
  $dbname = "taller_mecanico";

  $conn = new mysqli($servername, $username, $password, $dbname);

  if ($conn->connect_error) {
      die("La conexión a la base de datos falló: " . $conn->connect_error);
  }

  // Procesar la recepción del trabajo
  $orden_id = $_POST['orden_id']; // Suponiendo que tienes un campo oculto con el ID de la orden
  $monto_total = $_POST['monto_total']; // Suponiendo que obtienes el monto total de alguna manera

  // Calcula el 19% del monto total
  $trabajador_pago = $monto_total * 0.19;

  // Actualizar el estado de la orden como completada y registrar el pago al trabajador
  $sql_update = "UPDATE ordenes SET estado='completada' WHERE id=$orden_id";
  $sql_insert_pago = "INSERT INTO pagos (orden_id, trabajador_id, monto) VALUES ($orden_id, $_SESSION[user_id], $trabajador_pago)";

  // Ejecutar las consultas
  $conn->query($sql_update);
  $conn->query($sql_insert_pago);

  $conn->close();
}
?>
