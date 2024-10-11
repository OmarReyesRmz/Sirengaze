<?php
session_start();
?>
<style>
    @font-face {
    font-family: 'Cormorant_Infant';
    src: url('fonts/Cormorant_Infant/CormorantInfant-Light.ttf') format('truetype');
}    
</style>
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sirenegaze";
$tabla = "inventario";


// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Obtener los valores del rango de precios desde la solicitud POST
$precioMin = isset($_POST['precio_min']) ? $_POST['precio_min'] : 0;
$precioMax = isset($_POST['precio_max']) ? $_POST['precio_max'] : 2000;
$var=0;

// Construir la consulta SQL con la condición del rango de precios
$dataQuery = "SELECT * FROM $tabla";

if ($precioMin > 0 || $precioMax < 2000) {
    $dataQuery .= " WHERE precio-(precio*descuento/100) BETWEEN $var AND $precioMin";
}

$dataResult = $conn->query($dataQuery);

if ($dataResult) {
    $dataResult->data_seek(0);

    if ($dataResult->num_rows > 0) {
        while ($row = $dataResult->fetch_assoc()) {
            // Mostrar los resultados según tus necesidades
            echo '<div class="contenedor">';
            echo '<div class="con"><img src="imagenes/' . $row['imagen'] . '" alt=""></div>';
            echo '<h5 style="font-weight: bold;">ID: ' . $row['Id_producto'] . '</h5>';
            echo '<h5 style="font-weight: bold;">' . $row['nombre'] . '</h5>';

            if($row['descuento']!=0){
                echo '<span style="color:red; text-decoration:line-through;">MXN ' . $row['precio'] . '</span>';
                echo '<span style="font-weight: bold;">MXN ' . $row['precio']-($row['precio']*$row['descuento']/100) . '</span>';
            }else{
                echo '<span>MXN ' . $row['precio'] . '</span>';
            }

            if($row['cantidad']!=0){
                echo '<span>Cantidad en existencia: ' . $row['cantidad'] . '</span>';
            }
            else{
                echo '<span>Agotado</span>';
            }

            if($row['descuento']!=0){
                echo '<span>Descuento del: ' . $row['descuento'] . '%</span><br>';
            }else{
                echo '<span>Sin descuento</span><br>';
            }

            echo '<details>';
            echo '<summary>Descripción</summary>';
            echo '<p>' . $row['descripcion'] . '</p>';
            echo '</details>';
            if(isset($_SESSION["cuenta"])){ 
            echo '<button class="buy" onclick="agregarAlCarrito(' . $row['Id_producto'] . ')"><i class="fa-solid fa-plus" style="color: #080808;"></i></button>';
            }else{
            echo '<button class="buy" onclick="mensaje()"><i class="fa-solid fa-plus" style="color: #080808;"></i></button>';
            }
            echo '</div>';
        }
    } else {
        echo '<pre style="margin-left: 300px; font-size:22px; font-family: Cormorant_Infant, sans-serif;">No se encontraron productos en este rango de precios.</pre><br>
        <img style="width: 500px; margin-left: 100px;" src="imagenes/ganchos.jpg" alt="img" class="ganchos">
        ';
    }
} else {
    echo "Error al obtener datos de la tabla: " . $conn->error;  
}

?>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
<script>
    function agregarAlCarrito(productoId) {
        var xhr = new XMLHttpRequest();

        xhr.open("POST", "agregarcarrito.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                var respuesta = JSON.parse(xhr.responseText);

                if (respuesta.success) {
                    window.location.reload();
                }else{
                    Swal.fire({
                    icon: 'info',
                    title: 'Sin existencias',
                    text: 'Ya no hay más productos en existencias.',
                    confirmButtonText: 'OK'
                    });
                }
            }
        };

        xhr.send("producto_id=" + productoId);
    }

    function mensaje() {
        Swal.fire({
            title: '¡Inicia sesión!',
            text: 'Debes iniciar sesión para agregar productos al carrito.',
            icon: 'info',
            showCancelButton: true,
            confirmButtonText: 'Ir a iniciar sesión',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = 'login.php';
            }
        });
    }
</script>
