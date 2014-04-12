<?php
session_start();
	
	include_once("../library/ConexionExterna.php");
	include_once("../library/Disciplina.php");
	include_once("../library/Area.php");
	include_once("../library/Referencia.php");
	include_once("../library/Indicaciones.php");
	include_once("../library/FotografiaReparacion.php");
	include_once("../library/Ducto.php");


	$conexion_externa = new ConexionExterna();
	$disciplina = new Disciplina();
	$area = new Area() ;
	$referencia = new Referencia();
	$indicacion = new Indicaciones();
	$fotografia_reparacion = new FotografiaReparacion();
	$ducto = new Ducto();


	$referencia->loadById($_GET['id_referencia']);
	$area->loadById($referencia->getArea());
	$disciplina->loadById($area->getDisciplina());

	$referencias = $referencia->getByArea($area->getId());
	$disciplina->loadById($area->getDisciplina());
	$conexion_externa->loadByIdContrato($disciplina->getContrato());

	if(isset($_GET['id_ducto'])){
		$ducto->loadById($_GET['id_ducto']);
		$indicaciones_t = $indicacion->getByReferenciaDdv($referencia->getId(), $_GET['id_ducto']);
		$fotografias_rep = $fotografia_reparacion->getByReferenciadDV($referencia->getId(), $_GET['id_ducto']);
		$fotos = $indicacion->getFotosDdv($referencia->getId(), $_GET['id_ducto']);


$ruta = str_replace('Ñ', 'N', "../files/".$conexion_externa->getNumero()."/".$disciplina->getNombre()."/".$area->getClasificacion()."-".$area->getNombre()."-".$area->getDiametro()."/".$referencia->getDescripcion()."/". $ducto->getTipoDucto()."-".$ducto->getNombre()."-".$ducto->getDiametro());

	}
	else{
		$indicaciones_t = $indicacion->getByReferencia($referencia->getId());
		$fotografias_rep = $fotografia_reparacion->getByReferencia($referencia->getId());
		$fotos = $indicacion->getFotos($referencia->getId());	
		$ruta = str_replace('Ñ', 'N', "../files/".$conexion_externa->getNumero()."/".$disciplina->getNombre()."/".$area->getClasificacion()."-".$area->getNombre()."-".$area->getDiametro()."/".$referencia->getDescripcion() );
	}

	
	//$ruta = $fotografias_rep[0]['ruta'] ;


	
	//echo $ruta ;
	$fotografias = array_merge($fotografias_rep,$fotos) ;

	
						//	print_r($fotografias_todas) ;

							$ordenadas = array() ;
							foreach ($fotografias as $value) {
								$ordenadas[$value['lugar']] = $value ;
						//		echo "<br><br>" .$value['lugar'] ;
						//		print_r($value) ;
							}
						//	echo "<br><br>" ;
							ksort($ordenadas);
							$fotografias = $ordenadas ;
						//	print_r($ordenadas) ;


							
						


	//print_r($fotografias);
	//print_r($fotografias) ;
	//echo "<br><br><br>" ;
	//print_r($fotos) ;
//	echo $indicaciones_t[0]['elemento'] ;
	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">


		<title>Servicios Marinos y Terrestres S. A. de C. V.</title>
		<link rel="Stylesheet" type="text/css" href="css/<?php echo $conexion_externa->getNumero(); ?>/style.css">

		<script type="text/javascript" src="../js/yoxview-init.js"></script>
		<link rel="Stylesheet" type="text/css" href="../js/yoxview.css">
		<script type="text/javascript" src="../js/jquery.min.js"></script>
		<script type="text/javascript" src="../js/jquery.yoxview-2.2.min.js"></script>

		<script type="text/javascript">
		    $(document).ready(function(){
		        $(".yoxview").yoxview();
		    });

		    function siguiente(actual){
		    	for(var i = 1; i <=document.getElementById("totales").value; i++){
		    		if(i!=actual+1){
		    			document.getElementById("alb_"+i).style.display="none";
		    		}
		    	}
		    	document.getElementById("alb_"+(actual+1)).style.display="block";
		    }

		    function anterior(actual){
		    	for(var i = 1; i <=document.getElementById("totales").value; i++){
		    		if(i!=actual-1){
		    			document.getElementById("alb_"+i).style.display="none";
		    		}
		    	}
		    	document.getElementById("alb_"+(actual-1)).style.display="block";
		    }

		</script>

	</head>

	<body>
		<div>







<!--
	
	INICIO DEL CUERPO EDITABLE PARA LA PRESENTACION
	
