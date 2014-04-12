<?php

	include_once("../library/Indicaciones.php");

	$indicacion = new Indicaciones() ;

	//echo $conexion_externa->getNumero();

	echo $indicacion->getForResumenKmGr($_GET['id_referencia']) ;


?>