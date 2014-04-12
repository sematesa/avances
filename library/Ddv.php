<?php

	include_once("Database.php");

	class Ddv{

		private $id ;
		private $nombre ;
		private $sector ;
		private $ubicacion_tecnica ;
		
		private $tabla ;

		
		function __construct()
		{
			$ob = new Database();
			$this->conexion = $ob->getConexion();
			$this->tabla = "ddvs" ;
		}

		function insert($registro){
			$sql = "insert into $this->tabla values(
				0, 
				'".$registro['nombre']."',
				'".$registro['sector']."',
				'".$registro['ubicacion_tecnica']."',
				".$registro['id_ddv']."
				)";
			$this->conexion->query($sql);
			return $this->conexion->insert_id ;
		}

		function update($registro){
			$sql = "update $this->tabla set 
				nombre='".$registro['nombre']."',
				sector='".$registro['sector']."',
				ubicacion_tecnica='".$registro['ubicacion_tecnica']."'
				where id_ddv = ".$registro['id_ddv']."
			 ";

			$this->conexion->query($sql);
			
			return $sql ;

		}

		function delete($id){
			$sql = "delete from $this->tabla where id_ddv=$id" ;
			$this->conexion->query($sql);
			//return $sql ;
		}

		function loadById($referencia){
			$sql = "select * from $this->tabla where id_ddv=$referencia" ;
			$resultado = $this->conexion->query($sql);
			if($resultado->num_rows > 0){
				$row = $resultado->fetch_assoc();
				$this->id = $row['id_ddv'] ;
				$this->nombre = $row['nombre'] ;
				$this->sector = $row['sector'] ;
				$this->ubicacion_tecnica = $row['ubicacion_tecnica'];
				$this->obra_especial = $row['id_ddv'] ;
			}
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

		function getId(){
			return $this->id ;
		}

		function getNombre(){
			return $this->nombre ;
		}

		function getSector(){
			return $this->sector ;
		}

		function getUbicacion_tecnica(){
			return $this->ubicacion_tecnica ;
		}


	}

?>