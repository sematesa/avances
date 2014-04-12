<?php
	session_start() ;

	//print_r($_SESSION) ;

	if( isset($_SESSION['perfil']) && ( $_SESSION['perfil'] === 'ADMINISTRADOR' || $_SESSION['perfil'] === 'CAPTURA' )  ) {

	
	include_once("../library/Area.php");
	include_once("../library/Disciplina.php");
	include_once("../library/ConexionExterna.php");
	include_once("../library/Ducto.php");
	include_once("../library/Ddv.php");


	$area = new Area();
	$disciplina = new Disciplina();
	$conexion_externa = new ConexionExterna ();
	$ducto = new Ducto();
	$ddv = new Ddv();

	$disciplina->loadById($_GET['id_disciplina']);
	$conexion_externa->loadByIdContrato($disciplina->getContrato());


	
	if(isset($_POST) && !empty($_POST) ){

		if($_POST['tipo'] == 'ducto'){
			$ducto->loadById($_POST['elemento_ducto']);
			$_POST['clasificacion']	 = $ducto->getTipoDucto();
			$_POST['nombre'] = $ducto->getNombre();
			$_POST['diametro'] = $ducto->getDiametro();
			$_POST['elemento'] = $ducto->getId();
			}
		else{
			$ddv->loadById($_POST['elemento_ddv']);
			$_POST['clasificacion'] = 'DDV' ;
			$_POST['nombre'] = $ddv->getNombre();
			$_POST['diametro'] = 0 ;
			$_POST['elemento'] = $ddv->getId();
		}



		$_POST['nombre'] = strtoupper($_POST['nombre']);
		if(isset($_GET['accion'])){
			$area->loadById($_GET['id_area']);
			rename("../files/".$conexion_externa->getNumero()."/".str_replace('Ñ', 'N', $disciplina->getNombre())."/".$area->getClasificacion()."-".str_replace('Ñ', 'N', $area->getNombre() ) ."-".$area->getDiametro(), "../files/".$conexion_externa->getNumero()."/".str_replace('Ñ', 'N', $disciplina->getNombre())."/".$_POST['clasificacion']."-".str_replace('Ñ', 'N', $_POST['nombre'] ) ."-".$_POST['diametro']) ;
			$area->update($_POST);
			?>
			<script type="text/javascript">
				alert("Actualización exitosa");
				window.location="area.php?id_disciplina=<?php echo $_GET['id_disciplina']; ?>";
			</script>
			<?php
		}
		else{
			$_POST['nombre']=str_replace('ñ', 'Ñ', $_POST['nombre']);
			$_POST['nombre'] = strtoupper($_POST['nombre']);


			$area->insert($_POST);	
			mkdir("../files/".$conexion_externa->getNumero()."/".str_replace('Ñ', 'N', $disciplina->getNombre())."/".$_POST['clasificacion']."-".str_replace('Ñ', 'N', $_POST['nombre'] ) ."-".$_POST['diametro']);
			?>
			<script type="text/javascript">
				alert("Inserción exitosa");
			</script>
			<?php
		}
	}



	if(isset($_GET['id_area'])){

		$area->loadById($_GET['id_area']);
		//echo $_GET['id_area'] ;
		$id_area = $area->getId();
		$nombre = $area->getNombre();
		$diametro = $area->getDiametro();
		$clasificacion = $area->getClasificacion();
		$elemento = $area->getElemento();
		$avance = $area->getAvance();
	}
	else{
		$id_area = '';
		$nombre = '';
		$diametro = '';
		$clasificacion = '';
		$elemento = '' ;
		$avance = '' ;
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
				 $.get("eliminar_area.php?id_area="+a);
				alert("Area eliminada con éxito");
			}
		}

		function muestra1(){
			document.getElementById("ductos").style.display='block';
			document.getElementById("ddvs").style.display='none';
		}

		function muestra2(){
			document.getElementById("ddvs").style.display='block';
			document.getElementById("ductos").style.display='none';
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
					<a href="#" class="selected">Areas</a>
					<a href="#">Referencias</a>
				</div>
				<div class="contact">
					<h2>Area</h2>
					
					<form method="POST">
						<input type="hidden" name="id_area" value="<?php echo $id_area; ?>" >
						<input type="hidden" name="id_disciplina" value="<?php echo $_GET['id_disciplina'] ; ?>">

						<label for="tipo_discontinuidad">Seleccione área</label>
						<br>

						<input type="radio" onclick="muestra1();" name="tipo" value="ducto" checked="checked"> Ductos
						<input type="radio" onclick="muestra2();" name="tipo" value="ddv" > DDV's

						
						<?php

						$ductos = $ducto->getAll();
						$ddvs = $ddv->getAll();

						?>

						<div id="ductos" style="display:block;">
						<select id="elemento_ducto" name="elemento_ducto" class="opciones">
							<?php
							foreach ($ductos as $value) {
								?>
								<option <?php if($elemento==$value['id_ducto']) echo "selected='selected' " ; ?> value="<?php echo $value['id_ducto']; ?>"><?php echo $value['tipo_ducto'] . " " . $value['diametro'] . " \"Ø " . $value['nombre'] ; ?></option>
								<?php
							}
							?>
						</select>
						</div>

						<div id="ddvs" style="display:none;">
						<select id="elemento_ddv" name="elemento_ddv" class="opciones">
							<?php
							foreach ($ddvs as $value) {
								?>
								<option <?php if($elemento==$value['id_ddv']) echo "selected='selected' " ; ?> value="<?php echo $value['id_ddv']; ?>"><?php echo "DDV " .  $value['nombre'] . " (Sector: " . $value['sector'] . " ) "; ?></option>
								<?php
							}
							?>
						</select>
						
						</div>
						
						<label for="avance">Avance</label>
						<input type="text" id="avance" name="avance" value="<?php echo $avance; ?>" class="texto" required >

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
									<?php echo $disciplina->getNombre() ; ?>
								</th>
							</tr>
							<tr>
								<th>Clasificación</th>
								<th>Diámetro</th>
								<th>Nombre</th>
								
								<th>Acciones</th>
							</tr>
							<?php
							$array_areas=$area->getByDisciplina($_GET['id_disciplina']);

							
								foreach ($array_areas as $value) {
									?>
										<tr>
											<td class="info"><?php echo $value['clasificacion']; ?></td>
											<td class="info_dia"><?php echo $value['diametro']; ?></td>
											<td class="info"><?php echo $value['nombre']; ?></td>
											
											
											<td class="acciones">
												<center>
												<div class="accion"><a class="normalTip" title="Editar" href="area.php?id_disciplina=<?php echo $_GET['id_disciplina']; ?>&id_area=<?php echo $value['id_area']; ?>&accion=ACTUALIZAR"><img src="../images/iconos/vcard_edit.png"></a></div>
												<div class="accion"><a class="normalTip" onclick="confirmation(<?php echo $value['id_area']; ?>);" title="Eliminar" href=""><img src="../images/iconos/delete.png"></a></div>
												<div class="accion"><a class="normalTip" title="Agregar Elementos" href="referencia.php?id_area=<?php echo $value['id_area']; ?>"><img src="../images/iconos/add.png"></a></div>
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