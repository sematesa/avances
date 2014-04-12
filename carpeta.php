<?php
	include_once("library/Disciplina.php");
	include_once("library/Area.php");
	include_once("library/Referencia.php");

	$disciplina = new Disciplina();
	$area = new Area();
	$referencia = new Referencia();

	$disciplinas = $disciplina->getByContratos(1);

	//print_r($disciplinas);
	$contador = 1 ;

	foreach ($disciplinas as $dis) {



		$dis['nombre']=str_replace('ñ', 'Ñ', $dis['nombre']);
			$dis['nombre'] = strtoupper($dis['nombre']);

			echo "files/425023803/".str_replace('Ñ', 'N', $dis['nombre']);
			mkdir("files/425023803/".str_replace('Ñ', 'N', $dis['nombre']));




		echo "<br>";

		$areas = $area->getByDisciplina($dis['id_disciplina']);

		foreach ($areas as $ar) {
			echo "<br>";
			$ar['nombre']=str_replace('ñ', 'Ñ', $ar['nombre']);
			$ar['nombre'] = strtoupper($ar['nombre']);
			echo "files/425023803/".str_replace('Ñ', 'N', $dis['nombre'])."/".$ar['clasificacion']."-".str_replace('Ñ', 'N', $ar['nombre'] ) ."-".$ar['diametro'];
			mkdir("files/425023803/".str_replace('Ñ', 'N', $dis['nombre'])."/".$ar['clasificacion']."-".str_replace('Ñ', 'N', $ar['nombre'] ) ."-".$ar['diametro']);

				$referencias = $referencia->getByArea($ar['id_area']);


				foreach ($referencias as $ref) {
				echo "<br>";
				
				$ref['descripcion']=str_replace('ñ', 'Ñ', $ref['descripcion']);
				$ref['descripcion'] = strtoupper($ref['descripcion']);
				$ref['ubicacion'] = strtoupper($ref['ubicacion']);
				echo "files/425023803/".str_replace('Ñ', 'N', $dis['nombre'])."/".$ar['clasificacion']."-".str_replace('Ñ', 'N', $ar['nombre'] ) ."-".$ar['diametro']."/".str_replace('Ñ', 'N', $ref['descripcion'])	;
				mkdir("files/425023803/".str_replace('Ñ', 'N', $dis['nombre'])."/".$ar['clasificacion']."-".str_replace('Ñ', 'N', $ar['nombre'] ) ."-".$ar['diametro']."/".str_replace('Ñ', 'N', $ref['descripcion'])) ;

				$contador ++ ;
			}
			
			echo "<br>";
			echo "<br>";




		}

		echo "<br>";
		echo "<br>";


	}

	echo $contador ;

?>