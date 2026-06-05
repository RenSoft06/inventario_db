<?php require_once 'conexion.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proveedores - Inventario NoSQL</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <?php include 'navbar.php'; ?>

    <div class="container">
        <h1>Gestión Proveedores</h1>

        <div class="buscador-card">
            <h3>Buscar Productos</h3>
            <form method="GET" action="">
                <div class="buscador-fields">
                    <input type="text" name="buscar" placeholder="Buscar por nombre..." class="search-input" value="<?php echo $_GET['buscar'] ?? ''; ?>">
                    <button type="submit" class="btn">Buscar</button>
                    <a href="productos.php" class="btn btn-secondary">Limpiar</a>
                </div>
            </form>
        </div>

        <h2>Listado de Proveedores</h2>
        
        <?php 
        $filtro = [];
        if(isset($_GET['buscar']) && !empty($_GET['buscar'])){
            $buscar = $_GET['buscar'];
            $filtro = ['nombre' => ['$regex' => $buscar, '$options' => 'i']];
        }

        $proveedores = $db->proveedores->find($filtro);
        $totalProveedores = $db->proveedores->count($filtro);
        ?>
        <div class="stats">
            <span>Total Proveedores: <?php echo $totalProveedores; ?></span>
        </div>

        <table>
            <thead>
                <th>ID</th>
                <th>Nombre</th>
                <th>Contacto</th>
                <th>Teléfono</th>
            </thead>
            <tbody>
                <?php foreach($proveedores as $proveedor): ?>
                <tr>
                    <td><?php echo $proveedor->codigo ?? substr($proveedor->_id, -8); ?></td>
                    <td><strong><?php echo $proveedor->nombre; ?></strong></td>
                    <td><?php echo $proveedor->contacto ?? 'N/A'; ?></td>
                    <td><?php echo $proveedor->telefono ?? 'N/A'; ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    
</body>
</html>