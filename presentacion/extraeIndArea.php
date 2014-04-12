<?php

	include_once("../library/Indicaciones.php");

	$indicacion = new Indicaciones() ;

	//echo $conexion_externa->getNumero();

	echo $indicacion->getForResumenAreaGr($_GET['id_area']) ;


?>