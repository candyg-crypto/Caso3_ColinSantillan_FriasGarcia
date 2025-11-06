<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST["usuario"];
    $clave = $_POST["clave"];

    // Credenciales válidas
    $usuario_valido = "dulce";
    $clave_valida = "1234";

    if ($usuario == $usuario_valido && $clave == $clave_valida) {
        // Guardar sesión y cookie
        $_SESSION["usuario"] = $usuario;
        setcookie("usuario", $usuario, time() + 60); // cookie dura 1 min

        header("Location: Inicio.php");
        exit;
    } else {
        header("Location: Error.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light text-center" style="padding-top: 100px; font-family: Consolas;">
    <div class="container col-md-4 bg-white p-4 rounded shadow">
        <h2 class="mb-4 text-success">Inicio de Sesion</h2>
        <form method="post" action="">
            <div class="mb-3">
                <input type="text" name="usuario" class="form-control" placeholder="Usuario" required>
            </div>
            <div class="mb-3">
                <input type="password" name="clave" class="form-control" placeholder="Contraseña" required>
            </div>
            <div class="form-check text-start mb-3">
                <input id="checkbox" type="checkbox" name="recordar_usuario" class="form-check-input">
                <label for="checkbox" class="form-check-label">Recuerdame</label>
            </div>
            <button type="submit" class="btn btn-success w-100">Ingresar</button>
        </form>
    </div>
</body>
</html>