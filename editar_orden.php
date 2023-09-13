<?php
session_start();
$orden_id = $_GET['id']; // Obtén el ID de la orden de la URL

$servername = "localhost";
$username = "root";
$password = "Multi*1234";
$dbname = "taller_mecanico";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$query = "SELECT * FROM ordenes_trabajo WHERE id = $orden_id";
$result = $conn->query($query);
$orden = $result->fetch_assoc();

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="styles.css">
  <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <style>
    /* Estilos específicos para la página de edición */
    body {
      font-family: Arial, sans-serif;
      background-color: #e74c3c; /* Color rojo para el fondo*/
      margin: 0;
      padding: 0;
    }
    .edit-container {
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      height: 100vh;
    }
    .edit-title {
      font-size: 20px;
      color: #333;
      margin-bottom: 10px;
      text-align: center;
    }
    .form-container {
      width: 100%;
      max-width: 400px; /* Aumenta el ancho del formulario */
      background-color: #fff;
      box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
      border-radius: 5px;
      padding: 20px; /* Añade un poco más de espacio interno */
      margin-top: 20px;
    }
    .form-container label {
      font-weight: bold;
      display: block;
      text-align: center; /* Centra las etiquetas */
    }
    .form-container input[type="text"],
    .form-container textarea,
    .form-container select {
      width: 100%;
      padding: 6px;
      margin-bottom: 10px; /* Aumenta el espacio inferior */
      border: 1px solid #ccc;
      border-radius: 3px;
    }
    .form-container select {
      padding: 4px;
    }
    .form-container button {
      background-color: #4caf50;
      color: #fff;
      border: none;
      padding: 6px 10px;
      border-radius: 3px;
      cursor: pointer;
      display: block;
      margin: 0 auto;
    }
    .form-container button:hover {
      background-color: #45a049;
    }
  </style>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <title>Editar Orden de Trabajo</title>
</head>
<body>
  <div class="edit-container">
    <h1 class="edit-title">Editar Orden de Trabajo</h1>
    <div class="form-container">
      <form action="procesar_edicion.php" method="post">
        <input type="hidden" name="orden_id" value="<?php echo $orden_id; ?>">
        
        <label for="descripcion">Descripción:</label>
        <textarea id="descripcion" name="descripcion" required><?php echo $orden['descripcion']; ?></textarea>
        
        <label for="fecha">Fecha:</label>
        <input type="date" id="fecha" name="fecha" value="<?php echo $orden['fecha']; ?>" required>
        
        <label for="valor_trabajo">Valor del Trabajo:</label>
        <input type="number" id="valor_trabajo" name="valor_trabajo" value="<?php echo $orden['valor_trabajo']; ?>" step="0.01" required>

        <label for="descuento">Descuento:</label>
        <input type="number" id="descuento" name="descuento" value="<?php echo $orden['descuento']; ?>" step="1" required>
        
        <label for="estado">Estado:</label>
        <select id="estado" name="estado" required>
          <option value="En Proceso" <?php if ($orden['estado'] === 'En Proceso') echo 'selected'; ?>>En Proceso</option>
          <option value="Completada" <?php if ($orden['estado'] === 'Completada') echo 'selected'; ?>>Completada</option>
        </select>
        
        <label for="patente">Patente del Vehículo:</label>
        <input type="text" id="patente" name="patente" value="<?php echo $orden['patente']; ?>" required>

        <label for="kilometraje">Kilometraje del Vehículo:</label>
        <input type="text" id="kilometraje" name="kilometraje" class="compact-input" required value="<?php echo $orden['kilometraje']; ?>">

        
        <label for="nombre_cliente">Nombre del Cliente:</label>
        <input type="text" id="nombre_cliente" name="nombre_cliente" value="<?php echo $orden['nombre_cliente']; ?>" required>
        
        <button type="submit">Guardar</button>
      </form>
    </div>
  </div>
</body>
</html>