-->

	<div id="contenedor_general">

		<div id="encabezado_down">
		<div id="encabezado">
			<div id="titulo_ta">
				<center>
			REGISTRO FOTOGRÁFICO
			<br>
			<?php echo $area->getClasificacion() . " ". $area->getDiametro() ." \"Ø " . $area->getNombre(); ?>
			<br>
			<?php echo $referencia->getDescripcion(); ?>
			</center>
			</div>
		</div>
		</div>
		<div id="lateral_izquierda"></div>

		<div id="container">


						<div id="submenu">
				<table id="tabla_submenu">
					<tr>
						<td><a href="disciplinas.php?id_contrato=<?php echo $disciplina->getContrato(); ?>"> < Disciplinas </a></td>
						<td><a href="areas.php?id_disciplina=<?php echo $disciplina->getId(); ?>"> < Lineas </a></td>
						<td><a href="referencias.php?id_area=<?php echo $area->getId(); ?>"> < Referencias </a></td>
						<?php
						if(isset($_GET['id_ducto'])){
							?>
							<td><a href="tratar.php?id_referencia=<?php echo $_GET['id_referencia']; ?>"> < Ductos </a></td>
							<?php
						}
						?>
						<?php
						if(!empty($indicaciones_t)){
							if(isset($_GET['id_ducto'])){

						?>
							<td><a href="indicaciones.php?id_referencia=<?php echo $referencia->getId(); ?>&id_ducto=<?php echo $_GET['id_ducto']; ?>"> < Registro de Indicaciones </a></td>
						<?php
						}
						else{
							?>
							<td><a href="indicaciones.php?id_referencia=<?php echo $referencia->getId(); ?>"> < Registro de Indicaciones </a></td>
						<?php
						}
						}
						?>
					</tr>
				</table>
			</div>


		<!--	<center><h1>Registro fotográfico</h1></center>  -->
			
		<!-- Clic en cada imagen para ampliar -->
		
			<div class="thumbnails yoxview" id="album">
			<?php


			$numero_imagenes = count($fotografias) ; //total de imagenes

			if($numero_imagenes % 6 == 0){
				$numero_bloques = intval($numero_imagenes / 6) ;
			}
			else{
				$numero_bloques = intval($numero_imagenes / 6) + 1 ;
			}


			$divs = 1 ;
			$i = 0 ;


			foreach ($fotografias as $value) {
				# code...
		
			
			//	for($i = 0 ; $i < $numero_imagenes ; $i++){
					
					if($i % 6 == 0 && $i !=0){
						?>
						</div>
						<?php
					}

					if($i % 6 == 0){
						if($i != 0) {
							?>
							<div id="alb_<?php echo $divs; ?>" style="display:none;">
							<?php
							
						}
						else {
							?>
							<div id="alb_1" style="display:block;">
								
							<?php
						//	$divs ++ ;
						}
						?>
						<div id="paginas">
									<table id="tabla_paginas">
										<tr>
											<td class="arrow"><?php if($divs > 1) { ?><a href="#" onclick="anterior(<?php echo $divs; ?>);"><img src="../images/iconos/arrow_left.png" width="18" height="22"></a><?php } ?></td>
											<td><input type="text" class="pag_inf" value="<?php echo $divs; ?>"></td>
											<td>de</td>
											<td><input type="text" class="pag_inf" value="<?php echo $numero_bloques; ?>"></td>
											<td class="arrow"><?php if($divs < $numero_bloques) { ?><a href="#" onclick="siguiente(<?php echo $divs; ?>);"><img src="../images/iconos/arrow_right.png" width="18" height="22"></a><?php } ?></td>
										</tr>
									</table>
									
									
									
									
								</div>
						<?php
						$divs ++ ;
					}
					$nombre_archivo = substr($value['nombre'], 0, -3) . 'jpg'  ;

					?>
					
						<a  <?php   echo (substr($value['nombre'], -3) == 'pdf') ? "target='_blank'" : "";  ?>  href="<?php echo $ruta.'/'.$value['nombre']; ?>">
							<img src="<?php echo $ruta.'/'.$nombre_archivo; ?>" width="310" height="240" alt="First" title="">
							<br>
							<div id="comentario"><?php echo $value['comentario']; ?></div>
							<!--  aqui va el pie de pagina de la foto  -->
						</a>
						
					<?php
					
			//	} // fin for
					$i ++ ;
			} //fin foreach
			?>

			<input type="hidden" id="totales" value="<?php echo $numero_bloques; ?>" >

			</div>
			</div>
			
			
			
		</div>

		<div id="lateral_derecha"></div>
		<div id="pie_pagina">
			<?php
			$registros = json_decode($indicacion->getForResumenKm($_GET['id_referencia'])) ;
			if(!empty($registros)){
			?>
			<div id="menu_pie">

				<a href="resumen_ref_tot.php?id_referencia=<?php echo $referencia->getId(); ?>">- Estadísticas</a>
				
			</div>
			<?php
		}
			?>
		</div>
	

