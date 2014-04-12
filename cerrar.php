<?php
/**
	Destruir sesion
*/
	/**
	prueba de cambios
	*/
	session_start();
	session_destroy();
	header("location: index.php");
?>