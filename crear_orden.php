<?php
session_start();

if (!isset($_SESSION['username'])) {
  header("Location: index.html");
  exit();
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
  <!-- ... (otros enlaces y estilos) ... -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <title>Crear Nueva Orden de Trabajo</title>
</head>
<body>
  <div class="dashboard-container">
    <h1 class="dashboard-title">Crear Nueva Orden de Trabajo</h1>
    <div class="form-container">
      <h2>Crear Nueva Orden de Trabajo</h2>
      <form id="frmordenes" method="post">
        <!-- ... (código del formulario de creación) ... -->
        <label for="patente">Patente del Vehículo:</label>
        <input type="text" id="patente" name="patente" required><br>
          
        <label for="nombre_cliente">Nombre del Cliente:</label>
        <input type="text" id="nombre_cliente" name="nombre_cliente" required><br>
        
        <label for="descripcion">Descripción:</label>
        <textarea id="descripcion" name="descripcion" required></textarea><br>
          
        <label for="fecha">Fecha:</label>
        <input type="text" id="fecha" name="fecha" class="compact-input" required><br>

        <label for="valor_trabajo">Valor Trabajo:</label>
        <input type="text" id="valor_trabajo" name="valor_trabajo" class="compact-input" required><br>

        <label for="descuento">Descuento:</label>
        <input type="text" id="descuento" name="descuento" class="compact-input" required><br>
          
        <label for="estado">Estado:</label>
        <select id="estado" name="estado" required>
            <option value="En Proceso">En Proceso</option>
            <option value="Completada">Completada</option>
            <!-- Agregar más opciones de estados aquí si es necesario -->
        </select><br>
        <input type="button" value="Crear Orden" onclick="crear_orden();">
      </form>
    </div>
    <a class="logout-link" href="logout.php">Cerrar Sesión</a>
  </div>
  <script>
    // Configurar el calendario emergente para el campo de fecha
    $(function() {
      $("#fecha").datepicker({
        dateFormat: "yy-mm-dd"
      });
    });

    function crear_orden() {
      var patente = $("#patente").val();
      var nombre_cliente = $("#nombre_cliente").val();
      var descripcion = $("#descripcion").val();
      var fecha = $("#fecha").val();
      var valor_trabajo = $("#valor_trabajo").val();
      var descuento = $("#descuento").val();
      var estado = $("#estado").val();

      $.ajax({
        url: "procesar_creacion.php", // Cambia la ruta según corresponda
        method: "POST",
        data: {
          patente: patente,
          nombre_cliente: nombre_cliente,
          descripcion: descripcion,
          fecha: fecha,
          valor_trabajo: valor_trabajo,
          descuento: descuento,
          estado: estado
        },
        success: function(response) {
          window.location.href = "listado_ordenes.php";
        },
        error: function() {
          alert("Error al crear la orden. Inténtalo de nuevo.");
        }
      });
    }
  </script>
  <!-- ... (otros scripts y cierre de la etiqueta <body>) ... -->
</body>
</html>
