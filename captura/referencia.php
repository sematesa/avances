<?php
session_start() ;

	//print_r($_SESSION) ;

	if( isset($_SESSION['perfil']) && ( $_SESSION['perfil'] === 'ADMINISTRADOR' || $_SESSION['perfil'] === 'CAPTURA' )  ) {

	
	
	include_once("../library/Area.php");
	include_once("../library/Disciplina.php");
	include_once("../library/Referencia.php");
	include_once("../library/ConexionExterna.php");

	$area = new Area();
	$disciplina = new Disciplina();
	$referencia =  new Referencia();
	$conexion_externa = new ConexionExterna ();


	$area->loadById($_GET['id_area']);
	$disciplina->loadById($area->getDisciplina());
	$conexion_externa->loadByIdContrato($disciplina->getContrato());
	
	if(isset($_POST) && !empty($_POST) ){
		if(isset($_GET['accion'])){
			$referencia->loadById($_GET['id_referencia']);
			rename("../files/".$conexion_externa->getNumero()."/".str_replace('Ñ', 'N', $disciplina->getNombre() )."/".str_replace('Ñ', 'N', $area->getClasificacion()."-".$area->getNombre()."-".$area->getDiametro())."/".str_replace('Ñ', 'N', $referencia->getDescripcion()), "../files/".$conexion_externa->getNumero()."/".str_replace('Ñ', 'N', $disciplina->getNombre() )."/".str_replace('Ñ', 'N', $area->getClasificacion()."-".$area->getNombre()."-".$area->getDiametro())."/".str_replace('Ñ', 'N', $_POST['descripcion']));
			$referencia->update($_POST);
			?>
			<script type="text/javascript">
				alert("Actualización exitosa");
				window.location="referencia.php?id_area=<?php echo $_GET['id_area']; ?>";
			</script>
			<?php
		}
		else{
			$_POST['descripcion']=str_replace('ñ', 'Ñ', $_POST['descripcion']);
			$_POST['descripcion'] = strtoupper($_POST['descripcion']);
			$_POST['ubicacion'] = strtoupper($_POST['ubicacion']);
			$_POST['id_usuario'] = $_SESSION['id_usuario'] ;

			$referencia->insert($_POST);
			mkdir("../files/".$conexion_externa->getNumero()."/".str_replace('Ñ', 'N', $disciplina->getNombre() )."/".str_replace('Ñ', 'N', $area->getClasificacion()."-".$area->getNombre()."-".$area->getDiametro())."/".str_replace('Ñ', 'N', $_POST['descripcion']))	;
			?>
			<script type="text/javascript">
				alert("Inserción exitosa");
			</script>
			<?php
		}
	}



	if(isset($_GET['id_referencia'])){

		$referencia->loadById($_GET['id_referencia']);
		$id_referencia = $referencia->getId();
		$descripcion = $referencia->getDescripcion();
		$ubicacion = $referencia->getUbicacion();

		$id_area = $referencia->getArea();
	}
	else{
		$id_referencia = '' ;
		$descripcion = '';
		$ubicacion = '' ;
		$id_area = $_GET['id_area'] ;
	}

//	$array_areas = $conexion_externa->getAreas();


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
				 $.get("eliminar_referencia.php?id_referencia="+a);
				alert("Referencia eliminada con éxito");
			}
		}

		</script>

</head>
<body>
	<div class="border">
		<div id="bg">
			

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
					<a href="captura.php" >Disciplinas</a>
					<a href="area.php?id_disciplina=<?php echo $area->getDisciplina(); ?>">Areas</a>
					<a href="#" class="selected">Referencias</a>
				</div>
				<div class="contact">
					<h2>Referencia</h2>
					
					<form method="POST">
						<input type="hidden" name="id_referencia" value="<?php echo $id_referencia; ?>" >
						<input type="hidden" name="id_area" value="<?php echo $id_area ; ?>">

						<label for="descripcion">Descripción</label>
						<input type="text" id="descripcion" name="descripcion" value="<?php echo $descripcion; ?>" class="texto" required >

						<label for="ubicacion">Ubicación</label>
						<input type="text" id="ubicacion" name="ubicacion" value="<?php echo $ubicacion; ?>" class="texto"  >

						<label for="inspector">Inspector</label>
						<input type="text" id="inspector" name="inspector" value="<?php echo ''; ?>" class="texto"  >
						
						<input type="submit" class="boton" value="Guardar">
					</form>


										<div class="tabla">

						<table class="tabla_contenido">
							<tr>
								<th colspan="4" style="background:#484848;">
									<?php
									
										echo "Contrato: " . $conexion_externa->getNumero();
									?>
									<br>
									<?php echo $disciplina->getNombre() . " - " . $area->getNombre() ; ?>
								</th>
							</tr>
							<tr>
								<th>Descripción</th>
								<th>Ubicación</th>
								<th>Acciones</th>
							</tr>
							<?php
							$array_areas=$referencia->getByArea($_GET['id_area']);

							
								foreach ($array_areas as $value) {
									?>
										<tr >
											<td class="info"><?php echo $value['descripcion']; ?></td>
											<td class="info"><?php echo $value['ubicacion']; ?></td>
											
											<td class="acciones">
												<center>
												<div class="accion"><a class="normalTip" title="Editar" href="referencia.php?id_area=<?php echo $_GET['id_area']; ?>&id_referencia=<?php echo $value['id_referencia']; ?>&accion=ACTUALIZAR"><img src="../images/iconos/vcard_edit.png"></a></div>
												<div class="accion"><a class="normalTip" onclick="confirmation(<?php echo $value['id_referencia']; ?>);" title="Eliminar" href=""><img src="../images/iconos/delete.png"></a></div>
												<div class="accion"><a class="normalTip" title="Agregar Elementos" href="p_indicaciones.php?id_referencia=<?php echo $value['id_referencia']; ?>"><img src="../images/iconos/add.png"></a></div>
												<?php
												if($area->getClasificacion()!='DDV'){
													?>
													<div class="accion"><a class="normalTip" title="Agregar Fotografías" href="fotografias.php?id_referencia=<?php echo $value['id_referencia']; ?>"><img src="../images/iconos/image_add.png"></a></div>
													<div class="accion"><a class="normalTip" title="Ordenar Fotografías" href="ordenar_fotografias.php?id_referencia=<?php echo $value['id_referencia']; ?>"><img src="../images/iconos/refresh.png"></a></div>

													<?php
												}
												?>
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