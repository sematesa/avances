<?php
	include_once("../library/Referencia.php");

	$referencia = new Referencia();

	$referencia->delete($_GET['id_referencia']);
	
?>