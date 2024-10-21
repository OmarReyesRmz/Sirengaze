<?php
session_start(); 
$conn = new mysqli('localhost', 'root', '', 'sirenegaze');

if ($conn->connect_error) {
    die("Error en la conexión: " . $conn->connect_error);
}

if (isset($_POST['delete'])) {
    $idProveedor = $_POST['idProveedor'];
    
    $sql = "DELETE FROM proveedor WHERE IdProveedor = '$idProveedor'";
    
    if ($conn->query($sql) === TRUE) {
        echo "<script>
            Swal.fire({
                icon: 'success',
                title: 'Proveedor eliminado con éxito',
                showConfirmButton: false,
                timer: 1500
            }).then(function() {
                window.location = 'eliminarprov.php'; // Redirigir después de eliminar
            });
        </script>";
    } else {
        echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Error al eliminar el proveedor',
                text: '" . $conn->error . "'
            });
        </script>";
    }
}

$sql = "SELECT * FROM proveedor";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar Proveedores</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

    <?php include 'header.php'; ?>

    <div class="container mt-5">
        <h2>Eliminar Proveedores</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID Proveedor</th>
                    <th>Nombre</th>
                    <th>Dirección</th>
                    <th>Teléfono</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['IdProveedor']; ?></td>
                            <td><?php echo $row['Nombre']; ?></td>
                            <td><?php echo $row['Direccion']; ?></td>
                            <td><?php echo $row['Telefono']; ?></td>
                            <td>
                                <form action="deleteprov.php" method="POST" style="display:inline;">
                                    <input type="hidden" name="idProveedor" value="<?php echo $row['IdProveedor']; ?>">
                                    <button type="submit" name="delete" class="btn btn-danger" onclick="return confirm('¿Estás seguro de que deseas eliminar este proveedor?');">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center">No hay proveedores</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <?php include 'footer.php'; ?>
</body>
</html>

<?php
$conn->close();
?>
