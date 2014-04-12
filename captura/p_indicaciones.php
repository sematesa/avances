<?php
session_start() ;

	//print_r($_SESSION) ;

	if( isset($_SESSION['perfil']) && ( $_SESSION['perfil'] === 'ADMINISTRADOR' || $_SESSION['perfil'] === 'CAPTURA' )  ) {

	
	
	include_once("../library/Area.php");
	include_once("../library/Disciplina.php");
	include_once("../library/Referencia.php");
	include_once("../library/ConexionExterna.php");
	include_once("../library/Ducto.php");
	include_once("../library/Ddv.php");
	include_once("../library/DdvDucto.php");

	$area = new Area();
	$disciplina = new Disciplina();
	$referencia =  new Referencia();
	$conexion_externa = new ConexionExterna ();
	$ducto = new Ducto();
	$ddv = new Ddv();

	$referencia ->loadById($_GET['id_referencia']);
	$area->loadById($referencia->getArea());
	$disciplina->loadById($area->getDisciplina());
	$conexion_externa->loadByIdContrato($disciplina->getContrato());
	$ddv->loadById($area->getElemento());
	

	if($area->getClasificacion()!='DDV'){
		header("location: indicaciones.php?id_referencia=".$_GET['id_referencia']);
	}
	else{



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
					<a href="captura.php" >Disciplinas</a>
					<a href="area.php?id_disciplina=<?php echo $area->getDisciplina(); ?>">Areas</a>
					<a href="#" class="selected">Referencias</a>
				</div>
				<div class="contact">
					<h2>Referencia</h2>

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
								<th>Clasificación</th>
								<th>Nombre</th>
								<th>Diámetro</th>
								<th>Acciones</th>
							</tr>

					<?php
						//echo $area->getClasificacion();
						$ductos = $ducto->getForIndicaciones($ddv->getId());
						foreach ($ductos as $value) {
							//echo "../files/".$conexion_externa->getNumero()."/".str_replace('Ñ', 'N', $disciplina->getNombre() )."/".str_replace('Ñ', 'N', $area->getClasificacion()."-".$area->getNombre()."-".$area->getDiametro())."/".str_replace('Ñ', 'N', $referencia->getDescripcion())."/".$value['tipo_ducto']."-".str_replace('Ñ', 'N',$value['nombre'])."-".$value['diametro'];
							//echo "<br>";

							if( ! file_exists("../files/".$conexion_externa->getNumero()."/".str_replace('Ñ', 'N', $disciplina->getNombre() )."/".str_replace('Ñ', 'N', $area->getClasificacion()."-".$area->getNombre()."-".$area->getDiametro())."/".str_replace('Ñ', 'N', $referencia->getDescripcion())."/".$value['tipo_ducto']."-".str_replace('Ñ', 'N',$value['nombre'])."-".$value['diametro']) ){
								mkdir("../files/".$conexion_externa->getNumero()."/".str_replace('Ñ', 'N', $disciplina->getNombre() )."/".str_replace('Ñ', 'N', $area->getClasificacion()."-".$area->getNombre()."-".$area->getDiametro())."/".str_replace('Ñ', 'N', $referencia->getDescripcion())."/".$value['tipo_ducto']."-".str_replace('Ñ', 'N',$value['nombre'])."-".$value['diametro']);
							}

							?>
							<tr>
											<td class="info"><?php echo $value['tipo_ducto']; ?></td>
											<td class="info"><?php echo $value['nombre']; ?></td>
											<td class="info"><?php echo $value['diametro']; ?></td>
											
											<td class="acciones">
												<center>
												<div class="accion"><a class="normalTip" title="Agregar Indicaciones" href="indicaciones.php?id_referencia=<?php echo $_GET['id_referencia']; ?>&id_ducto=<?php echo $value['id']; ?>"><img src="../images/iconos/add.png"></a></div>
												<div class="accion"><a class="normalTip" title="Agregar Fotografías" href="fotografias.php?id_referencia=<?php echo $_GET['id_referencia']; ?>&id_ducto=<?php echo $value['id']; ?>"><img src="../images/iconos/image_add.png"></a></div>
												</center>
											</td>
										</tr>
							<?php

						}

		
					?>
					</table>
					</div>




										
							<?php
							$array_areas=$referencia->getByArea($area->getId());

							
								foreach ($array_areas as $value) {
									?>
										
									<?php
								}
							?>
							
						


						<!--  tabla de captura  -->

					

				</div>
				
			</div>
		</div>
	</div>
</body>
</html>

<?php
	}
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