    <?php
    //Import PHPMailer classes into the global namespace
    //These must be at the top of your script, not inside a function
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    require 'PHPMailer/Exception.php';
    require 'PHPMailer/PHPMailer.php';
    require 'PHPMailer/SMTP.php';

    //Create an instance; passing `true` enables exceptions
    $mail = new PHPMailer(true);

    $nombre = $_GET['nombre'] ?? '';
    $email = $_GET['correo'] ?? '';

    $email = filter_var($_GET['correo'], FILTER_VALIDATE_EMAIL);
    if (!$email) {
        // Dirección de correo electrónico no válida
        echo "Dirección de correo electrónico no válida.";
        exit;  // O maneja el error de alguna manera apropiada para tu aplicación
    }
        
        try {
        
            //Server settings
            $mail->SMTPDebug = 0;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = 'alan22518prog@gmail.com';                     //SMTP username
            $mail->Password   = 'czah iezg bfne ixup';                               //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
        
            //Recipients
            $mail->setFrom('alan22518prog@gmail.com', 'Alan G');
            $mail->addAddress($email, $nombre);     //Add a recipient
            $mail->addReplyTo($email, 'Bienvenido');
        
        
            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = $nombre;
            
            $mail->Body = "Hola $nombre!<br><br>

            En nombre de todo el equipo, te damos la bienvenida a nuestra exclusiva comunidad de moda en linea! Estamos emocionados de tenerte aqui y queremos agradecerte por unirte a nosotros.<br><br>
            
            En nuestra tienda, encontraras una amplia gama de estilos que se adaptan a tu personalidad y resaltan tu esencia unica. Desde las ultimas tendencias hasta los clasicos a temporales, estamos comprometidos a ofrecerte calidad, estilo y comodidad en cada prenda que elijas.<br><br>
            
            Como miembro, tendras acceso a ofertas exclusivas, novedades en moda y una experiencia de compra personalizada que se ajusta a tus gustos y preferencias.";
            $rutaImagen = 'imagenes/cupon.jpg';
            $mail->addAttachment($rutaImagen);

            $mail->send();
            echo 'Message has been sent';
            header('Location: index.php');
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            header('Location: index.php');
        }
    ?>