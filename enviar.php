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

$nombre = $_POST['nombre'];
$email = $_POST['email'];
$mensaje = $_POST['mensaje'];
    
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
        $mail->addReplyTo($email, 'Nos pondremos en contacto con usted lo mas pronto posible');
    
    
        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = $nombre;
        $mail->Body = $mensaje;
        $mail->Body = "Nombre: $nombre <br> Email: $email <br> Mensaje: $mensaje <br> Atenderemos tu solicitud a la brevedad.";
    
        $mail->send();
        echo 'Message has been sent';
        header('Location: index.php');
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        header('Location: index.php');
    }
?>