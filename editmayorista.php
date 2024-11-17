<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'sirenegaze');

if ($conn->connect_error) {
    die("Error en la conexión: " . $conn->connect_error);
}

if (isset($_GET['id'])) {
    $idFiscal = $_GET['id'];
    $sql = "SELECT * FROM mayorista WHERE IdFiscal = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $idFiscal);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
    } else {
        echo "Mayorista no encontrado.";
        exit();
    }
} else {
    echo "No se proporcionó ID.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $volumenCompras = $_POST['VolumenCompras'];
    $nombreEmpresa = $_POST['NombreEmpresa'];
    $idCliente = $_POST['IdCliente']; 
    
    $sql_update = "UPDATE mayorista SET VolumenCompras = ?, NombreEmpresa = ?, IdCliente = ? WHERE IdFiscal = ?";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param("ssss", $volumenCompras, $nombreEmpresa, $idCliente, $idFiscal);
    
    if ($stmt_update->execute()) {
        $_SESSION['mensaje'] = 'Mayorista actualizado con éxito';
        $_SESSION['tipo_mensaje'] = 'success';
        header('Location: editclientes.php');
        exit();
    } else {
        $_SESSION['mensaje'] = 'Error al actualizar el mayorista: ' . $conn->error;
        $_SESSION['tipo_mensaje'] = 'error';
    }
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Mayorista</title>
    <link rel="stylesheet" href="css/aclientes.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

    <?php include 'header.php'; ?>

    <div class="container">
        <hr>
        <h1>Editar Mayorista</h1>
        <hr>
        <form method="POST" action="" style="display:flex; flex-direction: column; align-items: center;">
            <div class="mb-2 align-items-center col-8">
                <label for="name" class="form-label me-2">ID Cliente</label>
                <input type="text" name="IdCliente" class="form-control" id="name" value="<?php echo htmlspecialchars($row['IdCliente']); ?>" required>
            </div>
            
            <div class="mb-2 align-items-center col-8">
                <label for="VolumenCompras" class="form-label me-2">Volumen de Compra</label>
                <input type="number" name="VolumenCompras" class="form-control" id="VolumenCompras" value="<?php echo htmlspecialchars($row['VolumenCompras']); ?>" required>
            </div>

            <div class="mb-2 align-items-center col-8">
                <label for="NombreEmpresa" class="form-label me-2">Nombre de la Empresa</label>
                <input type="text" name="NombreEmpresa" class="form-control" id="NombreEmpresa" value="<?php echo htmlspecialchars($row['NombreEmpresa']); ?>" required>
            </div>

            <button type="submit" class="btn btn-dark">Actualizar Mayorista</button>
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
