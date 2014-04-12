<?php

	include_once("Database.php");

	class FotografiaCronologia{

		private $id ;
		private $nombre ;
		private $posicion ;
		private $comentario ;
		
		private $obra_especial ;
		
		private $tabla ;

		
		function __construct()
		{
			$ob = new Database();
			$this->conexion = $ob->getConexion();
			$this->tabla = "fotografias_cronologia" ;
		}

		function insert($registro){
			$sql = "insert into $this->tabla values(
				0, 
				'".$registro['nombre']."',
				".$registro['posicion'].",
				'".$registro['comentario']."',
				".$registro['id_obra_especial']."
				)";
			$this->conexion->query($sql);
			return $this->conexion->insert_id ;
		}

		function update($registro){
			$sql = "update $this->tabla set 
				nombre='".$registro['nombre']."',
				posicion=".$registro['posicion'].",
				comentario='".$registro['comentario']."'
				where id_fotografia_cronologia = ".$registro['id_fotografia_cronologia']."
			 ";

			$this->conexion->query($sql);
			
			return $sql ;

		}

		function delete($id){
			$sql = "delete from $this->tabla where id_fotografia_cronologia=$id" ;
			$this->conexion->query($sql);
			//return $sql ;
		}

		function loadById($referencia){
			$sql = "select * from $this->tabla where id_fotografia_cronologia=$referencia" ;
			$resultado = $this->conexion->query($sql);
			if($resultado->num_rows > 0){
				$row = $resultado->fetch_assoc();
				$this->id = $row['id_fotografia_cronologia'] ;
				$this->nombre = $row['nombre'] ;
				$this->posicion = $row['posicion'] ;
				$this->comentario = $row['comentario'];
				$this->obra_especial = $row['id_obra_especial'] ;
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


		function getByobra_especial($obra_especial){
			$sql = "select * from $this->tabla where id_obra_especial = $obra_especial" ;
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

		function getPosicion(){
			return $this->posicion ;
		}

		function getComentario(){
			return $this->comentario ;
		}

		function getobra_especial(){
			return $this->obra_especial ;
		}

	}

?>