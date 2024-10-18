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
            background-color: green;
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

        .contenedor-imagenes2{
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: row;
            gap: 20px;
        }

        .contenedor-imagenes2 div{
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
    $tabla = "inventario";

    $conn = new mysqli($servername, $username, $password, $database);

    if ($conn->connect_error) {
        die("Error de conexión: " . $conn->connect_error);
    }
?>

<div class="contenedor-altas">
    <form id="formularioAgregar" method="post" enctype="multipart/form-data" action="altastienda.php">
        <div class="contenedor-altas2">
            <!-- Vista previa de las imágenes -->
            <div class="contenedor-imagenes">
                <div class="contenedor-imagenes2">

                    <div>
                        <img id="imagenPrevia1" src="imagenes/ejemploformulario.png" alt="">
                        <input type="file" name="Imagen1" accept="image/jpeg, image/png" required onchange="mostrarVistaPrevia(this, 1)">
                    </div>
                    <div>
                        <img id="imagenPrevia2" src="imagenes/ejemploformulario.png" alt="">
                        <input type="file" name="Imagen2" accept="image/jpeg, image/png" required onchange="mostrarVistaPrevia(this, 2)">
                    </div>
                    <div>
                        <img id="imagenPrevia3" src="imagenes/ejemploformulario.png" alt="">
                        <input type="file" name="Imagen3" accept="image/jpeg, image/png" required onchange="mostrarVistaPrevia(this, 3)">
                    </div>
                </div>
            </div>

            <!-- Carga de imágenes -->

            <!-- Nombre y precio -->
            <div class="form-group-inline">
                <input type="text" name="Nombre" placeholder="Nombre de la prenda" required>
                <input type="number" name="Precio" placeholder="Precio (MXN)" required>
            </div>

            <!-- Categoría y marca -->
            <div class="form-group-inline">
                <select name="Categoria" required>
                    <option value="" disabled selected>Selecciona la categoría</option>
                    <option value="men">Men</option>
                    <option value="women">Women</option>
                </select>
                <input type="text" name="Marca" placeholder="Marca" required>
            </div>

            <!-- Exclusivo y descuento -->
            <div class="form-group-inline">
                <select name="Exclusivo" required>
                    <option value="" disabled selected>Exclusivo</option>
                    <option value="R">R</option>
                    <option value="E">E</option>
                </select>
                <label for="">Descuento
                    <input type="number" name="Descuento" placeholder="Descuento (%)" value="0" required>
                </label>
            </div>

            <!-- Descripción y subcategoría -->
            <details>
                <summary>Descripción</summary>
                <input type="text" name="Descripcion" placeholder="Descripción" required>
                <input type="text" name="Subcategoria" placeholder="Subcategoría" required>
            </details>

            <!-- Cantidades por talla -->
            <div class="contenedor-tallas">
                <div>
                    <label for="XCH">XCH</label>
                    <input type="number" id="XCH" name="XCH" placeholder="0" min="0" required>
                </div>
                <div>
                    <label for="CH">CH</label>
                    <input type="number" id="CH" name="CH" placeholder="0" min="0" required>
                </div>
                <div>
                    <label for="M">M</label>
                    <input type="number" id="M" name="M" placeholder="0" min="0" required>
                </div>
                <div>
                    <label for="L">L</label>
                    <input type="number" id="L" name="L" placeholder="0" min="0" required>
                </div>
                <div>
                    <label for="XL">XL</label>
                    <input type="number" id="XL" name="XL" placeholder="0" min="0" required>
                </div>
                <div>
                    <label for="XLL">XLL</label>
                    <input type="number" id="XLL" name="XXL" placeholder="0" min="0" required>
                </div>
            </div>

            <!-- Botón de agregar -->
            <button class="btn btn-success" type="submit">Agregar Producto</button>
        </div>
    </form>

    <div id="mensajeAgregar"></div>

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
