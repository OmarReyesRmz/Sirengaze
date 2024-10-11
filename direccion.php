<?php
session_start();

if (isset($_POST['direccion'])) {
    $_SESSION["direccion"] = $_POST['direccion'];
    echo $_SESSION["direccion"];
} else {
    echo "Error al guardar direccion";
}

?>
