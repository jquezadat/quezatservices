<?php
session_start();

$ordenesPorPagina = 10; // Cambia este valor según tus preferencias
$paginaActual = isset($_GET['pagina']) ? $_GET['pagina'] : 1;

$servername = "localhost";
$username = "root";
$password = "Multi*1234";
$dbname = "taller_mecanico";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$query = "SELECT COUNT(*) as total FROM ordenes_trabajo";
$result = $conn->query($query);
$totalFilas = $result->fetch_assoc()['total'];
$totalPaginas = ceil($totalFilas / $ordenesPorPagina);

$offset = ($paginaActual - 1) * $ordenesPorPagina;
$query = "SELECT * FROM ordenes_trabajo ORDER BY id DESC LIMIT $offset, $ordenesPorPagina"; // Agregamos el ORDER BY para ordenar por ID de forma descendente
$resultado = $conn->query($query);
?>

<h2>Listado de Órdenes de Trabajo</h2>
<table class="orden-table">
  <tr>
    <th>id</th>
    <th>Descripción</th>
    <th>Fecha</th>
    <th>Valor del Trabajo</th>
    <th>Descuento</th>
    <th>Total</th>
    <th>Estado</th>
    <th>Acciones</th>
  </tr>
  <?php
  if ($resultado->num_rows > 0) {
    while ($fila = $resultado->fetch_assoc()) {
      echo "<tr>";
      echo "<td>" . $fila['id'] . "</td>";
      echo "<td>" . $fila['descripcion'] . "</td>";
      echo "<td>" . $fila['fecha'] . "</td>";
      echo "<td>" . $fila['valor_trabajo'] . "</td>";
      echo "<td>" . $fila['descuento'] . "</td>";
      $Total = $fila['valor_trabajo'] - (($fila['valor_trabajo'] * $fila['descuento']) / 100);
      echo "<td>" . $Total . "</td>";
      echo "<td>" . $fila['estado'] . "</td>";
      echo "<td><a href='editar_orden.php?id=" . $fila['id'] . "'>Editar</a></td>"; // Botón de edición
      echo "</tr>";
    }
  } else {
    echo "<tr><td colspan='8'>No hay órdenes de trabajo registradas</td></tr>";
  }
  ?>
</table>

<div class="pagination">
  <?php
  for ($i = 1; $i <= $totalPaginas; $i++) {
    echo "<a href='listado_ordenes.php?pagina=$i'>$i</a> ";
  }
  ?>
</div>

<?php
$conn->close();
?>
