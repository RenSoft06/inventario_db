<?php 
require_once __DIR__ . '/../conexion.php';

$id = $_POST['id'];
$nombre = $_POST['nombre'];
$precio = (float)$_POST['precio'];
$stock = (int)$_POST['stock'];
$categoria_id = $_POST['categoria_id'];
$proveedor_id = $_POST['proveedor_id'];

$db->productos->updateOne(
    ['_id' => $id],
    ['$set' => [
        'nombre' => $nombre,
        'precio' => $precio,
        'stock' => $stock,
        'categoria_id' => $categoria_id,
        'proveedor_id' => $proveedor_id
    ]]
);

header('Location: ../productos.php?mensaje=Producto actualizado');
exit();
?>