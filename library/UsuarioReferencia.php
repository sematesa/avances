<?php

	include_once("Database.php");

	class UsuarioReferencia{

		private $id ;
		private $fecha ;
		private $usuario ;
		private $referencia ;
		

		
		private $tabla ;

		
		function __construct()
		{
			$ob = new Database();
			$this->conexion = $ob->getConexion();
			$this->tabla = "usuarios_referencias" ;
		}

		function insert($registro){
			$sql = "insert into $this->tabla values(
				0, 
				'".$registro['fecha']."',
				".$registro['id_usuario'].",
				".$registro['id_referencia']."
				)";
			$this->conexion->query($sql);
			return $this->conexion->insert_id ;
		}

		function update($registro){
			$sql = "update $this->tabla set 
				fecha='".$registro['fecha']."',
				id_usuario=".$registro['ubicacion'].",
				id_referencia=".$registro['id_referencia']."
				where id_usuario_referencia = ".$registro['id_usuario_referencia']."
			 ";

			$this->conexion->query($sql);
			
			return $sql ;

		}

		function delete($id){
			$sql = "delete from $this->tabla where id_usuario_referencia=$id" ;
			$this->conexion->query($sql);
			//return $sql ;
		}

		function loadById($referencia){
			$sql = "select * from $this->tabla where id_usuario_referencia=$referencia" ;
			$resultado = $this->conexion->query($sql);
			if($resultado->num_rows > 0){
				$row = $resultado->fetch_assoc();
				$this->id = $row['id_referencia'] ;
				$this->fecha = $row['fecha'] ;
				$this->usuario = $row['id_usuario'] ;
				$this->referencia = $row['id_referencia'];
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

		function getFecha(){
			return $this->fecha ;
		}

		function getUsuario(){
			return $this->usuario ;
		}

		function getReferencia(){
			return $this->referencia ;
		}

	}

?>