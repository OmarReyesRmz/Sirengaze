<?php
session_start(); 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $nombre = $_POST['nombre'];
    $direccion = $_POST['direccion'];
    $telefono = $_POST['telefono'];

    $conn = new mysqli('localhost', 'root', '', 'sirenegaze');

    if ($conn->connect_error) {
        die("Error en la conexión: " . $conn->connect_error);
    }

    $sql = "INSERT INTO proveedor (Nombre, Direccion, Telefono) 
            VALUES ('$nombre', '$direccion', '$telefono')";

    if ($conn->query($sql) === TRUE) {
        $_SESSION['mensaje'] = 'Proveedor agregado con éxito';
        $_SESSION['tipo_mensaje'] = 'success';
    } else {
        $_SESSION['mensaje'] = 'Error al agregar el proveedor: ' . $conn->error;
        $_SESSION['tipo_mensaje'] = 'error';
    }

    $conn->close();

    header('Location: addprov.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Proveedor</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

    <?php include 'header.php'; ?>

    <div class="container mt-5">
        <h2>Agregar Proveedor</h2>
        <form action="addprov.php" method="POST">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre" required>
            </div>
            <div class="mb-3">
                <label for="direccion" class="form-label">Dirección</label>
                <input type="text" class="form-control" id="direccion" name="direccion" required>
            </div>
            <div class="mb-3">
                <label for="telefono" class="form-label">Teléfono</label>
                <input type="text" class="form-control" id="telefono" name="telefono" required>
            </div>
            <button type="submit" class="btn btn-primary">Agregar Proveedor</button>
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
