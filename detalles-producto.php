<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles del Producto</title>
    <link rel="stylesheet" href="css/styt.css">
    <link rel="stylesheet" href="css/detalles_producto.css">
    <link rel="stylesheet" href="css/tienda.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
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
    
    // Mostrar la información del producto
    ?>
    <div class="contenedor-producto-detalles">
        <h1 class="titulo-producto"><?php echo $product['Nombre']; ?></h1>
        <div class="imagenes-producto">
            <img src="<?php echo 'imagenes/' . $product['Imagen']; ?>" alt="<?php echo $product['Nombre']; ?>" class="imagen-principal">
            <div class="imagenes-secundarias">
                <img src="<?php echo 'imagenes/' . $product['Imagen2']; ?>" alt="<?php echo $product['Nombre']; ?>" class="imagen-secundaria">
                <img src="<?php echo 'imagenes/' . $product['Imagen3']; ?>" alt="<?php echo $product['Nombre']; ?>" class="imagen-secundaria">
            </div>
        </div>
        <div class="detalles-producto">
            <p><strong>Descripción:</strong> <?php echo $product['Descripcion']; ?></p>
            <p><strong>Precio:</strong> MXN <?php echo $product['Precio']; ?></p>
            <p><strong>Descuento:</strong> <?php echo $product['Descuento']; ?>%</p>
            <p><strong>Marca:</strong> <?php echo $product['Marca']; ?></p>
            <p><strong>Categoría:</strong> <?php echo $product['Categoria']; ?></p>
            <p><strong>Subcategoría:</strong> <?php echo $product['Subcategoria']; ?></p>
            <p><strong>Existencias:</strong> <?php echo $product['Existencias']; ?></p>
        </div>
        <div class="tallas-producto">
    <h3>Selecciona una Talla</h3>
    <div class="opciones-tallas">
        <?php if ($product['XCH'] > 0) { ?>
            <button class="btn-talla" data-talla="XCH">XCH</button>
            <?php } else { ?>
            <button class="btn-talla x" data-talla="XCH" disabled>XCH</button>
            <?php } ?>
        <?php if ($product['CH'] > 0) { ?>
            <button class="btn-talla" data-talla="CH">CH</button>
        <?php } else { ?>
            <button class="btn-talla x" data-talla="CH" disabled>CH</button>
            <?php } ?>
        <?php if ($product['M'] > 0) { ?>
            <button class="btn-talla" data-talla="M">M</button>
        <?php }else { ?>
            <button class="btn-talla x" data-talla="M" disabled>M</button>
            <?php } ?>
        <?php if ($product['L'] > 0) { ?>
            <button class="btn-talla" data-talla="L">L</button>
        <?php }else { ?>
            <button class="btn-talla x" data-talla="L" disabled>L</button>
            <?php } ?>
        <?php if ($product['XL'] > 0) { ?>
            <button class="btn-talla" data-talla="XL">XL</button>
        
        <?php } else{?>
            <button class="btn-talla x" data-talla="XL" disabled>XL</button>
            <?php } ?>
        <?php if ($product['XXL'] > 0) { ?>
            <button class="btn-talla" data-talla="XXL">XXL</button>
        <?php }else{ ?>
            <button class="btn-talla x" data-talla="XXL" disabled>XXL</button>
            <?php } ?>
    </div>
</div>

        <!-- Botón para agregar al carrito -->
        <?php if(isset($_SESSION["cuenta"])){ ?>
            <button class="btn-agregar-carrito" onclick="agregarAlCarrito(<?php echo $idProducto; ?>)"><i class="fa-solid fa-plus"></i> Agregar al carrito</button>
        <?php }else{ ?>
            <button class="btn-agregar-carrito" onclick="mensaje()"><i class="fa-solid fa-plus"></i> Agregar al carrito</button>
        <?php }?>
    </div>
    <?php
} else {
    echo "<p>No se encontró el producto.</p>";
}

$conn->close();
?>

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

<?php include 'footer.php'; ?>
</body>
</html>
