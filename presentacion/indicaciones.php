<?php
session_start();
	
	include_once("../library/ConexionExterna.php");
	include_once("../library/Disciplina.php");
	include_once("../library/Area.php");
	include_once("../library/Referencia.php");
	include_once("../library/Indicaciones.php");
	include_once("../library/FotografiaReparacion.php");


	$conexion_externa = new ConexionExterna();
	$disciplina = new Disciplina();
	$area = new Area() ;
	$referencia = new Referencia();
	$indicacion = new Indicaciones();
	$fotografia_reparacion = new FotografiaReparacion();


	$referencia->loadById($_GET['id_referencia']);
	$area->loadById($referencia->getArea());
	$disciplina->loadById($area->getDisciplina());

	$referencias = $referencia->getByArea($area->getId());
	$disciplina->loadById($area->getDisciplina());
	$conexion_externa->loadByIdContrato($disciplina->getContrato());

	if(isset($_GET['id_ducto'])){
		$indicaciones_t = $indicacion->getByReferenciaDdv($referencia->getId(), $_GET['id_ducto']);		
		$fotografias = $fotografia_reparacion->getByReferenciaDdv($referencia->getId(), $_GET['id_ducto']);
	}
	else{

	$indicaciones_t = $indicacion->getByReferencia($referencia->getId());
	$fotografias = $fotografia_reparacion->getByReferencia($referencia->getId());
}
	

	//print_r($indicaciones_t) ;
//	echo $indicaciones_t[0]['elemento'] ;
	
?>




<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!-- saved from url=(0065)http://www.yoxigen.com/yoxview/demo/demo%20-%20basic%20usage.html -->
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
			REGISTRO DE INDICACIONES
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
						if(!empty($fotografias)){
							if(isset($_GET['id_ducto'])){
						?>
							<td><a href="album.php?id_referencia=<?php echo $referencia->getId(); ?>&id_ducto=<?php echo $_GET['id_ducto']; ?>"> < Registro Fotográfico </a></td>
						<?php
						}
						else{
							?>
							<td><a href="album.php?id_referencia=<?php echo $referencia->getId(); ?>"> < Registro Fotográfico </a></td>
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


			$indicaciones_totales = count($indicaciones_t ); //total de imagenes

			if($indicaciones_totales % 30 == 0){
				$numero_bloques = intval($indicaciones_totales / 30) ;
			}
			else{
				$numero_bloques = intval($indicaciones_totales / 30) + 1 ;
			}
			//echo $numero_bloques ;


			$divs = 1 ;
			$element = 0 ;
			
				for($i = 0 ; $i < $numero_bloques ; $i++){




					if($i != 0){
						?>
						</div>
						<?php
					}

					if($i== 0){
						?>
							<div id="alb_1" style="display:block;">

							<?php
					}
					else{
						?>
							<div id="alb_<?php echo $divs; ?>" style="display:none;">
							<?php
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
									<div class="d_simbologia" >
									<table class="simbologia">
										<tr>
											<td class="ind_amarillo"></td>
											<td class="ind_texto">INDICACIÓN > 10% Y ≤ 30%</td>
											<td class="ind_naranja"></td>
											<td class="ind_texto">INDICACIÓN > 30% Y ≤ 80%</td>
											<td class="ind_rojo"></td>
											<td class="ind_texto">INDICACIÓN > 80%</td>
										</tr>
									</table>
									</div>
									
								</div> <!--  fin paginas -->
						<?php
						
			//		}

					?>
					<div class="dt_indicaciones" >
						<table id="tabla_indicaciones">
									<tr>
									<th>Elemento</th>
									<th>No. Ind.</th>
									<th>Ref. Ind.</th>
									<th>Dist.</th>
									<th>Hor.</th>
									<th>Tipo Disc.</th>
									<th>Largo</th>
									<th>Ancho</th>
									<th>Profundidad</th>
									<th>Esp. mín.</th>
									<th>Esp. máx.</th>
									<th>Esp. Rem.</th>
									<th>Pérdida</th>
								</tr>
						<?php

							$limite = ($divs) * 30 ;
                            

							if($limite >= $indicaciones_totales ){
								$limite = $indicaciones_totales -1 ;
							}
						//	echo $limite ;

						for ($j=$element; $j <= $limite ; $j++) { 
							
							if($j%2 == 0){
								 $efecto = 'par';
							}
							else{
								$efecto = 'impar' ;
							}


							if( is_numeric($indicaciones_t[$j]['referencia_indicacion']) ){
								$referencia_soldadura = "W-".$indicaciones_t[$j]['referencia_indicacion'];
							}
							else{
								$referencia_soldadura = $indicaciones_t[$j]['referencia_indicacion'];
							}


							$perdida = (100 * round($indicaciones_t[$j]['perdida'], 2)) ;
							if($perdida >=10 and $perdida<=30){
								$clase = "amarillo" ;
							}
							else if($perdida >30 and $perdida<=80){
								$clase = "naranja" ;
							}
							else if($perdida >80){
								$clase = "rojo" ;
							}
							else{
								$clase = "" ;
							}

						?>



						<tr class="<?php echo $efecto;?>">
							<td class="info"><?php echo $indicaciones_t[$j]['elemento']; ?></td>
							<td class="info"><?php echo $indicaciones_t[$j]['numero_indicacion']; ?></td>
							<td class="info"><?php echo $referencia_soldadura ?></td>
							<td class="info"><?php echo $indicaciones_t[$j]['distancia']; ?></td>
							<td class="info"><?php echo $indicaciones_t[$j]['horario']; ?></td>
							<td class="info"><?php echo $indicaciones_t[$j]['tipo_discontinuidad']; ?></td>
							<td class="info"><?php echo round($indicaciones_t[$j]['largo'],2); ?></td>
							<td class="info"><?php echo round($indicaciones_t[$j]['ancho'],2); ?></td>
							<td class="info"><?php echo round($indicaciones_t[$j]['profundidad'],3); ?></td>
							<td class="info"><?php echo round($indicaciones_t[$j]['espesor_minimo'],3); ?></td>
							<td class="info"><?php echo round($indicaciones_t[$j]['espesor_maximo'],3); ?></td>
							<td class="info"><?php echo round($indicaciones_t[$j]['espesor_remanente'],3); ?></td>
							<td class="<?php echo $clase; ?>"><?php echo (100 * round($indicaciones_t[$j]['perdida'], 2)) . " %" ; ?></td>
						</tr>


							
						<?php
						$element ++ ;
						}
						$divs ++ ;
						?>
						</table>
					</div> <!-- dt_indicaciones -->
					<?php
				}
			?>
			

			<input type="hidden" id="totales" value="<?php echo $numero_bloques; ?>" >

			</div>
			</div>
			
			
			
		</div>

		<div id="lateral_derecha"></div>
		<div id="pie_pagina">
			<div id="menu_pie">

				<a href="resumen_ref_tot.php?id_referencia=<?php echo $referencia->getId(); ?>">- Estadísticas</a>
				
			</div>
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