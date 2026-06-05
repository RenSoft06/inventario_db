<?php require_once 'conexion.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movimientos - Inventario</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <?php include 'navbar.php'; ?>
    
    <div class="container">
        <h1>Movimientos de Inventario</h1>
        
        <div class="instrucciones">
            <strong>Instrucciones:</strong><br>
            • Para <strong>ENTRADA</strong> de stock (compras, devoluciones): usa el botón <span style="background:#27ae60; color:white; padding:2px 8px; border-radius:3px;">Entrada</span><br>
            • Para <strong>SALIDA</strong> de stock (ventas, pérdidas): usa el botón <span style="background:#e74c3c; color:white; padding:2px 8px; border-radius:3px;">Salida</span><br>
            • <strong>Validación activa:</strong> No permite stock negativo
        </div>
        
        <?php
        $productos = $db->productos->find();
        ?>
        
        <div class="table-container">
            <table class="movimientos-table">
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Producto</th>
                        <th>Stock Actual</th>
                        <th>Categoría</th>
                        <th>Entrada</th>
                        <th>Salida</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($productos as $producto): 
                        $categoria = $db->categorias->findOne(['_id' => $producto->categoria_id]);
                        $stockClass = $producto->stock < 10 ? 'stock-bajo-mov' : '';
                    ?>
                    <tr>
                         <td><?php echo $producto->codigo ?? substr($producto->_id, -8); ?></td>
                        <td><strong><?php echo $producto->nombre; ?></strong></td>
                        <td>
                            <span class="stock-valor <?php echo $stockClass; ?>">
                                <?php echo $producto->stock; ?> unidades
                            </span>
                        </td>
                        <td><?php echo $categoria ? $categoria->nombre : 'N/A'; ?></td>
                        
                        <td>
                            <form method="GET" action="acciones/entrada.php" class="movimiento-form">
                                <input type="hidden" name="id" value="<?php echo $producto->_id; ?>">
                                <input type="number" name="cantidad" class="movimiento-cantidad" min="1" value="1" required>
                                <button type="submit" class="btn-movimiento btn-entrada">+ Entrada</button>
                            </form>
                        </td>
                       
                        <td>
                            <form method="GET" action="acciones/salida.php" class="movimiento-form" onsubmit="return confirm('⚠️ ¿Confirmar salida de stock?')">
                                <input type="hidden" name="id" value="<?php echo $producto->_id; ?>">
                                <input type="number" name="cantidad" class="movimiento-cantidad" min="1" value="1" required>
                                <button type="submit" class="btn-movimiento btn-salida">- Salida</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        
        <div style="margin-top: 25px; text-align: center;">
            <a href="productos.php" class="btn">Volver a Productos</a>
        </div>
    </div>
</body>
</html>