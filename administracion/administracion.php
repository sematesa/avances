<?php
	session_start() ;

	if( isset($_SESSION['perfil']) && $_SESSION['perfil'] === 'ADMINISTRADOR' ) {
	
	include_once("../library/Usuario.php");
	include_once("../library/ConexionExterna.php");

	$usuario = new Usuario();
	$conexion_externa = new ConexionExterna();

	$array_contratos = $conexion_externa->getContratos();





		if(isset($_POST) && !empty($_POST) ){
		 $_POST['nombre'] = strtolower($_POST['nombre']) ;
		if(isset($_GET['accion'])){
			$usuario->update($_POST);
			$accion='';
			?>
			<script type="text/javascript">
				alert("Actualización exitosa");
				window.location="administracion.php";
			</script>
			<?php
		}
		else{
			$_POST['nombre'] = strtoupper($_POST['nombre']) ;
			if($_POST['password'] === $_POST['cpassword']){
				$usuario->insert($_POST);	
				?>
				<script type="text/javascript">
					alert("Inserción exitosa");
				</script>
			<?php
			}
			else{
				?>
				<script type="text/javascript">
					alert("Las contraseñas no coinciden");
				</script>
			<?php
			}
			
		}
	}






	if(isset($_GET['id_usuario'])){
		$usuario->loadById($_GET['id_usuario']);
		$id = $usuario->getId();
		$nombre = $usuario->getNombre();
		$perfil = $usuario->getPerfil();
		$compania = $usuario->getCompania();
		$password = $usuario->getPassword();
		$contrato = $usuario->getContrato();
		$clave_usuario = $usuario->getUsuario();
	}
	else{
		$id = '' ;
		$nombre = '' ;
		$perfil = '' ;
		$compania = '' ;
		$password = '' ;
		$contrato = '' ;
		$clave_usuario = '' ;
	}


?>


<!DOCTYPE html>
<!-- Website template by freewebsitetemplates.com -->
<html>
<head>
	<meta charset="UTF-8">
	<title>Servicios Marinos y Terrestres S. A. de C. V.</title>
	<link rel="stylesheet" href="../css/style.css" type="text/css">

		<link type="text/css" href="../css/tooltip/atooltip.css" rel="stylesheet"  media="screen" />

	<script type="text/javascript" src="../js/jquery.min.js"></script>
	<script type="text/javascript" src="../js/jquery.atooltip.js"></script>




	<script type="text/javascript">
			$(function(){ 
				$('a.normalTip').aToolTip();
			}); 

		function confirmation(a) {
			var answer = confirm("¿Desea borrar permanentemente el elemento? ");
			if (answer){
				 $.get("eliminar_u.php?id_usuario="+a);
				alert("Disciplina eliminada con éxito");
			}
		}

		</script>


</head>
<body>
	<div class="border">
		<div id="bg">
			background
		</div>
		<div class="page">
			<div class="sidebar">
				<a href="index.php" id="logo"><img src="../images/logo.png" alt="logo" with="120" height="120" style="float:right; margin:10px;"></a>

				<ul>
					<li>
						<a href="../index.php">Inicio</a>
					</li>
					<li>
						<a href="../captura/captura.php">Captura</a>
					</li>
					<li>
						<a href="portfolio.html">Presentación</a>
					</li>
					<li class="selected">
						<a href="administracion.php">Administración</a>
					</li>
					
				</ul>

				<div style="text-align:right; margin-right:30px; margin-top:20px;"><a href="../cerrar.php">Cerrar sesión</a></div>

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
					<h2>Registro de Usuarios</h2>
					
					<form method="post">
						
						<label for="nombre">Nombre</label>
						<input type="text" id="nombre" class="texto" name="nombre" value="<?php echo $nombre ; ?>">

						<label for="perfil">Perfil</label>
						<select class="opciones" id="perfil" name="perfil">
							<option value="OBSERVADOR">Diapositiva (Observador)</option>
							<option value="CAPTURA">Captura</option>
							<option value="ADMINISTRADOR">Administrador</option>
						</select>


						<label for="compania">Compañía</label>
						<select class="opciones" id="compania" name="compania">
							<option value="SMT">SMT</option>
							<option value="PEMEX">PEMEX</option>
						</select>


						<label for="usuario">Clave de Usuario</label>
						<input type="text" id="usuario" name="usuario" class="texto" value="<?php echo $clave_usuario ; ?>">


						<label for="password">Password</label>
						<input type="password" id="password" class="texto" name="password">

						<label for="cpassword">Confirmar Password</label>
						<input type="password" id="cpassword" name="cpassword" class="texto">

						


						<label for="contrato">Contrato</label>
						<select class="opciones" name="contrato" id="contrato" >
							<option value="*">TODOS</option>
							<?php 
							foreach ($array_contratos as $value) {
								if($contrato == $value['numero']){
									$sel = "selected='selected'";
								}
								else{
									$sel = '' ;
								}
								?>
								<option <?php echo $sel; ?> value="<?php echo $value['numero']; ?>" ><?php echo $value['numero']; ?></option>
								<?php
							}
							?>
						</select>




						
					
						<input type="submit" id="submit2" class="boton" value="Guardar">
					</form>

										<div class="tabla">

						<table class="tabla_contenido">
							<tr>
								<th colspan="5" style="background:#484848;">Usuarios</th>
							</tr>
							<tr>
								<th>Nombre</th>
								
								<th>Perfil</th>
								<th>Compañía</th>
								<th>Contrato</th>
								<th>Acciones</th>
							</tr>
							<?php
								
								$array_usuarios = $usuario->getAll();
							
								foreach ($array_usuarios as $value) {
									?>
										<tr>
											<td class="info"><?php echo $value['nombre']; ?></td>
											<td class="info"><?php echo $value['perfil']; ?></td>
											<td class="info"><?php echo $value['compania']; ?></td>
											<td class="info"><?php echo $value['contrato']; ?></td>

											
											<td class="acciones">
												<center>
												<div class="accion"><a class="normalTip" title="Editar" href="captura.php?id_usuario=<?php echo $value['id_usuario']; ?>&accion=ACTUALIZAR"><img src="../images/iconos/vcard_edit.png"></a></div>
												<div class="accion"><a class="normalTip" onclick="confirmation(<?php echo $value['id_usuario']; ?>);" title="Eliminar" href=""><img src="../images/iconos/delete.png"></a></div>
												</center>
											</td>
										</tr>
									<?php
								}
							?>
							
						</table>

						<!--  tabla de captura  -->

					</div>


				</div>
			</div>
		</div>
	</div>
</body>
</html>

<?php
	}
	else{
		?>
		<script type="text/javascript">
			alert("Acceso no permitido");
			window.location = "../index.php" ;
		</script>
	<?php
	}
?>