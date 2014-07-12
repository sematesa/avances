<?php

	include_once("Database.php");

	class Indicaciones{

		private $id ;
		private $elemento ;
		private $numero_indicacion ;
		private $referencia_indicacion ;
		private $distancia ;
		private $horario ;
		private $tipo_discontinuidad ;
		private $largo ;
		private $ancho ;
		private $profundidad ;
		private $espesor_minimo ;
		private $espesor_maximo ;
		private $espesor_remanente ;
		private $perdida ;
		private $fotografia ;
		private $comentario ;
		private $posicion ;
		private $fecha ;
		private $referencia ;
		private $ducto ;
		
		private $tabla ;

		
		function __construct()
		{
			$ob = new Database();
			$this->conexion = $ob->getConexion();
			$this->tabla = "indicaciones" ;
		}

		function insert($registro){
			$sql = "insert into $this->tabla values(
				0, 
				'".$registro['elemento']."',
				'".$registro['numero_indicacion']."',
				'".$registro['referencia_indicacion']."',
				'".$registro['distancia']."',
				'".$registro['horario']."',
				'".$registro['tipo_discontinuidad']."',
				'".$registro['largo']."',
				'".$registro['ancho']."',
				'".$registro['profundidad']."',
				'".$registro['espesor_minimo']."',
				'".$registro['espesor_maximo']."',
				'".$registro['espesor_remanente']."',
				'".$registro['perdida']."',
				'".$registro['fotografia']."',
				'".$registro['comentario']."',
				".$registro['posicion'].",
				'".$registro['fecha']."',
				".$registro['id_referencia'].",
				'".$registro['id_ducto']."',
				'".$registro['id_usuario']."'
				)";
			$this->conexion->query($sql);
			return $this->conexion->insert_id ;
		}

		function update($registro){
			$sql = "update $this->tabla set 
				elemento='".$registro['elemento']."',
				numero_indicacion='".$registro['numero_indicacion']."',
				referencia_indicacion='".$registro['referencia_indicacion']."',
				distancia ='".$registro['distancia']."',
				horario='".$registro['horario']."',
				tipo_discontinuidad ='".$registro['tipo_discontinuidad']."',
				largo ='".$registro['largo']."',
				ancho ='".$registro['ancho']."',
				profundidad='".$registro['profundidad']."',
				espesor_minimo='".$registro['espesor_minimo']."',
				espesor_maximo='".$registro['espesor_maximo']."',
				espesor_remanente='".$registro['espesor_remanente']."',
				perdida='".$registro['perdida']."',
				fotografia='".$registro['fotografia']."',
				comentario='".$registro['comentario']."',
				posicion=".$registro['posicion'].",
				fecha='".$registro['fecha']."'
				where id_indicacion = ".$registro['id_indicacion']."
			 ";

			$this->conexion->query($sql);
			
			return $sql ;

		}

		function updateFotografia($id_insert, $name){
			$sql = "update $this->tabla set 
				fotografia='".$name."'
				where id_indicacion = ".$id_insert."
			 ";

			$this->conexion->query($sql);
			
			return $sql ;

		}

		function updatePosicion($posicion, $elemento){
			$sql = "update $this->tabla set 
				posicion=".$posicion."
				where id_indicacion = ".$elemento."
			 ";

			$this->conexion->query($sql);
			
			return $sql ;

		}

		function delete($id){
			$sql = "delete from $this->tabla where id_indicacion=$id" ;
			$this->conexion->query($sql);
			return $sql ;
		}

		function loadById($id){
			$sql = "select * from $this->tabla where id_indicacion=$id" ;
			$resultado = $this->conexion->query($sql);
			if($resultado->num_rows > 0){
				$row = $resultado->fetch_assoc();
				$this->id = $row['id_indicacion'] ;
				$this->elemento = $row['elemento'] ;
				$this->numero_indicacion = $row['numero_indicacion'] ;
				$this->referencia_indicacion = $row['referencia_indicacion'] ;
				$this->distancia = $row['distancia'] ;
				$this->horario = $row['horario'];
				$this->tipo_discontinuidad = $row['tipo_discontinuidad'] ;
				$this->largo = $row['largo'] ;
				$this->ancho = $row['ancho'] ;
				$this->profundidad = $row['profundidad'] ;
				$this->espesor_minimo = $row['espesor_minimo'] ;
				$this->espesor_maximo = $row['espesor_maximo'] ;
				$this->espesor_remanente = $row['espesor_remanente'] ;
				$this->perdida = $row['perdida'] ;
				$this->fotografia = $row['fotografia'] ;
				$this ->referencia = $row['id_referencia'] ;
				$this->comentario = $row['comentario'];
				$this->posicion = $row['posicion'] ;
				$this->fecha = $row['fecha'] ;
				$this->ducto = $row['id_ducto'];
			}
		}

		function getFotos($referencia) {
			$sql = "select * from $this->tabla where posicion > 0 and id_referencia = $referencia" ;
			$fotos = array() ;
			$resultado = $this->conexion->query($sql);
			if( $resultado->num_rows >0 ){
				
				while($row=$resultado->fetch_assoc()){

					$fotos[$row['posicion']] = array(
									'id_fotografia_reparacion'=>$row['id_indicacion'],
									'nombre'=>$row['fotografia'],
									'ruta'=>'',
									'comentario'=>$row['comentario'],
									'lugar'=>$row['posicion'],
									'id_referencia'=>$row['id_referencia'],
									'tabla'=>'indicaciones'
									) ;
				}
					
			}
			return $fotos ;

		}

		function getFotosDdv($referencia, $id_ducto) {
			$sql = "select * from $this->tabla where posicion > 0 and id_referencia = $referencia and id_ducto = $id_ducto" ;
			$fotos = array() ;
			$resultado = $this->conexion->query($sql);
			if( $resultado->num_rows >0 ){
				
				while($row=$resultado->fetch_assoc()){

					$fotos[] = array(
									'id_fotografia_reparacion'=>$row['id_indicacion'],
									'nombre'=>$row['fotografia'],
									'ruta'=>'',
									'comentario'=>$row['comentario'],
									'lugar'=>$row['posicion'],
									'id_referencia'=>$row['id_referencia'],
									'tabla'=>'indicaciones'
									) ;
				}
					
			}
			return $fotos ;

		}

	function getMaxLugar( $referencia ){
		$sql = "select max(posicion) as pos from $this->tabla where id_referencia = $referencia" ;
		$resultado = $this->conexion->query($sql);
			if( $resultado->num_rows >0 ){
				$row=$resultado->fetch_assoc();
					$maximo = $row['pos'] ;
			}
			else{
				$maximo = 0 ;
			}
			//echo $sql ;
			return $maximo ;
	}

		function getAll(){
			$sql = "select * from $this->tabla" ;
			$array_referencias = array() ;
			$resultado = $this->conexion->query($sql);
			if( $resultado->num_rows >0 ){
				while($row=$resultado->fetch_assoc()){

					$array_referencias[] = $row ;
				}
			}
			return $array_referencias ;
			
		}


		function getByReferencia($referencia){
			$sql = "select * from $this->tabla where id_referencia = $referencia" ;
			$array_referencias = array() ;
			$resultado = $this->conexion->query($sql);
			if( $resultado->num_rows >0 ){
				while($row=$resultado->fetch_assoc()){

					$array_referencias[] = $row ;
				}
			}
			return $array_referencias ;
		}

		function getByReferenciaDdv($referencia, $id_ducto){
			$sql = "select * from $this->tabla where id_referencia = $referencia and id_ducto = $id_ducto" ;
			$array_referencias = array() ;
			$resultado = $this->conexion->query($sql);
			if( $resultado->num_rows >0 ){
				while($row=$resultado->fetch_assoc()){

					$array_referencias[] = $row ;
				}
			}
			return $array_referencias ;
		}

