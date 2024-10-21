<?php
session_start(); 
$conn = new mysqli('localhost', 'root', '', 'sirenegaze');

if ($conn->connect_error) {
    die("Error en la conexión: " . $conn->connect_error);
}

if (isset($_GET['id'])) {
    $idProveedor = $_GET['id'];
    $sql = "SELECT * FROM proveedor WHERE IdProveedor = '$idProveedor'";
    $result = $conn->query($sql);
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
    } else {
        echo "Proveedor no encontrado.";
        exit();
    }
} else {
    echo "No se proporcionó un ID de proveedor.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $direccion = $_POST['direccion'];
    $telefono = $_POST['telefono'];

    $sql_update = "UPDATE proveedor SET Nombre='$nombre', Direccion='$direccion', Telefono='$telefono' 
                   WHERE IdProveedor='$idProveedor'";

    if ($conn->query($sql_update) === TRUE) {
        $_SESSION['mensaje'] = 'Proveedor actualizado con éxito';
        $_SESSION['tipo_mensaje'] = 'success';
        header('Location: editprov.php');
        exit();
    } else {
        $_SESSION['mensaje'] = 'Error al actualizar el proveedor: ' . $conn->error;
        $_SESSION['tipo_mensaje'] = 'error';
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Proveedor</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

    <?php include 'header.php'; ?>

    <div class="container mt-5">
        <h2>Editar Proveedor</h2>
        <form action="" method="POST">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo htmlspecialchars($row['Nombre']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="direccion" class="form-label">Dirección</label>
                <input type="text" class="form-control" id="direccion" name="direccion" value="<?php echo htmlspecialchars($row['Direccion']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="telefono" class="form-label">Teléfono</label>
                <input type="text" class="form-control" id="telefono" name="telefono" value="<?php echo htmlspecialchars($row['Telefono']); ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Actualizar Proveedor</button>
        </form>
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
