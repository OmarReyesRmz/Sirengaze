<?php
session_start(); 
$conn = new mysqli('localhost', 'root', '', 'sirenegaze');

if ($conn->connect_error) {
    die("Error en la conexión: " . $conn->connect_error);
}

if (isset($_GET['id'])) {
    $idCliente = $_GET['id'];
    $sql = "SELECT * FROM cliente WHERE IdCliente = '$idCliente'";
    $result = $conn->query($sql);
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
    } else {
        echo "Cliente no encontrado.";
        exit();
    }
} else {
    echo "No se proporcionó ID.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

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

    $claveSecreta = "tu_clave_secreta";

    if (!empty($_POST['Password'])) {
        $encryptedPassword = openssl_encrypt($password, 'aes-256-cbc', $claveSecreta, 0, $claveSecreta);
        $sql_update = "UPDATE cliente 
                       SET Edad = '$edad', 
                           Telefono = '$telefono', 
                           Nombre = '$nombre', 
                           Calle = '$calle', 
                           CP = '$cp', 
                           Numero = '$numero', 
                           Colonia = '$colonia', 
                           Correo = '$correo', 
                           Password = '$encryptedPassword', 
                           Cuenta = '$cuenta'
                       WHERE IdCliente = '$idCliente'";

    } else {
        $sql_update = "UPDATE cliente 
                       SET Edad = '$edad', 
                           Telefono = '$telefono', 
                           Nombre = '$nombre', 
                           Calle = '$calle', 
                           CP = '$cp', 
                           Numero = '$numero', 
                           Colonia = '$colonia', 
                           Correo = '$correo', 
                           Cuenta = '$cuenta'
                       WHERE IdCliente = '$idCliente'";
    }
    

    if ($conn->query($sql_update) === TRUE) {
        $_SESSION['mensaje'] = 'Cliente actualizado con éxito';
        $_SESSION['tipo_mensaje'] = 'success';
        header('Location: editclientes.php');
        exit();
    } else {
        $_SESSION['mensaje'] = 'Error al actualizar el cliente: ' . $conn->error;
        $_SESSION['tipo_mensaje'] = 'error';
    }
}


?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Cliente</title>
    <link rel="stylesheet" href="css/aclientes.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

    <?php include 'header.php'; ?>

    <div class="container">
        <hr>
        <h1>Editar Cliente</h1>
        <hr>
        <form method="POST" action="" style="display:flex; flex-direction: column; align-items: center;">
            
            <div class="mb-2 align-items-center col-8">
                <label for="name" class="form-label me-2">Nombre</label>
                <input type="text" name="Nombre" class="form-control" id="name" value="<?php echo htmlspecialchars($row['Nombre']); ?>" required>
            </div>
            
            <div class="mb-2 align-items-center col-8">
                <label for="Edad" class="form-label me-2">Edad</label>
                <input type="number" name="Edad" class="form-control" id="Edad" value="<?php echo htmlspecialchars($row['Edad']); ?>" required>
            </div>

            <div class="mb-2 align-items-center col-8">
                <label for="Telefono" class="form-label me-2">Teléfono</label>
                <input type="text" name="Telefono" class="form-control" id="Telefono" value="<?php echo htmlspecialchars($row['Telefono']); ?>" required>
            </div>

            <div class="mb-2 align-items-center col-8">
                <label for="Calle" class="form-label me-2">Calle</label>
                <input type="text" name="Calle" class="form-control" id="Calle" value="<?php echo htmlspecialchars($row['Calle']); ?>" required>
            </div>

            <div class="mb-2 align-items-center col-8">
                <label for="CP" class="form-label me-2">Código Postal</label>
                <input type="number" name="CP" class="form-control" id="CP" value="<?php echo htmlspecialchars($row['CP']); ?>" required>
            </div>

            <div class="mb-2 align-items-center col-8">
                <label for="Numero" class="form-label me-2">Número</label>
                <input type="number" name="Numero" class="form-control" id="Numero" value="<?php echo htmlspecialchars($row['Numero']); ?>" required>
            </div>

            <div class="mb-2 align-items-center col-8">
                <label for="Colonia" class="form-label me-2">Colonia</label>
                <input type="text" name="Colonia" class="form-control" id="Colonia" value="<?php echo htmlspecialchars($row['Colonia']); ?>" required>
            </div>

            <div class="mb-2 align-items-center col-8">
                <label for="Correo" class="form-label me-2">Correo</label>
                <input type="email" name="Correo" class="form-control" id="Correo" value="<?php echo htmlspecialchars($row['Correo']); ?>" required>
            </div>

            <div class="mb-2 align-items-center col-8">
                <label for="Password" class="form-label me-2">Nueva Contraseña</label>
                <input type="password" name="Password" class="form-control" id="Password" placeholder="Ingrese nueva contraseña si desea cambiarla">
                <small class="text-muted">Deje este campo vacío para conservar la contraseña actual.</small>
            </div>

            <div class="mb-2 align-items-center col-8">
                <label for="Cuenta" class="form-label me-2">Cuenta</label>
                <input type="text" name="Cuenta" class="form-control" id="Cuenta" value="<?php echo htmlspecialchars($row['Cuenta']); ?>" required>
            </div>
            <button type="submit" class="btn btn-dark">Actualizar Cliente</button>
        </form>
</div>
    </div>

    <?php include 'footer.php'; ?>

    <?php if (isset($_SESSION['mensaje'])): ?>
        <script>
            Swal.fire({
                icon: '<?php echo $_SESSION['tipo_mensaje']; ?>',
                title: '<?php echo $_SESSION['mensaje']; ?>',
                showConfirmButton: false,
                timer: 1500
            });
        </script>
        <?php
        unset($_SESSION['mensaje']);
        unset($_SESSION['tipo_mensaje']);
        ?>
    <?php endif; ?>

</body>
</html>

<?php
$conn->close();
?>
