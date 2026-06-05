<?php
require_once __DIR__ . '/../conexion.php';
use MongoDB\BSON\ObjectId;

if (!isset($_GET['id'])) {
    header('Location: ../productos.php?error=ID no válido');
    exit;
}

try {
    $id = new ObjectId($_GET['id']);
    
    $resultado = $db->productos->deleteOne(['_id' => $id]);
    
    if ($resultado->getDeletedCount() > 0) {
        header('Location: ../productos.php?mensaje=Producto eliminado exitosamente');
    } else {
        header('Location: ../productos.php?error=Producto no encontrado');
    }
} catch (Exception $e) {
    header('Location: ../productos.php?error=Error al eliminar: ' . $e->getMessage());
}
?>
