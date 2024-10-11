<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$database = "sirenegaze";
$tabla = "inventario";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idProducto = $_POST["Id_producto"];
    $nombreEditar = $_POST["nombre"];
    $precioEditar = $_POST["precio"];
    
// Procesar la imagen si se proporciona
if (!empty($_FILES["imagen"]["name"])) {
    $imagen = $_FILES["imagen"]["name"];
    $rutaTemporal = $_FILES['imagen']['tmp_name'];
    $carpetaDestino = 'imagenes/';
    $rutaCompleta = $carpetaDestino . $imagen;
    move_uploaded_file($rutaTemporal, $rutaCompleta);
} else {
    // Si no se proporciona una nueva imagen, mantener la imagen existente
    $consultaImagen = $conn->prepare("SELECT imagen FROM $tabla WHERE Id_producto = ?");
    $consultaImagen->bind_param("i", $idProducto);
    $consultaImagen->execute();

    // Manejar errores durante la consulta
    if ($consultaImagen->errno) {
        // Manejar el error de la consulta (por ejemplo, mostrar un mensaje de error o registrar el error)
        die("Error durante la consulta de la imagen existente: " . $consultaImagen->error);
    }

    $resultadoImagen = $consultaImagen->get_result()->fetch_assoc();

    // Asignar la imagen existente a la variable $imagen
    $imagen = $resultadoImagen['imagen'];
    echo $imagen;
    $consultaImagen->close();
}

    $existenciaEditar = $_POST["cantidad"];
    $descuentoEditar = $_POST["descuento"];
    $descripcionEditar = $_POST["descripcion"];
    $categoriaEditar = $_POST["categoria"];
    $subcategoriaEditar = $_POST["subcategoria"];

    // Actualizar los datos en la base de datos
    $actualizarConsulta = $conn->prepare("UPDATE $tabla SET nombre = ?, precio = ?, cantidad = ?, descuento = ?, descripcion = ?, categoria = ?, subcategoria = ?, imagen = ? WHERE Id_producto = ?");
    $actualizarConsulta->bind_param("sdiissssi", $nombreEditar, $precioEditar, $existenciaEditar, $descuentoEditar, $descripcionEditar, $categoriaEditar, $subcategoriaEditar, $imagen, $idProducto);

    if ($actualizarConsulta->execute()) {
        header("Location: c.php");
        exit(); 
    } else {
        echo "Error al guardar cambios: " . $actualizarConsulta->error;
    }

    $actualizarConsulta->close();
} else {
    echo "Solicitud incorrecta.";
}

$conn->close();
?>
