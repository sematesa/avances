<?php

	include_once("Database.php");

	class Ducto{

		private $id ;
		private $nombre ;
		private $tipo_ducto ;
		private $diametro ;
		private $ubicacion_tecnica ;
		private $denominacion_ubicacion_tecnica ;
		private $fluido_manejado ;
		private $presion_actual ;
		private $presion_maxima ;
		private $temperatura_operacion ;
		private $longitud ;
		private $fecha_construccion ;
		private $fecha_inicio_operacion ;
		private $especificacion_material ;
		private $clase_localizacion ;
		
		private $tabla ;

		
		function __construct()
		{
			$ob = new Database();
			$this->conexion = $ob->getConexion();
			$this->tabla = "ductos" ;
		}

		function insert($registro){
			$sql = "insert into $this->tabla values(
				0, 
				'".$registro['nombre']."',
				'".$registro['tipo_ducto']."',
				".$registro['diametro'].",
				'".$registro['ubicacion_tecnica']."',
				'".$registro['denominacion_ubicacion_tecnica']."',
				'".$registro['fluido_manejado']."',
				'".$registro['presion_actual']."',
				'".$registro['presion_maxima']."',
				'".$registro['temperatura_operacion']."',
				".$registro['longitud'].",
				'".$registro['fecha_construccion']."',
				'".$registro['fecha_inicio_operacion']."',
				'".$registro['especificacion_material']."',
				'".$registro['clase_localizacion']."'
				)";
			$this->conexion->query($sql);
			return $this->conexion->insert_id ;
		}

		function update($registro){
			$sql = "update $this->tabla set 
				nombre='".$registro['nombre']."',
				tipo_ducto='".$registro['tipo_ducto']."',
				diametro=".$registro['diametro'].",
				ubicacion_tecnica='".$registro['ubicacion_tecnica']."',
				denominacion_ubicacion_tecnica='".$registro['denominacion_ubicacion_tecnica']."',
				fluido_manejado='".$registro['fluido_manejado']."',
				presion_actual='".$registro['presion_actual']."',
				presion_maxima='".$registro['presion_maxima']."',
				temperatura_operacion='".$registro['temperatura_operacion']."',
				longitud=".$registro['longitud'].",
				fecha_construccion='".$registro['fecha_construccion']."',
				fecha_inicio_operacion='".$registro['fecha_inicio_operacion']."',
				especificacion_material='".$registro['especificacion_material']."',
				clase_localizacion='".$registro['clase_localizacion']."'
				where id_ducto = ".$registro['id_ducto']."
			 ";

			$this->conexion->query($sql);
			
			return $sql ;

		}

		function delete($id){
			$sql = "delete from $this->tabla where id_ducto=$id" ;
			$this->conexion->query($sql);
			//return $sql ;
		}

		function getForIndicaciones( $id_ddv ){
			$sql = "select d.nombre as nombre, 
					d.diametro as diametro, 
					d.tipo_ducto as tipo_ducto,
					d.id_ducto as id from $this->tabla as d
					join ddvsductos as dd on d.id_ducto = dd.id_ducto
					join ddvs as dv on dd.id_ddv = dv.id_ddv
					where dv.id_ddv = $id_ddv ";
					//echo $sql ;
			$array_ductos = array() ;
			$resultado = $this->conexion->query($sql);
			if( $resultado->num_rows >0 ){
				while($row=$resultado->fetch_assoc()){

					$array_ductos[] = $row ;
				}
			}
			return $array_ductos ;
		}

		function loadById($referencia){
			$sql = "select * from $this->tabla where id_ducto=$referencia" ;
			$resultado = $this->conexion->query($sql);
			if($resultado->num_rows > 0){
				$row = $resultado->fetch_assoc();
				$this->id = $row['id_ducto'] ;
				$this->nombre = $row['nombre'] ;
				$this->tipo_ducto = $row['tipo_ducto'] ;
				$this->diametro = $row['diametro'] ;
				$this->ubicacion_tecnica = $row['ubicacion_tecnica'] ;
				$this->denominacion_ubicacion_tecnica = $row['denominacion_ubicacion_tecnica'] ;
				$this->fluido_manejado = $row['fluido_manejado'] ;
				$this->presion_actual = $row['presion_actual'] ;
				$this->presion_maxima = $row['presion_maxima'] ;
				$this->temperatura_operacion = $row['temperatura_operacion'] ;
				$this->longitud = $row['longitud'] ;
				$this->fecha_construccion = $row['fecha_construccion'] ;
				$this->fecha_inicio_operacion = $row['fecha_inicio_operacion'] ;
				$this->especificacion_material = $row['especificacion_material'] ;
				$this->clase_localizacion = $row['clase_localizacion'] ;
				
			}
		}

		function getByDdv($ddv){
			$sql = "select * from $this->tabla" ;
			$array_ductos = array() ;
			$resultado = $this->conexion->query($sql);
			if( $resultado->num_rows >0 ){
				while($row=$resultado->fetch_assoc()){

					$array_ductos[] = $row ;
				}
			}
			return $array_ductos ;
			
		}

		function getAll(){
			$sql = "select * from $this->tabla order by tipo_ducto, nombre" ;
			$array_ductos = array() ;
			$resultado = $this->conexion->query($sql);
			if( $resultado->num_rows >0 ){
				while($row=$resultado->fetch_assoc()){

					$array_ductos[] = $row ;
				}
			}
			return $array_ductos ;
			
		}


		function getId(){
			return $this->id ;
		}

		function getTipoDucto(){
			return $this->tipo_ducto ;
		}

		function getNombre(){
			return $this->nombre;
		}

		function getDiametro(){
			return $this->diametro ;
		}

		function getUbicacionTecnica(){
			return $this->ubicacion_tecnica ;
		}

		function getDenominacionUbicacionTecnica(){
			return $this->denominacion_ubicacion_tecnica ;
		}

		function getFluidoManejado(){
			return $this->fluido_manejado ;
		}

		function getPresionActual(){
			return $this->presion_actual ;
		}

		function getPresionMaxima(){
			return $this->presion_maxima ;
		}

		function getTemperaturaOperacion(){
			return $this->temperatura_operacion ;
		}

		function getLongitud(){
			return $this->longitud ;
		}

		function getFechaConstruccion(){
			return $this->fecha_construccion ;
		}

		function getFechaInicioOperacion(){
			return $this->fecha_inicio_operacion ;
		}

		function getEspecificacionMaterial(){
			return $this->especificacion_material ;
		}

		function getClaseLocalizacion(){
			return $this->clase_localizacion ;
		}


	}

?>