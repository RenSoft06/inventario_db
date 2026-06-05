<?php 
require_once __DIR__ . '/vendor/autoload.php';

function conectarDB() {
    try {
        $client = new MongoDB\Client("mongodb://localhost:27017");
        $db = $client->inventario_db;
        return $db;
        echo "Conectado a MongoDB<br>";
    } catch (Exception $e){
        die("Error: " . $e->getMessage());
    }
}

$db = conectarDB();
?>