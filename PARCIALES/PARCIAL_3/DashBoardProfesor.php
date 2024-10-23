<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if(!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>DashBoard Profesor</title>
</head>
<body>
    <h1>Bienvenido, <?php echo htmlspecialchars($_SESSION['usuario']); ?>, Rol: <?php  echo htmlspecialchars($_SESSION['rol'])?>!</h1>
    <p>Esta es tu DashBoard de Profesor.</p>
    <a href="logout.php">Cerrar Sesión</a>
</body>
</html>