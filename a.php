<?php session_start(); ?>
<header>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
    <link rel="stylesheet" href="css/styt.css">
    <link rel="stylesheet" href="css/altas.css">
</header>

<?php
    require 'header.php';
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "sirenegaze";
    $tabla = "inventario";

    $conn = new mysqli($servername, $username, $password, $database);

    if ($conn->connect_error) {
        die("Error de conexión: " . $conn->connect_error);
    }
?>

<div class="contenedor-altas" >
    <form id="formularioAgregar" method="post" enctype="multipart/form-data" action="altastienda.php">
        <div class="contenedor-altas2">
            <img id="imagenPrevia" src="imagenes/ejemploformulario.png" alt="" class="con" >
            <input type="file" name="imagen" accept="image/jpeg, image/png" required onchange="mostrarVistaPrevia(this)"><br>
            <h5 style="font-weight: bold;"><?php echo 'Nombre de la prenda' ?>
            <input type="text" name="nombre" placeholder="Nombre" required><br>
            </h5>
            <p><?php echo 'Precio MXN:'  , '<br>'; ?>
            <input type="number" name="precio" placeholder="Precio" required>
            <?php echo '<br> Cantidad en existencia: '  , '<br>'; ?>
            <input type="number" name="cantidad" placeholder="Cantidad" required><br>
            <?php echo 'Descuento <br><input type="number" name="descuento" value="0" required> %'; ?>
            <br></p>
            <details>
                <summary>Descripción</summary>
                <input type="text" name="descripcion" placeholder="Descripcion" required><br>
                <label for="categoria">Categoría:</label>
                <select name="categoria" id="categoria" required>
                    <option value="men">Men</option>
                    <option value="woman">Women</option>
                </select><br>
                <input type="text" name="subcategoria" placeholder="Subcategoria" required >
            </details>
            <button class="btn btn-success " type="submit">Agregar Producto</button><br>
        </div>
    </form>
    <div id="mensajeAgregar"></div>

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

<?php include 'footer.php'; ?>