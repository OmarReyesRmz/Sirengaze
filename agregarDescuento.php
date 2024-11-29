<?php
session_start();
ob_start(); // Inicia el almacenamiento de la salida en el buffer
include 'header.php';

// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$database = "sirenegaze";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Recibir datos del formulario
$nombre_descuento = $_POST['nombre_descuento'];
$categoria = $_POST['categoria'];
$tipo_descuento = $_POST['tipo_descuento'];
$valor_descuento = $_POST['valor_descuento'];
$fecha_expiracion = $_POST['fecha_expiracion'];
$Cantidad = $_POST['Cantidad'];

// Insertar el descuento en la base de datos
$sql = "INSERT INTO descuentos (Nombre, Categoria, Tipo, Descuento, FechaExpiracion, Cantidad) 
        VALUES ('$nombre_descuento', '$categoria', '$tipo_descuento', '$valor_descuento', '$fecha_expiracion', '$Cantidad')";

if ($conn->query($sql) === TRUE) {
    echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
    echo "<script>
        Swal.fire({
            icon: 'success',
            title: 'Descuento agregado exitosamente',
            showConfirmButton: false,
            timer: 1500
        }).then(function() {
            window.location = 'control.php';  
        });
    </script>";
} else {
    echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
    echo "<script>
        alert('Este es un mensaje de prueba de error'); 
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: '" . $conn->error . "',
        });
    </script>";
}

ob_end_flush(); // Envía todo el contenido almacenado en el buffer
$conn->close();

