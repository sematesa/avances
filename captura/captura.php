<?php
	session_start() ;

	//print_r($_SESSION) ;

	if( isset($_SESSION['perfil']) && ( $_SESSION['perfil'] === 'ADMINISTRADOR' || $_SESSION['perfil'] === 'CAPTURA' )  ) {
	
	include_once("../library/Disciplina.php");
	include_once("../library/ConexionExterna.php");

	$disciplina = new Disciplina();
	$conexion_externa = new ConexionExterna ();



	
	if(isset($_POST) && !empty($_POST) ){
		 $_POST['nombre'] = strtoupper($_POST['nombre']) ;
		 $conexion_externa->loadByIdContrato($_POST['id_contrato']);
		if(isset($_GET['accion'])){
			//mkdir("../files/".$conexion_externa->getNumero()."/". str_replace('Ñ', 'N', $_POST['nombre'])) ;
			//fileperms("../files/".$conexion_externa->getNumero()."/". str_replace('Ñ', 'N', $_POST['oldname']));
			rename( "../files/".$conexion_externa->getNumero()."/".$_POST['oldname'] ,"../files/".$conexion_externa->getNumero()."/". str_replace('Ñ', 'N', $_POST['nombre']) ) ;
			$disciplina->update($_POST);
			$accion='';
			?>
			<script type="text/javascript">
				alert("Actualización exitosa");
				window.location="captura.php";
			</script>
			<?php
		}
		else{
			$_POST['nombre']=str_replace('ñ', 'Ñ', $_POST['nombre']);
			//echo $_POST['nombre'] ;
			$_POST['nombre'] = strtoupper($_POST['nombre']) ;
			$disciplina->insert($_POST);	
			

			mkdir("../files/".$conexion_externa->getNumero()."/". str_replace('Ñ', 'N', $_POST['nombre']) ) ;
			?>
			<script type="text/javascript">
				alert("Inserción exitosa");
			</script>
			<?php
		}
	}



	if(isset($_GET['id_disciplina'])){

		$disciplina->loadById($_GET['id_disciplina']);
		$id_disciplina = $disciplina->getId();
		$nombre = $disciplina->getNombre();
		$id_contrato = $disciplina->getContrato();
	}
	else{
		$id_disciplina = '' ;
		$nombre = '';
		$id_contrato = '' ;
	}

	$array_contratos = $conexion_externa->getContratos();

	foreach ($array_contratos as $value) {
		if(!file_exists('../files/'.$value['numero'])){
			mkdir('../files/'.$value['numero']) ;
		}
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
				 $.get("eliminar.php?id_disciplina="+a);
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
				<a href="../index.php" id="logo"><img src="../images/logo.png" alt="logo" with="120" height="120" style="float:right; margin:10px;"></a>

				<ul>
					<li>
						<a href="../index.php">Inicio</a>
					</li>

					<li class="selected">
						<a href="captura.php">Captura</a>
					</li>

					<li>
						<a href="../administracion/administracion.php">Administración</a>
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
				<div class="submenu" >
					<a href="captura.php" class="selected">Disciplinas</a>
					<a href="#">Areas</a>
					<a href="#">Referencias</a>
				</div>
				<div class="contact">
					<h2>Disciplina</h2>
					
					<form method="POST">
						<input type="hidden" name="id_disciplina" value="<?php echo $id_disciplina; ?>" >
						<input type="hidden" name="id_contrato" value="<?php echo $id_contrato ; ?>">

						<input type="hidden" name="oldname" value="<?php echo $nombre; ?>">

						<label for="nombre">Nombre</label>
						<input type="text" id="nombre" name="nombre" value="<?php echo $nombre; ?>" class="texto" required >

						<label for="id_contrato">Contrato</label>
						<select class="opciones" name="id_contrato" id="id_contrato" >
							<?php 
							foreach ($array_contratos as $value) {
								if($id_contrato == $value['id_contrato']){
									$sel = "selected='selected'";
								}
								else{
									$sel = '' ;
								}
								?>
								<option <?php echo $sel; ?> value="<?php echo $value['id_contrato']; ?>" ><?php echo $value['numero']; ?></option>
								<?php
							}
							?>
						</select>
						
						<input type="submit" class="boton" value="Guardar">
					</form>
					<div class="tabla">


						<?php
							//print_r(json_encode($array_contratos));


							foreach ($array_contratos as $value) {
								$array_disciplinas = $disciplina->getByContratos($value['id_contrato']);


								?>
						
						<table class="tabla_contenido">
							<tr>
								<th colspan="2" style="background:#484848;"><?php echo 'CONTRATO: ' . $value['numero']; ?></th>
							</tr>
							<tr>
								<th>Disciplina</th>
								
								<th>Acciones</th>
							</tr>
							<?php
						//	$array_disciplinas=$disciplina->getGroupContratos();
							
								foreach ($array_disciplinas as $value) {
									?>
										<tr>
											<td class="info"><?php echo $value['nombre']; ?></td>
											
											<td class="acciones">
												<center>
												<div class="accion"><a class="normalTip" title="Editar" href="captura.php?id_disciplina=<?php echo $value['id_disciplina']; ?>&accion=ACTUALIZAR"><img src="../images/iconos/vcard_edit.png"></a></div>
												<div class="accion"><a class="normalTip" onclick="confirmation(<?php echo $value['id_disciplina']; ?>);" title="Eliminar" href=""><img src="../images/iconos/delete.png"></a></div>
												<div class="accion"><a class="normalTip" title="Agregar Elementos" href="area.php?id_disciplina=<?php echo $value['id_disciplina']; ?>"><img src="../images/iconos/add.png"></a></div>
												</center>
											</td>
										</tr>
									<?php
								}
							?>
							
						</table>
						<?php

							}


						?>

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