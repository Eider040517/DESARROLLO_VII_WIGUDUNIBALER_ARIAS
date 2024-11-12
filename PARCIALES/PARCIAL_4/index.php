<?php
define('BASE_DIR', __DIR__);

session_start();

require_once(BASE_DIR . "/config.php");

//Verificacion de seccion inicializada o no.
if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
  header('location: /public/index.php');
} else {
  header('Location:  /public/login.php' );
}




