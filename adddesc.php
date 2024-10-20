<?php session_start(); ?>
<?php include 'header.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Descuento</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        /* Centrar el formulario en la página */
        .contenedor-descuentos {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f5f5f5;
        }

        /* Diseño de tabla para el formulario */
        .tabla-descuentos {
            width: 100%;
            max-width: 500px;
            border-collapse: collapse;
            background-color: white;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            border-radius: 10px;
        }

        /* Estilo de las celdas de la tabla */
        .tabla-descuentos td {
            padding: 10px;
            vertical-align: middle;
        }

        /* Mejorar el diseño de los inputs y selects */
        input[type="text"], input[type="number"], input[type="date"], select {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            border-radius: 5px;
            border: 1px solid #ddd;
            transition: border-color 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
        }

        /* Agregar un efecto al enfocar inputs */
        input[type="text"]:focus, input[type="number"]:focus, input[type="date"]:focus, select:focus {
            border-color: #66afe9;
            box-shadow: 0 0 8px rgba(102, 175, 233, 0.6);
        }

        /* Estilo del botón con animación */
        button.btn {
            background-color: #28a745;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease-in-out, transform 0.2s ease;
        }

        /* Animación al pasar sobre el botón */
        button.btn:hover {
            background-color: #218838;
            transform: scale(1.05);
        }

        /* Animación al hacer clic */
        button.btn:active {
            background-color: #1e7e34;
            transform: scale(1);
        }

        h3 {
            text-align: center;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<div class="contenedor-descuentos">
    <form id="formularioDescuento" method="post" enctype="multipart/form-data" action="agregarDescuento.php">
        <div class="contenedor-descuentos2">
            <h3>Agregar Descuento</h3>
            <table class="tabla-descuentos">
                <tr>
                    <td><strong>Nombre del descuento</strong></td>
                    <td><input type="text" name="nombre_descuento" placeholder="Nombre del Descuento" required></td>
                </tr>
                <tr>
                    <td><strong>Categoría</strong></td>
                    <td>
                        <select name="categoria" required>
                            <option value="men">Men</option>
                            <option value="women">Women</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td><strong>Tipo de Descuento</strong></td>
                    <td>
                        <select name="tipo_descuento" required>
                            <option value="porcentaje">Porcentaje</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td><strong>Valor del Descuento</strong></td>
                    <td><input type="number" name="valor_descuento" placeholder="Descuento" required></td>
                </tr>
                <tr>
                    <td><strong>Fecha de Expiración</strong></td>
                    <td><input type="date" name="fecha_expiracion" required></td>
                </tr>
                <tr>
                    <td colspan="2" style="text-align: center;">
                        <button class="btn btn-success" type="submit">Agregar Descuento</button>
                    </td>
                </tr>
            </table>
        </div>
    </form>
</div>

<?php include 'footer.php'; ?>
</body>
</html>
