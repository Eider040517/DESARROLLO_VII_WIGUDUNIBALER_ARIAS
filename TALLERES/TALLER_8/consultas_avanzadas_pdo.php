
<?php
require_once "config_pdo.php";

try {
    // 1. Mostrar todos los usuarios junto con el número de publicaciones que han hecho
    $sql = "SELECT u.id, u.nombre, COUNT(p.id) as num_publicaciones 
            FROM usuarios u 
            LEFT JOIN publicaciones p ON u.id = p.usuario_id 
            GROUP BY u.id";

    $stmt = $pdo->query($sql);

    echo "<h3>Usuarios y número de publicaciones:</h3>";
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "Usuario: " . $row['nombre'] . ", Publicaciones: " . $row['num_publicaciones'] . "<br>";
    }

    // 2. Listar todas las publicaciones con el nombre del autor
    $sql = "SELECT p.titulo, u.nombre as autor, p.fecha_publicacion 
            FROM publicaciones p 
            INNER JOIN usuarios u ON p.usuario_id = u.id 
            ORDER BY p.fecha_publicacion DESC";

    $stmt = $pdo->query($sql);

    echo "<h3>Publicaciones con nombre del autor:</h3>";
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "Título: " . $row['titulo'] . ", Autor: " . $row['autor'] . ", Fecha: " . $row['fecha_publicacion'] . "<br>";
    }

    // 3. Encontrar el usuario con más publicaciones
    $sql = "SELECT u.nombre, COUNT(p.id) as num_publicaciones 
            FROM usuarios u 
            LEFT JOIN publicaciones p ON u.id = p.usuario_id 
            GROUP BY u.id 
            ORDER BY num_publicaciones DESC 
            LIMIT 1";

    $stmt = $pdo->query($sql);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    echo "<h3>Usuario con más publicaciones:</h3>";
    echo "Nombre: " . $row['nombre'] . ", Número de publicaciones: " . $row['num_publicaciones'];

    // 4. Mostrar las últimas 5 publicaciones con el nombre del autor y la fecha de publicación.
     $sql = "SELECT p.titulo, u.nombre as autor, p.fecha_publicacion 
              FROM publicaciones p 
            INNER JOIN usuarios u ON p.usuario_id = u.id 
            ORDER BY p.fecha_publicacion DESC
            LIMIT 5";

    $stmt = $pdo->query($sql);

    echo "<h3>Ultimas 5 publicadas :</h3>";
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
      echo "Título: " . $row['titulo'] . ", Autor: " . $row['autor'] . ", Fecha: " . $row['fecha_publicacion'] . "<br>";
    }
    //5. Listar los usuarios que no han realizado ninguna publicación.
    $sql = "SELECT u.nombre
            FROM usuarios u
            LEFT JOIN publicaciones p ON u.id = p.usuario_id
            WHERE p.id IS NULL;";

    $stmt = $pdo->query($sql);

    echo "<h3>Listar de usuarios que no han realizado ninguna publicación:</h3>";
    while( $row = $stmt -> fetch(PDO::FETCH_ASSOC)){
        echo "Nombre: " . $row['nombre'] ;
    }

    //6.
    $sql = "SELECT AVG(publicaciones_count) AS promedio_publicaciones
            FROM (
            SELECT COUNT(*) AS publicaciones_count
            FROM publicaciones
            GROUP BY usuario_id
            ) AS resultado;";

    $stmt = $pdo ->query($sql);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "<h3>Promedio de publicaciones por usuario:</h3>";
    echo " Promedio de publicaciones: " . $row["promedio_publicaciones"] ;


} catch(PDOException $e) {

    echo "Error: " . $e->getMessage();
}

$pdo = null;
?>
