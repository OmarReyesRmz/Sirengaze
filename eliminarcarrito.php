<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sirenegaze";
$tabla = "producto";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productoId = isset($_POST['producto_id']) ? intval($_POST['producto_id']) : 0;
    $talla = $_POST['talla'];

    // Verifica que el producto y la talla existan en el carrito
    if ($productoId > 0 && isset($_SESSION['carrito'][$productoId][$talla])) {
        // Disminuye la cantidad para esa talla
        $_SESSION['carrito'][$productoId][$talla]['cantidad'] -= 1;
        
        // Si la cantidad llega a 0, elimina la talla del carrito
        if ($_SESSION['carrito'][$productoId][$talla]['cantidad'] <= 0) {
            unset($_SESSION['carrito'][$productoId][$talla]);
        }

        // Si ya no hay tallas para ese producto, elimina el producto del carrito
        if (empty($_SESSION['carrito'][$productoId])) {
            unset($_SESSION['carrito'][$productoId]);
        }

        // Disminuye el contador total del carrito
        $_SESSION['contador'] = isset($_SESSION['contador']) ? $_SESSION['contador'] - 1 : 0;

        // Si el contador llega a 0, elimina todo el carrito
        if ($_SESSION['contador'] <= 0) {
            unset($_SESSION['carrito']);
            $_SESSION['contador'] = 0;
        }

        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['error' => 'Producto o talla no válidos']);
    }
} else {
    echo json_encode(['error' => 'Método de solicitud no válido']);
}
?>
