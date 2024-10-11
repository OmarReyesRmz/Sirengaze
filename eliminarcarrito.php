<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sirenegaze";
$tabla = "inventario";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productoId = isset($_POST['producto_id']) ? intval($_POST['producto_id']) : 0;
    $query = "SELECT * FROM $tabla WHERE Id_producto = $productoId";
    $result = $conn->query($query);
    $row = $result->fetch_assoc();

    if ($productoId > 0) {
        $_SESSION['carrito'][$productoId]['cantidad'] = $_SESSION["carrito"][$productoId]["cantidad"] - 1;
        
        $_SESSION["contador"] = $_SESSION["contador"] - 1;

        if($_SESSION["contador"] == 0){
            unset($_SESSION["carrito"]);
        }
        echo json_encode(['success' => true]);
    } else {    
        echo json_encode(['error' => 'ID de producto no válido']);
    }
} else {
    echo json_encode(['error' => 'Método de solicitud no válido']);
}
