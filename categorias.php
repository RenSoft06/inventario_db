<?php require_once 'conexion.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categorías - Inventario NoSQL</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <?php include 'navbar.php'; ?>

    <div class="container">
        <h1>Gestión Categorías</h1>

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

        <h2>Listado de Categorías</h2>
        
        <?php 
        $filtro = [];
        if(isset($_GET['buscar']) && !empty($_GET['buscar'])){
            $buscar = $_GET['buscar'];
            $filtro = ['nombre' => ['$regex' => $buscar, '$options' => 'i']];
        }

        $categorias = $db->categorias->find($filtro);
        $totalCategorias = $db->categorias->count($filtro);
        ?>
        <div class="stats">
            <span>Total Categorías: <?php echo $totalCategorias; ?></span>
        </div>

        <table>
            <thead>
                <th>ID</th>
                <th>Nombre</th>
                <th>Descripción</th>
            </thead>
            <tbody>
                <?php foreach($categorias as $categoria): ?>
                <tr>
                    <td><?php echo substr($categoria->_id, -8); ?></td>
                    <td><strong><?php echo $categoria->nombre; ?></strong></td>
                    <td><?php echo $categoria->descripcion ?? 'N/A'; ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    
</body>
</html>