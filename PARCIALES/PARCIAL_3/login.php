<?php
include 'config_sesion.php';

$credenciales = [
    ["usuario" => "Estudiante1","contrasena" => "1234","rol"=> "Estudiante" ,"calificaciones" => [85, 92, 78, 96, 88]],
    ["usuario" => "Estudiante1","contrasena" => "1234","rol"=> "Estudiante" ,"calificaciones" => [75, 84, 91, 79, 86]],
    ["usuario" => "Estudiante2","contrasena" => "1234","rol"=> "Estudiante" ,"calificaciones" => [92, 95, 89, 97, 93]],
    ["usuario" => "Estudiante3","contrasena" => "1234","rol"=> "Estudiante" ,"calificaciones" => [70, 72, 78, 75, 77]],
    ["usuario" => "Estudiante4","contrasena" => "1234","rol"=> "Estudiante" ,"calificaciones" => [88, 86, 90, 85, 89]],
    ["usuario" => "Profesor1","contrasena" => "1234","rol" => "Profesor"],
    ["usuario" => "Profesor2","contrasena" => "1234","rol" => "Profesor"],
    
];

  if(isset($_SESSION['usuario'])) {
    header("Location: DashBoardEstudiante.php");
    exit();
  }

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
       die("Error de validación CSRF");
    }

    $usuario = $_POST['usuario'];
    $contrasena = $_POST['contrasena'];
    $rol = $_POST['rol'];

    // En un caso real, verificaríamos contra una base de datos



   $credencial = array_filter($credenciales, function($credencial) use ($usuario ,$contrasena, $rol) {
      if($credencial["usuario"] === $usuario && $credencial["contrasena"] === $contrasena && $credencial["rol"]=== $rol)
      {
        echo "estoy aqui";
        print_r($credencial);
        return $credencial;
      }
    });
    print_r($credencial);

  if($usuario === "Profesor3" && $contrasena === "1234" && $rol === "Profesor") {
      echo "Esto aqui revisando";
        $_SESSION['usuario'] = $usuario;
        $_SESSION['rol'] =  $rol;
        //header("Location: DashBoardProfesor.php");
        exit();
      } elseif ($usuario === "Estudiante1" && $contrasena === "1234" && $rol === "Estudiante") {
        $_SESSION['usuario'] = $usuario;
        $_SESSION['rol'] =  $rol;
        header("Location: DashBoardEstudiante.php");
      }else{
        $error = "Usuario o contraseña incorrectos";
      }
}
    

// Generar token CSRF
  $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>
<body>
    <h2>Login</h2>
    <?php
    if (isset($error)) {
        echo "<p style='color: red;'>$error</p>";
    }
    ?>
    <form method="post" action="">
        <label for="usuario">Usuario:</label><br>
        <input type="text" id="usuario" name="usuario" required><br><br>
        <label for="contrasena">Contraseña:</label><br>
        <input type="password" id="contrasena" name="contrasena" required><br><br>
        <input type="text" id="rol"  name="rol">
        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
        <input type="submit" value="Iniciar Sesión">
    </form>
</body>
</html>
        
