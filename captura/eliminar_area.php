<?php
	include_once("../library/Area.php");

	$area = new Area();

	$area->delete($_GET['id_area']);
	
?>