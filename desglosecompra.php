    <?php
    session_start();

    if (isset($_SESSION['carrito']) && count($_SESSION['carrito']) > 0) {
        $subtotal = $_SESSION['subtotal'];
        $_SESSION['total'] = $subtotal;
        $carrito = $_SESSION['carrito'];

        $descuentototal = $_SESSION['descuentototal'];
        $servername = "localhost";
        $username = "root";
        $password = "";
        $database = "sirenegaze";
        $tabla = "producto";
        $descuento = 0;
        $totalCarrito = 0;
        $totalcupon = 0;
        $impuestos = 0;
        $gastosEnvio = 0;
        $temp2 = 0;

        $conn = new mysqli($servername, $username, $password, $database);
        
        if ($conn->connect_error) {
            die("Error de conexión: " . $conn->connect_error);
        }


        if (isset($_SESSION['cuenta'])) {
            $cuenta = $_SESSION['cuenta'];
            
            // Consulta para obtener el IdCliente usando la cuenta
            $sql = "SELECT IdCliente FROM cliente WHERE Cuenta = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $cuenta);
            $stmt->execute();
            $result = $stmt->get_result();
        
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $user_id = $row['IdCliente'];
                
                // Verificar si el usuario tiene membresía
                $sql_membresia = "SELECT * FROM membresia WHERE IdCliente = ?";
                $stmt_membresia = $conn->prepare($sql_membresia);
                $stmt_membresia->bind_param("i", $user_id);
                $stmt_membresia->execute();
                $result_membresia = $stmt_membresia->get_result();
                $is_member = $result_membresia->num_rows > 0;
        
                // Obtener descuentos aplicables al usuario
                // Inicializar el array de cupones válidos con los descuentos generales
                $cuponesValidos = [];

                // Descuentos generales para 'all', 'men' y 'women'
                $sql_descuentos_generales = "SELECT Nombre, Descuento FROM descuentos WHERE Tipo = 'all';";
                $result_descuentos_generales = $conn->query($sql_descuentos_generales);

                // Guardar los descuentos generales
                while ($row_descuento = $result_descuentos_generales->fetch_assoc()) {
                    $cuponesValidos[$row_descuento['Nombre']] = $row_descuento['Descuento'];
                }

                // Si el usuario es miembro, obtener los descuentos específicos para miembros
                if ($is_member) {
                    // Descuentos específicos para miembros
                    $sql_descuentos_membresia = "SELECT d.Nombre, d.Descuento, d.Tipo FROM descuentos d 
                                                INNER JOIN tipomembresia_descuento tm ON d.IdDescuentos = tm.IdDescuento 
                                                INNER JOIN tipomembresia m ON tm.IdTipo = m.IdTipo 
                                                INNER JOIN membresia mem ON mem.IdTipo = m.IdTipo 
                                                WHERE mem.IdCliente = ?;";
                    $stmt_descuentos = $conn->prepare($sql_descuentos_membresia);
                    $stmt_descuentos->bind_param("i", $user_id);
                    $stmt_descuentos->execute();
                    $result_descuentos = $stmt_descuentos->get_result();

                    // Agregar los descuentos específicos del miembro al array de cupones válidos
                    while ($row_descuento = $result_descuentos->fetch_assoc()) {
                        // Solo agregar si no existe ya el descuento (en caso de que sea el mismo código)
                        $cuponesValidos[$row_descuento['Nombre']] = $row_descuento['Descuento'];
                    }
                }

                // Convertir cupones válidos a formato JSON para usar en JavaScript
                $cuponesValidosJson = json_encode($cuponesValidos);

            } else {
                echo "No se encontró un usuario con esa cuenta.";
            }
        } else {
            echo "No hay cuenta en sesión.";
        }

        if ($_SESSION['subtotal'] < 1500) {
            $gastosEnvio = 200;
        } else {
            $gastosEnvio = 0; 
        }
        $_SESSION["gastosEnvio"] = $gastosEnvio;

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $_SESSION['total'] = $_SESSION['total'] + $_SESSION["gastosEnvio"] + $_SESSION['impuestos'] - $_SESSION['descuento'];
            header("Location: direccionenvio.php");
            exit; 
        }
    }
    ?>

    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8sh+WyZqBAYB1B/BKQxIepqXarGBjDAJ7f6dU6" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <link rel="stylesheet" href="css/styt.css">
        <link rel="stylesheet" href="css/altas.css">
        <link rel="stylesheet" href="css/carrito.css">
        <title>Procesar Pago</title>
    </head>
        <style>
            body {
                background-color: white;
                padding-top: 90px;
                font-family: 'Cormorant_Infant', sans-serif;
                font-size:20px;
            }
            .accordion-button {
            color: #000 !important; /* Set text color to black */
            background-color: #fff !important; /* Set background color to white */
            border-color: #000 !important; /* Set border color to black */
            font-size:18px;    
            }

            td, th{
                font-size:18px; 
            }
            
        </style>
    <body style="font-family: 'Cormorant_Infant', sans-serif; font-size:18px;">
    <?php include 'header.php'; ?>

    <div class="container mt-5">
        <div class="row justify-content-center"> 
            <div class="col-md-6">
                <h3> <a href="desglosecompra.php">Resumen <i class="fa-solid fa-chevron-right" style="color: #000000; font-size:18px;"></i></a></h3>
                <h4>Detalle de Pago</h4>
                
                
                <div class="form-group">
                <div class="accordion accordion-flush" id="accordionFlushExample1">
                <div class="accordion-item">
                <h2 class="accordion-header" id="flush-headingOne">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                        Ver resumen
                    </button>
                </h2>
                    <?php 
                    foreach ($carrito as $productoId => $tallasProducto) {
                        foreach ($tallasProducto as $talla => $detallesProducto) {
                        echo '<div class="form-group">';
                        if($detallesProducto['cantidad'] != 0){
                            $query = "SELECT * FROM $tabla WHERE IdProducto = $productoId";
                            $result = $conn->query($query);

                            if ($result->num_rows > 0) {
                                $row = $result->fetch_assoc();
                                ?>
                                <div id="flush-collapseOne" class="accordion-collapse collapse show" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample1">
                                <div class="accordion-body">
                                <?php
                                echo '<table class="table table-borderless">';
                                echo '<tr>';
                                echo '<td rowspan=5><img class="img_detalles" src="imagenes/' . $row['Imagen'] . '" alt="imagen no cargada" width="130" height="180"></td>';
                                echo '</tr>';
                                echo '<tr>';
                                echo '<td>' . $row['Nombre'] . '</td>';
                                echo '<td>'.$talla.' </td>';
                                echo '<td> </td>';
                                echo '</tr>';
                                echo '<tr>';
                                if ($row['Descuento'] != 0) {
                                $precio_final = ($row['Precio'] - $row['Precio'] * $row['Descuento'] / 100);
                                } else {
                                $precio_final = $row['Precio'];
                                }
                                echo '<td> $' . $precio_final . '</td>';
                                echo '<td></td>';
                                echo '</tr>';
                                echo '<td> x' . $detallesProducto['cantidad']  . '</td>';
                                echo '<td> </td>';
                                echo '<td style="font-weight: 900;">$' . $precio_final * $detallesProducto['cantidad'] . '</td>';
                                echo '</tr>';
                                echo '</table>';
                                }
                            }
                        echo '</div>';
                        }
                    }
                ?>
                </div>
                </div>
                </div>
                </div>
                </div>
                </div>
                </div>
                </div>

                <div class="container mt-5">
                <div class="row justify-content-center"> 
            <div class="col-md-6">
                <form class="form-group" action="desglosecompra.php" method="POST">

                        <div class="form-group">
                        <hr>
                            <label for="pais">País:</label>
                            <select class="form-select" aria-label="Default select example" id="pais" name="pais" required>
                                <option value="" disabled selected>Selecciona un país</option>
                                <option value="USA">USA</option>
                                <option value="MEX">MEX</option>
                            </select>
                        </div>

                        <div class="accordion accordion-flush" id="accordionFlushExample2">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="flush-headingTwo">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
                                        ¿Tienes un código de descuento?
                                    </button>
                                </h2>
                                <div id="flush-collapseTwo" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample2">
                                    <div class="accordion-body">
                                        <div class="form-group">
                                        <input type="text" class="form-control" id="codigo" name="codigoDescuento" placeholder="Ingresar código">
                                        <br>
                                        <button type="button" id="aplicarDescuento" class="btn btn-dark">Aplicar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        
                        <hr>

                        <div class="form-group">
                            <p>Subtotal: $<?php echo $subtotal;?></p>
                        </div>
                        <div class="form-group">
                            <hr>
                            <div id="descuentoAplicadoContainer">Descuentos aplicados: $0</div>
                            <!-- <hr> -->
                        </div>

                        <div class="form-group">
                            <div id="impuestosContainer">Impuestos aplicados: $0</div>
                            <!-- <hr> -->
                        </div>

                        <div class="form-group">
                            <p>Gastos de envío: $<?php echo $gastosEnvio; ?></p>
                        </div>

                        <hr>
                        <div class="form-group">
                            <h3><div id="totalapagar">T O T A L : $<?php echo $_SESSION["total"] + $_SESSION["gastosEnvio"];?></div></h3>
                        </div>
                        
                        <!-- Alineado a la izquierda
                            <div class="form-group">
                            <button type="submit" name="checar" class="btn btn-dark">Siguiente</button>
                        </div> -->
                        <!-- Alineado a la derecha -->
                        <div class="form-group d-flex justify-content-end">
                            <button type="submit" name="checar" class="btn btn-dark">Siguiente</button>
                        </div>

                    </form>   

                </div>        
            </div>
        </div>
    </div></div></div>
                </div>
    <?php include 'footer.php'; ?>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        var selectPais = document.getElementById('pais');
        var inputCodigo = document.getElementById('codigo');
        var btnAplicarDescuento = document.getElementById('aplicarDescuento');

        // Event listener para el cambio en el país
        selectPais.addEventListener('change', function () {
            var paisSeleccionado = selectPais.value;
            calcularImpuestos(paisSeleccionado);
        });

        // Esta función actualiza el contenido de totalapagar haciendo una solicitud AJAX al servidor
        function actualizarTotal() {
            $.ajax({
                type: 'GET',
                url: 'total.php',  // Reemplaza esto con la ruta correcta
                success: function (response) {
                    // Actualiza el contenido de totalapagar con la respuesta del servidor
                    $('#totalapagar').html(response);
                }
            });
        }

        // Función para calcular impuestos
        function calcularImpuestos(pais) {
            var impuestosContainer = document.getElementById('impuestosContainer');
            var totalapagar = document.getElementById('totalapagar');

            if (pais === 'USA') {
                var impuestos = <?php echo $_SESSION['subtotal'] * 0.0625; ?>;
                impuestosContainer.textContent = 'Impuestos aplicados (6.25% USA): $' + impuestos.toFixed(2);
            } else if (pais === 'MEX') {
                var impuestos = <?php echo $_SESSION['subtotal'] * 0.16; ?>;
                impuestosContainer.textContent = 'Impuestos aplicados  (16% Mex): $' + impuestos.toFixed(2);
            } else {
                impuestosContainer.textContent = 'Impuestos aplicados: $0';
            }

            $.ajax({
                type: 'POST',
                url: 'impuestos.php', 
                data: { impuestos: impuestos.toFixed(2), pais: pais },
                success: function (response) {
                    console.log(response); 
                }
            });
            
            actualizarTotal();
        }

        var cuponesValidos = <?php echo $cuponesValidosJson; ?>;

        btnAplicarDescuento.addEventListener('click', function () {
            var codigo = inputCodigo.value;
            aplicarDescuento(codigo);
        });

        function aplicarDescuento(codigo) {
            var descuentoAplicadoContainer = document.getElementById('descuentoAplicadoContainer');

            if (cuponesValidos.hasOwnProperty(codigo)) {
                var descuento = cuponesValidos[codigo];
                var totalCarrito = <?php echo $subtotal; ?>;
                var descuentoAplicado = totalCarrito * descuento / 100;
                descuentoAplicadoContainer.textContent = 'Descuento aplicado: $' + descuentoAplicado.toFixed(2);
                
            } else {
                descuentoAplicadoContainer.textContent = 'Código de descuento no válido';
                descuentoAplicado = 0;

            }

            $.ajax({
                type: 'POST',
                url: 'descuento.php', 
                data: { descuentoAplicado: descuentoAplicado.toFixed(2) },
                success: function (response) {
                    console.log(response); 
                }
            });


            actualizarTotal();
        }
    });
</script>
</body>
</html>