/**
	grafica disciplinas indicaciones externas
*/

		function getForResumenExt($disciplina, $contrato){
			$tipos = array(
				0=>"CE",
				1=>"DS",
				2=>"Q",
				3=>"AB",
				4=>"DM",
				5=>"M",
				6=>"R",
				7=>"D",
				8=>"P",
				9=>"PA",
				10=>"EL",
				11=>"S",
				12=>"DL",
				13=>"DE",
				14=>"CB",
				15=>"CA"
				);
			$respuesta = array();
			foreach ($tipos as $value) {
				$sql = "select count(*) as total from $this->tabla 
						join referencias
							on referencias.id_referencia = $this->tabla.id_referencia
						join areas
							on areas.id_area = referencias.id_area
						join disciplinas
							on disciplinas.id_disciplina = areas.id_disciplina
						where
							$this->tabla.tipo_discontinuidad = '".$value."' 
							and disciplinas.id_disciplina=".$disciplina." 
							and disciplinas.id_contrato=".$contrato."
				";

				$resultado = $this->conexion->query($sql);
				if($resultado->num_rows > 0){
					$row=$resultado->fetch_assoc() ;
					if($row['total']>0){
						$respuesta[$value] = $row['total'] ;
					}
				}
			}
			return json_encode($respuesta) ;
		}



		function getForResumenExtGr($disciplina, $contrato){
			$tipos = array(
				0=>"CE",
				1=>"DS",
				2=>"Q",
				3=>"AB",
				4=>"DM",
				5=>"M",
				6=>"R",
				7=>"D",
				8=>"P",
				9=>"PA",
				10=>"EL",
				11=>"S",
				12=>"DL",
				13=>"DE",
				14=>"CB",
				15=>"CA"
				);
			$respuesta = array();
			foreach ($tipos as $value) {
				$sql = "select count(*) as total from $this->tabla 
						join referencias
							on referencias.id_referencia = $this->tabla.id_referencia
						join areas
							on areas.id_area = referencias.id_area
						join disciplinas
							on disciplinas.id_disciplina = areas.id_disciplina
						where
							$this->tabla.tipo_discontinuidad = '".$value."' 
							and disciplinas.id_disciplina=".$disciplina." 
							and disciplinas.id_contrato=".$contrato."
				";

				$resultado = $this->conexion->query($sql);
				if($resultado->num_rows > 0){
					$row=$resultado->fetch_assoc() ;
					if($row['total']>0){
						$respuesta[]= array(
											'tipo' =>$value ,
											'cantidad' => $row['total'],
											'balloonColor' => '#754DEB' );
						//$respuesta[$value] = $row['total'] ;
					}
				}
			}
			return json_encode($respuesta) ;
		}


