<?php
session_start();
include_once "mysqlaux.php";

if (!isset($_SESSION["usuario"]) || !isset($_COOKIE["usuario"])) {
    header("Location: Login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombre = $_POST["nombre"];
    $precio = $_POST["precio"];
    $stock = $_POST["stock"];

    if (!empty($nombre) && is_numeric($precio) && is_numeric($stock)) {
        $sql = "INSERT INTO producto (nombre, precio, stock) VALUES ('$nombre', $precio, $stock)";
        $id = insertar($sql);

        if ($id != 0) {
            header("Location: Inicio.php");
            exit;
        } else {
            $error = "Error al insertar el producto.";
        }
    } else {
        $error = "Todos los campos deben llenarse correctamente.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agregar nuevo producto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light" style="font-family: Consolas;">
    <div class="container bg-white rounded shadow p-4 mt-5 col-md-6">
        <h2 class="text-success text-center mb-3">Agregar nuevo producto</h2>

        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>

        <form method="post" action="">
            <div class="mb-3">
                <label class="form-label">Nombre del producto:</label>
                <input type="text" name="nombre" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Precio:</label>
                <input type="number" step="0.01" name="precio" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Stock:</label>
                <input type="number" name="stock" class="form-control" required>
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-success">💾 Guardar producto</button>
                <a href="Inicio.php" class="btn btn-secondary">↩️ Volver</a>
            </div>
        </form>
    </div>
</body>
</html>
