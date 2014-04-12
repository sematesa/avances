<?php
include_once("Database.php");
	class ConexionExterna{


		private 	$servidor 	;
		private 	$usuario 	;
		private 	$password	;
		private 	$base_datos	;
		private 	$conexion	;

		private 	$id ;
		private 	$numero ;
		private 	$descripcion ;
		private 	$estatus ;
		
		function __construct()
		{
			$ob = new Database();
			$this->conexion = $ob->getConexion();
			$this->tabla = "contratos" ;
		}

		function getContratos(){
			$sql = "select * from $this->tabla" ;
			$array_contratos = array() ;
			$resultado = $this->conexion->query($sql);
			if( $resultado->num_rows >0 ){
				while($row=$resultado->fetch_assoc()){

					$array_contratos[] = $row ;
				}
			}
			return $array_contratos ;
			
		}

		function getIdByNumero($numero){
			$sql = "select id_contrato from $this->tabla where numero='".$numero."'" ;
			$resultado = $this->conexion->query($sql);
			if($resultado->num_rows > 0){
				$row = $resultado->fetch_assoc();
				return $row['id_contrato'] ;
			}
			else{
				return 0 ;
			}
		}

		function loadByIdContrato($contrato){
			$sql = "select * from $this->tabla where id_contrato=$contrato" ;
			$resultado = $this->conexion->query($sql);
			if($resultado->num_rows > 0){
				$row = $resultado->fetch_assoc();
				$this->id = $row['id_contrato'] ;
				$this->numero = $row['numero'] ;
				$this ->descripcion = $row['descripcion'] ;
				$this->estatus = $row['estatus'] ;
			}
		}

		function getId(){
			return $this->id ;
		}

		function getNumero(){
			return $this->numero ;
		}

		function getDescripcion(){
			return $this->descripcion ;
		}

		function getEstatus(){
			return $this->estatus ;
		}





	}
?>