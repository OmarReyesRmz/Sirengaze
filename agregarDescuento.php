<?php
session_start();
ob_start(); // Inicia el almacenamiento de la salida en el buffer
include 'header.php';

// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$database = "sirenegaze";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Recibir datos del formulario
$nombre_descuento = $_POST['nombre_descuento'];
// $categoria = $_POST['categoria'];
$tipo_descuento = $_POST['tipo_descuento'];
$valor_descuento = $_POST['valor_descuento'];
$fecha_expiracion = $_POST['fecha_expiracion'];
$Cantidad = $_POST['Cantidad'];

// Verificar si el nombre del descuento ya existe
$check_sql = "SELECT COUNT(*) AS count FROM descuentos WHERE Nombre = ?";
$stmt = $conn->prepare($check_sql);
$stmt->bind_param("s", $nombre_descuento);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if ($row['count'] > 0) {
    echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
    echo "<script>
        Swal.fire({
            icon: 'warning',
            title: 'El nombre del descuento ya existe',
            text: 'Por favor elige un nombre diferente.',
            showConfirmButton: true
        }).then(function() {
                window.location = 'adddesc.php';  
            });
    </script>";
} else {
    // Insertar el descuento
    $sql = "INSERT INTO descuentos (Nombre, Tipo, Descuento, FechaExpiracion, Cantidad) 
            VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $nombre_descuento, $tipo_descuento, $valor_descuento, $fecha_expiracion, $Cantidad);

    if ($stmt->execute()) {
        $id_descuento = $conn->insert_id; // Obtener el último IdDescuento insertado

    // Insertar en `mayorista_descuentos` si la categoría es ALL, MEN o WOMEN
    if (strtoupper($tipo_descuento) == 'ALL') {
        // Obtener los IdFiscal de la tabla mayorista
        $fiscal_sql = "SELECT IdFiscal FROM mayorista";
        $fiscal_result = $conn->query($fiscal_sql);

        // Preparar la consulta para insertar en mayorista_descuentos
        $insert_mayorista_sql = "INSERT INTO mayorista_descuentos (IdDescuentos, IdFiscal) VALUES (?, ?)";
        $stmt_mayorista = $conn->prepare($insert_mayorista_sql);

        // Insertar en la tabla mayorista_descuentos para cada IdFiscal
        while ($fiscal_row = $fiscal_result->fetch_assoc()) {
            $stmt_mayorista->bind_param("ii", $id_descuento, $fiscal_row['IdFiscal']);
            $stmt_mayorista->execute();
        }
    }

    // Insertar en `regular_descuentos` si la categoría es ALL, MEN o WOMEN
    if (in_array(strtoupper($tipo_descuento), ['ALL'])) {
        // Obtener los IdRegular de la tabla regular
        $regular_sql = "SELECT IdRegular FROM regular";
        $regular_result = $conn->query($regular_sql);

        // Preparar la consulta para insertar en regular_descuentos
        $insert_regular_sql = "INSERT INTO regular_descuento (IdDescuentos, IdCliente) VALUES (?, ?)";
        $stmt_regular = $conn->prepare($insert_regular_sql);

        // Insertar en la tabla regular_descuento para cada IdCliente
        while ($regular_row = $regular_result->fetch_assoc()) {
            $stmt_regular->bind_param("ii", $id_descuento, $regular_row['IdRegular']); // Usar IdRegular para la relación
            $stmt_regular->execute();
        }
    }


        // Insertar en `tipomembresia_descuento` si el tipo coincide (PLATA = PLATA)
        $membresia_sql = "SELECT IdTipo, UPPER(Tipo) AS Tipo FROM tipomembresia";
        $membresia_result = $conn->query($membresia_sql);

        $insert_membresia_sql = "INSERT INTO tipomembresia_descuento (IdTipo, IdDescuento) VALUES (?, ?)";
        $stmt_membresia = $conn->prepare($insert_membresia_sql);

        while ($membresia_row = $membresia_result->fetch_assoc()) {
            if (strtoupper($tipo_descuento) === $membresia_row['Tipo']) {
                $stmt_membresia->bind_param("ii", $membresia_row['IdTipo'], $id_descuento);
                $stmt_membresia->execute();
            }
        }

        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
        echo "<script>
            Swal.fire({
                icon: 'success',
                title: 'Descuento agregado exitosamente',
                showConfirmButton: false,
                timer: 1500
            }).then(function() {
                window.location = 'control.php';  
            });
        </script>";
    } else {
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
        echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Hubo un error al insertar el descuento: " . $stmt->error . "',
            });
        </script>";
    }
}

ob_end_flush(); // Envía todo el contenido almacenado en el buffer
$conn->close();
?>
