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
?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="css/carrito.css">
        <title>COMPRAS</title>
        <style>
    
        </style>
    </head>
    <body>
        <?php include 'header.php'; ?>
        
        <div class="carrito" style="text-align: center">
            <section class="regresar" style="position:absolute;">
                <a href="./control.php">
                    <i class=" fa-solid fa-arrow-left " style="font-size: 40px"></i>
                </a>
            </section>
            <hr>
            <i class="fa-brands fa-shopify" style="color: rgb(64, 79, 70); font-size: 100px;"></i>
            <h1 class="titulo">C O M P R A S</h1>
            <hr>
        <?php 

            $compras = "SELECT * FROM compra";
            $comprasr = $conn->query($compras);

            $ventas = "SELECT c.IdCliente, cl.Nombre, SUM(c.Total_compra) AS Total_Compras 
            FROM compra c JOIN cliente cl ON c.IdCliente = cl.IdCliente
            GROUP BY c.IdCliente WITH ROLLUP;";
            $resultadorol = $conn->query($ventas);

            $ventasaño = "SELECT Year, Month, SUM(Total_compra) AS Total_Compras 
            FROM compra GROUP BY Year, Month WITH ROLLUP;";
            $resultadoa = $conn->query($ventasaño);

        ?>
            <div class="table-responsive">
                <table class="table table-borderless table-hover prod">
                    <thead>
                        <tr>
                            <th class="px-3 can">COMPRA</th>
                            <th class="px-3 can">FECHA DE REALIZACIÓN</th>
                            <th class="px-3 can">CUENTA UTILIZADA</th>
                            <th class="px-3 can">TOTAL</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                 if ($comprasr->num_rows > 0) {
                    while ($row = $comprasr->fetch_assoc()) {
                            $vari = $row['IdCliente'];
                            $client = "SELECT Cuenta FROM cliente WHERE IdCliente = $vari";
                            $cleintr = $conn->query($client);
                            $clientRow = $cleintr->fetch_assoc();
                                echo '<tr>';
                                echo "<td class='align-middle px-4'><button style='padding: 5px 40px 5px 40px;' onclick=\"location.href='detalles_compra.php?id=" . $row['IdCompra'] . "'\"><i class='fa-regular fa-eye'></i></button></td>";
                                echo '<td class="align-middle px-4">' . $row['Day'] . "/" . $row['Month'] . "/" . $row['Year'] .  '</td>';
                                echo "<td class='align-middle px-4'>".$clientRow['Cuenta']  ."</td>";
                                echo '<td class="align-middle px-4">' . number_format($row['Total_compra'], 2) . '</td>';
                                
                            }
                        }              
                    ?>
                    </tbody>
                </table>
            </div>

            <p class="d-inline-flex gap-1">
        <br><hr>
        <h2 class="titulo2" data-bs-toggle="collapse" href="#tablaE" role="button" aria-expanded="false" aria-controls="tablaMayoristas">
            Total de Compras por Cliente (Con Total General)
        </h2>
        <hr>
        </p>

        <div class="collapse" id="tablaE">
        
            <div class="table-responsive">
                <table class="table table-borderless table-hover prod">
                    <thead>
                        <tr>
                            <th class="px-3 can">ID_Cliente</th>
                            <th class="px-3 can">Nombre</th>
                            <th class="px-3 can">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($resultadorol->num_rows > 0) {
                            while ($row = $resultadorol->fetch_assoc()) {
                                echo '<tr>';
                                echo '<td class="align-middle px-4">' . $row['IdCliente'] . '</td>';
                                echo '<td class="align-middle px-4">' . $row['Nombre'] . '</td>';
                                echo '<td class="align-middle px-4">' . $row['Total_Compras'] . '</td>';
                                echo '</tr>';
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        
        </div>


        <p class="d-inline-flex gap-1">
        <br><hr>
        <h2 class="titulo2" data-bs-toggle="collapse" href="#tablaA" role="button" aria-expanded="false" aria-controls="tablaMayoristas">
            Reporte de compras por Año y Mes
        </h2>
        <hr>
        </p>

        <div class="collapse" id="tablaA">
        
            <div class="table-responsive">
                <table class="table table-borderless table-hover prod">
                    <thead>
                        <tr>
                            <th class="px-3 can">AÑO</th>
                            <th class="px-3 can">MES</th>
                            <th class="px-3 can">TOTAL COMPRAS</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($resultadoa->num_rows > 0) {
                            while ($row = $resultadoa->fetch_assoc()) {
                                echo '<tr>';
                                echo '<td class="align-middle px-4">' . $row['Year'] . '</td>';
                                echo '<td class="align-middle px-4">' . $row['Month'] . '</td>';
                                echo '<td class="align-middle px-4">' . $row['Total_Compras'] . '</td>';
                                echo '</tr>';
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        
        </div>


        </div>

    <?php include 'footer.php'; ?>
</body>
</html>