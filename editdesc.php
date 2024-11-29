<?php
session_start();
?>

<header>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
    <link rel="stylesheet" href="css/styt.css">
    <link rel="stylesheet" href="css/tienda.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .btn2{
            margin-top: 10px;
            height: 50px;
            background-color: #8AB4F8;
            font-weight: 1000;
        }
    </style>
</header>

<?php
require('header.php');
$servername = "localhost";
$username = "root";
$password = "";
$database = "sirenegaze";
$tabla = "descuentos"; // Cambiar la tabla a "descuentos"

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

$dataQuery = "SELECT * FROM $tabla";
$dataResult = $conn->query($dataQuery);
if ($dataResult) {
    $dataResult->data_seek(0);
    ?>
    <div class="tienda contenedor-tienda">
        <?php
        while ($row = $dataResult->fetch_assoc()) {
        // Asignar valores a variables
        $id = $row['IdDescuentos'];
        $nombre = $row['Nombre'];
        $categoria = $row['Categoria'];
        $fechaExpiracion = $row['FechaExpiracion'];
        $tipo = $row['Tipo'];
        $descuento = $row['Descuento'];
        $cantidad = $row['Cantidad'];

        ?>
        
        <div class="contenedor">
            <h5 style="font-weight: bold;"><?php echo 'ID: ' . $id ?></h5>
            <h5 style="font-weight: bold;"><?php echo $nombre ?></h5>
            <p>
            <?php
            echo 'Categoría: ' . $categoria . '<br>';
            echo 'Tipo: ' . $tipo . '<br>';
            echo 'Fecha de Expiración: ' . $fechaExpiracion . '<br>';
            echo 'Descuento: ' . $descuento . '%<br>';
            echo 'Cantidad: ' . $cantidad . '<br>';
            ?>
            </p>
            <button class="editar-button" onclick="editarDescuento(<?php echo $id; ?>)">Editar Descuento <?php echo $id ?></button>
            </div>
        <?php
        }
        ?>
    </div>
<?php
} else {
    echo "Error al obtener datos de la tabla: " . $conn->error;
}

$conn->close();
?>

<script>
    function editarDescuento(idDescuento) {
        window.location.href = 'editarDescuento.php?id=' + idDescuento;
    }
</script>

<?php include 'footer.php'; ?>
