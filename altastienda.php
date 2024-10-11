<?php

$servername = "localhost";
$username = "root";
$password = "";
$database = "sirenegaze";
$tabla = "inventario";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$nombre = $_POST["nombre"];
$descripcion = $_POST["descripcion"];
$cantidad = $_POST["cantidad"];
$precio = $_POST["precio"];
$imagen = $_FILES["imagen"]["name"];
$descuento = $_POST["descuento"];
$categoria = $_POST["categoria"];
$subcategoria = $_POST["subcategoria"];

$rutaTemporal = $_FILES['imagen']['tmp_name'];
$carpetaDestino = 'imagenes/'; 

$rutaCompleta = $carpetaDestino . $imagen;

move_uploaded_file($rutaTemporal, $rutaCompleta);

$sql = $conn->prepare("INSERT INTO inventario (nombre, descripcion, cantidad, precio, imagen, descuento, categoria, subcategoria) VALUES (?, ?, ?, ?, ?, ?, ?, ? )");
$sql->bind_param("ssidsiss", $nombre, $descripcion, $cantidad, $precio, $imagen, $descuento, $categoria, $subcategoria);

if ($sql->execute()) {
    echo "Producto agregado correctamente.";
    sleep(5);
    header("Location: tienda.php");
} else {
    echo "Error al agregar el producto: " . $sql->error;
}

$sql->close();
$conn->close();
?>
