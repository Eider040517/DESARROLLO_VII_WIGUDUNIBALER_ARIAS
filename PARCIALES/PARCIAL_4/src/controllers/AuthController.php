<?php

session_start();
require_once __DIR__ . '/../models/user.php';
require_once __DIR__ . '/../service/GoogleOAuthService.php';

$client = new GoogleOAuthService();
$user = new User();

try {
  // Si no hay código de autorización en la URL, redirige al usuario a Google para autenticación.
  if (!isset($_GET['code'])) {
    // Generar y almacenar el estado en la sesión para prevenir CSRF.
    $_SESSION['state'] = $client->getState();

    // Obtener la URL de autenticación.
    $authUrl = $client->getAuthUrl();
    header('Location: ' . filter_var($authUrl, FILTER_SANITIZE_URL));

    echo 'Generated state: ' . $_SESSION['state'];
    exit();
  } else {
    // Verificar si el estado de la URL coincide con el estado de la sesión.
    if (!isset($_GET['state']) || $_GET['state'] !== $_SESSION['state']) {
      throw new Exception('Error: State mismatch. Posible ataque CSRF.');
    }
    //Estabilizar el Access_toke para las consultas
    $client->authenticate($_GET['code']);
    $_SESSION['access_token'] = $client->getAccessToken();

    $userInfo = $client->getUserInfo();
    print_r($userInfo);
    if(!$user->isLoginUser($userInfo)){
      $user->loginOrCreateUser($userInfo);
    }
   
    // Redirigir al usuario a la página principal.
    $redirectUri = 'http://' . $_SERVER['HTTP_HOST'] . '/';
    header('Location: ' . filter_var($redirectUri, FILTER_SANITIZE_URL));
    exit();
  }
} catch (Exception $e) {
  // Manejar los errores y mostrar un mensaje amigable.
  echo 'Error en AuthController:  ' . $e->getMessage();
}
