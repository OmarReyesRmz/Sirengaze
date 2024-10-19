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
        <i class="fa-regular fa-credit-card" style="color: rgb(64, 79, 70); font-size: 100px;"></i>
        <h1 class="titulo">M E M B R E S I A S</h1>
        <hr>
        <?php 

            $compras = "SELECT * FROM membresia";
            $comprasr = $conn->query($compras);

        ?>
            <div class="table-responsive">
                <table class="table table-borderless table-hover prod">
                    <thead>
                        <tr>
                            <th class="px-3 can">EDITAR</th>
                            <th class="px-3 can">NO. DE MEMBRESIA</th>
                            <th class="px-3 can">FECHA DE CADUCIDAD</th>
                            <th class="px-3 can">ESTADO</th>
                            <th class="px-3 can">CLEINTE</th>
                            <th class="px-3 can">TIPO</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                 if ($comprasr->num_rows > 0) {
                    while ($row = $comprasr->fetch_assoc()) {
                            $vari = $row['IdTipo'];
                            $client = "SELECT * FROM tipomembresia WHERE IdTipo = $vari";
                            $cleintr = $conn->query($client);
                            $clientRow = $cleintr->fetch_assoc();

                            $vari2 = $row['IdCliente'];
                            $client2 = "SELECT Cuenta FROM cliente WHERE IdCliente = $vari2";
                            $cleintr2 = $conn->query($client2);
                            $clientRow2 = $cleintr2->fetch_assoc();


                                echo '<tr>';
                                echo "<td class='align-middle px-4'><button style='padding: 5px 40px 5px 40px;' onclick=\"location.href='detalles_compra.php?id=" . $row['NoMembresia'] . "'\"><i class='fa-solid fa-bars'></i></button></td>";
                                echo "<td class='align-middle px-4'>". $row['NoMembresia'] . "</td>";
                                echo '<td class="align-middle px-4">' . $row['FechaCaducidad'] .  '</td>';
                                if($row['Estado'] == "Activa"){
                                    echo "<td class='align-middle px-4'>".$row['Estado']  ."</td>";
                                }else{
                                    echo "<td class='align-middle px-4'>".$row['Estado']  ."</td>";
                                }
                                echo "<td class='align-middle px-4'>".$clientRow2['Cuenta']  ."</td>";
                                echo '<td class="align-middle px-4">' . $clientRow['Tipo']. '</td>';
                                
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