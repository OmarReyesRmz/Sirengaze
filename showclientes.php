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
        <title>CLIENTES</title>
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
        <i class="fa-solid fa-users" style="color: black; font-size: 100px;"></i><br>
        <br>
        <h1 class="titulo">C L I E N T E S</h1>
        <hr>
        <?php 
            $clientes = "SELECT cliente.*, IF(membresia.NoMembresia IS NOT NULL, 1, 0) AS Membresia
                        FROM cliente
                        LEFT JOIN membresia ON cliente.IdCliente = membresia.IdCliente";
            $resultadoClientes = $conn->query($clientes);
        ?>

        <div class="table-responsive">
            <table class="table table-borderless table-hover prod">
                <thead>
                    <tr>
                        <th class="px-3 can">ID CLIENTE</th>
                        <th class="px-3 can">NOMBRE</th>
                        <th class="px-3 can">EDAD</th>
                        <th class="px-3 can">TELÉFONO</th>
                        <th class="px-3 can">CALLE</th>
                        <th class="px-3 can">CÓDIGO POSTAL</th>
                        <th class="px-3 can">NÚMERO</th>
                        <th class="px-3 can">COLONIA</th>
                        <th class="px-3 can">CORREO</th>
                        <th class="px-3 can">CUENTA</th>
                        <th class="px-3 can">MEMBRESIA</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($resultadoClientes->num_rows > 0) {
                        while ($row = $resultadoClientes->fetch_assoc()) {
                            echo '<tr>';
                            echo '<td class="align-middle px-4">' . $row['IdCliente'] . '</td>';
                            echo '<td class="align-middle px-4">' . $row['Nombre'] . '</td>';
                            echo '<td class="align-middle px-4">' . $row['Edad'] . '</td>';
                            echo '<td class="align-middle px-4">' . $row['Telefono'] . '</td>';
                            echo '<td class="align-middle px-4">' . $row['Calle'] . '</td>';
                            echo '<td class="align-middle px-4">' . $row['CP'] . '</td>';
                            echo '<td class="align-middle px-4">' . $row['Numero'] . '</td>';
                            echo '<td class="align-middle px-4">' . $row['Colonia'] . '</td>';
                            echo '<td class="align-middle px-4">' . $row['Correo'] . '</td>';
                            echo '<td class="align-middle px-4">' . $row['Cuenta'] . '</td>';
                            echo '<td class="align-middle px-4">';
                            if ($row['Membresia'] == 1) {
                                echo '<i class="fa-solid fa-check" style="color: #338212;"></i>'; 
                            } else {
                                echo '<i class="fa-solid fa-xmark" style="color: #b42727;"></i>'; 
                            }
                            echo '</td>';
                            echo '</tr>';
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php include 'footer.php'; ?>
</body>
</html>