<?php
session_start();

if (isset($_SESSION['carrito']) && count($_SESSION['carrito']) > 0) {
    $carrito = $_SESSION['carrito'];
    $_SESSION['impuestos']=0;
    $_SESSION['subtotal'] = 0;
    $_SESSION['cupon']=0;
    $_SESSION['descuentototal']=0;
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "sirenegaze";
    $tabla = "inventario";
    $total = 0;
    $precio_final=0;
    $dcto=0;

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
        <?php include 'header.php'; ?>
        
        <div class="carrito">

            <h1 class="titulo">C a r r i t o &nbsp&nbsp  d e  &nbsp&nbspc o m p r a s</h1>
            <div class="table-responsive">

                <table class="table table-borderless table-hover prod">
                    
                    <thead>
                        <tr>
                            <th class="px-3 can">Imagen</th>
                            <th class="px-3 can">Producto</th>
                            <th class="px-3 can">Descripcion</th>
                            <th class="px-3 can">Precio</th>
                            <th class="px-3 can">Cantidad</th>
                            <th class="px-3 can">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                    foreach ($carrito as $productoId => $detallesProducto) {
                        if($detallesProducto['cantidad'] != 0){
                            $query = "SELECT * FROM $tabla WHERE Id_producto = $productoId";
                            $result = $conn->query($query);
                            
                            if ($result->num_rows > 0) {
                                $row = $result->fetch_assoc();
                                echo '<tr>';
                                echo '<td class="align-middle px-4"><img class="img_carrito" src="imagenes/' . $row['imagen'] . '" alt="imagen no cargada"></td>';
                                echo '<td class="align-middle px-4">' . $row['nombre'] . '</td>';
                                echo '<td class="align-middle px-4">' . $row['descripcion'] . '</td>';
                                if($row['descuento']!=0){
                                    $dcto = ($row['precio']*$row['descuento']/100) + $dcto;
                                    $precio_final = ($row['precio'] - $row['precio']*$row['descuento']/100);
                                    echo '<td class="align-middle px-4 can" style="color:red";> $' . $precio_final . '</td>';
                                }else{
                                    $precio_final = $row['precio'];
                                    echo '<td class="align-middle px-4 can"> $' . $precio_final . '</td>';
                                }
                                echo '<td class="align-middle px-4 can">' . $detallesProducto['cantidad'] . '</td>';
                                echo '<td class="align-middle px-4 can"> $' . $precio_final * $detallesProducto['cantidad'] . '</td>';
                                echo '<td class="align-middle px-4 can"><button onclick="eliminar(' . $row['Id_producto'] . ')"><i class="fa-regular fa-trash-can" style="color: #000000; font-size:25px;"></i></button></td>';
                                echo '</tr>';
                            }
                            $total = $precio_final* $detallesProducto['cantidad'] + $total;
                        }
                    }
                    echo '<tr>';
                        echo '<td colspan="5" style="text-align:center;">T&nbsp O &nbspT&nbsp A&nbsp L</td>';
                        echo '<td class="can">$' . $total .'</td>';
                        echo '<td></td>';
                        echo '</tr>';
                        $_SESSION['subtotal']=$total;
                        $_SESSION['descuentototal']=$dcto;
                        ?>
                </tbody>
            </table>
            <center><button class="editar-button" onclick="realizarCompra()">Realizar Pedido</button></center>
        </div>
        <script>
            function realizarCompra() {
                window.location.href = "desglosecompra.php";
            }
        </script>
        <script>
            function eliminar(productoId) {
                var xhr = new XMLHttpRequest();

                xhr.open("POST", "eliminarcarrito.php", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

                xhr.onreadystatechange = function () {
                    if (xhr.readyState == 4 && xhr.status == 200) {
                        var respuesta = JSON.parse(xhr.responseText);

                        if (respuesta.success) {
                            window.location.reload();
                        }else{
                            Swal.fire({
                            icon: 'info',
                            title: 'Sin existencias',
                            text: 'Ya no hay más productos en existencias.',
                            confirmButtonText: 'OK'
                            });
                        }
                    }
                };

                xhr.send("producto_id=" + productoId);
            }
        </script>
        </div>
        <?php include 'footer.php'; ?>
    </body>
    </html>
    <?php
} else {
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Carrito de compras</title>
        <link rel="stylesheet" href="css/carrito.css">
    </head>
    <body>
        <?php include 'header.php'; ?>
        <div class="carrito">
        <h1 class="titulo">C a r r i t o &nbsp&nbsp  d e  &nbsp&nbspc o m p r a s</h1>
        <div class="carrito_vacio">
        <img src="imagenes/carrito_vacio.jpg" alt="img" class="vacio">
        <p>Aún no tienes ningún artículo en el carrito, descubre todo lo que tenemos para ti<br><br><button type="button" class="btn btn-dark" onclick="window.location.href='tienda.php'">Descubrir</button></p>
        </div>
        </div>
        <?php include 'footer.php'; ?>
    </body>
    </html>
<?php
}
?>