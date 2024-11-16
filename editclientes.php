<?php
session_start(); 
$conn = new mysqli('localhost', 'root', '', 'sirenegaze');
if ($conn->connect_error) {
    die("Error en la conexión: " . $conn->connect_error);
}

$sql = "SELECT * FROM cliente";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Clientes</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

    <?php include 'header.php'; ?>

    <div class="container mt-5">
        <h2>Lista de Clientes</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID Cliente</th>
                    <th>Nombre</th>
                    <th>Edad</th>
                    <th>Teléfono</th>
                    <th>Correo</th>
                    <th>CP</th>
                    <th>Calle</th>
                    <th>Número</th>
                    <th>Colonia</th>
                    <th>Cuenta</th>
                    <th>Password</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['IdCliente']; ?></td>
                            <td><?php echo $row['Nombre']; ?></td>
                            <td><?php echo $row['Edad']; ?></td>
                            <td><?php echo $row['Telefono']; ?></td>
                            <td><?php echo $row['Correo']; ?></td>
                            <td><?php echo $row['CP']; ?></td>
                            <td><?php echo $row['Calle']; ?></td>
                            <td><?php echo $row['Numero']; ?></td>
                            <td><?php echo $row['Colonia']; ?></td>
                            <td><?php echo $row['Cuenta']; ?></td>
                            <td><?php echo $row['password']; ?></td>
                            <td>
                                <a href="editprov2.php?id=<?php echo $row['IdCliente']; ?>" class="btn btn-black">Editar</a>
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
// Cerrar la conexión a la base de datos
$conn->close();
?>
