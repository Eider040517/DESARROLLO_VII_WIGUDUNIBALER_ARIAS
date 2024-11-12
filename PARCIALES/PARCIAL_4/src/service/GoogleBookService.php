<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__. '/GoogleOAuthService.php';
class GoogleBookService
{
  private $service;
  private $client;

  function __construct() {
    $authService = new GoogleOAuthService();
    $this->client =  $authService->getClient();
    $this->service = new Google\Service\Books($this->client);
  }

  public function ListBooks()
  {
    // Buscar los libros más populares (puedes cambiar el término de búsqueda a lo que desees)
    $query = 'bestsellers'; // O cualquier otra palabra clave popular
    $optParams = array(
      'maxResults' => 6, // Limitar los resultados a 10 libros
      'orderBy' => 'relevance', // Ordenar por los más nuevos (puedes cambiarlo por "relevance" o quitarlo)
    );

    // Realizar la consulta a la API
    $results = $this->service->volumes->listVolumes($query, $optParams);

    // Mostrar los resultados en formato JSON o como desees
    $books = $results->getItems();

    return $books;
  }
}
