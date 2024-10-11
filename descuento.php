<?php
session_start();

if (isset($_POST['descuentoAplicado'])) {
    $_SESSION["descuento"] = $_POST['descuentoAplicado'];
    echo $_SESSION["descuento"];
} else {
    echo "Error al guardar impuestos";
}

?>