</div><!-- fin de contenedor general -->





<!--
	
	FIN DEL CUERPO EDITABLE PARA LA PRESENTACION
	
-->









<div id="yoxview_popupWrap" style="background-color: rgba(0, 0, 0, 0.8); display: none;">
	<div id="yoxview" style="width: 102px; height: 102px; top: 109px; left: 726px; display: block;">
		<div class="yoxview_imgPanel" style="z-index: 2; width: 102px; height: 102px; opacity: 1; display: block;">
			
		</div>
		<div class="yoxview_imgPanel" style="z-index: 1; display: none; opacity: 1;">
			<img class="yoxview_fadeImg" style="display: block; width: 100%; height: 100%;">
		</div>
		<div class="yoxview_popupBarPanel yoxview_top">
			<div id="yoxview_menuPanel" style="top: -42px;">
				<a href="#">
					<span style="opacity: 0;">Cerrar</span>
					<img src="../js/images/empty.gif" alt="close" style="width: 18px; height: 18px; background-image: url(http://www.yoxigen.com/yoxview/yoxview/images/sprites.png); background-position: 0px -59px; background-repeat: no-repeat no-repeat;">
				</a>
				<a href="">
					<span style="opacity: 0;">Ayuda</span>
					<img src="../js/images/empty.gif" alt="help" style="width: 18px; height: 18px; background-image: url(http://www.yoxigen.com/yoxview/yoxview/images/sprites.png); background-position: -18px -59px; background-repeat: no-repeat no-repeat;">
				</a>
				<a href="#" class="last">
					<span style="opacity: 0;">Reproducir</span>
					<img src="../js/images/empty.gif" alt="play" style="width: 18px; height: 18px; background-image: url(http://www.yoxigen.com/yoxview/yoxview/images/sprites.png); background-position: -108px -59px; background-repeat: no-repeat no-repeat;">
				</a>
			</div>
		</div>
		<a class="yoxview_ctlBtn" href="#" style="background-image: url(../images/left.png); opacity: 0; outline: 0px; left: 0px; background-position: 0% 50%; background-repeat: no-repeat no-repeat;">cass</a>
		<a class="yoxview_ctlBtn" href="#" style="background-image: url(../images/left.png); opacity: 0; outline: 0px; right: 0px; background-position: 100% 50%; background-repeat: no-repeat no-repeat;"></a>
		<div id="yoxview_ajaxLoader" class="yoxview_notification" style="display: none;">
			<img src="images/popup_ajax_loader.gif" alt="Loading" style="width: 32px; height: 32px; background-image: url(http://www.yoxigen.com/yoxview/yoxview/images/sprites.png); background-position: 0px 0px;">
		</div>
		<img class="yoxview_notification">
		<div id="yoxview_helpPanel" href="#" title="Close help" style="background-image: url(../images/help_panel.png); direction: ltr; opacity: 0; background-position: 50% 0%; background-repeat: no-repeat no-repeat;">
			<h1>HELP</h1>
			<p>
				La galería puede navegarse usando el teclado:
				<br>
				<br>
				LEFT/RIGHT ARROWS: Anterior/Siguiente
				<br>
				Barra Espacio: Siguiente
				<br>
				ENTER: Start/Stop slideshow
				<br>
				ESCAPE: Cerrar galería
				<br>
				HOME/END: Primera/Última fotografía
				<br>
				H - Panel de Ayuda
			</p>
			<span id="yoxview_closeHelp">Cerrar Ayuda</span>
		</div>
		<div class="yoxview_popupBarPanel yoxview_bottom">
			<div id="yoxview_infoPanel" style="background-color: rgba(0, 0, 0, 0.498039); overflow: hidden; height: 0px; display: block;">
				<span id="yoxview_count">2/3</span>
				<a class="yoxviewInfoLink" href="#" title="Pin info" style="display: inline;">
					<img src="../js/images/empty.gif" alt="pin" style="width: 18px; height: 18px; background-image: url(http://www.yoxigen.com/yoxview/yoxview/images/sprites.png); background-position: -72px -59px; background-repeat: no-repeat no-repeat;">
				</a>
				<a class="yoxviewInfoLink" target="_blank" title="View in original context" style="display: none;">
					<img src="../js/images/empty.gif" alt="link" style="width: 18px; height: 18px; background-image: url(http://www.yoxigen.com/yoxview/yoxview/images/sprites.png); background-position: -54px -59px; background-repeat: no-repeat no-repeat;">
				</a>
				<div id="yoxview_infoText">
				</div>
			</div>
		</div>
	</div>
</div>
</div>
</body>
</html>