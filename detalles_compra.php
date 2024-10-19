<?php
session_start();
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "sirenegaze";
    $tabla = "producto";
    $total = 0;


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
        <title>Carrito de compras</title>
        <style>
    
        </style>
    </head>
    <body>
        <?php include 'header.php'; 
        $id = $_GET['id'];
        $detalles = "SELECT * FROM detalles WHERE IdCompra = $id";
        $detallesr = $conn->query($detalles);
        ?>
        
        <div class="carrito" style="text-align:center;">
        <section class="regresar" style="position:absolute;">
			<a href="./showcompras.php">
				<i class=" fa-solid fa-arrow-left " style="font-size: 40px"></i>
			</a>
		</section>
            <hr>
            <i class="fa-solid fa-cart-shopping" style="font-size: 100px"></i>
            <h1 class="titulo">C a r r i t o &nbsp&nbsp  d e  &nbsp&nbspc o m p r a s</h1>
            <hr>
            <div class="table-responsive">

                <table class="table table-borderless table-hover prod">
                    
                    <thead>
                        <tr>
                            <th class="px-3 can">Imagen</th>
                            <th class="px-3 can">Producto</th>
                            <th class="px-3 can">Talla</th>
                            <th class="px-3 can">Precio</th>
                            <th class="px-3 can">Cantidad</th>
                            <th class="px-3 can">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($detallesr->num_rows > 0) {
                            while ($rows = $detallesr->fetch_assoc()) {
                                $idprod = $rows['IdProducto'];
                                $query = "SELECT * FROM $tabla WHERE IdProducto = $idprod";
                                $result = $conn->query($query);
                            
                            if ($result->num_rows > 0) {
                                $row = $result->fetch_assoc();
                                echo '<tr>';
                                echo '<td class="align-middle px-4"><img class="img_carrito" src="imagenes/' . $row['Imagen'] . '" alt="imagen no cargada"></td>';
                                echo '<td class="align-middle px-4">' . $row['Nombre'] . '</td>';
                                echo '<td class="align-middle px-4">' . $rows['Talla'] . '</td>';
                                
                                if ($row['Descuento'] != 0) {
                                    $dcto = ($row['Precio'] * $row['Descuento'] / 100);
                                    $precio_final = $row['Precio'] - $dcto;
                                    echo '<td class="align-middle px-4 can" style="color:red;">$' . $precio_final . '</td>';
                                } else {
                                    $precio_final = $row['Precio'];
                                    echo '<td class="align-middle px-4 can">$' . $precio_final . '</td>';
                                }
                
                                echo '<td class="align-middle px-4 can">' . $rows['Cantidad'] . '</td>';
                                echo '<td class="align-middle px-4 can">$' . ($precio_final * $rows['Cantidad']) . '</td>';
                                echo '</tr>';
                
                                $total += $precio_final * $rows['Cantidad'];
                            }
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
  