<?php
session_start();
?>

<header>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
    <link rel="stylesheet" href="css/styt.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</header>

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
    $idDescuento = $_POST['Id_descuento'];
    $nombre = $_POST['nombre'];
    $categoria = $_POST['categoria'];
    $tipo = $_POST['tipo'];
    $descuento = $_POST['descuento'];
    $fechaExpiracion = $_POST['fechaExpiracion'];
    $cantidad = $_POST['cantidad'];

    $sql = "UPDATE $tabla SET 
                Nombre = '$nombre', 
                Categoria = '$categoria', 
                Tipo = '$tipo', 
                Descuento = '$descuento', 
                FechaExpiracion = '$fechaExpiracion' ,
                Cantidad = '$cantidad'
            WHERE IdDescuentos = '$idDescuento'";

    if ($conn->query($sql) === TRUE) {
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
        echo "<script>
            Swal.fire({
                icon: 'success',
                title: 'Descuento actualizado exitosamente',
                showConfirmButton: false,
                timer: 1500
            }).then(function() {
                window.location = 'control.php';  
            });
        </script>";
    } else {
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
        echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Error al actualizar el descuento',
                text: '" . $conn->error . "',
                showConfirmButton: true
            });
        </script>";
    }
}

$conn->close();
?>
