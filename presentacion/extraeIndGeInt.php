<?php

/*	include_once("../library/ConexionExterna.php");
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

	$externas = json_decode($indicacion->getForResumenExt($disciplina->getId(), $disciplina->getContrato())) ;
	$internas = json_decode($indicacion->getForResumenInt($disciplina->getId(), $disciplina->getContrato())) ;
	$total_internas = 0 ;
	$total_externas = 0 ;
	foreach ($externas as $value) {
		$total_externas += $value ;
	}

	foreach ($internas as $value) {
		$total_internas += $value ;
	}

	echo json_encode( 
						array( 
								array(
									'tipo' => 'Ind. Ext.' , 
									'cantidad'=>$total_externas ), 
								array('tipo'=>'Ind. Int.',
									'cantidad'=>$total_internas)
								) 
						) ;*/


	include_once("../library/Indicaciones.php");


	$indicacion = new Indicaciones();



	
	//$conexion_externa->loadById($_GET['id_disciplina']);
	/*$conexion_externa->loadByIdContrato($_GET['id_disciplina']);
	$areas = $area->getByDisciplina($disciplina->getId());*/
	//echo $conexion_externa->getNumero();

	echo $indicacion->getForResumenTotIntGr( $_GET['id_contrato']) ;


?>