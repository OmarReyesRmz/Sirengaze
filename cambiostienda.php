<?php session_start(); ?>

<header>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
    <link rel="stylesheet" href="css/styt.css">
    <link rel="stylesheet" href="css/altas.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .contenedor-altas2 button{
            background-color: #8AB4F8;
            font-weight: 1000;
            font-size: 1.2rem;
        }
    </style>
</header>

<?php
require('header.php');
$servername = "localhost";
$username = "root";
$password = "";
$database = "sirenegaze";
$tabla = "inventario";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Obtener los datos actuales del producto
if (isset($_GET['id'])) {
    $idProductoEditar = $_GET['id'];

    $consultaEditar = $conn->prepare("SELECT * FROM $tabla WHERE Id_producto = ?");
    $consultaEditar->bind_param("i", $idProductoEditar);
    $consultaEditar->execute();
    $resultadoEditar = $consultaEditar->get_result();

    if ($resultadoEditar->num_rows > 0) {
        $productoEditar = $resultadoEditar->fetch_assoc();
    } else {
        echo "Producto no encontrado.";
    }

    $consultaEditar->close();
}
?>

<!DOCTYPE html>
<html lang="es">

<body>
<div class="contenedor-altas">
    <div class="tienda ">
        <form method="post" enctype="multipart/form-data" action="cambiosguardar.php">
            <div class="contenedor-altas2">
                <h5 style="font-weight: bold;">Editar Producto <?php echo $idProductoEditar ?></h5>
                <input type="hidden" name="Id_producto" value="<?php echo $productoEditar['Id_producto']; ?>">
                <img id="imagenPrevia" src="<?php echo 'imagenes/' . $productoEditar['imagen']; ?>" alt="" class="con">
                <input type="file" name="imagen" accept="image/jpeg, image/png" onchange="mostrarVistaPrevia(this)"><br>
                <h5 style="font-weight: bold;">Nombre de la prenda</h5>
                <input type="text" name="nombre" placeholder="Nombre" value="<?php echo $productoEditar['nombre']; ?>" required><br>
                <p><?php echo 'Precio MXN:'  , '<br>'; ?>
                <input type="number" name="precio" placeholder="Precio" value="<?php echo $productoEditar['precio']; ?>" required>
                <?php echo ' <br> Cantidad en existencia: '  , '<br>'; ?>
                <input type="number" name="cantidad" placeholder="Cantidad" value="<?php echo $productoEditar['cantidad']; ?>" required><br>
                <?php echo 'Descuento <br><input type="number" name="descuento" value="' . $productoEditar['descuento'] . '" required> %'; ?>
                <br></p>
                <details>
                    <summary>Descripción</summary>
                    <input type="text" name="descripcion" placeholder="Descripcion" value="<?php echo $productoEditar['descripcion']; ?>" required><br>

                    <label for="categoria">Categoría:</label>
                    <select name="categoria" id="categoria" required>
                        <option value="men" <?php echo ($productoEditar['categoria'] == 'men') ? 'selected' : ''; ?>>Men</option>
                        <option value="woman" <?php echo ($productoEditar['categoria'] == 'woman') ? 'selected' : ''; ?>>Women</option>
                    </select><br>
                    <label for="subcategoria">Subcategoria</label>
                    <input type="text" name="subcategoria" value="<?php echo $productoEditar['subcategoria']; ?>" required>
                </details>
                <button type="submit">Guardar Cambios</button><br>
            </div>
        </form>
</div>  

        <script>
            function mostrarVistaPrevia(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        document.getElementById('imagenPrevia').src = e.target.result;
                    };
                    reader.readAsDataURL(input.files[0]);
                }
            }
        </script>
    </div>
</body>

</html>
