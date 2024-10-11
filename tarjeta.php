<?php
session_start();

if (isset($_POST['option'])) {
    $_SESSION["tarjeta"] = $_POST['option'];
    echo $_SESSION["tarjeta"];
} else {
    echo "Error al guardar direccion";
}

?>
