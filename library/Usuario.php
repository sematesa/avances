<?php

	include_once("Database.php");

	class Usuario{

		private $id ;
		private $nombre ;
		private $perfil ;
		private $compania ;
		private $password ;
		private $contrato ;
		private $usuario ;
		
		
		private $tabla ;

		
		function __construct()
		{
			$ob = new Database();
			$this->conexion = $ob->getConexion();
			$this->tabla = "usuarios" ;
		}

		function insert($registro){
			$sql = "insert into $this->tabla values(
				0, 
				'".$registro['nombre']."',
				'".$registro['perfil']."',
				'".$registro['compania']."',
				'".$registro['password']."',
				'".$registro['contrato']."',
				'".$registro['usuario']."'
				)";
			$this->conexion->query($sql);
			return $this->conexion->insert_id ;
		}

		function update($registro){
			$sql = "update $this->tabla set 
				nombre='".$registro['nombre']."',
				perfil='".$registro['perfil']."',
				compania='".$registro['compania']."'
				where id_usuario = ".$registro['id_usuario']."
			 ";

			$this->conexion->query($sql);
			
			return $sql ;

		}

		function loadByUsuario( $usuario ) {
			$sql = "select * from $this->tabla where usuario = '".$usuario."'" ;
		
			$resultado = $this->conexion->query($sql);
			$rows = $resultado->num_rows ;
			if($rows > 0){
				$row = $resultado->fetch_assoc();
				$this->id = $row['id_usuario'] ;
				$this->nombre = $row['nombre'] ;
				$this->perfil = $row['perfil'] ;
				$this->compania = $row['compania'];
				$this->password = $row['password'] ;
				$this->contrato = $row['contrato'] ;
				$this->usuario = $row['usuario'] ;
			}
			return $rows ;
		}

		function delete($id){
			$sql = "delete from $this->tabla where id_usuario=$id" ;
			$this->conexion->query($sql);
			//return $sql ;
		}

		function loadById($usuario){
			$sql = "select * from $this->tabla where id_usuario=$usuario" ;
			$resultado = $this->conexion->query($sql);
			if($resultado->num_rows > 0){
				$row = $resultado->fetch_assoc();
				$this->id = $row['id_usuario'] ;
				$this->nombre = $row['nombre'] ;
				$this->perfil = $row['perfil'] ;
				$this->compania = $row['compania'];
				$this->password = $row['password'] ;
				$this->contrato = $row['contrato'] ;
				$this->usuario = $row['usuario'] ;
			}
		}

		function getAll(){
			$sql = "select * from $this->tabla" ;
			$array_usuarios = array() ;
			$resultado = $this->conexion->query($sql);
			if( $resultado->num_rows >0 ){
				while($row=$resultado->fetch_assoc()){

					$array_usuarios[] = $row ;
				}
			}
			return $array_usuarios ;
			
		}


		function getId(){
			return $this->id ;
		}

		function getNombre(){
			return $this->nombre ;
		}

		function getPerfil(){
			return $this->perfil ;
		}

		function getCompania(){
			return $this->compania ;
		}

		function getPassword(){
			return $this->password ;
		}

		function getContrato(){
			return $this->contrato ;
		}

		function getUsuario(){
			return $this->usuario ;
		}

	}

?>