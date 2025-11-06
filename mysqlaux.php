<?php
ini_set('display_errors', E_ALL);

function conectar($host = "127.0.0.1", $user = "root", $pass = "123456", $db = "Productosweb", $port = 3306) {
    $cnx = mysqli_connect($host, $user, $pass, $db, $port);

    if (!$cnx) {
        die("Error al conectar a la base de datos: " . mysqli_connect_error());
    }

    return $cnx;
}

function insertar($query) {
    $cnx = conectar();
    $res = mysqli_query($cnx, $query);
    if (!$res) {
        die("Error en INSERT: " . mysqli_error($cnx));
    }
    $id = mysqli_insert_id($cnx);
    mysqli_close($cnx);
    return $id;
}

function seleccionar($query) {
    $regs = [];
    $cnx = conectar();
    $res = mysqli_query($cnx, $query);
    if (!$res) {
        die("Error en SELECT: " . mysqli_error($cnx));
    }
    // Cambié fetch_row por fetch_assoc para arrays asociativos
    while ($registro = mysqli_fetch_assoc($res)) {
        $regs[] = $registro;
    }
    mysqli_free_result($res);
    mysqli_close($cnx);
    return $regs;
}

function actualizar($query) {
    $cnx = conectar();
    $res = mysqli_query($cnx, $query);
    if (!$res) {
        die("Error en UPDATE: " . mysqli_error($cnx));
    }
    mysqli_close($cnx);
    return $res;
}

function eliminar($query) {
    $cnx = conectar();
    $res = mysqli_query($cnx, $query);
    if (!$res) {
        die("Error en DELETE: " . mysqli_error($cnx));
    }
    mysqli_close($cnx);
    return $res;
}
?>
