
<?php
session_start() ;

	include_once("../library/ConexionExterna.php");
	include_once("../library/Disciplina.php");
	include_once("../library/Area.php");
	include_once("../library/Referencia.php");
	include_once("../library/Indicaciones.php");

	$conexion_externa = new ConexionExterna();
	$disciplina = new Disciplina();
	$area = new Area() ;
	$referencia = new Referencia();
	$indicacion = new Indicaciones();


	$area->loadById($_GET['id_area']);
	$disciplina->loadById($area->getDisciplina());

	$referencias = $referencia->getByArea($area->getId());
	$disciplina->loadById($area->getDisciplina());
	$conexion_externa->loadByIdContrato($disciplina->getContrato());
	
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
			<div id="texto_encabezado">
			<center>


			<?php 
						if ($area->getDiametro() !=0){
							echo $area->getClasificacion() . " " .$area->getDiametro() . "\"Ø " . $area->getNombre(); 	
						}
						else{
							echo $area->getClasificacion() . " " . $area->getNombre(); 	
						}
						?>
			<!--
			<br>
			REFERENCIAS -->
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
					</tr>
				</table>
			</div>

			<div id="indice" >
				<ul id="indice_lista">
				<?php
				//print_r($disciplinas);
					foreach ($referencias as $value) {

						?>
						<li><a href="tratar.php?id_referencia=<?php echo $value['id_referencia']; ?>"><?php echo $value['descripcion']; ?> 
						</a></li>
						<?php
					}
				?>
				</ul>
			</div>
			
			
		</div>

		<div id="lateral_derecha"></div>
		
		<div id="pie_pagina">
			<?php
			$registros = json_decode($indicacion->getForResumenArea($_GET['id_area']) );
			if(!empty($registros)){
			?>
			<div id="menu_pie">

				<a href="resumen_area_tot.php?id_area=<?php echo $_GET['id_area']; ?>">- Estadísticas</a>
				
			</div>
			<?php
		}
			?>
		</div>
	

</div><!-- fin de contenedor general -->





<!--
	
	FIN DEL CUERPO EDITABLE PARA LA PRESENTACION
	
-->





</div>
</body>
</html>