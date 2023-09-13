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

// Configuración de paginación
$registrosPorPagina = 10;
$paginaActual = isset($_GET['pagina']) ? $_GET['pagina'] : 1;
$inicio = ($paginaActual - 1) * $registrosPorPagina;

// Consulta para obtener la lista de órdenes de trabajo con paginación
$query = "SELECT * FROM ordenes_trabajo LIMIT $inicio, $registrosPorPagina";
$resultado = $conn->query($query);

// Verificar si la consulta fue exitosa
if (!$resultado) {
    die("Error al obtener datos de la base de datos: " . $conn->error);
}

// Cálculo de total de páginas
$queryTotal = "SELECT COUNT(*) AS total FROM ordenes_trabajo";
$resultadoTotal = $conn->query($queryTotal);

// Verificar si la consulta fue exitosa
if (!$resultadoTotal) {
    die("Error al obtener el total de registros: " . $conn->error);
}

$totalRegistros = $resultadoTotal->fetch_assoc()['total'];
$totalPaginas = ceil($totalRegistros / $registrosPorPagina);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <!-- Encabezado y estilos -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css"> <!-- Enlace a tu archivo de estilos personalizados -->
    <style>
        /* Estilos específicos para la página de listado de órdenes */
        body {
            font-family: Arial, sans-serif;
            background-color: #e74c3c; /* Color rojo para el fondo */
            margin: 0;
            padding: 0;
        }
        .dashboard-container {
            text-align: center;
            margin-top: 50px;
            padding: 20px 40px; /* Ampliar los lados del formulario */
            background-color: #fff; /* Color de fondo del contenedor */
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            overflow: auto; /* Agregar scroll si el contenido es muy largo */
        }
        .dashboard-title {
            font-size: 28px;
            margin-bottom: 20px;
            color: #333; /* Color gris oscuro para el título */
        }
        .logout-link,
        .back-button {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            font-weight: bold;
            background-color: #e74c3c; /* Color rojo para el botón Cerrar Sesión */
            color: #fff;
        }
        .back-button {
            background-color: #3498db; /* Color azul para el botón Volver al Dashboard */
            margin-left: 10px;
        }
        .orden-table-container {
            margin-top: 20px;
            background-color: #fff; /* Color de fondo del formulario */
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            align-items: center; /* Centrar el contenido horizontalmente */
        }
        .orden-table {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid #ccc;
        }
        .orden-table th,
        .orden-table td {
            padding: 10px;
            text-align: center;
            border-bottom: 1px solid #ccc;
            background-color: #f2f2f2; /* Color gris claro para las celdas de título */
            color: #333; /* Color gris oscuro para el texto de las celdas */
            font-weight: bold;
        }
        .orden-table th {
            background-color: #0cb7f2; /* Otro color para las celdas de título */
        }
        .pagination {
            margin-top: 20px;
        }
        .pagination a {
            display: inline-block;
            padding: 5px 10px;
            border: 1px solid #ccc;
            margin-right: 5px;
            text-decoration: none;
            color: #333;
        }
        .pagination a.active {
            background-color: #3498db; /* Color azul */
            color: #fff;
            border: 1px solid #3498db; /* Color azul */
        }
        .table-cell {
            background-color: #fff; /* Sin color de fondo en las celdas */
            border: 1px solid #ccc; /* Borde de las celdas */
        }
        /* Ajustar el ancho de la columna Kilometraje */
        .orden-table .kilometraje-cell {
            width: 10%;
        }
    </style>
    <title>Listado de Órdenes de Trabajo</title>
</head>
<body>
<div class="dashboard-container" style="max-width: 1200px; margin: 0 auto;"> <!-- Ancho máximo de 1200px y centrado -->
    <h1 class="dashboard-title">Listado de Órdenes de Trabajo</h1>
    <!-- Botones de Cerrar Sesión y Volver al Dashboard -->
    <a href="logout.php" class="logout-link">Cerrar Sesión</a>
    <a href="dashboard.php" class="back-button">Volver al Panel de Control</a>
    <div class="orden-table-container" style="overflow-x: auto;"> <!-- Agrega scroll horizontal si es necesario -->
        <h2 style="margin-top: 0;">*Quezada / Motors*</h2>
        <table class="orden-table">
            <tr>
                <th class="table-cell">Id</th>
                <th class="table-cell">Patente</th>
                <th class="table-cell kilometraje-cell">Kilometraje</th>
                <th class="table-cell">Nombre del Cliente</th>
                <th class="table-cell">Descripción</th>
                <th class="table-cell">Fecha</th>
                <th class="table-cell">Valor del Trabajo</th>
                <th class="table-cell">Descuento %</th>
                <th class="table-cell">Total $</th>
                <th class="table-cell">Estado</th>
                <th class="table-cell" style="width: 120px;">Acciones</th>
            </tr>
            <?php
            if ($resultado->num_rows > 0) {
                while ($fila = $resultado->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td class='table-cell'>" . $fila['id'] . "</td>";
                    echo "<td class='table-cell'>" . $fila['patente'] . "</td>";
                    echo "<td class='table-cell'>" . $fila['kilometraje'] . "</td>";
                    echo "<td class='table-cell'>" . $fila['nombre_cliente'] . "</td>";
                    echo "<td class='table-cell'>" . $fila['descripcion'] . "</td>";
                    echo "<td class='table-cell'>" . $fila['fecha'] . "</td>";
                    echo "<td class='table-cell'>" . $fila['valor_trabajo'] . "</td>";
                    echo "<td class='table-cell'>" . $fila['descuento'] . "</td>";
                    $total = $fila['valor_trabajo'] - (($fila['valor_trabajo'] * $fila['descuento']) / 100);
                    echo "<td class='table-cell'>" . $total . "</td>";
                    echo "<td class='table-cell'>" . $fila['estado'] . "</td>";
                    echo "<td class='table-cell'><a href='editar_orden.php?id=" . $fila['id'] . "'>Editar</a></td>"; // Botón de edición
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='10'>No hay órdenes de trabajo registradas</td></tr>";
            }
            ?>
        </table>
        <!-- Paginación -->
        <div class="pagination">
            <?php for ($i = 1; $i <= $totalPaginas; $i++) : ?>
                <a href="?pagina=<?php echo $i; ?>"
                   class="<?php if ($i == $paginaActual) echo 'active'; ?>"><?php echo $i; ?></a>
            <?php endfor; ?>
        </div>
    </div>
</div>
</body>
</html>

