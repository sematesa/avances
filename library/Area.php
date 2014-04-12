<?php

	include_once("Database.php");

	class Area{

		private $id ;
		private $clasificacion ;
		private $nombre ;
		private $diametro ;
		private $elemento ;
		private $disciplina ;
		private $avance ;
		
		private $tabla ;

		
		function __construct()
		{
			$ob = new Database();
			$this->conexion = $ob->getConexion();
			$this->tabla = "areas" ;
		}

		function insert($registro){
			$sql = "insert into $this->tabla values(
				0, 
				'".$registro['clasificacion']."',
				'".$registro['nombre']."',
				'".$registro['diametro']."',
				".$registro['elemento'].",
				".$registro['id_disciplina'].",
				0
				)";
			$this->conexion->query($sql);
			return $this->conexion->insert_id ;
		}

		function update($registro){
			$sql = "update $this->tabla set 
				avance='".$registro['avance']."'
				where id_area = ".$registro['id_area']."
			 ";

			$this->conexion->query($sql);
			
			return $sql ;

		}

		function delete($id){
			$sql = "delete from $this->tabla where id_area=$id" ;
			$this->conexion->query($sql);
			//return $sql ;
		}

		function loadById($area){
			$sql = "select * from $this->tabla where id_area=$area" ;
			$resultado = $this->conexion->query($sql);
			if($resultado->num_rows > 0){
				$row = $resultado->fetch_assoc();
				$this->id = $row['id_area'] ;
				$this->clasificacion = $row['clasificacion'] ;
				$this->nombre = $row['nombre'] ;
				$this->diametro = $row['diametro'] ;
				$this->elemento = $row['elemento'] ;
				$this ->disciplina = $row['id_disciplina'] ;
				$this ->avance = $row['avance'] ;
			}
		}

		function getAll(){
			$sql = "select * from $this->tabla" ;
			$array_areas = array() ;
			$resultado = $this->conexion->query($sql);
			if( $resultado->num_rows >0 ){
				while($row=$resultado->fetch_assoc()){

					$array_areas[] = $row ;
				}
			}
			return $array_areas ;
			
		}


		function getByDisciplina($disciplina){
			$sql = "select * from $this->tabla where id_disciplina = $disciplina" ;
			$array_areas = array() ;
			$resultado = $this->conexion->query($sql);
			if( $resultado->num_rows >0 ){
				while($row=$resultado->fetch_assoc()){

					$array_areas[] = $row ;
				}
			}
			return $array_areas ;
		}

		function getId(){
			return $this->id ;
		}

		function getClasificacion(){
			return $this->clasificacion ;
		}

		function getNombre(){
			return $this->nombre ;
		}

		function getDiametro(){
			return $this->diametro ;
		}

		function getElemento(){
			return $this->elemento ;
		}

		function getDisciplina(){
			return $this->disciplina ;
		}
		
		function getAvance(){
			return $this->avance ;
		}

	}

?>