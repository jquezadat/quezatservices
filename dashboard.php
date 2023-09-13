<?php
session_start();
if (!isset($_SESSION['username'])) {
  header("Location: index.html");
  exit();
}

$servername = "localhost";
$username = "root";
$password = "Multi*1234";
$dbname = "taller_mecanico";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("La conexión a la base de datos falló: " . $conn->connect_error);
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
  <!-- Encabezado y estilos -->
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="styles.css">
  <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <style>
    /* Estilos personalizados */
    body {
      font-family: Arial, sans-serif;
      background-color: rgba(177, 42, 8, 0.911);/* Color rojo para el fondo*/
      margin: 0;
      padding: 0;
    }
    .dashboard-container {
      text-align: center;
      margin-top: 50px;
      padding: 20px;
    }
    .dashboard-title {
      font-size: 28px;
      margin-bottom: 20px;
      color: #333;
    }
    .welcome-message {
      font-size: 18px;
      margin-bottom: 20px;
      color: #333;
    }
    .button {
      background-color: #3498db; /* Color azul para el botón "Ver Listado de Órdenes de Trabajo" */
      color: #fff;
      padding: 10px 20px;
      text-decoration: none;
      border-radius: 5px;
      transition: background-color 0.3s; /* Agregar transición suave al color */
    }
    .button:hover {
      background-color: #2980b9; /* Cambio de color al pasar el mouse */
    }
    .green-button {
      background-color: #27ae60; /* Color verde para el botón "Crear Orden" */
      color: #fff;
      padding: 10px 20px;
      border-radius: 5px;
      cursor: pointer;
      transition: background-color 0.3s; /* Agregar transición suave al color */
    }
    .green-button:hover {
      background-color: #219451; /* Cambio de color al pasar el mouse */
    }
    .logout-link {
      display: block;
      margin-top: 20px;
      color: #3498db;
    }
    .form-container {
      background-color: #fff;
      padding: 20px;
      border-radius: 5px;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
      text-align: center; /* Alineación centrada de los elementos del formulario */
      margin: 0 auto; /* Centrar el formulario horizontalmente */
      max-width: 500px; /* Ajustar el ancho máximo del formulario */
    }
    label {
      display: block;
      margin-bottom: 5px;
      text-align: left; /* Alineación izquierda para las etiquetas */
    }
    input[type="text"],
    textarea,
    select {
      width: 100%;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 5px;
      margin-bottom: 10px;
      font-size: 14px;
    }
  </style>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <title>Panel de Control</title>
</head>
<body>
  <div class="dashboard-container">
    <h1 class="dashboard-title">Bienvenido al Panel de Control</h1>
    <p class="welcome-message">¡Hola, <?php echo $_SESSION['username']; ?>! Aquí puedes administrar tus órdenes de trabajo.</p>
    <!-- Botón para acceder al listado de órdenes de trabajo -->
    <a href="listado_ordenes.php" class="button">Ver Listado de Órdenes de Trabajo</a>
    <!-- Nuevo botón para ver el resultado total mensual -->
    <a href="resultado_total_mensual.php" class="button">Ver Resultado Total Mensual</a>
    <div class="form-container">
      <h2>Crear Nueva Orden de Trabajo</h2>
      <form id="frmordenes" method="post">
        <!-- ... (formulario para crear una nueva orden) ... -->
        <label for="patente">Patente del Vehículo:</label>
        <input type="text" id="patente" name="patente" required>

        <label for="kilometraje">Kilometraje del Vehículo:</label>
        <input type="text" id="kilometraje" name="kilometraje" class="compact-input" required>

        <label for="nombre_cliente">Nombre del Cliente:</label>
        <input type="text" id="nombre_cliente" name="nombre_cliente" required>

        <label for="descripcion">Descripción:</label>
        <textarea id="descripcion" name="descripcion" required></textarea>

        <label for="fecha">Fecha:</label>
        <input type="text" id="fecha" name="fecha" class="compact-input" required>

        <label for="valor_trabajo">Valor Trabajo:</label>
        <input type="text" id="valor_trabajo" name="valor_trabajo" class="compact-input" required>

        <label for="descuento">Descuento:</label>
        <input type="text" id="descuento" name="descuento" class="compact-input" required>

        <label for="estado">Estado:</label>
        <select id="estado" name="estado" required>
          <option value="En Proceso">En Proceso</option>
          <option value="Completada">Completada</option>
          <!-- Agregar más opciones de estados aquí si es necesario -->
        </select>
        <br>
        <input type="button" value="Crear Orden" class="green-button" onclick="crear_orden();">
      </form>
    </div>
    <div class="login-footer">
      <p>Developer QuezatServices</p>
    </div>
    <a class="logout-link" href="logout.php">Cerrar Sesión</a>
  </div>

  <script>
    $(function() {
      $("#fecha").datepicker();
    });

    function crear_orden() {
      // Obtener datos del formulario y realizar la llamada AJAX
      $.ajax({
        type: "POST",
        url: "procesar_creacion.php", // Ajusta la ruta según corresponda
        data: $("#frmordenes").serialize(),
        success: function(data) {
          // Limpiar los campos del formulario o realizar otras acciones después de crear la orden
          // Redirigir a la página de listado de órdenes de trabajo
          window.location.href = 'listado_ordenes.php';
        },
        error: function(xhr, status, error) {
          console.log("Error al crear la orden: " + error);
        }
      });
    }
  </script>
</body>
</html>



