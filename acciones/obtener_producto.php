<?php 
require_once __DIR__ . '/../conexion.php';
use MongoDB\BSON\ObjectId;

header('Content-Type: application/json');

if (!isset($_GET['id'])) {
    http_response_code(400);
    echo json_encode(['error' => 'ID no proporcionado']);
    exit;
}

try {
    $id = new ObjectId($_GET['id']);
    $producto = $db->productos->findOne(['_id' => $id]);
    
    if ($producto) {
        echo json_encode([
            '_id' => (string)$producto->_id,
            'nombre' => $producto->nombre,
            'precio' => $producto->precio,
            'stock' => $producto->stock,
            'codigo' => $producto->codigo ?? 'N/A',
            'categoria_id' => (string)$producto->categoria_id,
            'proveedor_id' => (string)$producto->proveedor_id
        ]);
    } else {
        http_response_code(404);
        echo json_encode(['error' => 'Producto no encontrado']);
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Error: ' . $e->getMessage()]);
}
?>
