<?php session_start(); ?>
<header>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
    <link rel="stylesheet" href="css/styt.css">
    <link rel="stylesheet" href="css/altas.css">
    <style>

        /* Estilos generales del formulario */
        .contenedor-altas {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .id{
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .contenedor-altas2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            background-color: #f4f4f4;
            padding: 20px;
            border-radius: 10px;
            width: 100%;
        }

        .contenedor-altas2 img {
            grid-column: span 2;
            max-width: 100%;
            height: auto;
            border-radius: 10px;
        }

        .contenedor-altas2 input, .contenedor-altas2 select {
            width: 95%;
            padding: 8px;
            margin-top: 5px;
            margin-bottom: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .contenedor-altas2 button {
            grid-column: span 2;
            padding: 10px;
            background-color: #8AB4F8;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }

        .contenedor-tallas {
            grid-column: span 2;
            display: grid;
            grid-template-columns: repeat(6, 1fr);
            gap: 10px;
        }

        .contenedor-tallas input {
            width: 80%;
        }

        .contenedor-altas2 details {
            grid-column: span 2;
        }

        .form-group-inline {
            display: flex;
            justify-content: space-between;
            gap: 15px;
        }

        .form-group-inline input {
            width: 48%;
        }

        .contenedor-imagenes {
            grid-column: span 2;
            display: grid;
            grid-template-columns: 1fr;
            gap: 20px;
        }

        .contenedor-imagenes2 img {
            width: 180px;
            height: 180px;
            object-fit: cover;
        }

        .contenedor-imagenes2 {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: row;
            gap: 20px;
        }

        .contenedor-imagenes2 div {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }
    </style>
</header>

<?php
require 'header.php';
$servername = "localhost";
$username = "root";
$password = "";
$database = "sirenegaze";
$tabla = "producto";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

if (isset($_GET['id'])) {
    $idProductoEditar = $_GET['id'];
    $consultaEditar = $conn->prepare("SELECT * FROM $tabla WHERE IdProducto = ?");
    $consultaEditar->bind_param("i", $idProductoEditar);
    $consultaEditar->execute();
    $resultadoEditar = $consultaEditar->get_result();

    if ($resultadoEditar->num_rows > 0) {
        $productoEditar = $resultadoEditar->fetch_assoc();
    } else {
        echo "Producto no encontrado.";
        exit();
    }

    $consultaEditar->close();
}
?>

<div class="contenedor-altas">
<form id="formularioModificar" method="post" enctype="multipart/form-data" action="cambiosguardar.php">
    <div class="id">
       <label for="IdProducto">ID: <?php echo $productoEditar['IdProducto']; ?> 
       <input type="hidden" name="IdProducto" value="<?php echo $productoEditar['IdProducto']; ?>">
       </label>
    </div>

    <div class="contenedor-altas2">
        <!-- Vista previa de las imágenes -->
        <div class="contenedor-imagenes">
            <div class="contenedor-imagenes2">
                <div>
                    <img id="imagenPrevia1" src="imagenes/<?php echo $productoEditar['Imagen']; ?>" alt="">
                    <input type="file" name="Imagen1" accept="image/jpeg, image/png" onchange="mostrarVistaPrevia(this, 1)">
                </div>
                <div>
                    <img id="imagenPrevia2" src="imagenes/<?php echo $productoEditar['Imagen2']; ?>" alt="">
                    <input type="file" name="Imagen2" accept="image/jpeg, image/png" onchange="mostrarVistaPrevia(this, 2)">
                </div>
                <div>
                    <img id="imagenPrevia3" src="imagenes/<?php echo $productoEditar['Imagen3']; ?>" alt="">
                    <input type="file" name="Imagen3" accept="image/jpeg, image/png" onchange="mostrarVistaPrevia(this, 3)">
                </div>
            </div>
        </div>

        <!-- Nombre y precio -->
        <div class="form-group-inline">
            <input type="text" name="Nombre" placeholder="Nombre de la prenda" value="<?php echo $productoEditar['Nombre']; ?>" required>
            <input type="number" name="Precio" placeholder="Precio (MXN)" value="<?php echo $productoEditar['Precio']; ?>" required>
        </div>

        <!-- Categoría y marca -->
        <div class="form-group-inline">
            <select name="Categoria" required>
                <option value="men" <?php echo ($productoEditar['Categoria'] == 'men') ? 'selected' : ''; ?>>Men</option>
                <option value="women" <?php echo ($productoEditar['Categoria'] == 'women') ? 'selected' : ''; ?>>Women</option>
            </select>
            <input type="text" name="Marca" placeholder="Marca" value="<?php echo $productoEditar['Marca']; ?>" required>
        </div>

        <!-- Exclusivo y descuento -->
        <div class="form-group-inline">
            <select name="Exclusivo" required>
                <option value="R" <?php echo ($productoEditar['Exclusivo'] == 'R') ? 'selected' : ''; ?>>R</option>
                <option value="E" <?php echo ($productoEditar['Exclusivo'] == 'E') ? 'selected' : ''; ?>>E</option>
            </select>
            <label for="">Descuento
                <input type="number" name="Descuento" placeholder="Descuento (%)" value="<?php echo $productoEditar['Descuento']; ?>" required>
            </label>
        </div>

        <!-- Descripción y subcategoría -->
        <details>
            <summary>Descripción</summary>
            <input type="text" name="Descripcion" placeholder="Descripción" value="<?php echo $productoEditar['Descripcion']; ?>" required>
            <input type="text" name="Subcategoria" placeholder="Subcategoría" value="<?php echo $productoEditar['Subcategoria']; ?>" required>
        </details>

        <!-- Cantidades por talla -->
        <div class="contenedor-tallas">
            <div>
                <label for="XCH">XCH</label>
                <input type="number" id="XCH" name="XCH" placeholder="0" value="<?php echo $productoEditar['XCH']; ?>" min="0" required>
            </div>
            <div>
                <label for="CH">CH</label>
                <input type="number" id="CH" name="CH" placeholder="0" value="<?php echo $productoEditar['CH']; ?>" min="0" required>
            </div>
            <div>
                <label for="M">M</label>
                <input type="number" id="M" name="M" placeholder="0" value="<?php echo $productoEditar['M']; ?>" min="0" required>
            </div>
            <div>
                <label for="L">L</label>
                <input type="number" id="L" name="L" placeholder="0" value="<?php echo $productoEditar['L']; ?>" min="0" required>
            </div>
            <div>
                <label for="XL">XL</label>
                <input type="number" id="XL" name="XL" placeholder="0" value="<?php echo $productoEditar['XL']; ?>" min="0" required>
            </div>
            <div>
                <label for="XXL">XXL</label>
                <input type="number" id="XXL" name="XXL" placeholder="0" value="<?php echo $productoEditar['XXL']; ?>" min="0" required>
            </div>
        </div>

        <!-- Botón de modificar -->
        <button class="btn btn-success" type="submit">Guardar Cambios</button>
    </div>
</form>


    <div id="mensajeModificar"></div>

    <script>
        function mostrarVistaPrevia(input, imgNum) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    document.getElementById('imagenPrevia' + imgNum).src = e.target.result;
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</div>

<?php include 'footer.php'; ?>
