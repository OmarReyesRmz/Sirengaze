<?php
    session_start();

    if (isset($_SESSION['carrito']) && count($_SESSION['carrito']) > 0) {
    $carrito = $_SESSION['carrito'];

    // $descuentototal = $_SESSION['descuentototal'];
    $servername = "localhost";        
    $username = "root";
    $password = "";
    $database = "sirenegaze";
    $tabla = "inventario";
    $total = 0;
    
    $conn = new mysqli($servername, $username, $password, $database);

    if ($conn->connect_error) {
        die("Error de conexión: " . $conn->connect_error);
    }
    }
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generar Ticket</title>
    <!-- Agrega los enlaces a Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha384-GLhlTQ8i04F5L5+8rvaI8L2PxpM46CDXitWq6YdUCqKxIep9tiCx8V88RNqmz9w9" crossorigin="anonymous">
    <style>
        .ticket{
            margin: 100px;
            padding: 35px;
            font-family: 'Courier New', Courier, monospace;
            border: 1px solid black;
            max-width: 400px;
            text-align: justify;
            font-size:medium;
        }
        .centro{
            text-align: center;
        }

        .container-ticket{
            display: flex;
            justify-content: center;
            align-items: center;
        }
        /* td, th{
            margin:50px;
        } */
        table.tik {
            border-collapse: collapse;
            width: 100%;
        }

        table.tik td {
            border: none;
            padding: 5px;
            text-align: left;
        }
        table.tik td.et {
            text-align: right;
        }
    </style>
</head>
<body>
    <?php include 'header.php'; ?>

    <div class="container-ticket">

    <div class="ticket">
        <h2 class="centro">S I R E N G A Z E</h2>
        <br><br>
        <p>SIRENGAZE MÉXICO CONTRATO 1 A EN P</p>
        <p>SEM93JDM2K42</p>
        <p>Avenida Universidad 940, Bosques del Prado Sur, 20100 Aguascalientes, Ags.</p>
        <p>Tel. 5087-093</p>
        <br>
        <p>S I R E N G A Z E</p>
        <p><?php
        date_default_timezone_set('America/Mexico_City'); 
        echo date("d/m/Y H:i:s"); ?></p>
        <br>
        <table class="tik">
        <tr>
            <th>Producto</th>
            <th>Precio</th>
            <th>Cantidad</th>
            <th>Subtotal</th>
        </tr>
        <?php
        foreach ($carrito as $productoId => $detallesProducto) {    
        if($detallesProducto['cantidad'] != 0){
            $query = "SELECT * FROM $tabla WHERE Id_producto = $productoId";
            $result = $conn->query($query);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                
                ?>
                <tr>
                <td><?php echo $row['nombre'] ?></td>
                <td><?php
                if ($row['descuento'] != 0) {
                    $precio_final = ($row['precio'] - $row['precio'] * $row['descuento'] / 100);
                } else {
                    $precio_final = $row['precio'];
                } 
                echo $precio_final ?></td>
                <td><?php echo $detallesProducto['cantidad'] ?></td>
                <td class="et"><?php echo $precio_final*$detallesProducto['cantidad'];
                $total = $precio_final*$detallesProducto['cantidad'] + $total;
                ?></td>
                </tr>
                
                <?php
            }
        }
        }
       
        ?>
        <td></td>
        <td></td>
        <td></td>
        <td><?php echo $total; ?></td>
        </table>
        <hr>
        <table class="tik">
            <tr>
                <td>Dirreccion de envio:</td>
                <td class="et"><?php echo $_SESSION["direccion"]; ?></td>
            </tr>
        </table>
        <table class="tik">
            <td>Tipo de pago:</td>
            <td class="et"><?php echo $_SESSION["tarjeta"];?></td>
        </table>
        <table class="tik">
            <tr>
            <td>Descuento:</td>
            <td class="et"><?php echo isset($_SESSION["descuento"]) ? $_SESSION["descuento"] : "0"; ?></td>
            </tr>
        </table>
        <table class="tik">
            <tr>
            <td>Envio:</td>
            <td class="et"><?php echo $_SESSION["gastosEnvio"] ?></td>
            </tr>
        </table>
        <table class="tik">
            <tr>
            <td>IVA:</td>
            <td class="et"><?php echo $_SESSION["impuestos"] ?></td>
            </tr>
        </table>
        <hr>
        <table class="tik">
            <tr>
            <td>TOTAL</td>
            <td class="et"><?php echo $_SESSION["total"] ?></td>
            </tr>
        </table>

        <p class="centro">*** GRACIAS POR SU COMPRA ***</p>
        <img src="imagenes/Log.png" alt="" class="tic">
        <h4 class="centro">WWW.SIRENGAZE.COM</h4>
        <div class="centro">
            <a href="pdf.php" >
                <i class="fas fa-file-pdf"></i> DESCARGAR PDF
            </a>
        </div>
        <div style="margin-top:50px; margin-left: 80px;">
            <a href="venta.php"><button type="button" class="btn btn-danger">Confirmar Pago</button></a>
        </div>
    </div>
    
</div> <!--Cierre del container-ticket  -->
    <?php include 'footer.php'; ?>
</body>
</html>