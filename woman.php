<?php session_start(); ?>
<header>
    <title>Women</title>
    <link rel="stylesheet" href="css/styt.css">
    <link rel="stylesheet" href="css/tienda.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
    <link rel="icon" sizes="180x180" href="imagenes/logoic.ico">
</header>
<?php
require 'header.php';

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sirenegaze";
$tabla = "inventario";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Obtener los datos de la tabla inventario
$dataQuery = "SELECT * FROM $tabla";
$dataResult = $conn->query($dataQuery);

    
if ($dataResult) {
    $dataResult->data_seek(0);
    
    ?>
    <h1 class="subtitulo1" style="margin:100px; ">W &nbsp&nbspO &nbsp&nbspM &nbsp&nbspA &nbsp&nbspN</h1>
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

        if($categoria == 'woman'){
        ?>
        <div class="contenedor">
        <div class="con">
            <img src="<?php echo 'imagenes/' . $imagen ?>" alt="" >
        </div>
        <h5 style="font-weight: bold;"><?php echo 'ID: ' . $id ?></h5>
        <h5 style="font-weight: bold;"><?php echo $nombre ?></h5>
        <p><?php
        if($descuento!=0){
            $descuento_decimal = $descuento/100;
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
        <?php if(isset($_SESSION["cuenta"])){ ?>
            <button class="buy" onclick="agregarAlCarrito(<?php echo $id; ?>)"><i class="fa-solid fa-plus" style="color: #080808;"></i></button>
        <?php }else{ ?>
            <button class="buy" onclick="mensaje()"><i class="fa-solid fa-plus" style="color: #080808;"></i></button>
        <?php }?>
        </div>
        
    <?php
        }
    }
} else {
        echo "Error al obtener datos de la tabla: " . $conn->error;  
}

?>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script>
    function agregarAlCarrito(productoId) {
        var xhr = new XMLHttpRequest();

        xhr.open("POST", "agregarcarrito.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                var respuesta = JSON.parse(xhr.responseText);

                if (respuesta.success) {
                    window.location.reload();
                }else{
                    Swal.fire({
                    icon: 'info',
                    title: 'Sin existencias',
                    text: 'Ya no hay más productos en existencias.',
                    confirmButtonText: 'OK'
                    });
                }
            }
        };

        xhr.send("producto_id=" + productoId);
    }

    function mensaje() {
        Swal.fire({
            title: '¡Inicia sesión!',
            text: 'Debes iniciar sesión para agregar productos al carrito.',
            icon: 'info',
            showCancelButton: true,
            confirmButtonText: 'Ir a iniciar sesión',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = 'login.php';
            }
        });
    }
</script>


<?php
    include 'footer.php';
?>