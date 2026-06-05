<?php 
require_once __DIR__ . '/../conexion.php';
use MongoDB\BSON\ObjectId;

// Validaciones de datos vacíos
$errores = [];

if (empty($_POST['nombre']) || strlen($_POST['nombre']) < 3) {
    $errores[] = 'El nombre debe tener al menos 3 caracteres';
}

if (empty($_POST['precio']) || (float)$_POST['precio'] <= 0) {
    $errores[] = 'El precio debe ser mayor a 0';
}

if (empty($_POST['stock']) || (int)$_POST['stock'] < 0) {
    $errores[] = 'El stock no puede ser negativo';
}

if (empty($_POST['categoria_id'])) {
    $errores[] = 'Debe seleccionar una categoría';
}

if (empty($_POST['proveedor_id'])) {
    $errores[] = 'Debe seleccionar un proveedor';
}

if (!empty($errores)) {
    header('Location: ../productos.php?error=' . urlencode(implode(', ', $errores)));
    exit;
}

// Si pasó validaciones, crear el producto
$nombre = trim($_POST['nombre']);
$precio = (float)$_POST['precio'];
$stock = (int)$_POST['stock'];
$categoria_id = new ObjectId($_POST['categoria_id']);
$proveedor_id = new ObjectId($_POST['proveedor_id']);

// Generar código único
$codigo = 'PROD-' . strtoupper(substr(uniqid(), -6));

try {
    $db->productos->insertOne([
        'nombre' => $nombre,
        'precio' => $precio,
        'stock' => $stock,
        'codigo' => $codigo,
        'categoria_id' => $categoria_id,
        'proveedor_id' => $proveedor_id,
        'fechaRegistro' => date('Y-m-d H:i:s'),
        'estado' => 'activo'
    ]);
    
    header('Location: ../productos.php?mensaje=Producto agregado exitosamente');
} catch (Exception $e) {
    header('Location: ../productos.php?error=Error al agregar: ' . $e->getMessage());
}
?>
