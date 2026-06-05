<?php
require_once __DIR__ . '/../conexion.php';

$id = $_GET['id'];
$cantidad = (int)$_GET['cantidad'];
$db->productos->updateOne(['_id' => $id], ['$inc' => ['stock' => $cantidad]]);
header('Location: ../productos.php');
?>