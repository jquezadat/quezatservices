<?php
session_start();
// Asegurarse de que el usuario tenga una sesión válida
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
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

// Obtener el mes y el año seleccionados por el usuario (o el mes y año actuales si no se ha enviado el formulario)
$selectedMonth = isset($_POST['mes']) ? $_POST['mes'] : date("m");
$selectedYear = isset($_POST['anio']) ? $_POST['anio'] : date("Y");

// Consulta SQL para obtener el resultado total mensual antes de aplicar el descuento
$sql = "SELECT SUM(valor_trabajo) AS total_mensual FROM ordenes_trabajo WHERE MONTH(fecha) = $selectedMonth AND YEAR(fecha) = $selectedYear";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $totalMensualSinDescuento = $row["total_mensual"];
} else {
    $totalMensualSinDescuento = 0;
}

// Calcular el resultado total mensual después de aplicar el descuento del 85%
$totalMensualConDescuento = $totalMensualSinDescuento * (1 - 0.85);

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Estilos personalizados */
        body {
            font-family: Arial, sans-serif;
            background-color: #e74c3c; /* Color rojo para el fondo*/
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .dashboard-container {
            text-align: center;
            padding: 20px;
            background-color: #fff; /* Color de fondo del contenedor */
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
        }
        .welcome-message {
            font-size: 24px;
            margin-bottom: 20px;
            color: #333;
        }
        .result {
            font-size: 18px;
            margin-bottom: 10px;
            color: #333;
        }
        .footer {
            margin-top: 20px;
            font-size: 14px;
            color: #888;
        }
        .back-button {
            background-color: #3498db; /* Color azul para el botón de regreso */
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .back-button:hover {
            background-color: #2980b9;
        }
    </style>
    <title>Resultado Total Mensual</title>
</head>
<body>
    <div class="dashboard-container">
        <h1 class="welcome-message">Resultado Total Mensual</h1>
        <!-- Formulario para seleccionar el mes y el año -->
        <form method="post">
            <label for="mes">Seleccionar Mes:</label>
            <select name="mes" id="mes">
                <?php
                $months = [
                    '01' => 'Enero',
                    '02' => 'Febrero',
                    '03' => 'Marzo',
                    '04' => 'Abril',
                    '05' => 'Mayo',
                    '06' => 'Junio',
                    '07' => 'Julio',
                    '08' => 'Agosto',
                    '09' => 'Septiembre',
                    '10' => 'Octubre',
                    '11' => 'Noviembre',
                    '12' => 'Diciembre'
                ];

                foreach ($months as $monthNum => $monthName) {
                    echo "<option value='$monthNum'";
                    if ($selectedMonth == $monthNum) echo " selected";
                    echo ">$monthName</option>";
                }
                ?>
            </select>
            <label for="anio">Seleccionar Año:</label>
            <select name="anio" id="anio">
                <?php
                for ($i = 2023; $i >= 2020; $i--) {
                    echo "<option value='$i'";
                    if ($selectedYear == $i) echo " selected";
                    echo ">$i</option>";
                }
                ?>
            </select>
            <input type="submit" value="Ver Resultado">
        </form>
        <p class="result">Mes y Año: <?php echo date("F Y", strtotime("$selectedYear-$selectedMonth-01")); ?></p>
        <p class="result">Total sin descuento: $<?php echo number_format($totalMensualSinDescuento, 2); ?></p>
        <p class="result">Total con descuento (15%): $<?php echo number_format($totalMensualConDescuento, 2); ?></p>
        <a class="back-button" href="dashboard.php">Volver al Dashboard</a>
        <div class="footer">
            <p>Developer QuezatServices</p>
        </div>
    </div>
</body>
</html>
