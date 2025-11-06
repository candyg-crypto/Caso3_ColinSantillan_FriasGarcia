<?php
session_start();
include_once "mysqlaux.php";

if (!isset($_SESSION["usuario"]) || !isset($_COOKIE["usuario"])) {
    header("Location: Login.php");
    exit;
}

if (!isset($_GET["id"])) {
    header("Location: Inicio.php");
    exit;
}

$id = intval($_GET["id"]);
$accion = $_GET["accion"] ?? "";

// Eliminar
if ($accion === "eliminar") {
    $sql = "DELETE FROM producto WHERE id = $id";
    $res = eliminar($sql);
    if ($res) {
        header("Location: Inicio.php");
        exit;
    } else {
        $error = "No se pudo eliminar el producto.";
    }
}

// Cargar datos
$sql = "SELECT * FROM producto WHERE id = $id";
$regs = seleccionar($sql);

if (count($regs) === 0) {
    echo "<script>alert('Producto no encontrado'); window.location='Inicio.php';</script>";
    exit;
}

// Ahora cargamos también la descripción
$producto = [
    "id" => $regs[0]["id"],
    "nombre" => $regs[0]["nombre"],
    "precio" => $regs[0]["precio"],
    "stock" => $regs[0]["stock"],
    "descripcion" => $regs[0]["descripcion"] // NUEVO: descripción
];

// Actualizar
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombre = $_POST["nombre"];
    $precio = $_POST["precio"];
    $stock = $_POST["stock"];
    $descripcion = $_POST["descripcion"]; // NUEVO: descripción

    if (!empty($nombre) && is_numeric($precio) && is_numeric($stock) && !empty($descripcion)) {
        $sqlUpdate = "UPDATE producto SET nombre='$nombre', precio=$precio, stock=$stock, descripcion='$descripcion' WHERE id=$id";
        $resultado = actualizar($sqlUpdate);

        if ($resultado) {
            header("Location: Inicio.php");
            exit;
        } else {
            $error = "Error al actualizar el producto.";
        }
    } else {
        $error = "Por favor, llena todos los campos correctamente.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar producto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light" style="font-family: Consolas;">
<div class="container bg-white rounded shadow p-4 mt-5 col-md-6 text-center">
    <h2 class="text-success mb-3">Editar producto</h2>

    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>

    <form method="post" action="">
        <div class="mb-3 text-start">
            <label class="form-label">Nombre del producto:</label>
            <input type="text" name="nombre" class="form-control" value="<?php echo htmlspecialchars($producto['nombre']); ?>" required>
        </div>
        <div class="mb-3 text-start">
            <label class="form-label">Precio:</label>
            <input type="number" step="0.01" name="precio" class="form-control" value="<?php echo $producto['precio']; ?>" required>
        </div>
        <div class="mb-3 text-start">
            <label class="form-label">Stock:</label>
            <input type="number" name="stock" class="form-control" value="<?php echo $producto['stock']; ?>" required>
        </div>
        <!-- NUEVO: Campo para la descripción -->
        <div class="mb-3 text-start">
            <label class="form-label">Descripción:</label>
            <textarea name="descripcion" class="form-control" rows="3" required><?php echo htmlspecialchars($producto['descripcion']); ?></textarea>
        </div>

        <div class="text-center mt-4">
            <button type="submit" class="btn btn-success">💾 Guardar cambios</button>
            <a href="Inicio.php" class="btn btn-secondary">↩️ Volver</a>
            <a href="mantenimiento.php?id=<?php echo $id; ?>&accion=eliminar" class="btn btn-danger"
               onclick="return confirm('¿Seguro que deseas eliminar este producto?');">🗑️ Eliminar</a>
        </div>
    </form>
</div>
</body>
</html>
