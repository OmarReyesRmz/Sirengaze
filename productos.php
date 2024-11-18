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
        <i class="fa-solid fa-shirt" style="color: #000000; font-size: 100px;"></i>
        <br>
        <h1 class="titulo">P r o d u c t o s</h1>
        <hr>

        <?php 
            $prod = "SELECT IdProducto, Nombre FROM producto WHERE Exclusivo = 'T' 
            INTERSECT SELECT IdProducto, Nombre FROM producto WHERE Descuento != 0;";

            $resultadoprod = $conn->query($prod);


            
        ?>

        <p class="d-inline-flex gap-1">
        <br><hr>
        <h2 class="titulo2" data-bs-toggle="collapse" href="#tablaCliM" role="button" aria-expanded="false" aria-controls="tablaMayoristas">
            Productos Exclusivos que tienen Descuento
        </h2>
        <hr>
        </p>

        <div class="collapse" id="tablaCliM">
        
            <div class="table-responsive">
                <table class="table table-borderless table-hover prod">
                    <thead>
                        <tr>
                            <th class="px-3 can">ID PRODUCTO</th>
                            <th class="px-3 can">NOMBRE</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($resultadoprod->num_rows > 0) {
                            while ($row = $resultadoprod->fetch_assoc()) {
                                echo '<tr>';
                                echo '<td class="align-middle px-4">' . $row['IdProducto'] . '</td>';
                                echo '<td class="align-middle px-4">' . $row['Nombre'] . '</td>';
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