<header>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
    <link rel="stylesheet" href="css/styt.css">
    <link rel="stylesheet" href="css/altas.css">
</header>
<?php session_start(); 

require 'header.php';
$total = $_SESSION['total'];
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8sh+WyZqBAYB1B/BKQxIepqXarGBjDAJ7f6dU6" crossorigin="anonymous">
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,700" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <title>Formulario de Tarjeta de Crédito</title>

</head>
<style>
        * 	 { margin: 0;padding: 0; }
        body { font-size: 14px; 
            background-color: #f4f4f4;
            padding-top: 90px;
        }

        h3 {
            margin-bottom: 10px;
            /* font-size: 15px; */
            /* font-weight: 600; */
            /* text-transform: uppercase; */
        }

        .opps {
            width: 496px; 
            border-radius: 4px;
            box-sizing: border-box;
            padding: 0 45px;
            margin: 40px auto;
            overflow: hidden;
            border: 1px solid #b0afb5;
            font-family: 'Open Sans', sans-serif;
            color: #4f5365;
        }

        .opps-reminder {
            position: relative;
            top: -1px;
            padding: 9px 0 10px;
            font-size: 11px;
            text-transform: uppercase;
            text-align: center;
            color: #ffffff;
            background: #000000;
        }

        .opps-info {
            margin-top: 26px;
            position: relative;
        }

        .opps-info:after {
            visibility: hidden;
            display: block;
            font-size: 0;
            content: " ";
            clear: both;
            height: 0;

        }

        .opps-brand {
            width: 45%;
            float: left;
        }

        .opps-brand img {
            max-width: 150px;
            margin-top: 2px;
        }

        .opps-ammount {
            width: 55%;
            float: right;
        }

        .opps-ammount h2 {
            font-size: 36px;
            color: #000000;
            line-height: 24px;
            margin-bottom: 15px;
        }

        .opps-ammount h2 sup {
            font-size: 16px;
            position: relative;
            top: -2px
        }

        .opps-ammount p {
            font-size: 10px;
            line-height: 14px;
        }

        .opps-reference {
            margin-top: 14px;
        }

        h1 {
            font-size: 27px;
            color: #000000;
            text-align: center;
            margin-top: -1px;
            padding: 6px 0 7px;
            border: 1px solid #b0afb5;
            border-radius: 4px;
            background: #f8f9fa;
        }

        .opps-instructions {
            margin: 32px -45px 0;
            padding: 32px 45px 45px;
            border-top: 1px solid #b0afb5;
            background: #f8f9fa;
        }

        ol {
            margin: 17px 0 0 16px;
        }

        li + li {
            margin-top: 10px;
            color: #000000;
        }

        a {
            color: #1155cc;
        }

        .opps-footnote {
            margin-top: 22px;
            padding: 22px 20 24px;
            color: #108f30;
            text-align: center;
            border: 1px solid #108f30;
            border-radius: 4px;
            background: #ffffff;
        }
        h3{
            text-align: center;
        }
        
</style>
<script>
        // Función para mostrar u ocultar los detalles de pago
        function togglePaymentDetails(option) {
            var cardDetails = document.getElementById('cardDetails');
            var cashDetails = document.getElementById('cashDetails');

            // Ocultar ambos detalles
            cardDetails.style.display = 'none';
            cashDetails.style.display = 'none';

            // Mostrar el detalle correspondiente a la opción seleccionada
            if (option === 'VISA' || option === 'BANCOMER') {
                $.ajax({
                    type: 'POST',
                    url: 'tarjeta.php', 
                    data: { option: option},
                    success: function (response) {
                        console.log(response); 
                    }
                });
                cardDetails.style.display = 'block';
            } else if (option === 'OXXO') {
                $.ajax({
                    type: 'POST',
                    url: 'tarjeta.php', 
                    data: { option: option},
                    success: function (response) {
                        console.log(response); 
                    }
                });
                cashDetails.style.display = 'block';
            }
        }
    </script>
