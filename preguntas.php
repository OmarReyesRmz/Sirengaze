<?php session_start(); ?>
<?php
    include 'header.php'
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Preguntas frecuentes</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        @font-face {
            font-family: 'Cormorant_Infant';
            src: url('/fonts/Cormorant_Infant/CormorantInfant-Light.ttf') format('truetype');
        }
        body {
            font-family: 'Cormorant_Infant', sans-serif;
            font-size:18px;
            /* display:flex;
            flex-direction:column; */
            /* display: grid;
            grid-template-columns: repeat(1, 1fr);
            grid-gap:0px; */
        }
        .pregunta{
            padding: 20px;
            border: 2px solid black;
            border-radius: 10px;
            font-size: 1.6rem;
            text-align: center;
            background-color: white;
            border:none;
            transition: .5s;
            border-collapse: collapse;
            margin: 20px;
        }
        .pregunta:hover{
            scale: 1.1;
            cursor: pointer
        }

        .pregunta a{
            text-decoration: none;
            color: black;
        }
        .respuesta{
            /* font-weight: 700; */
            display: none;
            /* background-color: #f8f9fa; */
            background-color:rgba(200, 163, 163, 0.171);
            padding: 20px;
            /* border: 2px solid black;
            border-radius: 10px; */
            font-size: 1.6rem;
            text-align: center;
            border-collapse: collapse;
            margin: 0 20px;
        }
        .respuesta:hover{
            cursor: pointer;
        }
        
    </style>
</head>
<body style="margin-top: 100px;">
<h1 style="text-align:center;">P r e g u n t a s&nbsp&nbsp   f r e c u e n t e s</h1>
<br>

<div class="pregunta"><p><i class="fa-solid fa-splotch" style="color:rgba(228, 158, 158, 0.356);font-size:15px;"></i> ¿Cuáles son las opciones de pago disponibles?</p></div>
<div class=" respuesta"><p>Aceptamos pagos con tarjeta de crédito, débito y PayPal.</p></div>
<div class="pregunta"><p><i class="fa-solid fa-splotch" style="color:rgba(228, 158, 158, 0.356);font-size:15px;"></i> ¿Cuánto tiempo tarda en llegar mi pedido?</p></div>
<div class=" respuesta"><p>Los tiempos de envío varían según la ubicación. Por lo general, toma entre 3 y 7 días laborables.</p></div>
<div class="pregunta"><p><i class="fa-solid fa-splotch" style="color:rgba(228, 158, 158, 0.356);font-size:15px;"></i> ¿Puedo devolver un artículo si no me queda bien?</p></div>
<div class=" respuesta"><p> Sí, aceptamos devoluciones dentro de los 30 días posteriores a la compra. Consulta nuestra política de devoluciones para más detalles.</p></div>
<div class="pregunta"><p><i class="fa-solid fa-splotch" style="color:rgba(228, 158, 158, 0.356);font-size:15px;"></i> ¿Cuánto tiempo tarda en llegar mi pedido?</p></div>
<div class=" respuesta"><p>El tiempo de entrega puede variar según tu ubicación y la disponibilidad de los productos. Normalmente, los pedidos se envían dentro de las 48 horas posteriores a la compra. Una vez enviado, el tiempo de entrega estimado es de X a Y días laborables.</p></div>
<div class="pregunta"><p><i class="fa-solid fa-splotch" style="color:rgba(228, 158, 158, 0.356);font-size:15px;"></i> ¿Ofrecen envíos internacionales?</p></div>
<div class=" respuesta"><p>Sí, enviamos a varios países. Los costos de envío y tiempos pueden variar.</p></div>
<div class="pregunta"><p><i class="fa-solid fa-splotch" style="color:rgba(228, 158, 158, 0.356);font-size:15px;"></i> ¿Cómo puedo realizar un seguimiento de mi pedido?</p></div>
<div class=" respuesta"><p>Una vez que tu pedido se envíe, recibirás un número de seguimiento por correo electrónico para rastrear tu paquete.</p></div>
<div class="pregunta"><p><i class="fa-solid fa-splotch" style="color:rgba(228, 158, 158, 0.356);font-size:15px;"></i> ¿Tienen tallas para niños?</p></div>
<div class=" respuesta"><p>Sí, contamos con una amplia gama de tallas para niños en nuestra colección.</p></div>
<div class="pregunta"><p><i class="fa-solid fa-splotch" style="color:rgba(228, 158, 158, 0.356);font-size:15px;"></i> ¿Los precios incluyen impuestos?</p></div>
<div class=" respuesta"><p> Sí, los precios mostrados incluyen los impuestos correspondientes.</p></div>
<div class="pregunta"><p><i class="fa-solid fa-splotch" style="color:rgba(228, 158, 158, 0.356);font-size:15px;"></i>  ¿Ofrecen descuentos para estudiantes?</p></div>
<div class=" respuesta"><p>Sí, ofrecemos descuentos especiales para estudiantes. Regístrate con tu correo estudiantil para obtener más detalles.</p></div>
<div class="pregunta"><p><i class="fa-solid fa-splotch" style="color:rgba(228, 158, 158, 0.356);font-size:15px;"></i> ¿Puedo cancelar mi pedido después de realizarlo?</p></div>
<div class=" respuesta"><p>Puedes cancelar tu pedido antes de que sea enviado. Ponte en contacto con nuestro equipo de soporte para asistencia.</p></div>


<script>
    document.addEventListener("DOMContentLoaded", function() {
        var preguntas = document.querySelectorAll('.pregunta');

        preguntas.forEach(function(pregunta) {
            pregunta.addEventListener('click', function() {
                var respuesta = this.nextElementSibling;
                if (respuesta.style.display === 'block') {
                    respuesta.style.display = 'none';
                } else {
                    respuesta.style.display = 'block';
                }
            });
        });
    });
</script>

 

<?php
    include 'footer.php'
?>

</body>

<!-- header
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script> -->

