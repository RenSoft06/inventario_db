<?php
require_once 'conexion.php';

echo "VERIFICACIÓN DE MONGODB<br><br>";

if (extension_loaded('mongodb')) {
    echo "EXTENSIÓN MONGODB: CARGADA<br><br>";
    
    try {
        $prueba = $db->productos->findOne();
        echo "CONEXIÓN A MONGODB: EXITOSA<br>";
        echo "Todo está funcionando correctamente!<br><br>";
        
        $productos = $db->productos->find();
        echo "<strong>Primeros 5 productos:</strong><br>";
        $contador = 0;
        foreach($productos as $p) {
            if ($contador >= 5) break;
            echo "- " . $p->nombre . " (Stock: " . $p->stock . ")<br>";
            $contador++;
        }
    } catch (Exception $e) {
        echo "Error de conexión: " . $e->getMessage();
    }
} else {
    echo "EXTENSIÓN MONGODB: NO CARGADA";
}
?>