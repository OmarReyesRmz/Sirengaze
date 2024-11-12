<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sirenegaze";

// Crear la conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Insertar cliente
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idCliente = $_POST['IdCliente'];
    $edad = $_POST['Edad'];
    $telefono = $_POST['Telefono'];
    $nombre = $_POST['Nombre'];
    $calle = $_POST['Calle'];
    $cp = $_POST['CP'];
    $numero = $_POST['Numero'];
    $colonia = $_POST['Colonia'];
    $correo = $_POST['Correo'];
    $password = $_POST['Password'];
    $cuenta = $_POST['Cuenta'];

    $sql = "INSERT INTO cliente (IdCliente, Edad, Telefono, Nombre, Calle, CP, Numero, Colonia, Correo, password, Cuenta)
            VALUES ('$idCliente', '$edad', '$telefono', '$nombre', '$calle', '$cp', '$numero', '$colonia', '$correo', '$password', '$cuenta')";

    if ($conn->query($sql) === TRUE) {
        echo "Cliente agregado exitosamente.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/aclientes.css">
    <title>Agregar Cliente</title>
    
</head>
<body>
    <?php include 'header.php'; ?>
    
    <div class="container" style="margin-top:100px; ">
        <h1 style="text-align:center">Agregar Cliente</h1>
        <hr>
        <form method="POST" action="" style="display:flex; flex-direction: column; align-items: center;">

            <div class="mb-2 d-flex align-items-center col-9">
                <label for="IDCliente" class="form-label me-2">ID</label>
                <input type="number" name="IdCliente" class="form-control" id="IDCliente" required>
            </div>
            
            <div class="mb-2 d-flex align-items-center col-9">
                <label for="name" class="form-label me-2">Nombre</label>
                <input  type="text" name="Nombre" class="form-control" id="name" required>
            </div>
            
            <div class="mb-2 d-flex align-items-center col-9">
                <label for="Edad" class="form-label me-2">Edad</label>
                <input type="number" name="Edad" class="form-control" id="Edad" required>
            </div>

            <div class="mb-2 d-flex align-items-center col-9">
                <label for="Telefono" class="form-label me-2">Teléfono</label>
                <input type="text" name="Telefono" class="form-control" id="Telefono" required>
            </div>

            <div class="mb-2 d-flex align-items-center col-9">
                <label for="Calle" class="form-label me-2">Calle</label>
                <input type="text" name="Calle" class="form-control" id="Calle" required>
            </div>

            <div class="mb-2 d-flex align-items-center col-9">
                <label for="CP" class="form-label me-2">Código Postal</label>
                <input type="number" name="CP" class="form-control" id="CP" required>
            </div>

            <div class="mb-2 d-flex align-items-center col-9">
                <label for="Numero" class="form-label me-2">Número</label>
                <input type="number" name="Numero" class="form-control" id="Numero" required>
            </div>

            <div class="mb-2 d-flex align-items-center col-9">
                <label for="Colonia" class="form-label me-2">Colonia</label>
                <input type="text" name="Colonia" class="form-control" id="Colonia" required>
            </div>

            <div class="mb-2 d-flex align-items-center col-9">
                <label for="Correo" class="form-label me-2">Correo</label>
                <input type="email" name="Correo" class="form-control" id="Correo">
            </div>

            <div class="mb-2 d-flex align-items-center col-9">
                <label for="Password" class="form-label me-2">Password</label>
                <input type="password" name="Password" class="form-control" id="Password">
            </div>

            <div class="mb-2 d-flex align-items-center col-9">
                <label for="Cuenta" class="form-label me-2">Cuenta</label>
                <input type="text" name="Cuenta" class="form-control" id="Cuenta">
            </div>

            <button class="btn btn-success" type="submit">Agregar Cliente</button>
        </form>
    </div>

    <?php include 'footer.php'; ?>
</body>
</html>
