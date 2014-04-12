<?php
session_start() ;
	include_once("library/ConexionExterna.php");
	include_once("library/Usuario.php");

	$conexion_externa = new ConexionExterna();
	$usuario = new Usuario();

	$array_contratos = $conexion_externa->getContratos();



	if(!empty($_POST)){

		?>
		<script type="text/javascript">
		window.location = "presentacion/index.php?id_contrato=<?php echo $_POST['id_contrato']; ?>" ;
		</script>
		<?php

	}



?>


<!DOCTYPE html>
<!-- Website template by freewebsitetemplates.com -->
<html>
<head>
	<meta charset="UTF-8">
	<title>Servicios Marinos y Terrestres S. A. de C. V.</title>
	<link rel="stylesheet" href="css/style.css" type="text/css">


</head>
<body>
	<div class="border">
		<div id="bg">
			background
		</div>
		<div class="page">
			<div class="sidebar">
				<a href="#" id="logo"><img src="images/logo.png" alt="logo" with="200" height="200" style="float:right; margin:10px;"></a>

				
					<div style="text-align:right; margin-right:30px; margin-top:20px;"><a href="cerrar.php">Cerrar sesión</a></div>


				<div class="copy">
				
				<p>
					Copyright 2023
				</p>
				<p>
					Servicios Marinos y Terrestres S. A. de C. V.
				</p>
				</div>
			</div>
			<div class="body">
				
				<div class="contact">
					<center>
					<p>
						Sistema electrónico de presentación de avances de contratos.
					</p>
					<br>
					<br>
					<br>
					<br>

					<h2>Inicio de sesión</h2>
					
					<form method="POST">

						<label for="id_contrato">Contrato</label>
						<select class="opciones" name="id_contrato" id="id_contrato" >
							<?php 
							
							foreach ($array_contratos as $value) {
								if($_SESSION['contrato']=='*' || $_SESSION['contrato']==$value['numero']){
								?>
								<option  value="<?php echo $value['id_contrato']; ?>" ><?php echo $value['numero']; ?></option>
								<?php
							}
							}
							?>
						</select>
		
						
						<input type="submit" class="boton" value="Ir">
					</form>



					


					</center>
					<div class="tabla">


											<br>
					<br>
					<br>
										<br>
					<br>
					<br>
						<!--  tabla de captura  -->

					</div>
				</div>
				
			</div>
		</div>
	</div>
</body>
</html>