<body style="font-family: 'Cormorant_Infant', sans-serif; font-size:18px;">
<?php require 'header.php';?>
<div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h3><a href="desglosecompra.php">Resumen <i class="fa-solid fa-chevron-right" style="color: #000000; font-size:18px;"></i> &nbsp</a> <a href="direccionenvio.php">Envio <i class="fa-solid fa-chevron-right" style="color: #000000; font-size:18px;"></i>&nbsp&nbsp</a><a href="datoscompra.php">Pago <i class="fa-solid fa-chevron-right" style="color: #000000; font-size:18px;"></i></a></h3>
                <h4 class="flex-grow mb-4">Selecciona tu metodo de Pago</h4>
                <form action="" onchange="togglePaymentDetails(this.pay.value)">
                    <div class="payment">
                        <div class="payment-select">
                                <div class="payment-select-logo">
                                    <i class="fa fa-money-check mr-1"></i> Crédito / Débito</span>
                                </div>
                                <div class="payment-select-header">
                                <div class="payment-select-radio">
                                    <input type="radio" id="debito" name="pay" value="VISA"> 
                                    <label for="debito">VISA</label>
                                </div>
                                <div class="payment-select-radio">
                                    <input type="radio" id="debito" name="pay" value="BANCOMER"> 
                                    <label for="debito">Bancomer</label>
                                </div>
                            </div>
                        </div>
                        <div class="payment-select">
                            <div class="payment-select-header">
                                <div class="payment-select-logo">
                                    <i class="fa fa-money-bill mr-1"></i> OXXO</span>
                                </div>
                                <div class="payment-select-radio">
                                    <input type="radio" id="credito" name="pay" value="OXXO"> 
                                    <label for="credito">Efectivo</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <form class="mx-auto" id="cardDetails" style="display: none;"  action="correo-ticket.php">
                <h4>Vas a pagar $<?php echo $total ?></h4>
                <div class="form-group">
                    <label for="nombre" class="my-2">Nombre Completo (en la Tarjeta)</label>
                    <input type="text" class="form-control" id="nombre" placeholder="Nombre Completo" required>
                </div>

                <div class="form-group">
                    <label for="numeroTarjeta" class="my-2">Número de Tarjeta</label>
                    <div class="d-flex align-items-center">
                        <input type="text" class="form-control" id="numeroTarjeta" placeholder="Número de Tarjeta" required>

                        <span class="input-group-text text-muted mx-2">
                            <i class="fa fa-cc-visa mx-1"></i>
                            <i class="fa fa-cc-amex mx-1"></i>
                            <i class="fa fa-cc-mastercard mx-1"></i>
                        </span>
                    </div>
                </div>

                <div class="form-row d-flex align-items-center">
                    <div class="form-group col-md-4">
                        <label for="expiracionMes" class="my-2">Mes de Expiración</label>
                        <input type="text" class="form-control" id="expiracionMes" placeholder="MM" required>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="expiracionAnio" class="my-2">Año de Expiración</label>
                        <input type="text" class="form-control" id="expiracionAnio" placeholder="AAAA" required>
                    </div>

                    <div class="form-group col-md-4">
                        <label data-toggle="tooltip" title="Codigo de 3 digitos en la parte de atras de tu tarjeta" class="my-2">
                            CCV <i class="fa fa-question-circle"></i>
                        </label>
                        <input type="text" class="form-control" id="ccv" placeholder="CCV" required>
                    </div>
                </div>
                <br>
                <button type="submit" class="btn btn-danger">Siguiente</button>
            </form>
        </div>
    </div>
</div>

	<body>
		<div class="opps">
        <form class="mx-auto" id="cashDetails" style="display: none;"  action="correo-ticket.php">
			<div class="opps-header">
				<div class="opps-reminder">Ficha digital. No es necesario imprimir.</div>
				<div class="opps-info">
					<div class="opps-brand"><img src="imagenes/oxxopay.png" alt="OXXOPay"></div>
					<div class="opps-ammount">
						<h3>Monto a pagar</h3>
						<h2>$<?php echo $total ?><sup>MXN</sup></h2>
						<p>OXXO cobrará una comisión adicional al momento de realizar el pago.</p>
					</div>
				</div>
				<div class="opps-reference">
					<h3>Referencia</h3>
					<h1>9300-2821-2679-07</h1>
				</div>
			</div>
			<div class="opps-instructions">
				<h3>Instrucciones</h3>
				<ol>
					<li>Ve al OXXO e indica al cajero que realizarás un pago en efectivo con <strong>OXXO PAY.</strong></li>
					<li>Proporciona tu número de referencia de pago y verifica que la información en pantalla sea correcta.</li>
					<li>Realiza tu pago en efectivo.</li>
					<li>Sirengaze te enviará un correo electrónico con la confirmación de pago.</li>
					<li>Al confirmar tu pago, el cajero te entregará un comprobante impreso. <strong>En el podrás verificar que se haya realizado correctamente.</strong> Conserva este comprobante de pago.</li>
				</ol>
				<div class="opps-footnote">Al completar estos pasos recibirás un correo de <strong>Sirenegaze</strong> confirmando tu pago.</div>
                <br>
                <button type="submit" class="btn btn-danger">Confirmar Pago en efectivo</button>
			</div>
            </form>
		</div>


<?php include 'footer.php'; ?>

</body>
</html>

