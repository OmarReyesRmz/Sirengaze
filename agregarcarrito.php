<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sirenegaze";
$tabla = "inventario";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productoId = isset($_POST['producto_id']) ? intval($_POST['producto_id']) : 0;
    $query = "SELECT * FROM $tabla WHERE Id_producto = $productoId";
    $result = $conn->query($query);
    $row = $result->fetch_assoc();

    $existencias = $row['cantidad'];

    $cant =  $existencias - (isset($_SESSION['carrito'][$productoId]['cantidad']) ? $_SESSION['carrito'][$productoId]['cantidad']: 0);

    if ($productoId > 0 && $existencias > 0 && $cant > 0) {
        // Lógica para agregar al carrito aquí
        $_SESSION['carrito'][$productoId]['cantidad'] = isset($_SESSION['carrito'][$productoId]['cantidad'])
            ? $_SESSION['carrito'][$productoId]['cantidad'] + 1
            : 1;
        
        $_SESSION["contador"] = isset($_SESSION["contador"]) ? $_SESSION["contador"] + 1 : 1;
        
        echo json_encode(['success' => true]);
    } else {    
        echo json_encode(['error' => 'ID de producto no válido']);
    }
} else {
    echo json_encode(['error' => 'Método de solicitud no válido']);
}
