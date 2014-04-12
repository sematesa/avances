<?php

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

	echo $indicacion->getForResumenExtGr($disciplina->getId(), $disciplina->getContrato()) ;

?>