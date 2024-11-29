<?php
session_start();
?>

<header>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
    <link rel="stylesheet" href="css/styt.css">
    <link rel="stylesheet" href="css/altas.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .contenedor-altas2 button{
            background-color: #8AB4F8;
            font-weight: 1000;
            font-size: 1.2rem;
        }
    </style>
</header>

<?php
require('header.php');

$servername = "localhost";
$username = "root";
$password = "";
$database = "sirenegaze";
$tabla = "descuentos"; 

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}


if (isset($_GET['id'])) {
    $idDescuentoEditar = $_GET['id'];

    $consultaEditar = $conn->prepare("SELECT * FROM $tabla WHERE IdDescuentos = ?");
    $consultaEditar->bind_param("i", $idDescuentoEditar);
    $consultaEditar->execute();
    $resultadoEditar = $consultaEditar->get_result();

    if ($resultadoEditar->num_rows > 0) {
        $descuentoEditar = $resultadoEditar->fetch_assoc();
    } else {
        echo "Descuento no encontrado.";
    }

    $consultaEditar->close();
}
?>

<!DOCTYPE html>
<html lang="es">

<body>
<div class="contenedor-altas">
    <div class="tienda ">
        <form method="post" enctype="multipart/form-data" action="cambioDescuento.php">
            <div class="contenedor-altas2">
                <h5 style="font-weight: bold;">Editar Descuento <?php echo $idDescuentoEditar ?></h5>
                <input type="hidden" name="Id_descuento" value="<?php echo $descuentoEditar['IdDescuentos']; ?>">
                <h5 style="font-weight: bold;">Nombre del Descuento</h5>
                <input type="text" name="nombre" placeholder="Nombre" value="<?php echo $descuentoEditar['Nombre']; ?>" required><br>
                
                <label for="tipo">Tipo Descuento:</label>
                <select name="tipo" id="tipo" required>
                    <option value="women" <?php echo ($descuentoEditar['Tipo'] == 'women') ? 'selected' : ''; ?>>Women</option>
                    <option value="men" <?php echo ($descuentoEditar['Tipo'] == 'men') ? 'selected' : ''; ?>>Men</option>
                    <option value="all" <?php echo ($descuentoEditar['Tipo'] == 'all') ? 'selected' : ''; ?>>All</option>
                    <option value="diamante" <?php echo ($descuentoEditar['Tipo'] == 'diamante') ? 'selected' : ''; ?>>Diamante</option>
                    <option value="dorada" <?php echo ($descuentoEditar['Tipo'] == 'dorada') ? 'selected' : ''; ?>>Dorada</option>
                    <option value="plata" <?php echo ($descuentoEditar['Tipo'] == 'plata') ? 'selected' : ''; ?>>Plata</option>
                    <option value="bronce" <?php echo ($descuentoEditar['Tipo'] == 'bronce') ? 'selected' : ''; ?>>Bronce</option>
                </select><br>

                <label for="categoria">Categoría:</label>
                <select name="categoria" id="categoria" required>
                    <option value="pantalones" <?php echo ($descuentoEditar['Categoria'] == 'pantalones') ? 'selected' : ''; ?>>Pantalones</option>
                    <option value="blusas" <?php echo ($descuentoEditar['Categoria'] == 'blusas') ? 'selected' : ''; ?>>Blusas</option>
                    <option value="sueteres" <?php echo ($descuentoEditar['Categoria'] == 'sueteres') ? 'selected' : ''; ?>>Sueteres</option>
                    <option value="chamarras" <?php echo ($descuentoEditar['Categoria'] == 'chamarras') ? 'selected' : ''; ?>>Chamarras</option>
                    <option value="vestidos" <?php echo ($descuentoEditar['Categoria'] == 'vestidos') ? 'selected' : ''; ?>>Vestidos</option>
                    <option value="camisetas" <?php echo ($descuentoEditar['Categoria'] == 'camisetas') ? 'selected' : ''; ?>>Camisetas</option>
                    <option value="playeras" <?php echo ($descuentoEditar['Categoria'] == 'playeras') ? 'selected' : ''; ?>>Playeras</option>
                    <option value="shorts" <?php echo ($descuentoEditar['Categoria'] == 'shorts') ? 'selected' : ''; ?>>Shorts</option>
                    <option value="pantalones_2" <?php echo ($descuentoEditar['Categoria'] == 'pantalones_2') ? 'selected' : ''; ?>>Pantalones</option>
                    <option value="sudaderas" <?php echo ($descuentoEditar['Categoria'] == 'sudaderas') ? 'selected' : ''; ?>>Sudaderas</option> 
                </select><br>


                <script>
                    // Listas de categorías según el tipo de descuento
                    const categoriasMujer = [
                        { value: 'pantalones', text: 'Pantalones' },
                        { value: 'blusas', text: 'Blusas' },
                        { value: 'sueteres', text: 'Sueteres' },
                        { value: 'chamarras', text: 'Chamarras' },
                        { value: 'vestidos', text: 'Vestidos' }
                    ];

                    const categoriasHombre = [
                        { value: 'camisetas', text: 'Camisetas' },
                        { value: 'playeras', text: 'Playeras' },
                        { value: 'chamarras_2', text: 'Chamarras' },
                        { value: 'pantalones_2', text: 'Pantalones' },
                        { value: 'sudaderas', text: 'Sudaderas' }
                    ];

                    const categoriasTodos = [
                        ...categoriasMujer,
                        ...categoriasHombre
                    ];

                    // Función para actualizar las opciones de categoría
                    function actualizarCategorias() {
                        const tipo = document.getElementById('tipo').value;
                        const categoriaSelect = document.getElementById('categoria');

                        // Limpia las opciones actuales
                        categoriaSelect.innerHTML = '';

                        // Selecciona las categorías correctas
                        let opciones = [];
                        if (tipo === 'women') {
                            opciones = categoriasMujer;
                        } else if (tipo === 'men') {
                            opciones = categoriasHombre;
                        } else if (tipo === 'all') {
                            opciones = categoriasTodos;
                        }

                        // Agrega las opciones seleccionadas al select de categorías
                        opciones.forEach(opcion => {
                            const optionElement = document.createElement('option');
                            optionElement.value = opcion.value;
                            optionElement.textContent = opcion.text;
                            // Selecciona la opción si coincide con la categoría actual
                            if (opcion.value === '<?php echo $descuentoEditar['Categoria']; ?>') {
                                optionElement.selected = true;
                            }
                            categoriaSelect.appendChild(optionElement);
                        });
                    }

                    // Llama a la función una vez para establecer las categorías al cargar
                    actualizarCategorias();

                    // Agrega un listener para actualizar categorías cuando cambie el tipo
                    document.getElementById('tipo').addEventListener('change', actualizarCategorias);
                </script>


                

                <label for="descuento">Descuento (%):</label>
                <input type="number" name="descuento" placeholder="Descuento" value="<?php echo $descuentoEditar['Descuento']; ?>" required><br>

                <label for="fechaExpiracion">Fecha de Expiración:</label>
                <input type="date" name="fechaExpiracion" value="<?php echo $descuentoEditar['FechaExpiracion']; ?>" required><br>

                <label for="cantidad">Cantidad:</label>
                <input type="number" name="cantidad" placeholder="Cantidad" value="<?php echo $descuentoEditar['Cantidad']; ?>" required><br>

                <button type="submit">Guardar Cambios</button><br>
                
            
            </div>
        </form>
    </div>
</div>


</body>

</html>
<?php include 'footer.php'; ?>

