<?php
require_once "config_pdo.php";

try {
    // 1. Productos que tienen un precio mayor al promedio de su categoría
    $sql = "SELECT p.nombre, p.precio, c.nombre as categoria,
            (SELECT AVG(precio) FROM productos WHERE categoria_id = p.categoria_id) as promedio_categoria
            FROM productos p
            JOIN categorias c ON p.categoria_id = c.id
            WHERE p.precio > (
                SELECT AVG(precio)
                FROM productos p2
                WHERE p2.categoria_id = p.categoria_id
            )";

    $stmt = $pdo->query($sql);
    
    echo "<h3>Productos con precio mayor al promedio de su categoría:</h3>";
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "Producto: {$row['nombre']}, Precio: {$row['precio']}, ";
        echo "Categoría: {$row['categoria']}, Promedio categoría: {$row['promedio_categoria']}<br>";
    }

    // 2. Clientes con compras superiores al promedio
    $sql = "SELECT c.nombre, c.email,
            (SELECT SUM(total) FROM ventas WHERE cliente_id = c.id) as total_compras,
            (SELECT AVG(total) FROM ventas) as promedio_ventas
            FROM clientes c
            WHERE (
                SELECT SUM(total)
                FROM ventas
                WHERE cliente_id = c.id
            ) > (
                SELECT AVG(total)
                FROM ventas
            )";

    $stmt = $pdo->query($sql);
    
    echo "<h3>Clientes con compras superiores al promedio:</h3>";
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "Cliente: {$row['nombre']}, Total compras: {$row['total_compras']}, ";
        echo "Promedio general: {$row['promedio_ventas']}<br>";
    }

    $sql = "SELECT nombre,stock , (SELECT count(1) AS Total_Cantidad FROM detalles_venta vp WHERE vp.producto_id = p.id) AS total_venta
              FROM productos p
            WHERE (SELECT count(1) AS Total_Cantidad FROM detalles_venta vp WHERE vp.producto_id = p.id) = 0 

    ";

    $stmt = $pdo->query($sql);
    
    echo "<h3>Los producto no vendidos</h3>";
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

        echo "Nombre producto: {$row['nombre']}, Stock: {$row['stock']}, Vendido: {$row['total_venta']}<br> ";
    }

    //5:  Lista de categoria con el numero de producto y el valor total en inventarioa
    $sql = "SELECT c.nombre AS categoria, COUNT(p.id) AS cantidad_productos, SUM(p.stock * p.precio) AS valor_total_inventario
    FROM categorias c
    JOIN productos p ON p.categoria_id = c.id
    GROUP BY c.nombre;
    ";

    $stmt = $pdo->query($sql);
    
    echo "<h3>Lista de categoria con el numero de producto y el valor total en inventarioa</h3>";
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

        echo "Gategoria de producto: {$row['categoria']}, Cantidad de producto: {$row['cantidad_productos']}, Valor de interiado: {$row['valor_total_inventario']}<br> ";
    }



} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}

$pdo = null;
?>
     