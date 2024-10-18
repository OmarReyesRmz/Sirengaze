<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sirenegaze";
$tabla = "producto";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener el ID del producto y la talla seleccionada del POST
    $productoId = isset($_POST['producto_id']) ? intval($_POST['producto_id']) : 0;
    $talla = isset($_POST['talla']) ? $_POST['talla'] : '';

    // Consulta para obtener detalles del producto
    $query = "SELECT * FROM $tabla WHERE IdProducto = $productoId";
    $result = $conn->query($query);
    $row = $result->fetch_assoc();

    // Verificar las existencias
    $existencias = $row['Existencias'];

    // Restar las existencias del carrito actual
    $cant = $existencias - (isset($_SESSION['carrito'][$productoId]['cantidad']) ? $_SESSION['carrito'][$productoId]['cantidad'] : 0);
    $ExistenciTalla = $row[$talla] - (isset($_SESSION['carrito'][$productoId]['cantidad']) ? $_SESSION['carrito'][$productoId]['cantidad'] : 0);
    // Validar si el producto es válido y hay suficientes existencias
    if ($productoId > 0 && $existencias > 0 && $cant > 0  && $ExistenciTalla > 0) {
        // Lógica para agregar al carrito aquí
        if (!isset($_SESSION['carrito'][$productoId])) {
            $_SESSION['carrito'][$productoId] = [
                'cantidad' => 0,
                'talla' => $talla  // Guardar la talla seleccionada en la sesión
            ];
        }
        
        // Incrementar la cantidad del producto en el carrito
        $_SESSION['carrito'][$productoId]['cantidad'] += 1;

        // Incrementar el contador total de productos
        $_SESSION["contador"] = isset($_SESSION["contador"]) ? $_SESSION["contador"] + 1 : 1;

        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['error' => 'ID de producto no válido o alcanzaste el limite de existencias en la talla selecionada']);
    }
} else {
    echo json_encode(['error' => 'Método de solicitud no válido']);
}
