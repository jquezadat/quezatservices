<?php
session_start();

// Destruir todas las variables de sesión
session_unset();

// Destruir la sesión
session_destroy();

// Redirigir al usuario de regreso a la página de inicio de sesión
header("Location: index.html");
exit();
?>
