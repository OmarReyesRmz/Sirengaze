<?php session_start() ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="css/iniciar_sesion.css">
    <link rel="icon" sizes="180x180" href="imagenes/logoic.ico">
    <style>


        .caja__trasera-register{
            width: 80%;
        }

        .caja__trasera-login{
            width: 30%;
        }
 
        .formulario__register{
            left: 320px;
        }
        .contenedor__login-register{
            top: -185px;
        }

        
        
        @media screen and (max-width: 1000px){
            .formulario__register{
                left: 34px;
            }
            .contenedor__login-register{
                top: -25px;
            }

            .caja__trasera a{
                padding: 20px;
            }
            .caja__trasera-login{
                width: 40%;
            }
        }

        @media screen and (max-width: 600px){
            .caja__trasera a{
                padding: 5px;
            }
            .caja__trasera-login{
                width: 50%;
            }
        }

    </style>
</head>
<?php
require 'header.php'; ?>
<body>
    <main>
		<section class="regresar">
			<a href="./index.php">
				<i class=" fa-solid fa-arrow-left "></i>
			</a>
		</section>
        <?php 
         $conn = new mysqli("localhost", "root", "", "sirenegaze");

         if ($conn->connect_error) {
             die("Error de conexión: " . $conn->connect_error);
         }

         // Obtener los datos de la membresía
         $membershipQuery = "SELECT * FROM tipomembresia";
         $membershipResult = $conn->query($membershipQuery);

         // Obtener datos del cliente basado en la sesión actual
         $cuenta = $_SESSION['cuenta'];
         $clienteQuery = "SELECT Nombre, Telefono, IdCliente, Correo, Cuenta FROM cliente WHERE Cuenta = '$cuenta'";
         $clienteResult = $conn->query($clienteQuery);
         $cliente = $clienteResult->fetch_assoc(); // Datos del cliente
         
         $idC = $cliente['IdCliente'];
         $mem = "SELECT NoMembresia FROM membresia WHERE IdCliente = $idC";
         $memr = $conn->query($mem);

         if ($memr->num_rows == 0) {
         ?>
		<div class="contenedor__todo">
			<div class="caja__trasera">
				<div class="caja__trasera-login">
					<h3>Obten tu membresia</h3>
					<p>Con solo un registro y seras otro miembro mas</p>
				</div>
				<div class="caja__trasera-register">
				</div>
			</div>
            <?php
                
                // Al enviar el formulario, registrar los datos en la tabla membresia
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    $idTipo = $_POST['tipo_membresia'];
                    $idCliente = $cliente['IdCliente'];
                    $fechaCaducidad = date('Y-m-d', strtotime('+1 year')); // Ejemplo: fecha de caducidad a 1 año
                    $estado = 'Activa'; // Estado inicial

                    $insertQuery = "INSERT INTO membresia (NoMembresia, FechaCaducidad, Estado, IdCliente, IdTipo) 
                                    VALUES (NULL, '$fechaCaducidad', '$estado', '$idCliente', '$idTipo')";
                    
                    if ($conn->query($insertQuery) === TRUE) {
                        $updateCantidadQuery = "UPDATE tipomembresia SET Cantidad = Cantidad + 1 WHERE IdTipo = '$idTipo'";
                        echo "<script>
                            Swal.fire({
                                title: 'Registro exitoso',
                                text: '¡La membresia se ha completado con éxito!',
                                icon: 'success',
                                confirmButtonText: 'Aceptar'
                            }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = 'index.php';
                            }
                            });
                        </script>";
                    } 
                }

                $conn->close();
            ?>
            <div class="contenedor__login-register">
                <form id="registroForm" action="" method="post" class="formulario__register">
                    <h2>Obtener Membresía</h2>

                    <!-- Datos de cliente (inputs deshabilitados) -->
                    <div class="registrosl">
                        <label for="nombre">Nombre:</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $cliente['Nombre']; ?>" disabled>
                    </div>
                    <div class="registrosl">
                        <label for="telefono">Teléfono:</label>
                        <input type="text" class="form-control" id="telefono" name="telefono" value="<?php echo $cliente['Telefono']; ?>" disabled>
                    </div>
                    <div class="registrosl">
                        <label for="correo">Correo:</label>
                        <input type="email" class="form-control" id="correo" name="correo" value="<?php echo $cliente['Correo']; ?>" disabled>
                    </div>
                    <div class="registrosl">
                        <label for="cuenta">Cuenta:</label>
                        <input type="text" class="form-control" id="cuenta" name="cuenta" value="<?php echo $cliente['Cuenta']; ?>" disabled>
                    </div>

                    <!-- Seleccionar tipo de membresía -->
                    <div class="registrosl">
                        <label for="tipo_membresia">Tipo de Membresía:</label>
                        <select class="form-control" id="tipo_membresia" name="tipo_membresia" required>
                            <?php while ($row = $membershipResult->fetch_assoc()): ?>
                                <option value="<?php echo $row['IdTipo']; ?>"><?php echo $row['Tipo']; ?> - Crédito: <?php echo $row['Credito']; ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>

                    <center><button type="submit" class="btn btn-primary" style="margin-top:30px;">Registrarse</button></center> 
                </form>
            </div>
        </div>
        <?php }else{
            echo "<script>
            Swal.fire({
                title: '¡Ya formas parte de nosotros, sigue comprando!',
                text: 'si quieres cambiar tu membresia o cancelarla, habla con los administradores!',
                icon: 'error',
                confirmButtonText: 'Volver'
            }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = 'index.php';
            }
            });
        </script>";
        } ?>
        <!-- Por si alguien ya tiene una cuenta -->

    </main>
    <script src="https://kit.fontawesome.com/673553f744.js" crossorigin="anonymous"></script>
</body>
</html>