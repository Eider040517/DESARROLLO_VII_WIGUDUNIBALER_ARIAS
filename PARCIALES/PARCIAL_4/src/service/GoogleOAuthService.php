<?php

require_once __DIR__ . '/../../config.php';
require_once __DIR__ . '/../../vendor/autoload.php';  // Asegúrate de cargar el autoload de Composer, si usas Composer

use Google\Client;
use Google\Service\Oauth2;

class GoogleOAuthService
{
  private $client;

  public function __construct()
  {
    // Cargar las credenciales y configuraciones
    $this->client = new Client();
    $this->client->setAuthConfig(__DIR__ . '/../../client_secret.json'); // Ruta al archivo de credenciales JSON
    $this->client->setRedirectUri('http://localhost/src/controllers/AuthController.php'); // URI de redirección
    $this->client->addScope("https://www.googleapis.com/auth/userinfo.email");
    $this->client->addScope("https://www.googleapis.com/auth/userinfo.profile");
  }

  // Obtener la URL de autenticación para redirigir al usuario
  public function getAuthUrl()
  {
    return $this->client->createAuthUrl();
  }

  public function getClient()
  {
    return $this->client;
  }

  // Cerrar la sesión y eliminar el token
  public function logout()
  {
    unset($_SESSION['access_token']);
    $this->client->revokeToken();
  }

  public function getState()
  {
    $state = bin2hex(random_bytes(16));
    $this->client->setState($state);
    return $state;
  }
  public function getAccessToken()
  {
    return $this->client->getAccessToken();
  }

  public function  authenticate($code)
  {
    $this->client->authenticate($code);
  }

  public function getUserInfo()
  {
    if (!$this->client->isAccessTokenExpired()) {
      $googleService = new Oauth2($this->client);
      return $googleService->userinfo->get();
    } else {
      // Si el token ha expirado, redirige al usuario a autenticarse de nuevo
      header('Location: /src/controllers/AuthController.php');
      exit();
    }
  }

  public function getAccessTokenWithAO($code){
    return $this->client->fetchAccessTokenWithAuthCode($code);

  }
  public function setAccessToken($token){
    $this->client->setAccessToken($token);
  }
}
