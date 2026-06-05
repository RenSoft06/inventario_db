<?php 
require_once __DIR__ . '/../conexion.php';

header('Content-Type: application/json');

$id = $_GET['id'];
$producto = $db->productos->findOne(['_id' => $id]);

$id = $_GET['id'];
$producto = $db->productos->findOne(['_id' => $id]);

if($producto) {
    echo json_encode([
        '_id' => (string)$producto->_id,
        'nombre' => $producto->nombre,
        'precio' => $producto->precio,
        'stock' => $producto->stock,
        'categoria_id' => (string)$producto->categoria_id,
        'proveedor_id' => (string)$producto->proveedor_id
    ]);
} else {
    echo json_encode(['error' => 'Producto no encontrado']);
}
?>