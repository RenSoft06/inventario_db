<?php
require_once __DIR__ . '/conexion.php';
use MongoDB\BSON\ObjectId;
use MongoDB\BSON\UTCDateTime;

echo "<h2> Insertando datos a MongoDB...</h2>";

$db->productos->drop();
$db->categorias->drop();
$db->proveedores->drop();
$db->usuarios->drop();

echo "<p>Datos anteriores eleminados. Insertando nuevos datos...</p>";

$categorias = [
    ['nombre' => 'Electrónica', 'descripcion' => 'Dispositivos electrónicos'],
    ['nombre' => 'Ropa', 'descripcion' => 'Prendas de vestir'],
    ['nombre' => 'Hogar', 'descripcion' => 'Artículos para el hogar'],
    ['nombre' => 'Deportes', 'descripcion' => 'Equipo deportivo'],
    ['nombre' => 'Juguetes', 'descripcion' => 'Juguetes para niños'],
    ['nombre' => 'Libros', 'descripcion' => 'Libros y revistas'],
    ['nombre' => 'Computación', 'descripcion' => 'Computación y tecnología'],
    ['nombre' => 'Jardineria', 'descripcion' => 'Herramientas para jardineria'],
    ['nombre' => 'Mascotas', 'descripcion' => 'Productos para mascotas'],
    ['nombre' => 'Cocina', 'descripcion' => 'Utensilios de cocina']

];

$categoriasIds = [];
foreach($categorias as $cat) {
    $result = $db->categorias->insertOne($cat);
    $categoriasIds[] = $result->getInsertedId();
}
echo "<p>10 categorías insertadas</p>";

$proveedores = [
    ['nombre' => 'TecnoImport S.A.', 'contacto' => 'Juan Pérez', 'telefono' => '555-0101'],
    ['nombre' => 'ModaExpress', 'contacto' => 'María López', 'telefono' => '555-0102'],
    ['nombre' => 'HogarTotal', 'contacto' => 'Carlos Ruiz', 'telefono' => '555-0103'],
    ['nombre' => 'SportsWorld', 'contacto' => 'Ana Gómez', 'telefono' => '555-0104'],
    ['nombre' => 'Jugueton SRL', 'contacto' => 'Luis Martínez', 'telefono' => '555-0105'],
    ['nombre' => 'BookLovers', 'contacto' => 'Elena Díaz', 'telefono' => '555-0106'],
    ['nombre' => 'PC Store', 'contacto' => 'Ricardo Torres', 'telefono' => '555-0107'],
    ['nombre' => 'GreenGarden', 'contacto' => 'Patricia Soto', 'telefono' => '555-0108']
];

$proveedoresIds = [];
foreach($proveedores as $prov) {
    $result = $db->proveedores->insertOne($prov);
    $proveedoresIds[] = $result->getInsertedId();
}
echo "<p>8 proveedores insertados</p>";

