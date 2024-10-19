<header>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</header>

<?php
session_start();
if (isset($_SESSION['carrito']) && count($_SESSION['carrito']) > 0) {
    $carrito = $_SESSION['carrito'];
    $_SESSION['impuestos'] = 0;
    $_SESSION['subtotal'] = 0;
    $_SESSION['cupon'] = 0;
    $_SESSION['descuentototal'] = 0;
    $total = $_SESSION['total'];
    $dia = $_SESSION['dia'];
    $mes = $_SESSION['mes'];
    $year = $_SESSION['year'];
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "sirenegaze";
    $tabla = "producto";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Error de conexión: " . $conn->connect_error);
    }

    
    $cuenta = $_SESSION['cuenta'];
    $datales = "SELECT IdCliente FROM cliente WHERE Cuenta = '$cuenta'";
    $resultado = $conn->query($datales);
    $fila = $resultado->fetch_assoc();
    $IdCliente = $fila['IdCliente'];
    echo $IdCliente, $dia, $mes, $year, $total;
    $dataQuery = "INSERT INTO compra (Day,Month,Year,IdCliente,Total_compra) VALUES ($dia, $mes, $year, $IdCliente,$total)";
    $conn->query($dataQuery);

    $IdCompra = $conn->insert_id;

    // Insertar cada producto del carrito en la tabla 'detalles'
    foreach ($carrito as $productoId => $tallasProducto) {
        foreach ($tallasProducto as $talla => $detallesProducto) {                 
        if ($detallesProducto['cantidad'] != 0) {
            echo $talla;
            // Insertar en la tabla 'detalles' la cantidad, IdCompra e IdProducto
            $insertDetalles = "INSERT INTO detalles (Cantidad, IdCompra, IdProducto, Talla) 
                            VALUES ({$detallesProducto['cantidad']}, $IdCompra, $productoId,'$talla')";
            $conn->query($insertDetalles);
            
            $cantidadtalla = "SELECT $talla FROM producto WHERE IdProducto = $productoId";
            $resultado = $conn->query($cantidadtalla);
            $fila = $resultado->fetch_assoc();
            $cantidad_disponible = $fila[$talla];

            // Actualizar las existencias en la tabla de productos
            $updateQuery = "UPDATE $tabla SET $talla = $talla - {$detallesProducto['cantidad']} 
                            WHERE IdProducto = $productoId";
            $conn->query($updateQuery);
        }
    }
    }

    $_SESSION['contador'] = 0;
    unset($_SESSION["carrito"]);

    // Utiliza SweetAlert2 en lugar de alert
    echo '<script type="text/javascript">
            Swal.fire({
                icon: "success",
                title: "Compra completada",
                text: "¡Gracias por tu compra!",
                timer: 2000,  // Controla el tiempo que se muestra la alerta (en milisegundos)
                showConfirmButton: false
            }).then(function() {
                window.location.href = "index.php";
            });
          </script>';
}
header('Location: index.php');
?>
