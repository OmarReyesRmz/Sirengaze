<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "sirenegaze";
$tabla = "producto";

$conn = new mysqli($servername, $username, $password, $database);

// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}
$idProducto = $_POST["idProducto"];

$dataQuery = "SELECT * FROM $tabla";
$dataResult = $conn->query($dataQuery);

$sql = "UPDATE $tabla SET Exclusivo='T' WHERE IdProducto = '$idProducto' ";

if ($conn->query($sql) === TRUE) {
    echo "Producto eliminado correctamente.";
    
    header("Location: b.php");
} else {
    
    echo "Error al eliminar el producto: " . $conn->error;
}

$conn->close();

?>