/**
		grafica disciplinas indicaciones externas
*/	




/**
		grafica general disciplinas
*/		
		function getForResumenGen($disciplina, $contrato){
			$tipos = array(
				0=>"CE",
				1=>"DS",
				2=>"Q",
				3=>"AB",
				4=>"DM",
				5=>"M",
				6=>"R",
				7=>"D",
				8=>"P",
				9=>"PA",
				10=>"EL",
				11=>"S",
				12=>"CI",
				13=>"IP",
				14=>"IA",
				15=>"DI",
				16=>"IPA",
				17=>"E",
				18=>"RE",
				19=>"C",
				20=>"L",
				21=>"LA",
				22=>"I",
				23=>"IL",
				24=>"DL",
				25=>"DE",
				26=>"CB",
				27=>"CA"
				);
			$respuesta = array();
			foreach ($tipos as $value) {
				$sql = "select count(*) as total from $this->tabla 
						join referencias
							on referencias.id_referencia = $this->tabla.id_referencia
						join areas
							on areas.id_area = referencias.id_area
						join disciplinas
							on disciplinas.id_disciplina = areas.id_disciplina
						where
							$this->tabla.tipo_discontinuidad = '".$value."' 
							and disciplinas.id_disciplina=".$disciplina." 
							and disciplinas.id_contrato=".$contrato."
				";

				$resultado = $this->conexion->query($sql);
				if($resultado->num_rows > 0){
					$row=$resultado->fetch_assoc() ;
					if($row['total']>0){
						$respuesta[$value] = $row['total'] ;
					}
				}
			}
			return json_encode($respuesta) ;
		}



		function getForResumenGenGr($disciplina, $contrato){
			$tipos = array(
				0=>"CE",
				1=>"DS",
				2=>"Q",
				3=>"AB",
				4=>"DM",
				5=>"M",
				6=>"R",
				7=>"D",
				8=>"P",
				9=>"PA",
				10=>"EL",
				11=>"S",
				12=>"CI",
				13=>"IP",
				14=>"IA",
				15=>"DI",
				16=>"IPA",
				17=>"E",
				18=>"RE",
				19=>"C",
				20=>"L",
				21=>"LA",
				22=>"I",
				23=>"IL",
				24=>"DL",
				25=>"DE",
				26=>"CB",
				27=>"CA"
				);
			$respuesta = array();
			foreach ($tipos as $value) {
				$sql = "select count(*) as total from $this->tabla 
						join referencias
							on referencias.id_referencia = $this->tabla.id_referencia
						join areas
							on areas.id_area = referencias.id_area
						join disciplinas
							on disciplinas.id_disciplina = areas.id_disciplina
						where
							$this->tabla.tipo_discontinuidad = '".$value."' 
							and disciplinas.id_disciplina=".$disciplina." 
							and disciplinas.id_contrato=".$contrato."
				";

				$resultado = $this->conexion->query($sql);
				if($resultado->num_rows > 0){
					$row=$resultado->fetch_assoc() ;
					if($row['total']>0){
						$respuesta[]= array(
											'tipo' =>$value ,
											'cantidad' => $row['total'],
											'balloonColor' => '#754DEB' );
						//$respuesta[$value] = $row['total'] ;
					}
				}
			}
			return json_encode($respuesta) ;
		}



