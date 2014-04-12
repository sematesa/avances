<?php

	include_once("Database.php");

	class Disciplina{

		private $id ;
		private $nombre ;
		private $contrato ;
		
		private $tabla ;

		
		function __construct()
		{
			$ob = new Database();
			$this->conexion = $ob->getConexion();
			$this->tabla = "disciplinas" ;
		}

		function insert($registro){
			$sql = "insert into $this->tabla values(
				0, 
				'".$registro['nombre']."',
				'".$registro['id_contrato']."'
				)";
			$this->conexion->query($sql);
			return $this->conexion->insert_id ;
		}

		function update($registro){
			$sql = "update $this->tabla set 
				nombre='".$registro['nombre']."',
				id_contrato = ".$registro['id_contrato']."
				where id_disciplina = ".$registro['id_disciplina']."
			 ";

			$this->conexion->query($sql);
			


		}

		function delete($id){
			$sql = "delete from $this->tabla where id_disciplina=$id" ;
			$this->conexion->query($sql);
			//return $sql ;
		}

		function loadById($disciplina){
			$sql = "select * from $this->tabla where id_disciplina=$disciplina" ;
			$resultado = $this->conexion->query($sql);
			if($resultado->num_rows > 0){
				$row = $resultado->fetch_assoc();
				$this->id = $row['id_disciplina'] ;
				$this->nombre = $row['nombre'] ;
				$this ->contrato = $row['id_contrato'] ;
			}
		}

		function getAll(){
			$sql = "select * from $this->tabla" ;
			$array_disciplinas = array() ;
			$resultado = $this->conexion->query($sql);
			if( $resultado->num_rows >0 ){
				while($row=$resultado->fetch_assoc()){

					$array_disciplinas[] = $row ;
				}
			}
			return $array_disciplinas ;
			
		}

		function getGroupContratos(){
			$sql = "select id_disciplina, nombre, id_contrato from $this->tabla order by id_contrato" ;
			$array_disciplinas = array() ;
			$resultado = $this->conexion->query($sql);
			if( $resultado->num_rows >0 ){
				while($row=$resultado->fetch_assoc()){

					$array_disciplinas[] = $row ;
				}
			}
			return $array_disciplinas ;
			
		}

		function loadByContrato($contrato){
			$sql = "select * from $this->tabla where id_contrato = $contrato" ;
			$resultado = $this->conexion->query($sql);
			if($resultado->num_rows > 0){
				$row = $resultado->fetch_assoc();
				$this->id = $row['id_disciplina'] ;
				$this->nombre = $row['nombre'] ;
				$this ->contrato = $row['id_contrato'] ;
			}
		}

		function getByContratos($contrato){
			$sql = "select * from $this->tabla where id_contrato = $contrato" ;
			$array_disciplinas = array() ;
			$resultado = $this->conexion->query($sql);
			if( $resultado->num_rows >0 ){
				while($row=$resultado->fetch_assoc()){

					$array_disciplinas[] = $row ;
				}
			}
			return $array_disciplinas ;
		}

		function getId(){
			return $this->id ;
		}

		function getNombre(){
			return $this->nombre ;
		}

		function getContrato(){
			return $this->contrato ;
		}

	}

?>