<?php 
require_once __DIR__ . '/../conexion.php';
use MongoDB\BSON\ObjectId;
use MongoDB\BSON\UTCDateTime;

$nombre = $_POST['nombre'];
$precio = (float)$_POST['precio'];
$stock = (int)$_POST['stock'];
$categoria_id = $_POST['categoria_id'];
$proveedor_id = $_POST['proveedor_id'];

$db->productos->insertOne([
    'nombre' => $nombre,
    'precio' => $precio,
    'stock' => $stock,
    'categoria_id' => $categoria_id,
    'proveedor_id' => $proveedor_id,
    'fechaRegistro' => date('Y-m-d H:i:s')
]);

header('Location: ../productos.php?mensaje=Producto agregado exitosamente');
?>