/**
		grafica disciplinas
*/	





/**
		grafica disciplinas indicaciones internas
*/	








		function getForResumenInt($disciplina, $contrato){
			$tipos = array(
				0=>"CI",
				1=>"IP",
				2=>"IA",
				3=>"DI",
				4=>"IPA",
				5=>"E",
				6=>"RE",
				7=>"C",
				8=>"L",
				9=>"LA",
				10=>"I",
				11=>"IL"
				);
			$respuesta = array();
			foreach ($tipos as $value) {
				$sql = "select count(*) as total from $this->tabla 
						join referencias
							on referencias.id_referencia = $this->tabla.id_referencia
						join areas
							on areas.id_area = referencias.id_area
						join disciplinas
							on disciplinas.id_disciplina = areas.id_disciplina
						where
							$this->tabla.tipo_discontinuidad = '".$value."' 
							and disciplinas.id_disciplina=".$disciplina." 
							and disciplinas.id_contrato=".$contrato."
				";

				$resultado = $this->conexion->query($sql);
				if($resultado->num_rows > 0){
					$row=$resultado->fetch_assoc() ;
					if($row['total']>0){
						$respuesta[$value] = $row['total'] ;
					}
				}
			}
			return json_encode($respuesta) ;
		}



		function getForResumenIntGr($disciplina, $contrato){
			$tipos = array(
				0=>"CI",
				1=>"IP",
				2=>"IA",
				3=>"DI",
				4=>"IPA",
				5=>"E",
				6=>"RE",
				7=>"C",
				8=>"L",
				9=>"LA",
				10=>"I",
				11=>"IL"
				);
			$respuesta = array();
			foreach ($tipos as $value) {
				$sql = "select count(*) as total from $this->tabla 
						join referencias
							on referencias.id_referencia = $this->tabla.id_referencia
						join areas
							on areas.id_area = referencias.id_area
						join disciplinas
							on disciplinas.id_disciplina = areas.id_disciplina
						where
							$this->tabla.tipo_discontinuidad = '".$value."' 
							and disciplinas.id_disciplina=".$disciplina." 
							and disciplinas.id_contrato=".$contrato."
				";

				$resultado = $this->conexion->query($sql);
				if($resultado->num_rows > 0){
					$row=$resultado->fetch_assoc() ;
					if($row['total']>0){
						$respuesta[]= array(
											'tipo' =>$value ,
											'cantidad' => $row['total'],
											'balloonColor' => '#754DEB' );
						//$respuesta[$value] = $row['total'] ;
					}
				}
			}
			return json_encode($respuesta) ;
		}

/**
		grafica disciplinas indicaciones internas
*/	





/**


	GENERALES		

	
*/


/**
	grafica disciplinas indicaciones externas
*/

		function getForResumenTotExt( $contrato){
			$tipos = array(
				0=>"CE",
				1=>"DS",
				2=>"Q",
				3=>"AB",
				4=>"DM",
				5=>"M",
				6=>"R",
				7=>"D",
				8=>"P",
				9=>"PA",
				10=>"EL",
				11=>"S",
				12=>"DL",
				13=>"DE",
				14=>"CB",
				15=>"CA"
				);
			$respuesta = array();
			foreach ($tipos as $value) {
				$sql = "select count(*) as total from $this->tabla 
						join referencias
							on referencias.id_referencia = $this->tabla.id_referencia
						join areas
							on areas.id_area = referencias.id_area
						join disciplinas
							on disciplinas.id_disciplina = areas.id_disciplina
						where
							$this->tabla.tipo_discontinuidad = '".$value."' 
							and disciplinas.id_contrato=".$contrato."
				";

				$resultado = $this->conexion->query($sql);
				if($resultado->num_rows > 0){
					$row=$resultado->fetch_assoc() ;
					if($row['total']>0){
						$respuesta[$value] = $row['total'] ;
					}
				}
			}
			return json_encode($respuesta) ;
		}



		function getForResumenTotExtGr($contrato){
			$tipos = array(
				0=>"CE",
				1=>"DS",
				2=>"Q",
				3=>"AB",
				4=>"DM",
				5=>"M",
				6=>"R",
				7=>"D",
				8=>"P",
				9=>"PA",
				10=>"EL",
				11=>"S",
				12=>"DL",
				13=>"DE",
				14=>"CB",
				15=>"CA"
				);
			$respuesta = array();
			foreach ($tipos as $value) {
				$sql = "select count(*) as total from $this->tabla 
						join referencias
							on referencias.id_referencia = $this->tabla.id_referencia
						join areas
							on areas.id_area = referencias.id_area
						join disciplinas
							on disciplinas.id_disciplina = areas.id_disciplina
						where
							$this->tabla.tipo_discontinuidad = '".$value."' 
							and disciplinas.id_contrato=".$contrato."
				";

				$resultado = $this->conexion->query($sql);
				if($resultado->num_rows > 0){
					$row=$resultado->fetch_assoc() ;
					if($row['total']>0){
						$respuesta[]= array(
											'tipo' =>$value ,
											'cantidad' => $row['total'],
											'balloonColor' => '#754DEB' );
						//$respuesta[$value] = $row['total'] ;
					}
				}
			}
			return json_encode($respuesta) ;
		}


