<?php
	include_once("../library/Indicaciones.php");

	$indicacion = new Indicaciones();

	echo $indicacion->delete($_GET['id_indicacion']);
	
?>