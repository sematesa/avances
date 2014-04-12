<?php
session_start();
	
	include_once("../library/ConexionExterna.php");
	include_once("../library/Disciplina.php");
	include_once("../library/Area.php");
	include_once("../library/Referencia.php");
	include_once("../library/Indicaciones.php");
	include_once("../library/FotografiaReparacion.php");
	include_once("../library/Ducto.php");
	include_once("../library/Ddv.php");
	include_once("../library/DdvDucto.php");


	$conexion_externa = new ConexionExterna();
	$disciplina = new Disciplina();
	$area = new Area() ;
	$referencia = new Referencia();
	$indicacion = new Indicaciones();
	$fotografia_reparacion = new FotografiaReparacion();
	$ducto = new Ducto();
	$ddv = new Ddv() ;
	$ddv_ducto = new DdvDucto();


	$referencia->loadById($_GET['id_referencia']);
	$area->loadById($referencia->getArea());
	$disciplina->loadById($area->getDisciplina());

	$referencias = $referencia->getByArea($area->getId());
	$disciplina->loadById($area->getDisciplina());
	$conexion_externa->loadByIdContrato($disciplina->getContrato());

	

	if($area->getClasificacion()==='DDV'){







		?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!-- saved from url=(0065)http://www.yoxigen.com/yoxview/demo/demo%20-%20basic%20usage.html -->
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">


		<title>Servicios Marinos y Terrestres S. A. de C. V.</title>
		<link rel="Stylesheet" type="text/css" href="css/<?php echo $conexion_externa->getNumero(); ?>/style.css">

		

	</head>

	<body>
		<div>







<!--
	
	INICIO DEL CUERPO EDITABLE PARA LA PRESENTACION
	
-->

	<div id="contenedor_general">

		<div id="encabezado_down">
		<div id="encabezado">
			<center>

			LINEAS REGULARES
			<br>
			CONTRATO No. <?php echo $conexion_externa->getNumero(); ?>
			</center>
		</div>
		</div>
		<div id="lateral_izquierda"></div>



		
		

		<div id="container">

			<div id="submenu">
				<table id="tabla_submenu">
					<tr>
						<td><a href="disciplinas.php?id_contrato=<?php echo $disciplina->getContrato(); ?>"> < Disciplinas </a></td>
						<td><a href="areas.php?id_disciplina=<?php echo $disciplina->getId(); ?>"> < Lineas </a></td>
						<td><a href="referencias.php?id_area=<?php echo $referencia->getArea(); ?>" >< Referencias</a></td>
					</tr>
				</table>
			</div>

			<div id="indice" >
				<ul id="indice_lista">
		<?php







//		echo $area->getElemento();
		$ductos_ddv = $ddv_ducto->getByDdv($area->getElemento());
		//print_r($ductos_ddv) ;

		foreach ($ductos_ddv as $value) {
			$indicaciones_t = $indicacion->getByReferenciaDdv($referencia->getId(), $value['id_ducto']);
			$fotografias = $fotografia_reparacion->getByReferenciaDdv($referencia->getId(), $value['id_ducto']);
			$ducto->loadById($value['id_ducto']);
			if( !empty($indicaciones_t) ){
				//var_dump($indicaciones_t) ;
				?>
				<li><a href="indicaciones.php?id_referencia=<?php echo $_GET['id_referencia'] ?>&id_ducto=<?php echo $ducto->getId(); ?>"><?php echo $ducto->getTipoDucto(). ' ' . $ducto->getDiametro() . '" Ø '.$ducto->getNombre(); ?></a></li>
				<?php		
			}
			else if(!empty($fotografias)){
				//var_dump($fotografias);
				?>
				<li><a href="album.php?id_referencia=<?php echo $_GET['id_referencia'] ?>&id_ducto=<?php echo $ducto->getId(); ?>"><?php echo $ducto->getTipoDucto(). ' ' . $ducto->getDiametro() . '" Ø '.$ducto->getNombre(); ?></a></li>
				<?php
			}
			else{
				//echo "no hay nada" ;
			}

//			echo sizeof($indicaciones_t) ;

		} /// foreach

		//
		//
		//$ductos = $ducto->getForIndicaciones($area->getElemento());
		//	print_r($ductos) ;


		?>

		</ul>
			</div>
			
			
		</div>

		<div id="lateral_derecha"></div>
		
		<div id="pie_pagina">

		</div>
	

</div><!-- fin de contenedor general -->





<!--
	
	FIN DEL CUERPO EDITABLE PARA LA PRESENTACION
	
-->





</div>
</body>
</html>

		<?php


	} // fin if ddv




	else{

		$indicaciones_t = $indicacion->getByReferencia($referencia->getId());
		$fotografias = $fotografia_reparacion->getByReferencia($referencia->getId());

	if( empty($indicaciones_t) && empty($fotografias) ) {
		?>
		<script type="text/javascript">
			alert("No hay indicaciones capturadas para este kilometraje");
			window.location = "referencias.php?id_area=<?php echo $area->getId(); ?>";
		</script>
		<?php
	}
	else if(!empty($indicaciones_t)){
		?>
		<script type="text/javascript">
			window.location = "indicaciones.php?id_referencia=<?php echo $referencia->getId(); ?>";
		</script>
		<?php
	}
	else if( empty($indicaciones_t) && !empty($fotografias)){
		?>
		<script type="text/javascript">
			window.location = "album.php?id_referencia=<?php echo $referencia->getId(); ?>";
		</script>
		<?php
	}
	else{
		echo "Error";
	}
}
	
?>