/**
		grafica disciplinas indicaciones externas
*/	




/**
		grafica general disciplinas
*/		
		function getForResumenTotGen($contrato){
			$tipos = array(
				0=>"CE",
				1=>"DS",
				2=>"Q",
				3=>"AB",
				4=>"DM",
				5=>"M",
				6=>"R",
				7=>"D",
				8=>"P",
				9=>"PA",
				10=>"EL",
				11=>"S",
				12=>"CI",
				13=>"IP",
				14=>"IA",
				15=>"DI",
				16=>"IPA",
				17=>"E",
				18=>"RE",
				19=>"C",
				20=>"L",
				21=>"LA",
				22=>"I",
				23=>"IL",
				24=>"DL",
				25=>"DE",
				26=>"CB",
				27=>"CA"
				);
			$respuesta = array();
			foreach ($tipos as $value) {
				$sql = "select count(*) as total from $this->tabla 
						join referencias
							on referencias.id_referencia = $this->tabla.id_referencia
						join areas
							on areas.id_area = referencias.id_area
						join disciplinas
							on disciplinas.id_disciplina = areas.id_disciplina
						where
							$this->tabla.tipo_discontinuidad = '".$value."' 
							and disciplinas.id_contrato=".$contrato."
				";
				//echo $sql ;
				//echo "<br><br>";

				$resultado = $this->conexion->query($sql);
				//echo $sql ;
				if($resultado->num_rows > 0){
					$row=$resultado->fetch_assoc() ;
					if($row['total']>0){
						$respuesta[$value] = $row['total'] ;
					}
				}
			}
			return json_encode($respuesta) ;
		}



		function getForResumenTotGenGr( $contrato){
			$tipos = array(
				0=>"CE",
				1=>"DS",
				2=>"Q",
				3=>"AB",
				4=>"DM",
				5=>"M",
				6=>"R",
				7=>"D",
				8=>"P",
				9=>"PA",
				10=>"EL",
				11=>"S",
				12=>"CI",
				13=>"IP",
				14=>"IA",
				15=>"DI",
				16=>"IPA",
				17=>"E",
				18=>"RE",
				19=>"C",
				20=>"L",
				21=>"LA",
				22=>"I",
				23=>"IL",
				24=>"DL",
				25=>"DE",
				26=>"CB",
				27=>"CA"
				);
			$respuesta = array();
			foreach ($tipos as $value) {
				$sql = "select count(*) as total from $this->tabla 
						join referencias
							on referencias.id_referencia = $this->tabla.id_referencia
						join areas
							on areas.id_area = referencias.id_area
						join disciplinas
							on disciplinas.id_disciplina = areas.id_disciplina
						where
							$this->tabla.tipo_discontinuidad = '".$value."'  
							and disciplinas.id_contrato=".$contrato."
				";

				$resultado = $this->conexion->query($sql);
				if($resultado->num_rows > 0){
					$row=$resultado->fetch_assoc() ;
					if($row['total']>0){
						$respuesta[]= array(
											'tipo' =>$value ,
											'cantidad' => $row['total'],
											'balloonColor' => '#754DEB' );
						//$respuesta[$value] = $row['total'] ;
					}
				}
			}
			return json_encode($respuesta) ;
		}



/**
		grafica disciplinas
*/	





