<?php
session_start();
?>

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
$tabla = "descuentos"; 

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}


if (isset($_GET['id'])) {
    $idDescuentoEditar = $_GET['id'];

    $consultaEditar = $conn->prepare("SELECT * FROM $tabla WHERE IdDescuentos = ?");
    $consultaEditar->bind_param("i", $idDescuentoEditar);
    $consultaEditar->execute();
    $resultadoEditar = $consultaEditar->get_result();

    if ($resultadoEditar->num_rows > 0) {
        $descuentoEditar = $resultadoEditar->fetch_assoc();
    } else {
        echo "Descuento no encontrado.";
    }

    $consultaEditar->close();
}
?>

<!DOCTYPE html>
<html lang="es">

<body>
<div class="contenedor-altas">
    <div class="tienda ">
        <form method="post" enctype="multipart/form-data" action="cambioDescuento.php">
            <div class="contenedor-altas2">
                <h5 style="font-weight: bold;">Editar Descuento <?php echo $idDescuentoEditar ?></h5>
                <input type="hidden" name="Id_descuento" value="<?php echo $descuentoEditar['IdDescuentos']; ?>">
                <h5 style="font-weight: bold;">Nombre del Descuento</h5>
                <input type="text" name="nombre" placeholder="Nombre" value="<?php echo $descuentoEditar['Nombre']; ?>" required><br>
                
                <label for="categoria">Categoría:</label>
                <select name="categoria" id="categoria" required>
                    <option value="men" <?php echo ($descuentoEditar['Categoria'] == 'men') ? 'selected' : ''; ?>>Men</option>
                    <option value="woman" <?php echo ($descuentoEditar['Categoria'] == 'woman') ? 'selected' : ''; ?>>Woman</option>
                </select><br>

                <label for="tipo">Tipo:</label>
                <input type="text" name="tipo" placeholder="Tipo de descuento" value="<?php echo $descuentoEditar['Tipo']; ?>" required><br>

                <label for="descuento">Descuento (%):</label>
                <input type="number" name="descuento" placeholder="Descuento" value="<?php echo $descuentoEditar['Descuento']; ?>" required><br>

                <label for="fechaExpiracion">Fecha de Expiración:</label>
                <input type="date" name="fechaExpiracion" value="<?php echo $descuentoEditar['FechaExpiracion']; ?>" required><br>

                <button type="submit">Guardar Cambios</button><br>
                
            
            </div>
        </form>
    </div>
</div>


</body>

</html>
<?php include 'footer.php'; ?>

