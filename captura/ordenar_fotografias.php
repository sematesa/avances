<?php



#
#LAS SENTENCIAS IF QUE EVALÚAN LA EXISTENCIA DE id_ducto 
#ES PARA VERIFICAR SI SE TRATA DE LA DISCIPLINA DE HALLAZGOS POR CELAJE
#EN LA DISCIPLINA HALLAZGOS POR CELAJE SE CONCATENA A LA URL EL id_ducto
#EN LAS DEMÁS SOLAMENTE SE ENVÍA EL id_referencia
#




	
	session_start() ;

	//print_r($_SESSION) ;

	if( isset($_SESSION['perfil']) && ( $_SESSION['perfil'] === 'ADMINISTRADOR' || $_SESSION['perfil'] === 'CAPTURA' )  ) {

	
	include_once("../library/Area.php");
	include_once("../library/Disciplina.php");
	include_once("../library/Referencia.php");
	include_once("../library/ConexionExterna.php");
	include_once("../library/FotografiaReparacion.php");
	include_once("../library/Indicaciones.php");
	include_once("../library/Ducto.php");
	include_once("../library/Ddv.php");

	$area = new Area();
	$fotografia_reparacion = new FotografiaReparacion();
	$disciplina = new Disciplina();
	$referencia =  new Referencia();
	$conexion_externa = new ConexionExterna ();
	$indicaciones = new Indicaciones();
	$ducto = new Ducto();
	$ddv = new Ddv();

	$referencia->loadById($_GET['id_referencia']);
	$area->loadById($referencia->getArea());
	$disciplina->loadById($area->getDisciplina());
	$conexion_externa->loadByIdContrato($disciplina->getContrato());


	if(isset($_POST) && !empty($_POST) ){
	//	print_r($_POST) ;

		foreach ($_POST as $key => $value) {
			$elemento = explode('-', $key) ;
		//	print_r($elemento) ;
		//	echo " -- " .$value. "<br><br>";

			switch ($elemento[0]) {
				case 'fotografia_reparacion':
					$fotografia_reparacion->updateLugar($value, $elemento[1]);
					break;
				
				case 'indicaciones':
					$indicaciones->updatePosicion($value, $elemento[1]);
					break;
			}


		}
		
/*
			$elemento = 1 ;
			$posicion = $fotografia_reparacion->getUltimoLugar($referencia->getId());
			$posicion2 = $indicaciones->getMaxLugar($referencia->getId()) ;

			if($posicion < $posicion2) {
				$posicion = $posicion2 ; 
			}*/
			
			
			?>
			<script type="text/javascript">
				alert("Actualización exitosa");
				window.location="ordenar_fotografias.php?id_referencia=<?php echo $_GET['id_referencia']; ?>";
			</script>
			<?php

	}



	if(isset($_GET['id_ducto'])){
		$ducto ->loadById($_GET['id_ducto']);
		$folder = str_replace('Ñ', 'N',"../files/".$conexion_externa->getNumero()."/".str_replace('Ñ', 'N', $disciplina->getNombre() )."/".str_replace('Ñ', 'N', $area->getClasificacion()."-".$area->getNombre()."-".$area->getDiametro())."/".str_replace('Ñ', 'N', $referencia->getDescripcion())."/".$ducto->getTipoDucto()."-".$ducto->getNombre()."-".$ducto->getDiametro() ) ;
	}
	else{
		$ducto->loadById($area->getElemento());
		$folder = str_replace('Ñ', 'N', "../files/".$conexion_externa->getNumero()."/".$disciplina->getNombre()."/".$area->getClasificacion()."-".$area->getNombre()."-".$area->getDiametro()."/".$referencia->getDescripcion() );
		
	//	print_r($fotografias_todas) ;

	}




	//echo $folder ;
	$fotografias = $fotografia_reparacion->getByReferencia($referencia->getId());
		$fotografias_ind = $indicaciones->getFotos($referencia->getId());
	//	print_r($fotografias_ind) ;
	//	print_r($fotografias) ;
	//	echo "<br><br>";

		$fotografias_todas = array_merge($fotografias_ind, $fotografias) ;
		asort($fotografias_todas) ;

	//	print_r($fotografias_todas) ;	
	set_time_limit(0);




	if(isset($_GET['id_referencia'])){

		$referencia->loadById($_GET['id_referencia']);
		$id_referencia = $referencia->getId();
		$descripcion = $referencia->getdescripcion();
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
					<a href="referencia.php?id_area=<?php echo $referencia->getArea(); ?>" >Referencias</a>
				</div>
				<div class="contact">
					<h2>Referencia</h2>
					
					<form method="POST" id="formulario_actualizar">

						<label for="id_ducto">Ducto</label>

								<input type="hidden" name="id_ducto" value="<?php echo $ducto->getId(); ?>">
								<input class="texto_d" disabled="disabled" type="text" name="nombre_ducto" value="<?php echo $ducto->getTipoDucto() . " " . $ducto->getDiametro() . " Ø " . $ducto->getNombre() ; ?>">
								<input class="texto_r" disabled="disabled" type="text" name="nombre_ducto" value="<?php echo $referencia->getDescripcion(); ?>">


						<div id="fotos_ordenar">
						
						
					
						<?php
							$ordenadas = array() ;
							foreach ($fotografias_todas as $value) {
								$ordenadas[$value['lugar']] = $value ;
							}
							ksort($ordenadas);

							foreach ($ordenadas as $value) {
								# code...
							
								?>

									<div class="foto">
										<img src="<?php echo $folder.'/'.$value['nombre'] ; ?>" height="225" width="250" >
										<select onchange="actualiza(this.id);" id="<?php echo $value['lugar']; ?>" class="opciones_foto"  name="<?php echo $value['tabla'].'-'.$value['id_fotografia_reparacion'] ?>" >
											<?php
											foreach ($ordenadas as $key ) {
												?>
												<option <?php echo ($key['lugar']==$value['lugar'] ) ? "selected='selected'" : "" ; ?> value="<?php echo $key['lugar'] ; ?>"><?php echo $key['lugar'] ; ?></option>
												<?php
											}
											if($value['tabla']=='fotografia_reparacion'){
												$a = 1;
											}
											else{
												$a = 2 ;
											}
											?>
										</select>
										<div class="accion2"><a class="normalTip" onclick="confirmationF(<?php echo $a.','.$value['id_fotografia_reparacion'] ?>);" title="Eliminar" href=""><img src="../images/iconos/delete.png"></a></div>
										
									</div>
								<?php
							}
						?>
						</div>
						
						<input type="submit" class="boton2" value="Guardar">
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
							$array_areas=$referencia->getByArea($referencia->getArea());

							
								foreach ($array_areas as $value) {
									?>
										<tr>
											<td class="info"><?php echo $value['descripcion']; ?></td>
											<td class="info"><?php echo $value['ubicacion']; ?></td>
											
											<td class="acciones">
												<center>
												
												<div class="accion"><a class="normalTip" onclick="confirmation(<?php echo $value['id_referencia']; ?>);" title="Eliminar" href=""><img src="../images/iconos/delete.png"></a></div>
												<div class="accion"><a class="normalTip" title="Agregar Indicaciones" href="indicaciones.php?id_referencia=<?php echo $value['id_referencia']; ?>"><img src="../images/iconos/add.png"></a></div>
												<div class="accion"><a class="normalTip" title="Agregar Fotografías" href="fotografias.php?id_referencia=<?php echo $value['id_referencia']; ?>"><img src="../images/iconos/image_add.png"></a></div>
												<?php
												$fotografias_rep = $fotografia_reparacion->getByReferencia($value['id_referencia']);
													if(!empty( $fotografias_rep)){
														?>
														<div class="accion"><a class="normalTip" title="Contiene Fotografías" href="#"><img src="../images/iconos/ok.png"></a></div>
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
	<script type="text/javascript">
		function actualiza(nuevo){
			//alert(document.getElementById(nuevo).value) ;
			var temp = document.getElementById(nuevo).value ;
			document.getElementById(temp).value = nuevo;
			document.getElementById(temp).setAttribute('id',0)
			document.getElementById(nuevo).setAttribute('id',temp)
			document.getElementById(0).setAttribute('id',nuevo);



			//alert(document.getElementById(temp).value) ;

			//document.getElementById(temp).value = 15 ;

		}

function confirmationF(a,b) {
			
			var answer = confirm("¿Desea borrar permanentemente la fotografía? ");
			if (answer){
				 $.get("eliminar_fotografia.php?elemento="+a+"&id="+b);
				alert("Fotografía eliminada con éxito");
			}
		}

		function confirmation(a) {
			var answer = confirm("¿Desea borrar permanentemente el elemento? ");
			if (answer){
				 $.get("eliminar_referencia.php?id_referencia="+a);
				alert("Referencia eliminada con éxito");
			}
		}


	</script>
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