/**
		grafica disciplinas indicaciones internas
*/	








		function getForResumenTotInt( $contrato){
			$tipos = array(
				0=>"CI",
				1=>"IP",
				2=>"IA",
				3=>"DI",
				4=>"IPA",
				5=>"E",
				6=>"RE",
				7=>"C",
				8=>"L",
				9=>"LA",
				10=>"I",
				11=>"IL"
				);
			$respuesta = array();
			foreach ($tipos as $value) {
				$sql = "select count(*) as total from $this->tabla 
						join referencias
							on referencias.id_referencia = $this->tabla.id_referencia
						join areas
							on areas.id_area = referencias.id_area
						join disciplinas
							on disciplinas.id_disciplina = areas.id_disciplina
						where
							$this->tabla.tipo_discontinuidad = '".$value."' 
							and disciplinas.id_contrato=".$contrato."
				";

				$resultado = $this->conexion->query($sql);
				if($resultado->num_rows > 0){
					$row=$resultado->fetch_assoc() ;
					if($row['total']>0){
						$respuesta[$value] = $row['total'] ;
					}
				}
			}
			return json_encode($respuesta) ;
		}



		function getForResumenTotIntGr( $contrato){
			$tipos = array(
				0=>"CI",
				1=>"IP",
				2=>"IA",
				3=>"DI",
				4=>"IPA",
				5=>"E",
				6=>"RE",
				7=>"C",
				8=>"L",
				9=>"LA",
				10=>"I",
				11=>"IL"
				
				);
			$respuesta = array();
			foreach ($tipos as $value) {
				$sql = "select count(*) as total from $this->tabla 
						join referencias
							on referencias.id_referencia = $this->tabla.id_referencia
						join areas
							on areas.id_area = referencias.id_area
						join disciplinas
							on disciplinas.id_disciplina = areas.id_disciplina
						where
							$this->tabla.tipo_discontinuidad = '".$value."' 
							and disciplinas.id_contrato=".$contrato."
				";

				$resultado = $this->conexion->query($sql);
				if($resultado->num_rows > 0){
					$row=$resultado->fetch_assoc() ;
					if($row['total']>0){
						$respuesta[]= array(
											'tipo' =>$value ,
											'cantidad' => $row['total'],
											'balloonColor' => '#754DEB' );
						//$respuesta[$value] = $row['total'] ;
					}
				}
			}
			return json_encode($respuesta) ;
		}

/**
		grafica disciplinas indicaciones internas
*/	


/**


	GENERALES


*/


/**



	area


*/



/**
	grafica disciplinas indicaciones externas
*/

		function getForResumenExtArea($area){
			$tipos = array(
				0=>"CE",
				1=>"DS",
				2=>"Q",
				3=>"AB",
				4=>"DM",
				5=>"M",
				6=>"R",
				7=>"D",
				8=>"P",
				9=>"PA",
				10=>"EL",
				11=>"S",
				12=>"DL",
				13=>"DE",
				14=>"CB",
				15=>"CA"
				);
			$respuesta = array();
			foreach ($tipos as $value) {
				$sql = "select count(*) as total from $this->tabla 
						join referencias
							on referencias.id_referencia = $this->tabla.id_referencia
						join areas
							on areas.id_area = referencias.id_area
						where
							$this->tabla.tipo_discontinuidad = '".$value."' 
							and areas.id_area=".$area."
				";

				$resultado = $this->conexion->query($sql);
				if($resultado->num_rows > 0){
					$row=$resultado->fetch_assoc() ;
					if($row['total']>0){
						$respuesta[$value] = $row['total'] ;
					}
				}
			}
			return json_encode($respuesta) ;
		}



		function getForResumenExtAreaGr($area){
			$tipos = array(
				0=>"CE",
				1=>"DS",
				2=>"Q",
				3=>"AB",
				4=>"DM",
				5=>"M",
				6=>"R",
				7=>"D",
				8=>"P",
				9=>"PA",
				10=>"EL",
				11=>"S",
				12=>"DL",
				13=>"DE",
				14=>"CB",
				15=>"CA"
				);
			$respuesta = array();
			foreach ($tipos as $value) {
				$sql = "select count(*) as total from $this->tabla 
						join referencias
							on referencias.id_referencia = $this->tabla.id_referencia
						join areas
							on areas.id_area = referencias.id_area
						where
							$this->tabla.tipo_discontinuidad = '".$value."' 
							and areas.id_area=".$area."
				";

				$resultado = $this->conexion->query($sql);
				if($resultado->num_rows > 0){
					$row=$resultado->fetch_assoc() ;
					if($row['total']>0){
						$respuesta[]= array(
											'tipo' =>$value ,
											'cantidad' => $row['total'],
											'balloonColor' => '#754DEB' );
						//$respuesta[$value] = $row['total'] ;
					}
				}
			}
			return json_encode($respuesta) ;
		}


/**
		grafica disciplinas indicaciones externas
*/	




