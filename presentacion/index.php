<?php
session_start() ;

	include_once("../library/ConexionExterna.php");

	$conexion_externa = new ConexionExterna();

	$conexion_externa->loadByIdContrato($_GET['id_contrato']);
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

	<div id="contenedor_index">

		<div id="logos" ><a href="../index.php"><h3>Salir</h3></a></div>
		<div id="name"></div>
		<div id="enlace"><a href="disciplinas.php?id_contrato=<?php echo $conexion_externa->getId(); ?>"><img src="css/<?php echo $conexion_externa->getNumero(); ?>/images/indice.png"></a></div>


	

</div><!-- fin de contenedor index -->





<!--
	
	FIN DEL CUERPO EDITABLE PARA LA PRESENTACION
	
-->




</div>
</body>
</html>