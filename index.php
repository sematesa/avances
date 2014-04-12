<?php
session_start() ;
	include_once("library/ConexionExterna.php");
	include_once("library/Usuario.php");

	$conexion_externa = new ConexionExterna();
	$usuario = new Usuario();

	$array_contratos = $conexion_externa->getContratos();

	$usuarioenc = 1 ;
	$passwordenc = 1 ;

	if(!empty($_POST)){

                if( $usuario ->loadByUsuario( strtolower( $_POST['usuario']) ) == 0){
                  //echo "Clave de usuario incorrecta.";
                	$usuarioenc = 0 ;
                }
                else if($usuario->getPassword() != $_POST['password'] ){
                 //echo "La contraseña intruducida es incorrecta."; 
                	$passwordenc = 0 ;
                }
                 else{
                  $_SESSION=array(
                      'nombre'=>$usuario->getNombre(),
                      'perfil'=>$usuario->getPerfil(),
                      'compania'=>$usuario->getCompania(),
                      'usuario'=>$usuario->getUsuario(),
                      'id_usuario'=>$usuario->getId(),
                      'contrato'=>$usuario->getContrato()
                    );

                 

                  
                }


	}

	if(isset($_SESSION['id_usuario'])){
		 switch ($_SESSION['perfil']) {
                  //  case '*':
                     // header("location: presentacion/index.php?id_contrato=2");
                    //  break;
                    case 'ADMINISTRADOR':
                      header("location: control_admin.php");
                      break;
                   case 'CAPTURA':
                      header("location: captura/captura.php");
                      break;
                     case 'OBSERVADOR':
                     	$clave_contrato = $conexion_externa->getIdByNumero($_SESSION['contrato']) ;
                      header("location: presentacion/index.php?id_contrato=".$clave_contrato);
                      break;
                /*    case 'SUPERINTENDENTE DE OBRA':
                      header("location: revisiones");
                      break;
                    case 'ADMINISTRADOR':
                      header("location: administracion");
                      break;*/

                  }
	}

?>


<!DOCTYPE html>
<!-- Website template by freewebsitetemplates.com -->
<html>
<head>
	<meta charset="UTF-8">
	<title>Servicios Marinos y Terrestres S. A. de C. V.</title>
	<link rel="stylesheet" href="css/style.css" type="text/css">


</head>
<body>
	<div class="border">
		<div id="bg">
			background
		</div>
		<div class="page">
			<div class="sidebar">
				<a href="#" id="logo"><img src="images/logo.png" alt="logo" with="200" height="200" style="float:right; margin:10px;"></a>

				
					
				</ul>


				<div class="copy">
				
				<p>
					Copyright 2023
				</p>
				<p>
					Servicios Marinos y Terrestres S. A. de C. V.
				</p>
				</div>
			</div>
			<div class="body">
				
				<div class="contact">
					<center>
					<p>
						Sistema electrónico de presentación de avances de contratos.
					</p>
					<br>
					<br>
					<br>
					<br>

					<h2>Inicio de sesión</h2>
					
					<form method="POST">

						<label for="usuario">Usuario</label>
						<input type="text" id="usuario" name="usuario" class="texto" required >

						<label for="password">Password</label>
						<input type="password" id="password" name="password" class="texto" required >
						
						<input type="submit" class="boton" value="Guardar">
					</form>


					<?php
						if($usuarioenc == 0 ){
							?>
							<div id="error_login">Clave de usuario incorrecta.</div>
							<?php
						}
						if($passwordenc == 0 ){
							?>
							<div id="error_login">Password incorrecto.</div>
							<?php
						}
					?>
					


					</center>
					<div class="tabla">


											<br>
					<br>
					<br>
										<br>
					<br>
					<br>
						<!--  tabla de captura  -->

					</div>
				</div>
				
			</div>
		</div>
	</div>
</body>
</html>