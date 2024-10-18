<header>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
</header>
<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$database = "sirenegaze";
$tabla = "producto";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['IdProducto'])) {
    $idProductoEditar = $_POST['IdProducto'];

    // Obtén los datos actuales del producto, incluidas las imágenes
    $sqlProducto = $conn->prepare("SELECT Imagen, Imagen2, Imagen3 FROM $tabla WHERE IdProducto = ?");
    $sqlProducto->bind_param("i", $idProductoEditar);
    $sqlProducto->execute();
    $resultadoProducto = $sqlProducto->get_result();
    $productoEditar = $resultadoProducto->fetch_assoc();
    $sqlProducto->close();

    $nombre = $_POST['Nombre'];
    $precio = $_POST['Precio'];
    $categoria = $_POST['Categoria'];
    $marca = $_POST['Marca'];
    $exclusivo = $_POST['Exclusivo'];
    $descuento = $_POST['Descuento'];
    $descripcion = $_POST['Descripcion'];
    $subcategoria = $_POST['Subcategoria'];

    $xch = $_POST['XCH'];
    $ch = $_POST['CH'];
    $m = $_POST['M'];
    $l = $_POST['L'];
    $xl = $_POST['XL'];
    $xxl = $_POST['XXL'];

    // Si no se suben nuevas imágenes, se mantienen las imágenes actuales
    $imagen1 = $productoEditar['Imagen'];
    $imagen2 = $productoEditar['Imagen2'];
    $imagen3 = $productoEditar['Imagen3'];

    // Manejo de archivos de imagen subidos
    if ($_FILES['Imagen1']['tmp_name']) {
        $imagen1 = basename($_FILES['Imagen1']['name']);
        move_uploaded_file($_FILES['Imagen1']['tmp_name'], "imagenes/" . $imagen1);
    }
    if ($_FILES['Imagen2']['tmp_name']) {
        $imagen2 = basename($_FILES['Imagen2']['name']);
        move_uploaded_file($_FILES['Imagen2']['tmp_name'], "imagenes/" . $imagen2);
    }
    if ($_FILES['Imagen3']['tmp_name']) {
        $imagen3 = basename($_FILES['Imagen3']['name']);
        move_uploaded_file($_FILES['Imagen3']['tmp_name'], "imagenes/" . $imagen3);
    }

    // Actualización de producto
    $sqlActualizar = $conn->prepare("UPDATE $tabla SET 
        Nombre = ?, Precio = ?, Categoria = ?, Marca = ?, Exclusivo = ?, Descuento = ?, Descripcion = ?, Subcategoria = ?, 
        Imagen = ?, Imagen2 = ?, Imagen3 = ?, 
        XCH = ?, CH = ?, M = ?, L = ?, XL = ?, XXL = ? 
        WHERE IdProducto = ?");

    $sqlActualizar->bind_param("sdsssdsssssiiiiiii", 
        $nombre, $precio, $categoria, $marca, $exclusivo, $descuento, $descripcion, $subcategoria,
        $imagen1, $imagen2, $imagen3, $xch, $ch, $m, $l, $xl, $xxl, $idProductoEditar
    );

    if ($sqlActualizar->execute()) {
        echo "<script>
            Swal.fire({
                title: 'Éxito!',
                text: 'Producto actualizado con éxito',
                icon: 'success',
                confirmButtonText: 'Aceptar'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'tienda.php';
                }
            });
        </script>";
    } else {
        echo "Error al actualizar el producto: " . $conn->error;
    }

    $sqlActualizar->close();
} else {
    echo "Solicitud no válida.";
}

$conn->close();
?>
