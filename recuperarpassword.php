<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Cuenta</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-... (valor del hash) ..." crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10">
    <link rel="stylesheet" href="css/iniciar_sesion.css">
    <style>
        .contenedor__login-register{
            top: 210px;
        }
        .formulario__login{
            background-color: rgb(230, 230, 230)!important;
        }
        *{
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            text-decoration: none;
            font-family: 'Cormorant_Infant', sans-serif;
            font-size: 20px;
            font-weight: 600 !important;
        }

        .btn-recuperar{
            margin-top: 20px;
        }

        @media screen and (max-width: 1000px) {
            .contenedor__login-register{
                top: 25px;
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
        <center>
        <div class="contenedor__login-register">
            <form id="recuperarForm" action="recuperarpassword.php" method="post" class="formulario__login">
                <div class="form-group">
                    <label for="cuenta">Cuenta:</label>
                    <input type="text" class="form-control" id="cuenta" name="cuenta" required>
                </div>

                <div class="form-group">
                    <label for="preguntaSeleccionada">Pregunta de Seguridad:</label>
                    <select class="form-control" id="preguntaSeleccionada" name="preguntaSeleccionada" required>
                        <option value="1">Cual es el nombre de tu mejor amigo?</option>
                        <option value="2">Cual es en nombre de tu mascota?</option>
                        <option value="3">Cual es el nombre de tu cantante favorito?</option>
                        <option value="4">Cual es tu personaje de ficción favorito?</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="respuestaPregunta">Respuesta de la pregunta de seguridad:</label>
                    <input type="text" class="form-control" id="respuestaPregunta" name="respuestaPregunta" required>
                </div>
                <div class="registrosl">
                    <label for="nueva-password">Nueva Contraseña:</label>
                    <input type="password" class="form-control" id="nueva-password" name="nueva-password" required>
                
                    <label for="repetir-password">Repetir Contraseña:</label>
                    <input type="password" class="form-control" id="repetir-password" name="repetir-password" required>
                </div> 
                <center><button type="submit" class="btn btn-primary btn-recuperar" id="recuperar-btn">Recuperar Contraseña</button></center>
            </form>
        </div>
        </center>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="js/recuperarpassword.js"></script>
</body>
</html>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cuenta = $_POST["cuenta"];
    $preguntaSeleccionada = $_POST["preguntaSeleccionada"];
    $respuestaPregunta = $_POST["respuestaPregunta"];
    $nuevaPassword = $_POST["nueva-password"];
    $repetirPassword = $_POST["repetir-password"];

    if ($nuevaPassword !== $repetirPassword) {
        echo "<script>Swal.fire('Las contraseñas no coinciden')</script>";
        exit;
    }

    $claveSecreta = "tu_clave_secreta";

    $conn = new mysqli("localhost", "root", "", "sirenegaze");

    if ($conn->connect_error) {
        die("Error de conexión: " . $conn->connect_error);
    }

    $stmt_verificar = $conn->prepare("SELECT COUNT(*) FROM usuarios WHERE cuenta = ? AND pregunta_seleccionada = ? AND respuesta_pregunta = ?");
    $stmt_verificar->bind_param("iss", $cuenta, $preguntaSeleccionada, $respuestaPregunta);
    $stmt_verificar->execute();
    $stmt_verificar->bind_result($count);
    $stmt_verificar->fetch();
    $stmt_verificar->close();

    if ($count > 0) {
        $stmt_reset_intentos = $conn->prepare("UPDATE usuarios SET Intentos_fallidos = 0, cuenta_habilitada = 1 WHERE cuenta = ?");
        $stmt_reset_intentos->bind_param("s", $cuenta);
        $stmt_reset_intentos->execute();
        $stmt_reset_intentos->close();

        $encryptedPassword = openssl_encrypt($nuevaPassword, 'aes-256-cbc', $claveSecreta, 0, $claveSecreta);

        $stmt_actualizar = $conn->prepare("UPDATE usuarios SET password = ? WHERE cuenta = ?");
        $stmt_actualizar->bind_param("ss", $encryptedPassword, $cuenta);
        $stmt_actualizar->execute();
        $stmt_actualizar->close();

        echo "<script>
                Swal.fire({
                    title: 'Contraseña Actualizada',
                    text: 'Su contraseña ha sido actualizada correctamente.',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = 'login.php';
                    }
                });
            </script>";
    } else {
        echo "<script>Swal.fire('La pregunta y/o respuesta de seguridad no son correctas')</script>";
    }

    $conn->close();
}
?>


