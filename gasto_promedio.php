<?php
header('Content-Type: application/json');
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sirenegaze";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(["error" => "Error de conexión: " . $conn->connect_error]));
}

if (isset($_POST['idCliente'])) {
    $idCliente = intval($_POST['idCliente']);
    $query = "SELECT GastoPromedioCliente(?) AS GastoPromedio";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $idCliente);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        echo json_encode(["gastoPromedio" => $row['GastoPromedio']]);
    } else {
        echo json_encode(["error" => "No se pudo obtener el promedio de gasto."]);
    }
    $stmt->close();
} else {
    echo json_encode(["error" => "ID del cliente no proporcionado."]);
}
$conn->close();
