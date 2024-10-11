<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
session_start();
$carrito = $_SESSION['carrito'];
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sirenegaze";
$tabla = "inventario";
$total = 0;
$precio_final = 0;

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/Exception.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

$nombre = "aaron";
$cuenta = $_SESSION["cuenta"];

$query = "SELECT email FROM usuarios WHERE cuenta = '$cuenta'";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $email = $row["email"]; // Obtener el correo de la fila obtenida
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
        $mail->addReplyTo($email, 'Detalles');
    
        $mail->CharSet = 'UTF-8';
        $mail->Encoding = 'base64'; // Opcional: establece la codificación a base64 para datos no ASCII
        
        
        $mail->Body =
         '<html>
            <head>
                <meta http-equiv="Content-Type" content="text/html;
                 charset=UTF-8">
                 <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
                <style>
                        .carrito{
                            margin: 150px;
                        }
                        
                        .prod{
                            margin-top: 50px;
                            font-size: 20px;
                            font-family: "Cormorant_Infant", sans-serif;
                            /* border-collapse: separate;
                            border-spacing: 40px;  */
                        }
                        
                        .can{
                            text-align: center;
                            padding: 15px;
                        }
                        
                        .titulo{
                            font-family: "Big_Sholuders_Inline_Text", sans-serif;
                            text-align: center;
                        }
                        
                        .img_carrito{
                            width: 150px;
                            height: 200px;
                        }
                        
                        .img_detalles{
                            width: 100px;
                            height: 135px;
                        }
                        
                        button{
                            border: none;
                            background-color: white;
                        }
                        
                        button:hover{
                            background-color: none;
                        }
                        
                        .vacio{
                            width: 400px;
                        }
                        
                        .carrito_vacio{
                            display: grid;
                            grid-template-columns: 30% 50%;
                            place-items: center;
                            justify-content: space-evenly;
                            font-family: "Cormorant_Infant";
                            font-size: 30px;
                        }
                                            
                        .editar-button{
                            padding: 15px 150px;
                            margin-top: 50px;
                            text-decoration: none;
                            border: none;
                            background-color: #7e7e7e8b !important;
                            border-radius: 5px;
                            font-weight: 600;
                        }
                        
                        .editar-button:hover{
                            background-color: #313131ab !important;
                            color: white;
                            font-weight: 600;
                        }
                        .marca{
                            display: flex;
                            justify-content: center;
                            align-items: center;
                            font-family: "Courier New", Courier, monospace;
                        }
                      
                 </style>
                 </head>
                 <body>';
        $emailContent = 
        '<h1>ticket</h1>
        <div class="marca">
            <h2>S I R E N G A Z E</h2>
        </div>';
        $emailContent .= '<p>' . date("d/m/Y H:i:s") . '</p>
        <br>
        <hr>';        
        $emailContent .='<div class="marca"> <table  class="table table-borderless table-hover prod">
            <thead>
                <tr>
                    <th class="px-3 can">Imagen</th>
                    <th class="px-3 can">Producto</th>
                    <th class="px-3 can">Precio</th>
                    <th class="px-3 can">Cantidad</th>
                    <th class="px-3 can">Subtotal</th>
                </tr>
            </thead>
            <tbody>';
            foreach ($carrito as $productoId => $detallesProducto) {
                if ($detallesProducto['cantidad'] != 0) {
                    $query = "SELECT * FROM $tabla WHERE Id_producto = $productoId";
                    $result = $conn->query($query);
            
                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        $emailContent .= '<tr>';
                        $emailContent .= '<td  class="align-middle px-4 can"><img src="cid:imagen' . $productoId . '" alt="imagen_producto_' . $productoId . '" style="width: 100px; height: 130px;"></td>';
                        $imagePath = 'imagenes/' . $row['imagen']; // Ruta de la imagen que deseas adjuntar
                        $imagenNombre = 'imagen' . $productoId; // Nombre único para cada imagen
                        $mail->AddEmbeddedImage($imagePath, $imagenNombre, $row['imagen']); 
                        $emailContent .= '<td  class="align-middle px-4 can">' . $row['nombre'] . '</td>';
                        // $emailContent .= '<td  class="align-middle px-4">' . $row['descripcion'] . '</td>';
                        if ($row['descuento'] != 0) {
                            $precio_final = ($row['precio'] - $row['precio'] * $row['descuento'] / 100);
                            $emailContent .= '<td class="align-middle px-4 can" style="color:red";> $' . $precio_final . '</td>';
                        } else {
                            $precio_final = $row['precio'];
                            $emailContent .= '<td class="align-middle px-4 can"> $' . $precio_final . '</td>';
                        }
                        $emailContent .= '<td class="align-middle px-4 can">' . $detallesProducto['cantidad'] . '</td>';
                        $subtotal = $precio_final * $detallesProducto['cantidad'];
                        $emailContent .= '<td class="align-middle px-4 can"> $' . $subtotal . '</td>';
                        $emailContent .= '</tr>';
                        $total += $subtotal;
                    }
                }
            }
            $emailContent .= '<tr>';
            $emailContent .= '<td colspan="4" style="text-align:center;">P&nbsp A &nbsp G&nbsp O:</td>';
            $emailContent .= '<td style="text-align:center;">' . (isset($_SESSION["tarjeta"]) ? $_SESSION["tarjeta"] : "") . '</td>';
            $emailContent .= '</tr>';
            $emailContent .= '<tr>';
            $emailContent .= '<td colspan="4" style="text-align:center;">D&nbsp E &nbspS&nbsp C&nbsp U&nbsp E&nbsp N&nbsp T&nbspO:</td>';
            $emailContent .= '<td  style="text-align:center;">' . (isset($_SESSION["descuento"]) ? $_SESSION["descuento"] : "0") . '</td>';
            $emailContent .= '</tr>';
            $emailContent .= '<tr>';
            $emailContent .= '<td colspan="4" style="text-align:center;">E&nbsp N &nbsp V&nbsp I&nbsp O:</td>';
            $emailContent .= '<td  style="text-align:center;">' . (isset($_SESSION["gastosEnvio"]) ? $_SESSION["gastosEnvio"] : "") . '</td>';
            $emailContent .= '</tr>';
            $emailContent .= '<tr>';
            $emailContent .= '<td colspan="4" style="text-align:center;">I&nbsp V &nbsp A:</td>';
            $emailContent .= '<td  style="text-align:center;">' . (isset($_SESSION["impuestos"]) ? $_SESSION["impuestos"] : "") . '</td>';
            $emailContent .= '</tr>';
            
            $emailContent .= '<tr>';
            $emailContent .= '<td colspan="4" style="text-align:center;">T&nbsp O &nbspT&nbsp A&nbsp L:</td>';
            $emailContent .= '<td  style="text-align:center;">' . (isset($_SESSION["total"]) ? $_SESSION["total"] : "") . '</td>';
            $emailContent .= '</tr>';
            // $emailContetn .= '<tr>
            //             <td>Dirreccion de envio:</td>
            //             <td>' .  (isset($_SESSION["direccion"]) ? $_SESSION["direccion"] : "") . '</td>
            //         </tr>
            //         <tr>
            //             <td>Tipo de pago:</td>
            //             <td>' . (isset($_SESSION["tarjeta"]) ? $_SESSION["tarjeta"] : "") . '</td>
            //         </tr>
            //         <tr>
            //             <td>Descuento:</td>
            //             <td>' . (isset($_SESSION["descuento"]) ? $_SESSION["descuento"] : "0") . '</td>
            //         </tr>
            //         <tr>
            //             <td>Envio:</td>
            //             <td>' . (isset($_SESSION["gastosEnvio"]) ? $_SESSION["gastosEnvio"] : "") . '</td>
            //         </tr>
            //         <tr>
            //             <td>IVA:</td>
            //             <td>' . (isset($_SESSION["impuestos"]) ? $_SESSION["impuestos"] : "") . '</td>
            //         </tr>
            //         <tr>
            //             <td>TOTAL</td>
            //             <td>' . (isset($_SESSION["total"]) ? $_SESSION["total"] : "") . '</td>
            //         </tr>';
            
            $emailContent .= '</tbody></table><hr></div>';
            $imagePath = 'imagenes/log.jpg';
            $mail->AddEmbeddedImage($imagePath, 'logo');
            $emailContent .=   '<div class="marca">
                                    <p>GRACIAS POR SU COMPRA </p>
                                    <img src="cid:logo" alt="" width="100" height="130">
                                    <h4 >WWW.SIRENGAZE.COM</h4>
                                </div>';
            $mail->isHTML(true);
            $mail->Subject = $nombre;
            $mail->Body .= $emailContent; // Tu contenido HTML aquí
            $mail->Body .= '</body></html>';
    

        $mail->send();
        echo '<script>
        Swal.fire({
            icon: "success",
            title: "Message has been sent",
            showConfirmButton: false,
            timer: 1500
        }).then(function() {
            window.location.href = "ticket.php";
        });
    </script>';
    
        header('Location: venta.php');
    } catch (Exception $e) {
        header('Location: index.php');
    }
?>