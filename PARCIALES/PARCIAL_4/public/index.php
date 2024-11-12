<?php
session_start();

require_once __DIR__ . '/../src/service/GoogleBookService.php';
// Verifica si el usuario está autenticado
if (!isset($_SESSION['access_token'])) {
  echo "Es verdad ya que esta logiado";
}

?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Perfil del Usuario</title>
  <link rel="stylesheet" href="/public/css/home.css">
</head>

<body>

  <div class="container">
    <div class="header">
      <h1>Books</h1>
      <div class="search-bar">
        <input type="text" placeholder="Titles, author, or topics">
      </div>

      <div class="nav-buttons">
        <button class="nav-button">Mis favoritos</button>
      </div>
    </div>


    <div class="trending-section">
      <div class="content-title">
        <H1>
          LIbros
          <br>
          Destacados
        </H1>
      </div>
      <div class="books-list">

        <!-- Libros Dinámicos desde la API de Google Books -->
        <?php
        $service = new GoogleBookService();
        $books = $service->ListBooks();

        if (count($books) > 0) {
          foreach ($books as $book) {
            $title = $book['volumeInfo']['title'];
            $authors = isset($book['volumeInfo']['authors']) ? implode(', ', $book['volumeInfo']['authors']) : 'Desconocido';
            $thumbnail = isset($book['volumeInfo']['imageLinks']['thumbnail']) ? $book['volumeInfo']['imageLinks']['thumbnail'] : 'https://via.placeholder.com/128x192';

        ?>
            <div class='book-item'>
              <img src='<?=$thumbnail?>' alt='<?= $title ?>' />
              <h4><?= $title ?></h4>
              <p><?= $authors ?></p>
              <button>Favorito</button>
            </div>";

        <?php
          }
        }
        ?>

      </div>
    </div>


  </div>

</body>

</html>