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
        <h1>Gestión Productos</h1>

        <div class="form-card">
            <h3>Agregar Nuevo Producto</h3>
            <form method="POST" action="acciones/agregar_producto.php">
                <div class="form-grid">
                    <input type="text" id="nombre" name="nombre" placeholder="Nombre del producto" required>
                    <input type="number" id="precio" step="0.01" name="precio" placeholder="Precio" required>
                    <input type="number" id="stock" value="0" name="stock" placeholder="Stock" required>
                     <select name="categoria_id" required>
                        <option value="">Seleccionar Categoría</option>
                        <?php
                        $categorias = $db->categorias->find();
                        foreach($categorias as $categoria):
                        ?>
                            <option value="<?php echo $categoria->_id; ?>"><?php echo $categoria->nombre; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <select name="proveedor_id" required>
                        <option value="">Seleccionar Proveedor</option>
                        <?php
                        $proveedores = $db->proveedores->find();
                        foreach($proveedores as $proveedor):
                        ?>
                            <option value="<?php echo $proveedor->_id; ?>"><?php echo $proveedor->nombre; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <button type="submit" class="btn-success">Agregar Producto</button>
            </form>      
        </div>

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

        <h2>Listado de Productos</h2>
        
        <?php 
        $filtro = [];
        if(isset($_GET['buscar']) && !empty($_GET['buscar'])){
            $buscar = $_GET['buscar'];
            $filtro = ['nombre' => ['$regex' => $buscar, '$options' => 'i']];
        }

        $productos = $db->productos->find($filtro);
        $totalProductos = $db->productos->count($filtro);

        $todosProductos = $db->productos->find();
        $stockTotal = 0;
        foreach($todosProductos as $prod){
            $stockTotal += $prod->stock;
        }
        ?>

        <div class="stats">
            <span>Total Productos: <?php echo $totalProductos; ?></span>
            <span>Stock Total: <?php echo $stockTotal; ?></span>
        </div>
        

        <div>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Precio</th>
                        <th>Stock</th>
                        <th>Categoría</th>
                        <th>Proveedor</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($productos as $producto):
                        $categoria = $db->categorias->findOne(['_id' => $producto->categoria_id]);
                        $proveedor = $db->proveedores->findOne(['_id' => $producto->proveedor_id]);
                    ?>
                    <tr>
                        <td><?php echo $producto->_id; ?></td>
                        <td><?php echo $producto->nombre; ?></td>
                        <td>$<?php echo number_format($producto->precio, 2); ?></td>
                        <td class="<?php echo $producto->stock < 10 ? 'stock-bajo' : ''; ?>"><?php echo $producto->stock; ?></td>
                        <td><?php echo $categoria ? $categoria->nombre : 'N/A'; ?></td>
                        <td><?php echo $proveedor ? $proveedor->nombre : 'N/A'; ?></td>
                        <td class="acciones">
                            <button onclick="abrirModalEditar('<?php echo $producto->_id; ?>')" class="btn-warning">Editar</button>
                            <a href="acciones/eliminar_producto.php?id=<?php echo $producto->_id; ?>" class="btn-danger" onclick="return confirm('¿Eliminar?')">Eliminar</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div id="modalEditar" class="modal">
        <div class="modal-content">
            <h3>Editar Producto</h3>
            <form method="POST" action="acciones/editar_producto.php">
                <input type="hidden" id="editId" name="id">
                <input type="text" id="editNombre" name="nombre" placeholder="Nombre" required>
                <input type="number" step="0.01" id="editPrecio" name="precio" placeholder="Precio" required>
                <input type="number" id="editStock" name="stock" placeholder="Stock" required>
                <select id="editCategoria" name="categoria_id" required>
                    <?php
                    $categorias = $db->categorias->find();
                    foreach($categorias as $cat):
                    ?>
                    <option value="<?php echo $cat->_id; ?>"><?php echo $cat->nombre; ?></option>
                    <?php endforeach; ?>
                </select>
                <select id="editProveedor" name="proveedor_id" required>
                    <?php
                    $proveedores = $db->proveedores->find();
                    foreach($proveedores as $prov):
                    ?>
                    <option value="<?php echo $prov->_id; ?>"><?php echo $prov->nombre; ?></option>
                    <?php endforeach; ?>
                </select>
                <div class="modal-buttons">
                    <button type="submit" class="btn-success">Guardar</button>
                    <button type="button" class="btn-secondary" onclick="cerrarModal()">Cancelar</button>
                </div>
            </form>
        </div>
    </div>

    <script>
    function abrirModalEditar(id) {
        fetch('acciones/obtener_producto.php?id=' + id)
            .then(response => response.json())
            .then(data => {
                document.getElementById('editId').value = data._id;
                document.getElementById('editNombre').value = data.nombre;
                document.getElementById('editPrecio').value = data.precio;
                document.getElementById('editStock').value = data.stock;
                document.getElementById('editCategoria').value = data.categoria_id;
                document.getElementById('editProveedor').value = data.proveedor_id;
                document.getElementById('modalEditar').style.display = 'flex';
            });
    }

    function cerrarModal() {
        document.getElementById('modalEditar').style.display = 'none';
    }

    window.onclick = function(event) {
        let modal = document.getElementById('modalEditar');
        if(event.target == modal) {
            modal.style.display = 'none';
        }
    }
    </script>
</body>
</html>