$productos = [
    ['nombre' => 'Laptop', 'precio' => 800, 'stock' => 10],
    ['nombre' => 'Mouse', 'precio' => 20, 'stock' => 50],
    ['nombre' => 'Teclado', 'precio' => 30, 'stock' => 40],
    ['nombre' => 'Monitor', 'precio' => 300, 'stock' => 15],
    ['nombre' => 'Auriculares', 'precio' => 50, 'stock' => 25],
    ['nombre' => 'Camiseta', 'precio' => 15, 'stock' => 100],
    ['nombre' => 'Pantalón', 'precio' => 20, 'stock' => 80],
    ['nombre' => 'Bufanda', 'precio' => 10, 'stock' => 60],
    ['nombre' => 'Zapatos', 'precio' => 50, 'stock' => 30],
    ['nombre' => 'Gorra', 'precio' => 12, 'stock' => 70],
    ['nombre' => 'Sartén', 'precio' => 25, 'stock' => 40],
    ['nombre' => 'Olla', 'precio' => 30, 'stock' => 35],
    ['nombre' => 'Cortinas', 'precio' => 40, 'stock' => 20],
    ['nombre' => 'Lámparas', 'precio' => 30, 'stock' => 15],
    ['nombre' => 'Pelota', 'precio' => 15, 'stock' => 50],
    ['nombre' => 'Raqueta', 'precio' => 40, 'stock' => 20],
    ['nombre' => 'Guantes', 'precio' => 20, 'stock' => 30],
    ['nombre' => 'Muñeca', 'precio' => 18, 'stock' => 40],
    ['nombre' => 'Robot', 'precio' => 35, 'stock' => 25],
    ['nombre' => 'Novela', 'precio' => 15, 'stock' => 30],
    ['nombre' => 'Revista', 'precio' => 8, 'stock' => 50],
    ['nombre' => 'Disco Duro', 'precio' => 100, 'stock' => 20],
    ['nombre' => 'Memoria RAM', 'precio' => 80, 'stock' => 25],
    ['nombre' => 'Maceta', 'precio' => 12, 'stock' => 60],
    ['nombre' => 'Tijeras de podar', 'precio' => 15, 'stock' => 30],
    ['nombre' => 'Collar para perro', 'precio' => 8, 'stock' => 50],
    ['nombre' => 'Comida para gatos', 'precio' => 20, 'stock' => 40],
    ['nombre' => 'Taza', 'precio' => 10, 'stock' => 100],
    ['nombre' => 'Plato', 'precio' => 8, 'stock' => 80],
    ['nombre' => 'Jarra', 'precio' => 12, 'stock' => 60],
    ['nombre' => 'Termo', 'precio' => 15, 'stock' => 40],
    ['nombre' => 'Cafetera', 'precio' => 50, 'stock' => 20],
    ['nombre' => 'Licuadora', 'precio' => 60, 'stock' => 15],
    ['nombre' => 'Ventilador', 'precio' => 30, 'stock' => 25],
    ['nombre' => 'Cuchillo', 'precio' => 10, 'stock' => 70]
];

for ($i = 0; $i < count($productos); $i++) {
    $categoriaIndex = $i % 10;  
    $proveedorIndex = $i % 8;   
    
    $productos[$i]['codigo'] = 'PROD-' . str_pad($i + 1, 4, '0', STR_PAD_LEFT);
    $productos[$i]['categoria_id'] = $categoriasIds[$categoriaIndex];
    $productos[$i]['proveedor_id'] = $proveedoresIds[$proveedorIndex];
    $productos[$i]['fechaRegistro'] = date('Y-m-d H:i:s');
}

$db->productos->insertMany($productos);
echo "<p>" . count($productos) . " productos insertados</p>";

$usuarios = [
    ['nombre' => 'Admin', 'email' => 'admin@inventario.com', 'rol' => 'admin'],
    ['nombre' => 'Vendedor Juan', 'email' => 'juan@inventario.com', 'rol' => 'vendedor'],
    ['nombre' => 'Vendedora Ana', 'email' => 'ana@inventario.com', 'rol' => 'vendedor'],
    ['nombre' => 'Almacén Carlos', 'email' => 'carlos@inventario.com', 'rol' => 'almacen'],
    ['nombre' => 'Almacén Laura', 'email' => 'laura@inventario.com', 'rol' => 'almacen']
];

$db->usuarios->insertMany($usuarios);
echo "<p>5 usuarios insertados</p>";

echo "<hr>";
echo "<h2>¡Todos los datos fueron insertados exitosamente!</h2>";
echo "<p>Resumen:</p>";
echo "<ul>";
echo "<li>10 categorías</li>";
echo "<li>8 proveedores</li>";
echo "<li>35 productos</li>";
echo "<li>5 usuarios</li>";
echo "</ul>";

echo "<br><a href='productos.php' style='background:#27ae60; color:white; padding:10px 20px; text-decoration:none; border-radius:5px;'>Ver Productos</a>";
?>