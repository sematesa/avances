<?php
	include_once("../library/FotografiaReparacion.php");
	include_once("../library/Indicaciones.php");

	$fotografia_reparacion = new FotografiaReparacion();
	$indicaciones = new Indicaciones();



//	$elemento = explode('.', $_GET) ;
		//	print_r($elemento) ;
		//	echo " -- " .$value. "<br><br>";

			switch ($_GET['elemento']) {
				case 1:
					$fotografia_reparacion->delete($_GET['id']);
					break;
				
				case 2:
					$indicaciones->updateFotografia($_GET['id'], '');
					$indicaciones->updatePosicion($_GET['id'], 0);
					break;
			}
	
?>