
<?php
session_start() ;

	include_once("../library/ConexionExterna.php");
	include_once("../library/Disciplina.php");
	

	$conexion_externa = new ConexionExterna();
	$disciplina = new Disciplina();
	



	$conexion_externa->loadByIdContrato($_GET['id_contrato']);
	$disciplinas = $disciplina->getByContratos($conexion_externa->getId());
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
	

			<?php if($_GET['id_contrato'] != 4 ){ 
				echo "INDICACIONES" ;
				} else{
				echo "ACTIVOS" ;
				} 
				?>


			
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
						<td><a href="index.php?id_contrato=<?php echo $_GET['id_contrato']; ?>"> < Inicio </a></td>
						
					</tr>
				</table>
			</div>

			<div id="indice" >
				<ul id="indice_lista">
				<?php
				//print_r($disciplinas);
					foreach ($disciplinas as $value) {

						?>
						<li><a href="areas.php?id_disciplina=<?php echo $value['id_disciplina']; ?>"><?php echo $value['nombre']; ?></a></li>
						<?php
					}
				?>
				</ul>
			</div>
			
			
		</div>

		<div id="lateral_derecha"></div>
		<div id="pie_pagina">
			<div id="menu_pie">
				<?php if($_GET['id_contrato'] != 4 ){ ?>
				<a href="resumen_ge.php?id_contrato=<?php echo $_GET['id_contrato']; ?>">- Estadísticas Generales</a>
				<?php
				} else{
				?>
				<a href="avance_financiero.pdf" target="_blank">- Avance Financiero</a>
				<?php
				} 
				?>
				<a href="resumen_ge_int_tot.php?id_contrato=<?php echo $_GET['id_contrato']; ?>">- Estadísticas Indicaciones</a>
					
			</div>
		</div>
	

</div><!-- fin de contenedor general -->





<!--
	
	FIN DEL CUERPO EDITABLE PARA LA PRESENTACION
	
-->





</div>
</body>
</html>