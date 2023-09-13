<?php
session_start();

// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "Multi*1234";
$dbname = "taller_mecanico";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener datos del formulario
$username = $_POST['username'];
$password = $_POST['password'];

// Consulta a la base de datos
$query = "SELECT * FROM users WHERE username = ? AND password = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ss", $username, $password);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 1) {
    // Inicio de sesión exitoso, redireccionar a la página principal
    $_SESSION['username'] = $username;
    header("Location: dashboard.php");
    // Puedes agregar más acciones aquí si es necesario
} else {
    // Inicio de sesión fallido, redireccionar al formulario de inicio de sesión con mensaje de error
    header("Location: index.html?error=1");
}

$stmt->close();
$conn->close();
?>
