<?php
	include_once("../library/Disciplina.php");

	$disciplina = new Disciplina();

	$disciplina->delete($_GET['id_disciplina']);
	
?>