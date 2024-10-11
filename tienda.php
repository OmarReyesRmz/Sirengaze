<?php session_start();?>

<header>
    <title>Tienda Online</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="css/styt.css">
    <link rel="stylesheet" href="css/tienda.css">
    <!-- <link rel="icon" sizes="180x180" href="imagenes/logoic.ico"> -->
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        #precio_range {
            width: 100%;
            margin: 15px;
        }

        #resultados {
            border: none;
        }

        .porprecio{
            display: flex;
            justify-content: space-around;
        }
        
    </style>
</header>

<body>
<?php
require 'header.php';
?>
    <button style="margin-top:80px; margin-left:80px;" class="btn" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">
        <i class="fa-solid fa-sliders" style="color: #000000; font-size:25px; margin-bottom:30px;"></i>
    </button>

    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasRightLabel">Filtrar</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <label for="precio_range">Precio:</label><br>
            <div class="porprecio">
                <p><span id="precio_min_display">0</span></p>
                <input type="range" id="precio_range" name="precio_range" min="0" max="2000" step="10" value="0">
                <p><span id="precio_max_display">2000</span></p>
            </div>
            <!-- <div id="resultados" class="tienda contenedor-tienda"></div> -->
        </div>
    </div>

    <div id="productos" class="tienda contenedor-tienda">

<?php

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
            <?php if(isset($_SESSION["cuenta"])){ ?>
                <button class="buy" onclick="agregarAlCarrito(<?php echo $id; ?>)"><i class="fa-solid fa-plus" style="color: #080808;"></i></button>
            <?php }else{ ?>
                <button class="buy" onclick="mensaje()"><i class="fa-solid fa-plus" style="color: #080808;"></i></button>
            <?php }?>
        </div>
    <?php
    }
} else {
    echo "Error al obtener datos de la tabla: " . $conn->error;  
}
?>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
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


<script>
        var precioMinDisplay = document.getElementById('precio_min_display');
        var precioRange = document.getElementById('precio_range');
        var precioMaxDisplay = document.getElementById('precio_max_display');
        var productosContainer = document.getElementById('productos');

        // Agrega el evento input al rango de precios
        precioRange.addEventListener('input', function() {
            // Actualiza el valor mínimo en tiempo real
            precioMinDisplay.textContent = this.value;
            // Actualiza el valor máximo fijo
            precioMaxDisplay.textContent = "2000";
        });

        // Agrega el evento change al rango de precios
        precioRange.addEventListener('change', function() {
            // Realiza la solicitud AJAX a filtro.php
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'filtro.php', true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    // Actualiza solo el valor 0 y muestra los productos en la página principal
                    precioMinDisplay.textContent = precioRange.value;
                    productosContainer.innerHTML = xhr.responseText;
                }
            };
            xhr.send('precio_min=' + this.value + '&precio_max=2000');
        });
</script>




<?php
include 'footer.php';
?>

</body>
</html>
