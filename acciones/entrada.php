<?php
require_once __DIR__ . '/../conexion.php';
use MongoDB\BSON\ObjectId;

// Validaciones
if (!isset($_GET['id']) || !isset($_GET['cantidad'])) {
    header('Location: ../movimientos.php?error=Datos incompletos');
    exit;
}

$id = $_GET['id'];
$cantidad = (int)$_GET['cantidad'];

// Validar que cantidad sea positiva
if ($cantidad <= 0) {
    header('Location: ../movimientos.php?error=La cantidad debe ser mayor a 0');
    exit;
}

// Validar que el producto exista
$producto = $db->productos->findOne(['_id' => new ObjectId($id)]);
if (!$producto) {
    header('Location: ../movimientos.php?error=Producto no encontrado');
    exit;
}

try {
    // Actualizar stock
    $db->productos->updateOne(
        ['_id' => new ObjectId($id)],
        ['$inc' => ['stock' => $cantidad]]
    );
    
    // Registrar movimiento en historial
    $db->movimientos->insertOne([
        'producto_id' => new ObjectId($id),
        'tipo' => 'ENTRADA',
        'cantidad' => $cantidad,
        'stock_anterior' => $producto->stock,
        'stock_nuevo' => $producto->stock + $cantidad,
        'fecha' => date('Y-m-d H:i:s'),
        'usuario_id' => 1, // TODO: Conectar con autenticación
        'motivo' => 'Compra/Devolución'
    ]);
    
    header('Location: ../movimientos.php?mensaje=Entrada registrada correctamente');
} catch (Exception $e) {
    header('Location: ../movimientos.php?error=Error al registrar entrada: ' . $e->getMessage());
}
?>
