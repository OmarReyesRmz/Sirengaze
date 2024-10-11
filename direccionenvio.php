<?php
session_start();
if (isset($_SESSION['carrito']) && count($_SESSION['carrito']) > 0) {
	$paisSeleccionado = $_SESSION['pais'];
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Dirección de envio</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
	<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
	<link rel="stylesheet" href="css/styt.css">
	<link rel="stylesheet" href="css/altas.css">
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<style>
  body{
    padding-top: 90px;
	font-family: 'Cormorant_Infant', sans-serif;
    font-size:20px;
  }
</style>
</head>

<body style="font-family: 'Cormorant_Infant', sans-serif; font-size:18px;">
		<?php include 'header.php'; ?>
		<div class="col-md-4 container bg-default">
			<h3><a href="desglosecompra.php">Resumen <i class="fa-solid fa-chevron-right" style="color: #000000; font-size:18px;"></i> </a> <a href="direccionenvio.php">Envio <i class="fa-solid fa-chevron-right" style="color: #000000; font-size:18px;"></i></a></h3>
			<h4 class="my-4">
					Dirección de envio
			</h4>
			<form >
				<div class="form-row">
					<div class="col-md-6 form-group">
						<label for="firstname">Nombre</label>
						<input type="text" class="form-control" id="firstname" placeholder="Nombre">
						<div class="invalid-feedback">
							El nombre es requerido.
						</div>
					</div>

					<div class="col-md-6 form-group">
						<label for="lastname">Apellido</label>
						<input type="text" class="form-control" id="lastname" placeholder="Apellido">
						<div class="invalid-feedback">
							El apellido es requerido
						</div>
					</div>
				</div>

				<div class="form-group">
					<label for="username">Usuario</label>
						<div class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text">@</span>
							</div>	
							<input type="text" class="form-control" id="username" placeholder="Usuario" required>
							<div class="invalid-feedback">
								El usuario es requerido.
							</div>
						</div>
				</div>

				<div class="form-group">
						<label for="email">Email</label>
						<input type="email" class="form-control" id="email" placeholder="you@example.com" required>
				</div>

				<div class="form-group">
					<label for="adress">Dirección</label>
					<input type="text" class="form-control" id="adress" placeholder="123, Juan Escutia" required>
					<div class="invalid-feedback">
						Ingresa tu dirección de envio.
					</div>
				</div>

				<div class="form-group">
					<label for="address2">Dirección 2
						<span class="text-muted">(Opcional)</span>
					</label>
					<input type="text" class="form-control" id="adress2" placeholder="123, Juan Barragan">
				</div>

				<div class="row">
            <div class="col-md-4 form-group">
			<label for="pais">País:</label>
			<input type="text" id="pais" name="pais" value="<?php echo htmlspecialchars($paisSeleccionado); ?>" disabled>
			<div class="invalid-feedback">
                    Seleccione un pais válido.
                </div>
            </div>

            <div class="col-md-4 form-group">
                <label for="Ciudad">Ciudad</label>
                <input type="text" class="form-control" id="Ciudad" placeholder="Ciudad" required>
                <div class="invalid-feedback">
                    Ingresa una ciudad válida.
                </div>
            </div>
            
            <div class="col-md-4 form-group">
                <label for="CodigoPostal">Código Postal</label>
                <input type="text" class="form-control" id="CodigoPostal" placeholder="Código postal" required>
                <div class="invalid-feedback">
                    Ingresa un código postal válido.
                </div>
            </div>
        </div>

				<div class="form-check">
					<input type="checkbox" class="form-check-input" id="shipping-adress"> 
            La dirección de envío es la misma que mi dirección de facturación.
					<label for="shipping-adress" class="form-check-label"></label>
				</div>

				<div class="form-check">
					<input type="checkbox" class="form-check-input" id="same-adress">
						Guardar información para futuras compras.
					<label for="same-adress" class="form-check-label"></label>					
					</div>
          <br>
		 	 <button id="btnContinuarPago" class="btn btn-dark bt-lg btn-block" type="button" onclick="validarFormulario()">Continuar al método de pago</button>

			</form>
		</div>
		<script>
            function validarFormulario() {
                var formularioCompleto = validarCampos();

                if (formularioCompleto) {
                    window.location.href = "datoscompra.php";
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Completa todos los campos del formulario.',
                    });
                }
            }

            function validarCampos() {
                var nombre = document.getElementById('firstname').value;
                var apellido = document.getElementById('lastname').value;
                var usuario = document.getElementById('username').value;
                var email = document.getElementById('email').value;
                var direccion = document.getElementById('adress').value;
                var ciudad = document.getElementById('Ciudad').value;
                var codigoPostal = document.getElementById('CodigoPostal').value;
                // Agrega más campos según sea necesario

                if (nombre && apellido && usuario && email && direccion && ciudad && codigoPostal) {
					$.ajax({
						type: 'POST',
						url: 'direccion.php', 
						data: { direccion: direccion},
						success: function (response) {
							console.log(response); 
						}
					});
                    return true;
                } else {
                    return false;
                }
            }
        </script>
	<?php include 'footer.php'; ?>
</body>
</html>