<?php

	include_once("Database.php");

	class FotografiaReparacion{

		private $id ;
		private $nombre ;
		private $ruta ;
		private $comentario ;
		private $lugar ;
		private $referencia ;
		private $ducto ;
		
		private $tabla ;

		
		function __construct()
		{
			$ob = new Database();
			$this->conexion = $ob->getConexion();
			$this->tabla = "fotografia_reparacion" ;
		}

		function insert($registro){
			$sql = "insert into $this->tabla values(
				0, 
				'".$registro['nombre']."',
				'".$registro['ruta']."',
				'".$registro['comentario']."',
				".$registro['lugar'].",
				".$registro['id_referencia'].",
				".$registro['id_ducto']."
				)";
			$this->conexion->query($sql);
			return $this->conexion->insert_id ;
		}

		function updateLugar($posicion,$elemento){
			$sql = "update $this->tabla set 
				lugar=$posicion
				where id_fotografia_reparacion = $elemento ";

			$this->conexion->query($sql);
			
			return $sql ;

		}

		function getUltimoLugar($referencia){
			$sql  = "select max(lugar) from $this->tabla where id_referencia= $referencia " ; 
			$resultado = $this->conexion->query($sql) ;
			$valor = 0 ;
			if($resultado->num_rows > 0){
				$row = $resultado->fetch_array() ;
				$valor = $row[0] ;
			}
			return $valor ;
		}

		function updateNombre($nombre, $elemento){
			$sql = "update $this->tabla set 
				nombre='".$nombre."'
				where id_fotografia_reparacion = $elemento ";

			$this->conexion->query($sql);
			
			return $sql ;

		}

		function delete($id){
			$sql = "delete from $this->tabla where id_fotografia_reparacion=$id" ;
			$this->conexion->query($sql);
			//return $sql ;
		}

		function loadById($elemento){
			$sql = "select * from $this->tabla where id_fotografia_reparacion=$elemento" ;
			$resultado = $this->conexion->query($sql);
			if($resultado->num_rows > 0){
				$row = $resultado->fetch_assoc();
				$this->id = $row['id_fotografia_reparacion'] ;
				$this->nombre = $row['nombre'] ;
				$this->ruta = $row['ruta'] ;
				$this->comentario = $row['comentario'] ;
				$this->lugar = $row['lugar'] ;
				$this->referencia = $row['id_referencia'] ;
				$this->ducto = $row['id_ducto'] ;
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


		function getByReferencia($referencia){
			$sql = "select * from $this->tabla where id_referencia = $referencia order by lugar" ;
			$array_referencias = array() ;
			$resultado = $this->conexion->query($sql);
			if( $resultado->num_rows >0 ){
				while($row=$resultado->fetch_assoc()){
					$row['tabla'] = 'fotografia_reparacion' ;
					$array_referencias[$row['lugar']] = $row ;
				}
			}
		//	echo $sql ;
			return $array_referencias ;
		}

		function getByReferenciaDdv($referencia, $id_ducto){
			$sql = "select * from $this->tabla where id_referencia = $referencia and id_ducto = $id_ducto order by lugar" ;
			$array_referencias = array() ;
			$resultado = $this->conexion->query($sql);
			if( $resultado->num_rows >0 ){
				while($row=$resultado->fetch_assoc()){
					$row['tabla'] = 'fotografia_reparacion' ;
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

		function getRuta(){
			return $this->ruta ;
		}

		function gerComentario(){
			return $this->comentario ;
		}

		function getLugar(){
			return $this->lugar ;
		}

		function getReferencia(){
			return $this->referencia ;
		}

		function getDucto(){
			return $this->ducto ;
		}

	}

?>