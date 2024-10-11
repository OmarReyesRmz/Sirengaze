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
            top: -225px;
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
<body>
    <main>
		<section class="regresar">
			<a href="./index.php">
				<i class=" fa-solid fa-arrow-left "></i>
			</a>
		</section>
		<div class="contenedor__todo">
			<div class="caja__trasera">
				<div class="caja__trasera-login">
					<h3>¿Ya tienes una cuenta?</h3>
					<p>Inicia sesión para entrar a la página</p>
                  
				    <center><button id="btn__iniciar-sesion"><a href="login.php">Iniciar Sesion</a></button> </center>	
				</div>
				<div class="caja__trasera-register">
				</div>
			</div>

            <div class="contenedor__login-register">
                <form id="registroForm" action="registro.php" method="post" class="formulario__register">
                    <h2>Registro</h2>
                    
                    <div class="registrosl">
                        <label for="nombre">Nombre:</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" required>

                        <label for="cuenta">Cuenta:</label>
                        <input type="text" class="form-control" id="cuenta" name="cuenta" required>
                    </div>

                    <div class="registrosl">
                        <label for="email">Correo Electrónico:</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>

                    <div class="registrosl">
                        <label for="preguntaSeleccionada">Pregunta de Seguridad:</label>
                        <select class="form-control" id="preguntaSeleccionada" name="preguntaSeleccionada" required>
                            <option value="1">Cual es el nombre de tu mejor amigo?</option>
                            <option value="2">Cual es en nombre de tu mascota?</option>
                            <option value="3">Cual es el nombre de tu cantante favorito?</option>
                            <option value="4">Cual es tu personaje de ficción favorito?</option>
                        </select>
                    </div>

                    <div class="registrosl">
                        <label for="respuestaPregunta">Respuesta de Seguridad:</label>
                        <input type="text" class="form-control" id="respuestaPregunta" name="respuestaPregunta" required>
                    </div>

                    <div class="registrosl">
                        <label for="password">Contraseña:</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    
                        <label for="confirmPassword">Repetir Contraseña:</label>
                        <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" required>
                    </div>
                    <center><p><input type="checkbox" name="sus" value="1"> Ser suscribtor</p></center>
                    <center><button type="submit" class="btn btn-primary" style="margin-top:30px;">Registrarse</button></center> 
                </form>
            </div>
        </div>
    </main>
    <script src="https://kit.fontawesome.com/673553f744.js" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function () {
            $('#registroForm').submit(function () {
                var password = $('#password').val();
                var confirmPassword = $('#confirmPassword').val();

                if (password !== confirmPassword) {
                    Swal.fire({
                        title: "Error al registrar",
                        text: "Las contraseñas no coinciden",
                        icon: "error",
                        confirmButtonText: "Aceptar"
                    });
                    return false;
                }
            });
        });
    </script>
</body>
</html>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST["nombre"];
    $cuenta = $_POST["cuenta"];
    $email = $_POST["email"];
    $preguntaSeleccionada = $_POST["preguntaSeleccionada"];
    $respuestaPregunta = $_POST["respuestaPregunta"];
    $password = $_POST["password"];

    if (isset($_POST["sus"])) {
        if($_POST["sus"] == "1")
            $esSuscriptor = 1;
    } else {
        $esSuscriptor = 0;
    }

    $claveSecreta = "tu_clave_secreta";

    $encryptedPassword = openssl_encrypt($password, 'aes-256-cbc', $claveSecreta, 0, $claveSecreta);

    $conn = new mysqli("localhost", "root", "", "sirenegaze");

    if ($conn->connect_error) {
        die("Error de conexión: " . $conn->connect_error);
    }

    // Verificar si el usuario ya existe
    $stmt_verificar = $conn->prepare("SELECT COUNT(*) FROM usuarios WHERE cuenta = ?");
    $stmt_verificar->bind_param("s", $cuenta);
    $stmt_verificar->execute();
    $stmt_verificar->bind_result($count);
    $stmt_verificar->fetch();
    $stmt_verificar->close();

    if ($count > 0) {
        echo '<script>
                    Swal.fire({
                        title: "Error al registrar",
                        text: "Usuario ya existente",
                        icon: "error",
                        confirmButtonText: "Aceptar"
                    });
                </script>';
    } else {
        // El usuario no existe, realizar el registro
        $stmt_insertar = $conn->prepare("INSERT INTO usuarios (nombre, cuenta, email, pregunta_seleccionada, respuesta_pregunta, password) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt_insertar->bind_param("ssssss", $nombre, $cuenta, $email, $preguntaSeleccionada, $respuestaPregunta, $encryptedPassword);

        if ($stmt_insertar->execute()) {
            // Registro exitoso
            echo '<script>
                    Swal.fire({
                        title: "Registro exitoso",
                        text: "¡El registro se ha completado con éxito!",
                        icon: "success",
                        confirmButtonText: "Aceptar"
                    }).then(function() {
                        window.location = "bienvenida.php?nombre=' . urlencode($nombre) . '&correo=' . urlencode($email) . '&sus='. urlencode($esSuscriptor) .'";
                    });
                </script>';
            exit;
        } else {
            // Error al registrar
            echo '<script>
                    Swal.fire({
                        title: "Error al registrar",
                        text: "Hubo un error al procesar tu solicitud: ' . $stmt_insertar->error . '",
                        icon: "error",
                        confirmButtonText: "Aceptar"
                    });
                </script>';
        }

        $stmt_insertar->close();
    }

    $conn->close();
}
?>
