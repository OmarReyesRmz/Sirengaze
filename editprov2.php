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
















<?php include 'header.php'; ?>

<div class="container mt-5">

    <p class="d-inline-flex gap-1">
        <hr>
        <h1 class="titulo" data-bs-toggle="collapse" href="#cli" role="button" aria-expanded="false" aria-controls="tablaMayoristas">   
            Lista de Clientes
        </h1>
        <hr>
    </p>

    <div class="collapse" id="cli">
        <table class="table  table-hover">
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
                    <th></th>
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
                                <a href="editcliente.php?id=<?php echo $row['IdCliente']; ?>" class="btn btn-dark">Editar</b>
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


    <p class="d-inline-flex gap-1">
        <hr>
        <h1 class="titulo" data-bs-toggle="collapse" href="#mayor" role="button" aria-expanded="false" aria-controls="tablaMayoristas">   
            Lista de Mayoristas
        </h1>
        <hr>
    </p>

    <div class="collapse" id="mayor">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>ID_Fiscal</th>
                    <th>ID_Cliente</th>
                    <th>Volumen de compra</th>
                    <th>Nombre de la empresa</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php if ($resultMayoristas->num_rows > 0): ?>
                    <?php while($row = $resultMayoristas->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['IdFiscal']; ?></td>
                            <td><?php echo $row['IdCliente']; ?></td>
                            <td><?php echo $row['VolumenCompras']; ?></td>
                            <td><?php echo $row['NombreEmpresa']; ?></td>
                            <td>
                                <a href="editmayorista.php?id=<?php echo $row['IdFiscal']; ?>" class="btn btn-dark">Editar</b>
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