/**
		grafica general disciplinas
*/		
		function getForResumenArea($area){
			$tipos = array(
				0=>"CE",
				1=>"DS",
				2=>"Q",
				3=>"AB",
				4=>"DM",
				5=>"M",
				6=>"R",
				7=>"D",
				8=>"P",
				9=>"PA",
				10=>"EL",
				11=>"S",
				12=>"CI",
				13=>"IP",
				14=>"IA",
				15=>"DI",
				16=>"IPA",
				17=>"E",
				18=>"RE",
				19=>"C",
				20=>"L",
				21=>"LA",
				22=>"I",
				23=>"IL",
				24=>"DL",
				25=>"DE",
				26=>"CB",
				27=>"CA"
				);
			$respuesta = array();
			foreach ($tipos as $value) {
				$sql = "select count(*) as total from $this->tabla 
						join referencias
							on referencias.id_referencia = $this->tabla.id_referencia
						join areas
							on areas.id_area = referencias.id_area
						where
							$this->tabla.tipo_discontinuidad = '".$value."' 
							and areas.id_area=".$area."
				";

				$resultado = $this->conexion->query($sql);
				if($resultado->num_rows > 0){
					$row=$resultado->fetch_assoc() ;
					if($row['total']>0){
						$respuesta[$value] = $row['total'] ;
					}
				}
			}
			return json_encode($respuesta) ;
		}



		function getForResumenAreaGr($area){
			$tipos = array(
				0=>"CE",
				1=>"DS",
				2=>"Q",
				3=>"AB",
				4=>"DM",
				5=>"M",
				6=>"R",
				7=>"D",
				8=>"P",
				9=>"PA",
				10=>"EL",
				11=>"S",
				12=>"CI",
				13=>"IP",
				14=>"IA",
				15=>"DI",
				16=>"IPA",
				17=>"E",
				18=>"RE",
				19=>"C",
				20=>"L",
				21=>"LA",
				22=>"I",
				23=>"IL",
				24=>"DL",
				25=>"DE",
				26=>"CB",
				27=>"CA"
				);
			$respuesta = array();
			foreach ($tipos as $value) {
				$sql = "select count(*) as total from $this->tabla 
						join referencias
							on referencias.id_referencia = $this->tabla.id_referencia
						join areas
							on areas.id_area = referencias.id_area
						where
							$this->tabla.tipo_discontinuidad = '".$value."' 
							and areas.id_area=".$area."
				";

				$resultado = $this->conexion->query($sql);
				if($resultado->num_rows > 0){
					$row=$resultado->fetch_assoc() ;
					if($row['total']>0){
						$respuesta[]= array(
											'tipo' =>$value ,
											'cantidad' => $row['total'],
											'balloonColor' => '#754DEB' );
						//$respuesta[$value] = $row['total'] ;
					}
				}
			}
			return json_encode($respuesta) ;
		}



/**
		grafica disciplinas
*/	





/**
		grafica disciplinas indicaciones internas
*/	








		function getForResumenIntArea($area){
			$tipos = array(
				0=>"CI",
				1=>"IP",
				2=>"IA",
				3=>"DI",
				4=>"IPA",
				5=>"E",
				6=>"RE",
				7=>"C",
				8=>"L",
				9=>"LA",
				10=>"I",
				11=>"IL"
				);
			$respuesta = array();
			foreach ($tipos as $value) {
				$sql = "select count(*) as total from $this->tabla 
						join referencias
							on referencias.id_referencia = $this->tabla.id_referencia
						join areas
							on areas.id_area = referencias.id_area
						where
							$this->tabla.tipo_discontinuidad = '".$value."' 
							and areas.id_area=".$area."
				";

				$resultado = $this->conexion->query($sql);
				if($resultado->num_rows > 0){
					$row=$resultado->fetch_assoc() ;
					if($row['total']>0){
						$respuesta[$value] = $row['total'] ;
					}
				}
			}
			return json_encode($respuesta) ;
		}



		function getForResumenIntAreaGr($area){
			$tipos = array(
				0=>"CI",
				1=>"IP",
				2=>"IA",
				3=>"DI",
				4=>"IPA",
				5=>"E",
				6=>"RE",
				7=>"C",
				8=>"L",
				9=>"LA",
				10=>"I",
				11=>"IL"
				);
			$respuesta = array();
			foreach ($tipos as $value) {
				$sql = "select count(*) as total from $this->tabla 
						join referencias
							on referencias.id_referencia = $this->tabla.id_referencia
						join areas
							on areas.id_area = referencias.id_area
						where
							$this->tabla.tipo_discontinuidad = '".$value."' 
							and areas.id_area=".$area."
				";

				$resultado = $this->conexion->query($sql);
				if($resultado->num_rows > 0){
					$row=$resultado->fetch_assoc() ;
					if($row['total']>0){
						$respuesta[]= array(
											'tipo' =>$value ,
											'cantidad' => $row['total'],
											'balloonColor' => '#754DEB' );
						//$respuesta[$value] = $row['total'] ;
					}
				}
			}
			return json_encode($respuesta) ;
		}

