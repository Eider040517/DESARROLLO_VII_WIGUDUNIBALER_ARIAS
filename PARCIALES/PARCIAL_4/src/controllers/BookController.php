<?php
require_once __DIR__ . '/../models/Book.php';

// Leer los datos enviados desde el frontend
$input = file_get_contents('php://input');
$data = json_decode($input, true);
// Validar si se han enviado datos por el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($data)) {
  $book = new Book();
  // Datos a insertar obtenidos desde la API y el formulario
  $userId = $data['user_id']; // Asegúrate de que el usuario esté autenticado y su ID esté disponible
  $googleId = $data['google_id'];
  $title = $data['titulo'];
  $authors = $data['autor'];
  $thumbnail = $data['imagen_portada'];
  $review = $data['reseña_personal'] ?? '';

  $params = [
    ':user_id' => $userId,
    ':google_id' => $googleId,
    ':titulo' => $title,
    ':autor' => $authors,
    ':imagen_portada' => $thumbnail,
    ':reseña_personal' => $review
  ];

  // Ejecutar la consulta
  if (!$book->isSaveBook($params)) {
    $book->saveBook($params);
  }

  $redirectUri = 'http://' . $_SERVER['HTTP_HOST'] . '/';
  header('Location: ' . filter_var($redirectUri, FILTER_SANITIZE_URL));
  exit();
}
