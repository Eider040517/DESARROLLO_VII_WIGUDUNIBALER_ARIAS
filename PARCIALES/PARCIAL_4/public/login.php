<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
$action = isset($_GET['action']) ? $_GET['action'] : null ;
if ($action === 'google_login') {
  $redirect_uri = 'http://' . $_SERVER['HTTP_HOST'] . '/src/controllers/AuthController.php';
  header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
  exit();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Página de Inicio de Sesión</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f0f0f0;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
    }

    .login-container {
      background-color: white;
      padding: 2rem;
      border-radius: 8px;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
      width: 300px;
    }

    h1 {
      text-align: center;
      color: #333;
    }

    form {
      display: flex;
      flex-direction: column;
    }

    label {
      margin-top: 1rem;
      color: #666;
    }

    input {
      padding: 0.5rem;
      margin-top: 0.5rem;
      border: 1px solid #ddd;
      border-radius: 4px;
    }

    button {
      margin-top: 1rem;
      padding: 0.5rem;
      background-color: #4285F4;
      color: white;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      transition: background-color 0.3s;
    }

    button:hover {
      background-color: #357AE8;
    }

    .google-btn {
      background-color: white;
      color: #757575;
      border: 1px solid #ddd;
    }

    .google-btn:hover {
      background-color: #f1f1f1;
    }
  </style>
</head>

<body>
  <div class="login-container">
    <h1>Iniciar Sesión</h1>
    <form action="" method="post">
      <label for="email">Correo electrónico:</label>
      <input type="email" id="email" name="email" required>

      <label for="password">Contraseña:</label>
      <input type="password" id="password" name="password" required>

      <button type="submit">Iniciar Sesión</button>
    </form>
    <form action="login.php" method="get">
      <input type="hidden" name="action" value="google_login">
      <button class="google-btn">Iniciar Sesión con Google</button>
    </form>
  </div>
</body>

</html>