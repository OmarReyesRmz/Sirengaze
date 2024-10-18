<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles del Producto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
    <link rel="stylesheet" href="css/detalles-producto.css">
</head>
<body>

<?php
require 'header.php';

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sirenegaze";
$tabla = "producto";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Obtener el ID del producto de la URL
$idProducto = isset($_GET['id']) ? $_GET['id'] : 0;

// Obtener los datos del producto seleccionado
$productQuery = "SELECT * FROM $tabla WHERE IdProducto = $idProducto";
$productResult = $conn->query($productQuery);

// Verificar si se obtuvo un resultado
if ($productResult && $productResult->num_rows > 0) {
    $product = $productResult->fetch_assoc();
?>

    <div id="contenedor-detalles">
        <div class="imagenes-producto">
            <img src="<?php echo 'imagenes/' . $product['Imagen']; ?>" alt="<?php echo $product['Nombre']; ?>">
            <div class="imagenes-secundarias">
                <img src="<?php echo 'imagenes/' . $product['Imagen2']; ?>" alt="<?php echo $product['Nombre']; ?>">
                <img src="<?php echo 'imagenes/' . $product['Imagen3']; ?>" alt="<?php echo $product['Nombre']; ?>">
            </div>
        </div>

        <div class="detalles">
            <p class="tit"><?php echo strtoupper($product['Nombre']); ?></p>
            <p class="precio">MXN &nbsp<?php echo $product['Precio']; ?></p>
            <p class="desc">- <?php echo $product['Descuento']; ?>%</p>

            <br><br>
            <p class="texto">SELECCIONA LA TALLA</p>
            <p class="texto">Existencias <?php echo $product['Existencias']; ?></p>
     
            <p class="texto">Talla seleccionada: <span id="tallaSeleccionada">Ninguna</span></p>

            <div class="tallas">
                <?php if ($product['XCH'] > 0) { ?>
                    <button type="button" class="btn-talla" onclick="seleccionarTalla('XCH')">XCH <?php echo $product['XCH']; ?></button>
                <?php } else { ?>
                    <button class="btn-talla x" disabled>XCH <?php echo $product['XCH']; ?></button>
                <?php } ?>

                <?php if ($product['CH'] > 0) { ?>
                    <button type="button" class="btn-talla" onclick="seleccionarTalla('CH')">CH <?php echo $product['CH']; ?></button>
                <?php } else { ?>
                    <button class="btn-talla x" disabled>CH <?php echo $product['CH']; ?></button>
                <?php } ?>

                <?php if ($product['M'] > 0) { ?>
                    <button type="button" class="btn-talla" onclick="seleccionarTalla('M')">M <?php echo $product['M']; ?></button>
                <?php } else { ?>
                    <button class="btn-talla x" disabled>M <?php echo $product['M']; ?></button>
                <?php } ?>

                <?php if ($product['L'] > 0) { ?>
                    <button type="button" class="btn-talla" onclick="seleccionarTalla('L')">L <?php echo $product['L']; ?></button>
                <?php } else { ?>
                    <button class="btn-talla x" disabled>L <?php echo $product['L']; ?></button>
                <?php } ?>

                <?php if ($product['XL'] > 0) { ?>
                    <button type="button" class="btn-talla" onclick="seleccionarTalla('XL')">XL <?php echo $product['XL']; ?></button>
                <?php } else { ?>
                    <button class="btn-talla x" disabled>XL <?php echo $product['XL']; ?></button>
                <?php } ?>

                <?php if ($product['XXL'] > 0) { ?>
                    <button type="button" class="btn-talla" onclick="seleccionarTalla('XXL')">XXL <?php echo $product['XXL']; ?></button>
                <?php } else { ?>
                    <button class="btn-talla x" disabled>XXL <?php echo $product['XXL']; ?></button>
                <?php } ?>
            </div>

            <br><br>

            <div class="comprar">
                <!-- Botón para agregar al carrito -->
                <?php if (isset($_SESSION["cuenta"])) { ?>
                    <button class="btn-agregar" onclick="agregarAlCarrito(<?php echo $idProducto; ?>)">AGREGAR</button>
                <?php } else { ?>
                    <button class="btn-agregar" onclick="mensaje()">A G R E G A R</button>
                <?php } ?>
            </div>
            
            <br>
            <p class="d-inline-flex gap-1 descripcion texto">
                <a data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">Descripción</a>
                <a data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                    <i style="margin-left:250px;" class="fa-solid fa-plus" style="color: #000000;"></i>
                </a>
            </p>
            <div class="collapse" id="collapseExample">
                <div class="texto" style="font-size: 15px;">
                    <?php echo $product['Descripcion']; ?>
                </div>
            </div>
        </div>
    </div>        

<?php
} else {
    echo "<p>No se encontró el producto.</p>";
}

$conn->close();
?>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script>
    let tallaSeleccionada = "";

    function seleccionarTalla(talla) {
        tallaSeleccionada = talla;
        document.getElementById('tallaSeleccionada').innerText = talla;
    }

    function agregarAlCarrito(productoId) {
        if (tallaSeleccionada === "") {
            mensajeTalla();
            return;
        }
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "agregarcarrito.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                var respuesta = JSON.parse(xhr.responseText);
                if (respuesta.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Agregado al carrito',
                        text: 'El producto se a agregado al carrito.',
                        // confirmButtonText: 'OK'
                    });
                    window.location.reload();

                } else {
                    Swal.fire({
                        icon: 'info',
                        title: 'Sin existencias',
                        text: 'Ya no hay más productos en existencias.',
                        confirmButtonText: 'OK'
                    });
                }
            }
        };
        xhr.send("producto_id=" + productoId + "&talla=" + tallaSeleccionada);
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

    function mensajeTalla(){
        Swal.fire({
            title: "Aún no seleccionas una talla",
            text: "Selecciona una talla y vuelve a intentarlo",
            icon: "error"
        });
    }
</script>

<?php include 'footer.php'; ?>
</body>
</html>
