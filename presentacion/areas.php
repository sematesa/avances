
<?php
session_start() ;

	include_once("../library/ConexionExterna.php");
	include_once("../library/Disciplina.php");
	include_once("../library/Area.php");
	include_once("../library/Indicaciones.php");


	$conexion_externa = new ConexionExterna();
	$disciplina = new Disciplina();
	$area = new Area() ;
	$indicacion = new Indicaciones();



	
	$disciplina->loadById($_GET['id_disciplina']);
	$conexion_externa->loadByIdContrato($disciplina->getContrato());
	$areas = $area->getByDisciplina($disciplina->getId());
	//echo $conexion_externa->getNumero();

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

			LINEAS REGULARES - <?php echo $disciplina->getNombre(); ?>
			<br>
			CONTRATO No. <?php echo $conexion_externa->getNumero(); ?>
			</center>
		</div>
		</div>
		<div id="lateral_izquierda"></div>



		
		

		<div id="container">



			<?php

			$indicaciones = json_decode($indicacion->getForResumenExt($_GET['id_disciplina'], $disciplina->getContrato()));
			//print_r($indicaciones);

			?>


			<div id="submenu">
				<table id="tabla_submenu">
					<tr>
						<td><a href="disciplinas.php?id_contrato=<?php echo $disciplina->getContrato(); ?>"> < Disciplinas </a></td>
					</tr>
				</table>
			</div>

			<div id="indice" >
				<ol id="indice_lista2">
				<?php
				//print_r($disciplinas);
					foreach ($areas as $value) {

						?>
						<li><a href="referencias.php?id_area=<?php echo $value['id_area']; ?>"><?php 
						if ($value['diametro'] !=0){
							echo $value['clasificacion'] . " " . $value['diametro'] . "\"Ø " . $value['nombre'] . " (".$value['avance']." %)"; 	
						}
						else{
							echo $value['clasificacion'] . " " . $value['nombre']; 	
						}
						?>
						</a></li>
						<?php
					}
				?>
				</ol>
			</div>
			
			
		</div>

		<div id="lateral_derecha"></div>
		<div id="pie_pagina">
			<div id="menu_pie">
				<?php 
				if(!empty(  $indicaciones)){
					//print_r($indicaciones);
				?>
				<a href="resumen_int_tot.php?id_disciplina=<?php echo $disciplina->getId(); ?>">- Estadísticas</a>
				<?php
			}
				?>
			</div>
		</div>
	

</div><!-- fin de contenedor general -->





<!--
	
	FIN DEL CUERPO EDITABLE PARA LA PRESENTACION
	
-->





</div>
</body>
</html>