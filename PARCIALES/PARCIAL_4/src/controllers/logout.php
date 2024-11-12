<?php
session_start();
require_once __DIR__ . '/../service/GoogleOAuthService.php';

$client = New GoogleOAuthService();

session_unset();
$client->logout();
// Destruir la sesión
session_destroy();

// Redirigir al usuario a la página de login
header('Location:' . '/../../index.php');
exit;
