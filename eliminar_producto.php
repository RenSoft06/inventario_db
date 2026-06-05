<?php 
require_once __DIR__ . '/../conexion.php';

$id = $_GET['id'];

$db->productos->deleteOne(['_id' => $id]);
header('Location: ../productos.php');
?>