<?php

	include_once("Database.php");

	class DdvDucto{

		private $id ;
		private $ddv ;
		private $ducto ;
		
		
		private $tabla ;

		
		function __construct()
		{
			$ob = new Database();
			$this->conexion = $ob->getConexion();
			$this->tabla = "ddvsductos" ;
		}

		function insert($registro){
			$sql = "insert into $this->tabla values(
				0, 
				".$registro['ddv'].",
				".$registro['ducto'].",
				)";
			$this->conexion->query($sql);
			return $this->conexion->insert_id ;
		}

		function update($registro){
			$sql = "update $this->tabla set 
				ddv=".$registro['ddv'].",
				ducto=".$registro['ducto'].",
				where id_ddv_ducto = ".$registro['id_ddv_ducto']."
			 ";

			$this->conexion->query($sql);
			
			return $sql ;

		}

		function delete($id){
			$sql = "delete from $this->tabla where id_ddv_ducto=$id" ;
			$this->conexion->query($sql);
			//return $sql ;
		}

		function loadById($referencia){
			$sql = "select * from $this->tabla where id_ddv_ducto=$referencia" ;
			$resultado = $this->conexion->query($sql);
			if($resultado->num_rows > 0){
				$row = $resultado->fetch_assoc();
				$this->id = $row['id_ddv_ducto'] ;
				$this->ddv = $row['ddv'] ;
				$this->ducto = $row['ducto'] ;
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

		function getByDdv($ddv){
			$sql = "select * from $this->tabla where id_ddv = $ddv" ;
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

		function getDdv(){
			return $this->ddv ;
		}

		function getDucto(){
			return $this->ducto ;
		}

	}

?>