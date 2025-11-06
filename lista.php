<?php
include_once "mysqlaux.php"; // Funciones de conexión y consultas

// Usamos la función seleccionar() y cambiamos para que devuelva arrays asociativos
$productos = seleccionar("SELECT * FROM producto");

// Verificamos que haya resultados
if (!$productos || count($productos) === 0) {
    echo "<div class='alert alert-warning'>No hay productos disponibles.</div>";
    exit;
}
?>

<table class="table table-striped table-bordered align-middle">
    <thead class="table-success text-center">
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Precio</th>
            <th>Stock</th>
            <th>Descripción</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($productos as $fila): ?>
            <tr>
                <td><?php echo $fila['id']; ?></td>
                <td><?php echo htmlspecialchars($fila['nombre']); ?></td>
                <td>$<?php echo number_format($fila['precio'], 2); ?></td>
                <td><?php echo $fila['stock']; ?></td>
                <td><?php echo htmlspecialchars($fila['descripcion']); ?></td>
                <td class="text-center">
                    <a href="mantenimiento.php?id=<?php echo $fila['id']; ?>" class="btn btn-sm btn-primary">✏️ Editar</a>
                    <a href="mantenimiento.php?id=<?php echo $fila['id']; ?>&accion=eliminar" 
                       class="btn btn-sm btn-danger"
                       onclick="return confirm('¿Seguro que deseas eliminar este producto?');">🗑️ Eliminar</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
