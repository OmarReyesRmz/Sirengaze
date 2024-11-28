<?php
session_start();

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "sirenegaze";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Error de conexión: " . $conn->connect_error);
    }

    $clientes = "SELECT cliente.*, 
                IF(membresia.NoMembresia IS NOT NULL, 1, 0) AS Membresia, 
                tipomembresia.Tipo AS Tipo 
                FROM cliente 
                LEFT JOIN membresia ON cliente.IdCliente = membresia.IdCliente 
                LEFT JOIN tipomembresia ON tipomembresia.IdTipo = membresia.IdTipo ORDER BY 
                cliente.IdCliente;";

            $resultadoClientes = $conn->query($clientes);

            $mayoristas = "SELECT mayorista.*, cliente.Nombre FROM mayorista JOIN cliente ON mayorista.IdCliente = cliente.IdCliente;";
            $resultadoMayoristas = $conn->query($mayoristas);

            $prod = "SELECT IdProducto, Nombre FROM producto WHERE Exclusivo = 'T'
            UNION SELECT IdProducto, Nombre FROM producto WHERE Descuento != 0;";

            $resultadoprod = $conn->query($prod);

            $compras = "SELECT c.IdCliente, c.Nombre, COUNT(co.IdCompra) AS NumeroDeCompras FROM cliente c
            JOIN compra co ON c.IdCliente = co.IdCliente WHERE c.IdCliente IN (
            SELECT IdCliente FROM membresia INTERSECT SELECT IdCliente FROM compra) 
            GROUP BY c.IdCliente HAVING NumeroDeCompras>2;"; 

            $resultadoc = $conn->query($compras);

            
