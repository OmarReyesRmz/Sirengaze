<?php 

$servername = "localhost";
$username = "root";
$password = "";
$database = "sirenegaze";
$tabla = "producto";

// Conectar a la base de datos
$conn = new mysqli($servername, $username, $password, $database);

if($conn->connect_error){
    die("Conexión fallida: ". $conn->connect_error);
}

// Recibimos los valores del formulario
$nombre = $_POST['Nombre'];
$descripcion = $_POST['Descripcion'];
$precio = $_POST['Precio'];
$descuento = $_POST['Descuento'];  // Corregido
$categoria = $_POST['Categoria'];
$subcategoria = $_POST['Subcategoria'];
$marca = $_POST['Marca'];
$exclusivo = $_POST['Exclusivo'];

// Recibimos valores de las tallas
$XCH = $_POST["XCH"];
$CH = $_POST["CH"];
$M = $_POST["M"];
$L = $_POST["L"];
$XL = $_POST["XL"];
$XXL = $_POST["XXL"];
$existencias = $XCH + $CH + $M + $L + $XL + $XXL;

// Recibimos las imágenes
$imagenes = [];

for ($i = 1; $i <= 3; $i++) {
    $imagenKey = "Imagen" . $i;
    $imagen = $_FILES[$imagenKey]["name"];
    $rutaTemporal = $_FILES[$imagenKey]['tmp_name'];
    $carpetaDestino = 'imagenes/';
    $rutaCompleta = $carpetaDestino . $imagen;

    if(move_uploaded_file($rutaTemporal, $rutaCompleta)){
        $imagenes[] = $imagen;
    } else {
        echo "Error al cargar la imagen";
        exit;
    }
}

// Preparar la consulta SQL para insertar los datos en la tabla de inventario
$sql = $conn->prepare("INSERT INTO producto (nombre, descripcion, precio, descuento, 
categoria, subcategoria, marca, exclusivo, imagen, imagen2, imagen3, xch, ch, m, l, xl, xxl, existencias) 
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

// Asegúrate de que tienes 19 tipos de datos en total
$sql->bind_param("ssddsssssssiiiiiii", 
    $nombre, $descripcion, $precio, $descuento, 
    $categoria, $subcategoria, $marca, $exclusivo,  // Ahora es de tipo string (s)
    $imagenes[0], $imagenes[1], $imagenes[2], 
    $XCH, $CH, $M, $L, $XL, $XXL, $existencias
);


// Ejecutar la consulta
if ($sql->execute()) {
    echo "Producto agregado correctamente.";
    sleep(2);
    header("Location: tienda.php");
} else {
    echo "Error al agregar el producto: " . $sql->error;
}

$sql->close();
$conn->close();

?>
