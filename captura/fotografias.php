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

	
	set_time_limit(0);

	if(isset($_POST) && !empty($_POST) ){
		if(isset($_GET['accion'])){
			$referencia->update($_POST);
			?>
			<script type="text/javascript">
				alert("Actualización exitosa");
				window.location="referencia.php?id_area=<?php echo $_GET['id_area']; ?>";
			</script>
			<?php
		}
		else{
		

			$elemento = 1 ;
			$posicion = $fotografia_reparacion->getUltimoLugar($referencia->getId());
			$posicion2 = $indicaciones->getMaxLugar($referencia->getId()) ;
			if($posicion < $posicion2) {
				$posicion = $posicion2 ;
			}
			//print_r($_FILES);
			$exito = 1 ;
			foreach ($_FILES as $value) {
				if($value['error'] != 4 ){
				$posicion ++ ;
				$_POST['nombre'] = 'TEMP_NAME' ;
				$_POST['ruta'] = $folder ;
				$_POST['lugar'] = $posicion ;
				$_POST['comentario'] = $_POST['comentario_'.$elemento] ;

				

				$name = $posicion.'.jpg' ;

				 if (move_uploaded_file($value['tmp_name'], $folder.'/'.$name) ){
					$id_insert = $fotografia_reparacion->insert($_POST);
					$fotografia_reparacion->updateNombre($name, $id_insert);
					include("ejecutar.php") ;
				}
				else{
					$exito = 0 ;
				}
				$elemento ++ ;
		
			}
		}	
		if($exito == 1){
			?>
			<script type="text/javascript">
				alert("Inserción exitosa");
			</script>
			<?php
		}
		else{
			?>
			<script type="text/javascript">
				alert("Ha ocurrido un error al intentar esta operación");
			</script>
			<?php
		}
		}
	}



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

	var campos = 1 ;

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


		function agregarCampo(){
			
			campos = campos + 1 ;
			var nuevo = document.createElement("div");
			nuevo.id = "divcampo_"+(campos);
			nuevo .innerHTML = 
			" <label for='fotografia_"+(campos)+"'>Fotografia "+(campos)+"</label>" +
			" <input type='file' id='fotografia_"+(campos)+"' name='fotografia_"+(campos)+"' class='texto' > " + 
			" <label for='comentario_"+(campos)+"'>Comentario "+(campos)+"</label>" +
			" <textarea name='comentario_"+(campos)+"' id='comentario_"+(campos)+"' ></textarea>" ;
			var contenedor = document.getElementById("campos_fotografias") ;
			contenedor.appendChild(nuevo) ;
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
					<a href="referencia.php?id_area=<?php echo $referencia->getArea(); ?>" >Referencias</a>
				</div>
				<div class="contact">
					<h2>Referencia</h2>
					
					<form method="POST" enctype="multipart/form-data">





						<input type="hidden" name="id_referencia" value="<?php echo $id_referencia; ?>" >
						<input type="hidden" name="id_area" value="<?php echo $id_area ; ?>">


						<label for="id_ducto">Ducto</label>

								<input type="hidden" name="id_ducto" value="<?php echo $ducto->getId(); ?>">
								<input class="texto_d" disabled="disabled" type="text" name="nombre_ducto" value="<?php echo $ducto->getTipoDucto() . " " . $ducto->getDiametro() . " Ø " . $ducto->getNombre() ; ?>">
								<input class="texto_r" disabled="disabled" type="text" name="nombre_ducto" value="<?php echo $referencia->getDescripcion(); ?>">

						<label for="fotografia">Fotografia</label>
						<input type="file" id="fotografia" name="fotografia_1" value="<?php echo ''; ?>" class="texto" >

						<label for="comentario">Comentario</label>
						<textarea id="comentario" name="comentario_1"></textarea>

						<div id="campos_fotografias"></div>
						<br>
						<a href="JavaScript:agregarCampo();">Agregar otra fotografía</a>


						<input type="submit" class="boton" value="Guardar">
					</form>
					<div id="fotos_ordenar">
						
						<?php

						//	var_dump($fotografias_todas) ;

						?>
					</div>


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
												<div class="accion"><a class="normalTip" title="Ordenar Fotografías" href="ordenar_fotografias.php?id_referencia=<?php echo $value['id_referencia']; ?>"><img src="../images/iconos/refresh.png"></a></div>
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