/**
		grafica disciplinas indicaciones internas
*/	


/**



	area


*/






/**
		grafica general kilometrajes
*/		
		function getForResumenKm($referencia){
			$tipos = array(
				0=>"CE",
				1=>"DS",
				2=>"Q",
				3=>"AB",
				4=>"DM",
				5=>"M",
				6=>"R",
				7=>"D",
				8=>"P",
				9=>"PA",
				10=>"EL",
				11=>"S",
				12=>"CI",
				13=>"IP",
				14=>"IA",
				15=>"DI",
				16=>"IPA",
				17=>"E",
				18=>"RE",
				19=>"C",
				20=>"L",
				21=>"LA",
				22=>"I",
				23=>"IL",
				24=>"DL",
				25=>"DE",
				26=>"CB",
				27=>"CA"
				);
			$respuesta = array();
			foreach ($tipos as $value) {
				$sql = "select count(*) as total from $this->tabla 
						join referencias
							on referencias.id_referencia = $this->tabla.id_referencia
						where
							$this->tabla.tipo_discontinuidad = '".$value."' 
							and referencias.id_referencia=".$referencia."
				";

				$resultado = $this->conexion->query($sql);
				if($resultado->num_rows > 0){
					$row=$resultado->fetch_assoc() ;
					if($row['total']>0){
						$respuesta[$value] = $row['total'] ;
					}
				}
			}
			return json_encode($respuesta) ;
		}



		function getForResumenKmGr($referencia){
			$tipos = array(
				0=>"CE",
				1=>"DS",
				2=>"Q",
				3=>"AB",
				4=>"DM",
				5=>"M",
				6=>"R",
				7=>"D",
				8=>"P",
				9=>"PA",
				10=>"EL",
				11=>"S",
				12=>"CI",
				13=>"IP",
				14=>"IA",
				15=>"DI",
				16=>"IPA",
				17=>"E",
				18=>"RE",
				19=>"C",
				20=>"L",
				21=>"LA",
				22=>"I",
				23=>"IL",
				24=>"DL",
				25=>"DE",
				26=>"CB",
				27=>"CA"
				);
			$respuesta = array();
			foreach ($tipos as $value) {
				$sql = "select count(*) as total from $this->tabla 
						join referencias
							on referencias.id_referencia = $this->tabla.id_referencia
						where
							$this->tabla.tipo_discontinuidad = '".$value."' 
							and referencias.id_referencia=".$referencia."
				";

				$resultado = $this->conexion->query($sql);
				if($resultado->num_rows > 0){
					$row=$resultado->fetch_assoc() ;
					if($row['total']>0){
						$respuesta[]= array(
											'tipo' =>$value ,
											'cantidad' => $row['total'],
											'balloonColor' => '#754DEB' );
						//$respuesta[$value] = $row['total'] ;
					}
				}
			}
			return json_encode($respuesta) ;
		}



/**
		grafica kilometrajes
*/	





		function getId(){
			return $this->id ;
		}

		function getElemento(){
			return $this->elemento ;
		}

		function getNumeroIndicacion(){
			return $this->numero_indicacion ;
		}

		function getReferenciaIndicacion(){
			return $this->referencia_indicacion ;
		}

		function getDistancia(){
			return $this->distancia ;
		}

		function getHorario(){
			return $this->horario ;
		}

		function getTipoDiscontinuidad(){
			return $this->tipo_discontinuidad ;
		}

		function getLargo(){
			return $this->largo ;
		}

		function getAncho(){
			return $this->ancho ;
		}

		function getProfundidad(){
			return $this->profundidad ;
		}

		function getEspesorMinimo(){
			return $this->espesor_minimo ;
		}

		function getEspesorMaximo(){
			return $this->espesor_maximo ;
		}

		function getEspesorRemanente(){
			return $this->espesor_remanente ;
		}

		function getPerdida(){
			return $this->perdida ;
		}

		function getFotografia(){
			return $this->fotografia ;
		}

		function getComentario(){
			return $this->comentario ;
		}

		function getPosicion(){
			return $this->posicion ;
		}

		function getFecha(){
			return $this->fecha ;
		}

		function getReferencia(){
			return $this->referencia ;
		}

		function getDucto(){
			return $this->ducto ;
		}

	}

?>