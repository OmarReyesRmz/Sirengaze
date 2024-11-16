<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sirenegaze";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    if (isset($_POST['cliente'])) {
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

        try {
            $sql = "INSERT INTO cliente (IdCliente, Edad, Telefono, Nombre, Calle, CP, Numero, Colonia, Correo, password, Cuenta)
                    VALUES ('$idCliente', '$edad', '$telefono', '$nombre', '$calle', '$cp', '$numero', '$colonia', '$correo', '$password', '$cuenta')";
            $conn->query($sql);
            $_SESSION['mensaje'] = 'Cliente agregado con éxito';
            $_SESSION['tipo_mensaje'] = 'success';
        } catch (mysqli_sql_exception $e) {
            if ($e->getCode() == 1062) {
                $_SESSION['mensaje'] = 'Error: El ID ya existe';
                $_SESSION['tipo_mensaje'] = 'error';
            } else {
                $_SESSION['mensaje'] = 'Error en la base de datos';
                $_SESSION['tipo_mensaje'] = 'error';
            }
        }
    } else if (isset($_POST['mayorista'])) {
        $idFiscal = $_POST['IdFiscal'];
        $idCliente = $_POST['IdCliente'];
        $volumenCompras = $_POST['VolumenCompras'];
        $nombreEmpresa = $_POST['NombreEmpresa'];

        try {
            $sql = "INSERT INTO mayorista (IdFiscal, VolumenCompras, NombreEmpresa, IdCliente)
                    VALUES ('$idFiscal', '$volumenCompras', '$nombreEmpresa', '$idCliente')";
            $conn->query($sql);
            $_SESSION['mensaje'] = 'Mayorista agregado con éxito';
            $_SESSION['tipo_mensaje'] = 'success';
        } catch (mysqli_sql_exception $e) {
            if ($e->getCode() == 1062) {
                $_SESSION['mensaje'] = 'Error: El ID ya existe';
                $_SESSION['tipo_mensaje'] = 'error';
            } else {
                $_SESSION['mensaje'] = 'Error en la base de datos';
                $_SESSION['tipo_mensaje'] = 'error';
            }
        }
    }
    $conn->close();
    header('Location: addclientes.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/aclientes.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Agregar Cliente</title>
    
</head>
<body>
    <?php include 'header.php'; ?>
    
<div class="container" style="margin-top:100px;">
    
    <p class="d-inline-flex gap-1">
        <br><hr>
        <h1 class="titulo" data-bs-toggle="collapse" href="#cli" role="button" aria-expanded="false" aria-controls="tablaMayoristas">
            <i style="font-size: 35px;" class="fa-solid fa-file-circle-plus"></i>    
            Agregar Cliente
        </h1>
        <hr>
    </p>
    
    <div class="collapse" id="cli">
        <form method="POST" action="" class="formulario" style="display:flex; flex-direction: column; align-items: center;">
        <!-- Para poner en la misma fila agregar: d-flex al div en class -->
            <div class="mb-2 align-items-center col-8">
                <label for="IDCliente" class="form-label me-2">ID</label>
                <input type="number" name="IdCliente" class="form-control" id="IDCliente" required>
            </div>
            
            <div class="mb-2 align-items-center col-8">
                <label for="name" class="form-label me-2">Nombre</label>
                <input  type="text" name="Nombre" class="form-control" id="name" required>
            </div>
            
            <div class="mb-2 align-items-center col-8">
                <label for="Edad" class="form-label me-2">Edad</label>
                <input type="number" name="Edad" class="form-control" id="Edad" required>
            </div>

            <div class="mb-2 align-items-center col-8">
                <label for="Telefono" class="form-label me-2">Teléfono</label>
                <input type="text" name="Telefono" class="form-control" id="Telefono" required>
            </div>

            <div class="mb-2 align-items-center col-8">
                <label for="Calle" class="form-label me-2">Calle</label>
                <input type="text" name="Calle" class="form-control" id="Calle" required>
            </div>

            <div class="mb-2 align-items-center col-8">
                <label for="CP" class="form-label me-2">Código Postal</label>
                <input type="number" name="CP" class="form-control" id="CP" required>
            </div>

            <div class="mb-2 align-items-center col-8">
                <label for="Numero" class="form-label me-2">Número</label>
                <input type="number" name="Numero" class="form-control" id="Numero" required>
            </div>

            <div class="mb-2x align-items-center col-8">
                <label for="Colonia" class="form-label me-2">Colonia</label>
                <input type="text" name="Colonia" class="form-control" id="Colonia" required>
            </div>

            <div class="mb-2 align-items-center col-8">
                <label for="Correo" class="form-label me-2">Correo</label>
                <input type="email" name="Correo" class="form-control" id="Correo" required>
            </div>

            <div class="mb-2 align-items-center col-8">
                <label for="Password" class="form-label me-2">Password</label>
                <input type="password" name="Password" class="form-control" id="Password" required>
            </div>

            <div class="mb-2 align-items-center col-8">
                <label for="Cuenta" class="form-label me-2">Cuenta</label>
                <input type="text" name="Cuenta" class="form-control" id="Cuenta" required>
            </div>
            <br>
            <button class="btn btn-success" style="font-size:18px" name="cliente" type="submit">Agregar Cliente</button>
        </form>
    </div>

        
    <p class="d-inline-flex gap-1">
        <br><hr>
        <h1 class="titulo" data-bs-toggle="collapse" href="#may" role="button" aria-expanded="false" aria-controls="tablaMayoristas">
        <i style="font-size: 35px;" class="fa-solid fa-file-circle-plus"></i>
        Agregar Mayorista
        </h1>
        <hr>
    </p>

    <div class="collapse" id="may">
    <form method="POST" action="" class="formulario" style="display:flex; flex-direction: column; align-items: center;">
        <!-- Para poner en la misma fila agregar: d-flex al div en class -->
            <div class="mb-2 align-items-center col-8">
                <label for="IDFiscal" class="form-label me-2">ID</label>
                <input type="number" name="IdFiscal" class="form-control" id="IDFiscal" required>
            </div>

            <div class="mb-2 align-items-center col-8">
                <label for="IdClientes" class="form-label me-2">ID Cliente</label>
                <select name="IdCliente" class="form-control" id="IdCliente" required>
                    <option value="">Selecciona el Cliente</option>
                    <?php
                    $result = $conn->query("SELECT IdCliente FROM cliente");
                    
                    if ($result->num_rows > 0): ?>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <option value="<?= $row['IdCliente']; ?>"><?= $row['IdCliente']; ?></option>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <option value="">No hay Clientes disponibles</option>
                    <?php endif; ?>
                </select>
            </div>

            <?php
            // Cerrar la conexión
            $conn->close();
            ?>
            
            <div class="mb-2 align-items-center col-8">
                <label for="VolumenCompras" class="form-label me-2">Volumen de Compras</label>
                <input  type="number" name="VolumenCompras" class="form-control" id="VolumenCompras" required>
            </div>
            
            <div class="mb-2 align-items-center col-8">
                <label for="NombreEmpresa" class="form-label me-2">Nombre de la Empresa</label>
                <input type="text" name="NombreEmpresa" class="form-control" id="NombreEmpresa" required>
            </div>

            <br>
            <button class="btn btn-success" style="font-size:18px" type="submit" name="mayorista">Agregar Mayorista</button>
        </form>

    </div>

</div>

    <?php include 'footer.php'; ?>
</body>
</html>

<?php if (isset($_SESSION['mensaje'])): ?>
    <script>
        Swal.fire({
            icon: '<?php echo $_SESSION['tipo_mensaje']; ?>',
            title: '<?php echo $_SESSION['mensaje']; ?>',
            showConfirmButton: false,
            timer: 2000
        });
    </script>
    <?php
    unset($_SESSION['mensaje']);
    unset($_SESSION['tipo_mensaje']);
    ?>
<?php endif; ?>
