<?php

	include_once("Database.php");

	class ObraEspecial{

		private $id ;
		private $clasificacion ;
		
		private $referencia ;
		
		private $tabla ;

		
		function __construct()
		{
			$ob = new Database();
			$this->conexion = $ob->getConexion();
			$this->tabla = "obras_especiales" ;
		}

		function insert($registro){
			$sql = "insert into $this->tabla values(
				0, 
				'".$registro['clasificacion']."',
				".$registro['id_referencia']."
				)";
			$this->conexion->query($sql);
			return $this->conexion->insert_id ;
		}

		function update($registro){
			$sql = "update $this->tabla set 
				clasificacion='".$registro['clasificacion']."',
				where id_obra_especial = ".$registro['id_obra_especial']."
			 ";

			$this->conexion->query($sql);
			
			return $sql ;

		}

		function delete($id){
			$sql = "delete from $this->tabla where id_obra_especial=$id" ;
			$this->conexion->query($sql);
			//return $sql ;
		}

		function loadById($id_obra_especial){
			$sql = "select * from $this->tabla where id_obra_especial=$id_obra_especial" ;
			$resultado = $this->conexion->query($sql);
			if($resultado->num_rows > 0){
				$row = $resultado->fetch_assoc();
				$this->id = $row['id_obra_especial'] ;
				$this->clasificacion = $row['clasificacion'] ;
				$this->referencia = $row['id_referencia'] ;
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

		function getClasificacion(){
			return $this->clasificacion ;
		}

		function getReferencia(){
			return $this->Referencia ;
		}

	}

?>