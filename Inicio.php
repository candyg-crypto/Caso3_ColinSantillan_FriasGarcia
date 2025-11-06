<?php 
session_start();

if (!isset($_SESSION["usuario"]) || !isset($_COOKIE["usuario"])) {
    header("Location: Login.php");
    exit;
}

// Si el usuario cierra sesion
if (isset($_POST["cerrar"])) {
    setcookie("usuario", "", time() - 3600);
    session_unset();
    session_destroy();
    header("Location: Login.php");
    exit;
}

include_once "mysqlaux.php"; // conexion a la base de datos
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Tienda</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #e6ffe6;
            font-family: Consolas, monospace;
        }
    </style>
</head>

<body>
    <div class="container text-center bg-white p-4 rounded shadow mt-4">
        <h1 class="text-success mb-3">¡Bienvenida, <?php echo htmlspecialchars($_SESSION["usuario"]); ?>!</h1>
        <p>Has iniciado sesión correctamente.</p>
        <p><small>Tu cookie está activa por un minuto.</small></p>
        <hr>

        <h3 class="text-success mb-4">📦 Lista de productos</h3>

        <div class="table-responsive">
            <?php include "lista.php"; ?>
        </div>

        <div class="mt-4">
            <form action="nuevo.php" method="get" class="d-inline">
                <button type="submit" class="btn btn-success">➕ Agregar nuevo producto</button>
            </form>

            <form method="post" action="" class="d-inline">
                <button type="submit" name="cerrar" class="btn btn-danger">🚪 Cerrar sesion</button>
            </form>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function() {
            $('table').DataTable({
                language: { url: "//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json" },
                pageLength: 5,
                responsive: true
            });
        });
    </script>
</body>
</html>
