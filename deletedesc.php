<?php
session_start();
?>

<header>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
    <link rel="stylesheet" href="css/styt.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</header>

<?php
include 'header.php';
$servername = "localhost";
$username = "root";
$password = "";
$database = "sirenegaze";
$tabla = "descuentos"; // Cambiar la tabla a "descuentos"

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Consulta para obtener los descuentos
$dataQuery = "SELECT * FROM $tabla";
$dataResult = $conn->query($dataQuery);
if ($dataResult) {
    $dataResult->data_seek(0);
?>

    <style>
        .btn2 {
            margin-top: 10px;
            height: 50px;
            background-color: #D73F4B;
        }
    </style>
    
    <div class="tienda contenedor-tienda">
        <?php
        while ($row = $dataResult->fetch_assoc()) {
            // Asignar valores a variables
            $id = $row['IdDescuentos'];
            $nombre = $row['Nombre'];
            $categoria = $row['Categoria'];
            $tipo = $row['Tipo'];
            $descuento = $row['Descuento'];
            $fechaExpiracion = $row['FechaExpiracion'];
        ?>
        
        <div class="contenedor">
            <br><br><br>
            <div class="con">
                <h5 style="font-weight: bold;"><?php echo 'ID: ' . $id ?></h5>
                <h5 style="font-weight: bold;"><?php echo $nombre ?></h5>
                <p><?php echo 'Categoría: ' . $categoria ?><br>
                <?php echo 'Descuento: ' . $descuento . '%' ?><br>
                <?php echo 'Fecha de Expiración: ' . $fechaExpiracion ?></p>
                
                <button class="btn btn-danger btn2" onclick="eliminarDescuento(<?php echo $id ?>)">
                    Eliminar Descuento <?php echo $id ?>
                </button>
                <div id="mensajeEliminar"></div>
            </div>
        </div>
        
        <?php
        }
        ?>
    </div>

<?php
} else {
    echo "Error al obtener datos de la tabla: " . $conn->error;
}

$conn->close();
?>

<script>
    function eliminarDescuento(idDescuento) {
        Swal.fire({
            title: '¿Estás seguro de eliminar este descuento? ' + idDescuento,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                var xhr = new XMLHttpRequest();
                xhr.open("POST", "eliminarDescuento.php", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhr.onreadystatechange = function () {
                    if (xhr.readyState === XMLHttpRequest.DONE) {
                        if (xhr.status === 200) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Descuento eliminado exitosamente',
                                showConfirmButton: false,
                                timer: 1500
                            }).then(function() {
                                window.location.reload(); // Recargar la página
                            });
                        } else {
                            document.getElementById("mensajeEliminar").innerHTML = "Error al eliminar el descuento.";
                        }
                    }
                };
                xhr.send("idDescuento=" + idDescuento);
            }
        });
    }
</script>

<?php include 'footer.php'; ?>
