<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "sirenegaze";
$tabla = "descuentos";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idDescuento = $_POST['idDescuento'];

    // Eliminar el descuento de la base de datos
    $sql = "DELETE FROM $tabla WHERE IdDescuentos = '$idDescuento'";

    if ($conn->query($sql) === TRUE) {
        echo "Descuento eliminado exitosamente.";
    } else {
        echo "Error al eliminar el descuento: " . $conn->error;
    }
}

$conn->close();