?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="css/carrito.css">
        <title>CLIENTES</title>
        <style>
    
        </style>
    </head>
    <body>
        <?php include 'header.php'; ?>
        
    <div class="carrito" style="text-align: center">

        <p class="d-inline-flex gap-1">
            <section class="regresar" style="position:absolute;">
                <br>
                <a href="./control.php">
                    <i class=" fa-solid fa-arrow-left " style="font-size: 40px"></i>
                </a>
            </section>
            <hr>
            <i class="fa-solid fa-users" style="color: black; font-size: 100px;"></i><br>
            <br>
            <h1 class="titulo">C L I E N T E S</h1>
            <hr>
        </p>


        <div class="table-responsive">

            <table class="table table-borderless table-hover prod">
                <thead>
                    <tr>
                        <th class="px-3 can">ID CLIENTE</th>
                        <th class="px-3 can">NOMBRE</th>
                        <th class="px-3 can">MEMBRESIA</th>
                        <th class="px-3 can">TIPO</th>
                        <th class="px-3 can">EDAD</th>
                        <th class="px-3 can">TELÉFONO</th>
                        <th class="px-3 can">CALLE</th>
                        <th class="px-3 can">CÓDIGO POSTAL</th>
                        <th class="px-3 can">NÚMERO</th>
                        <th class="px-3 can">COLONIA</th>
                        <th class="px-3 can">CORREO</th>
                        <th class="px-3 can">CUENTA</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($resultadoClientes->num_rows > 0) {
                        while ($row = $resultadoClientes->fetch_assoc()) {
                            echo '<tr>';
                            echo '<td class="align-middle px-4">' . $row['IdCliente'] . '</td>';
                            echo '<td class="align-middle px-4">
                                    <button class="btn btn-success" onclick="mostrarGastoPromedio(' . $row['IdCliente'] . ', \'' . $row['Nombre'] . '\')">
                                        ' . $row['Nombre'] . '
                                    </button>
                                  </td>';
                            echo '<td class="align-middle px-4">';
                            if ($row['Membresia'] == 1) {
                                echo '<i class="fa-solid fa-check" style="color: #338212;"></i>';
                            } else {
                                echo '<i class="fa-solid fa-xmark" style="color: #b42727;"></i>';
                            }
                            echo '</td>';
                        
                            if ($row['Tipo'] != "") {
                                echo '<td class="align-middle px-4">' . $row['Tipo'] . '</td>';
                            } else {
                                echo '<td class="align-middle px-4"><i class="fa-regular fa-window-minimize" style="color: #000000;"></i></td>';
                            }
                            echo '<td class="align-middle px-4">' . $row['Edad'] . '</td>';
                            echo '<td class="align-middle px-4">' . $row['Telefono'] . '</td>';
                            echo '<td class="align-middle px-4">' . $row['Calle'] . '</td>';
                            echo '<td class="align-middle px-4">' . $row['CP'] . '</td>';
                            echo '<td class="align-middle px-4">' . $row['Numero'] . '</td>';
                            echo '<td class="align-middle px-4">' . $row['Colonia'] . '</td>';
                            echo '<td class="align-middle px-4">' . $row['Correo'] . '</td>';
                            echo '<td class="align-middle px-4">' . $row['Cuenta'] . '</td>';
                            echo '</tr>';
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>

                    
        <p class="d-inline-flex gap-1">
        <br><hr>
        <h1 class="titulo" data-bs-toggle="collapse" href="#tablaMayoristas" role="button" aria-expanded="false" aria-controls="tablaMayoristas">
            M A Y O R I S T A S
        </h1>
        <hr>
        </p>

        <div class="collapse" id="tablaMayoristas">
        <div class="">
            <div class="table-responsive">
                <table class="table table-borderless table-hover prod">
                    <thead>
                        <tr>
                            <th class="px-3 can">ID FISCAL</th>
                            <th class="px-3 can">ID CLIENTE</th>
                            <th class="px-3 can">NOMBRE CLIENTE</th>
                            <th class="px-3 can">NOMBRE EMPRESA</th>
                            <th class="px-3 can">VOLUMEN DE COMPRAS</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($resultadoMayoristas->num_rows > 0) {
                            while ($row = $resultadoMayoristas->fetch_assoc()) {
                                echo '<tr>';
                                echo '<td class="align-middle px-4">' . $row['IdFiscal'] . '</td>';
                                echo '<td class="align-middle px-4">' . $row['IdCliente'] . '</td>';
                                echo '<td class="align-middle px-4">' . $row['Nombre'] . '</td>';
                                echo '<td class="align-middle px-4">' . $row['NombreEmpresa'] . '</td>';
                                echo '<td class="align-middle px-4">' . number_format($row['VolumenCompras'], 0) . '</td>';
                                echo '</tr>';
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        </div>


        <p class="d-inline-flex gap-1">
        <br><hr>
        <h2 class="titulo2" data-bs-toggle="collapse" href="#tablaCC" role="button" aria-expanded="false" aria-controls="tablaMayoristas">
            Clientes con Membresia que han realizado más de 2 Compras
        </h2>
        <hr>
        </p>

        <div class="collapse" id="tablaCC">
        <div class="">
            <div class="table-responsive">
                <table class="table table-borderless table-hover prod">
                    <thead>
                        <tr>
                            <th class="px-3 can">ID CLIENTE</th>
                            <th class="px-3 can">NOMBRE</th>
                            <th class="px-3 can">NO DE COMPRAS</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($resultadoc->num_rows > 0) {
                            while ($row = $resultadoc->fetch_assoc()) {
                                echo '<tr>';
                                echo '<td class="align-middle px-4">' . $row['IdCliente'] . '</td>';
                                echo '<td class="align-middle px-4">' . $row['Nombre'] . '</td>';
                                echo '<td class="align-middle px-4">' . $row['NumeroDeCompras'] . '</td>';
                                echo '</tr>';
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        </div>


    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        
    <script>
        function mostrarGastoPromedio(idCliente, nombreCliente) {
            fetch('gasto_promedio.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'idCliente=' + idCliente
            })
            .then(response => response.json())
            .then(data => {
                if (data.gastoPromedio) {
                    Swal.fire({
                        title: `Gasto Promedio`,
                        html: `<b>${nombreCliente}</b> tiene un gasto promedio de: <br><h2>$${parseFloat(data.gastoPromedio).toFixed(2)}</h2>`,
                        icon: 'info',
                        confirmButtonText: 'Aceptar'
                    });
                } else {
                    Swal.fire({
                        title: 'Error',
                        text: data.error || 'No se pudo obtener el promedio de gasto.',
                        icon: 'error',
                        confirmButtonText: 'Aceptar'
                    });
                }
            })
            .catch(error => {
                Swal.fire({
                    title: 'Error',
                    text: 'Hubo un problema al realizar la solicitud.',
                    icon: 'error',
                    confirmButtonText: 'Aceptar'
                });
            });
        }
    </script>

    <?php include 'footer.php'; ?>
</body>
</html>