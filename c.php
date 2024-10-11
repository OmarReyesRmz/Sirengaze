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
$tabla = "inventario";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

$dataQuery = "SELECT * FROM $tabla";
$dataResult = $conn->query($dataQuery);
if ($dataResult) {
    $dataResult->data_seek(0);
    ?>
    <div class="tienda contenedor-tienda" >
        <?php
        while ($row = $dataResult->fetch_assoc()) {
        // Asignar valores a variables
        $id = $row['Id_producto'];
        $nombre = $row['nombre'];
        $descripcion = $row['descripcion'];
        $cantidad = $row['cantidad'];
        $precio = $row['precio'];
        $imagen = $row['imagen'];
        $descuento = $row['descuento'];
        $categoria = $row['categoria'];
        $subcategoria = $row['subcategoria'];

        ?>
        
        <div class="contenedor">
            <div class="con">
                <img src="<?php echo 'imagenes/' . $imagen ?>" alt="" >
            </div>
            <h5 style="font-weight: bold;"><?php echo 'ID: ' . $id ?></h5>
            <h5 style="font-weight: bold;"><?php echo $nombre ?></h5>
            <p>
            <?php
            if($descuento != 0){
                $descuento_decimal = $descuento / 100;
                echo '<span class="oferta">MXN ' . $precio . '</span><br>';
                echo '<span class="precio">MXN ' . $precio - ($precio * $descuento_decimal) . '</span><br>';
            }else{
                echo '<span class="precio">MXN ' . $precio . '</span><br>';
            }
            if($cantidad == 0){
                echo 'Agotado<br>';
            }else{
                echo 'Cantidad en existencia: ' . (isset($_SESSION['carrito'][$id]['cantidad']) ? $cantidad - (isset($_SESSION['carrito'][$id]['cantidad']) ? $_SESSION['carrito'][$id]['cantidad']: 0) : $cantidad) . '<br>';
            }
            
            if($descuento == 0){
                echo 'Sin descuento';
            }else{
                echo 'Descuento del ' . $descuento . '%';
            }
            ?></p>
            <details>
                <summary>Descripción</summary>
                <p><?php echo $descripcion ?></p>
            </details>
            <button class="editar-button" onclick="editarProducto(<?php echo $id; ?>)">Editar Producto <?php echo $id ?></button>
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
    function editarProducto(idProducto) {
        window.location.href = 'cambiostienda.php?id=' + idProducto;
    }
</script>

<?php include 'footer.php'; ?>