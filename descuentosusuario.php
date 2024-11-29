<?php
session_start();

// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$database = "sirenegaze";

$conn = new mysqli($servername, $username, $password, $database);

if (isset($_SESSION['cuenta'])) {
    // Aquí se verifica si el usuario está registrado en la sesión.
    $cuenta = $_SESSION['cuenta'];
    // Consulta para encontrar el user_id (IdCliente) usando la cuenta
    $sql = "SELECT IdCliente FROM cliente WHERE Cuenta = ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $cuenta); // "s" es para indicar que el parámetro es una cadena
    $stmt->execute();
    
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $user_id = $row['IdCliente'];
        echo "El user_id es: " . $user_id;
    } else {
        echo "No se encontró un usuario con esa cuenta.";
    }

    // Verificar si el usuario tiene membresía
    $sql_membresia = "SELECT * FROM membresia WHERE IdCliente = ?";
    $stmt_membresia = $conn->prepare($sql_membresia);
    $stmt_membresia->bind_param("i", $user_id);
    $stmt_membresia->execute();
    $result_membresia = $stmt_membresia->get_result();
    
    if ($result_membresia->num_rows > 0) {
        // El usuario tiene membresía
        $is_member = true;
    } else {
        // El usuario no tiene membresía
        $is_member = false;
    }
} else {
    $is_member = false; // Si no está en sesión, no es miembro
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SireneGaze</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
    <link rel="stylesheet" href="css/sty.css">
    <link rel="icon" sizes="180x180" href="imagenes/logoic.ico">
    <style>
        .bloque3 {
            margin: 20px 0;
            padding: 10px;
            background-color: #000;
            color: white;
            border-radius: 8px;
        }
        .desct {
            font-size: 18px;
        }
        .desct2 {
            font-size: 142px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <?php include 'header.php'; ?>
<br><br><br><br>

    <?php
    // Mostrar los descuentos generales disponibles
    $sql_descuentos = "SELECT * FROM descuentos WHERE Tipo = 'all';"; // Suponiendo que la tabla de descuentos se llama "descuentos"
    $result_descuentos = $conn->query($sql_descuentos);

    if ($result_descuentos->num_rows > 0) {
        while ($row = $result_descuentos->fetch_assoc()) {
            echo "<div class='bloque3'>";
            echo "<p class='desct'>C ó d i g o &nbsp&nbspd e &nbsp&nbspd e s c u e n t o : " . $row['Nombre'] . "</p>";
            echo "<p class='desct2'>" . $row['Descuento'] . "%</p>";
            echo "<p class='desct'>P A R A&nbsp;&nbsp;T O D A&nbsp;&nbsp;L A&nbsp;&nbsp;T I E N D A</p>";
            echo "</div>";
        }
    }

    // Si el usuario es miembro, mostrar sus descuentos
    if ($is_member) {
        // Consulta para obtener los descuentos del miembro
        $sql_membresia_descuentos = "SELECT d.Nombre, d.Descuento, d.Tipo FROM descuentos d 
                                    INNER JOIN tipomembresia_descuento tm ON d.IdDescuentos = tm.IdDescuento 
                                    INNER JOIN tipomembresia m ON tm.IdTipo = m.IdTipo 
                                    INNER JOIN membresia mem ON mem.IdTipo = m.IdTipo 
                                    WHERE mem.IdCliente = ?;";

        $stmt_membresia_descuentos = $conn->prepare($sql_membresia_descuentos);
        $stmt_membresia_descuentos->bind_param("i", $user_id);
        $stmt_membresia_descuentos->execute();
        $result_membresia_descuentos = $stmt_membresia_descuentos->get_result();

        if ($result_membresia_descuentos->num_rows > 0) {
            while ($row = $result_membresia_descuentos->fetch_assoc()) {
                echo "<div class='bloque3'>";
                echo "<p class='desct'>C ó d i g o &nbsp&nbspd e &nbsp&nbspd e s c u e n t o : " . $row['Nombre'] . "</p>";
                echo "<p class='desct2'>" . $row['Descuento'] . "%</p>";
                echo "<p class='desct'>&nbsp;" . strtoupper($row['Tipo']) . "</p>";
                echo "</div>";
            }
        }
    }
    ?>

    <?php include 'footer.php'; ?>
</body>
</html>
