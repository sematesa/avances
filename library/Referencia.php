<?php

	include_once("Database.php");

	class Referencia{

		private $id ;
		private $descripcion ;
		private $ubicacion ;
		private $inspector ;
		
		private $area ;
		private $usuario ;
		
		private $tabla ;

		
		function __construct()
		{
			$ob = new Database();
			$this->conexion = $ob->getConexion();
			$this->tabla = "referencias" ;
		}

		function insert($registro){
			$sql = "insert into $this->tabla values(
				0, 
				'".$registro['descripcion']."',
				'".$registro['ubicacion']."',
				'".$registro['inspector']."',
				".$registro['id_area'].",
				".$registro['id_usuario']."
				)";
			$this->conexion->query($sql);
			return $this->conexion->insert_id ;
		}

		function update($registro){
			$sql = "update $this->tabla set 
				descripcion='".$registro['descripcion']."',
				ubicacion='".$registro['ubicacion']."',
				inspector='".$registro['inspector']."'
				where id_referencia = ".$registro['id_referencia']."
			 ";

			$this->conexion->query($sql);
			
			return $sql ;

		}

		function delete($id){
			$sql = "delete from $this->tabla where id_referencia=$id" ;
			$this->conexion->query($sql);
			//return $sql ;
		}

		function loadById($referencia){
			$sql = "select * from $this->tabla where id_referencia=$referencia" ;
			$resultado = $this->conexion->query($sql);
			if($resultado->num_rows > 0){
				$row = $resultado->fetch_assoc();
				$this->id = $row['id_referencia'] ;
				$this->descripcion = $row['descripcion'] ;
				$this->ubicacion = $row['ubicacion'] ;
				$this->inspector = $row['inspector'];
				$this->area = $row['id_area'] ;
				$this->usuario = $row['id_usuario'] ;
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


		function getByArea($area){
			$sql = "select * from $this->tabla where id_area = $area" ;
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

		function getDescripcion(){
			return $this->descripcion ;
		}

		function getUbicacion(){
			return $this->ubicacion ;
		}

		function getInspector(){
			return $this->inspector ;
		}

		function getArea(){
			return $this->area ;
		}

		function getUsuario(){
			return $this->usuario ;
		}

	}

?>