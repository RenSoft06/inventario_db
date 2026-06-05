<?php
require_once __DIR__ . '/../conexion.php';
use MongoDB\BSON\ObjectId;

// Validaciones
$errores = [];

if (empty($_POST['id'])) {
    $errores[] = 'ID de producto no válido';
}

if (empty($_POST['nombre']) || strlen($_POST['nombre']) < 3) {
    $errores[] = 'El nombre debe tener al menos 3 caracteres';
}

if (empty($_POST['precio']) || (float)$_POST['precio'] <= 0) {
    $errores[] = 'El precio debe ser mayor a 0';
}

if (empty($_POST['stock']) || (int)$_POST['stock'] < 0) {
    $errores[] = 'El stock no puede ser negativo';
}

if (!empty($errores)) {
    header('Location: ../productos.php?error=' . urlencode(implode(', ', $errores)));
    exit;
}

try {
    $id = new ObjectId($_POST['id']);
    
    $db->productos->updateOne(
        ['_id' => $id],
        ['$set' => [
            'nombre' => trim($_POST['nombre']),
            'precio' => (float)$_POST['precio'],
            'stock' => (int)$_POST['stock'],
            'categoria_id' => new ObjectId($_POST['categoria_id']),
            'proveedor_id' => new ObjectId($_POST['proveedor_id']),
            'fechaActualizacion' => date('Y-m-d H:i:s')
        ]]
    );
    
    header('Location: ../productos.php?mensaje=Producto actualizado exitosamente');
} catch (Exception $e) {
    header('Location: ../productos.php?error=Error al editar: ' . $e->getMessage());
}
?>
