<?php require_once 'conexion.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Inventario NoSQL</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <?php include 'navbar.php'; ?>

    <div class="container">
        <h1>Dashboard</h1>

        <?php 
        $totalProductos = $db->productos->count();
        $totalProveedores = $db->proveedores->count();
        $totalCategorias = $db->categorias->count();
        $totalUsuarios = $db->usuarios->count();

        $bajoStock = $db->productos->count(['stock' => ['$lt' => 10]]);
        ?>

        <div class="cards">
            <div class="card">
                <h2>Total Productos</h2>
                <p><?php echo $totalProductos; ?></p>
            </div>
            <div class="card">
                <h2>Total Proveedores</h2>
                <p><?php echo $totalProveedores; ?></p>
            </div>
            <div class="card">
                <h2>Total Categorías</h2>
                <p><?php echo $totalCategorias; ?></p>
            </div>
            <div class="card">
                <h2>Total Usuarios</h2>
                <p><?php echo $totalUsuarios; ?></p>
            </div>
            <div class="card-warning">
                <h2>Productos Bajo Stock</h2>
                <p><?php echo $bajoStock; ?></p>
            </div>
        </div>

        <div style="margin-top: 30px; text-align: center;">
            <a href="productos.php" class="btn" style="margin: 5px;">Gestionar Productos</a>
            <a href="movimientos.php" class="btn" style="margin: 5px; background: #27ae60;">Ver Movimientos</a>
        </div>
    </div>

</body>
</html>