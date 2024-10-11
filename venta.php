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
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "sirenegaze";
    $tabla = "inventario";
    $total = 0;
    $precio_final = 0;
    $dcto = 0;

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Error de conexión: " . $conn->connect_error);
    }

    foreach ($carrito as $productoId => $detallesProducto) {
        if ($detallesProducto['cantidad'] != 0) {
            // Resta la cantidad del carrito de las existencias actuales en la base de datos
            $updateQuery = "UPDATE $tabla SET cantidad = cantidad - {$detallesProducto['cantidad']} WHERE Id_producto = $productoId";
            $conn->query($updateQuery);
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
