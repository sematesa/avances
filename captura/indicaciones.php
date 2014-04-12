<?php
	session_start() ;

	//print_r($_SESSION) ;

	if( isset($_SESSION['perfil']) && ( $_SESSION['perfil'] === 'ADMINISTRADOR' || $_SESSION['perfil'] === 'CAPTURA' )  ) {

	
	include_once("../library/Area.php");
	include_once("../library/Disciplina.php");
	include_once("../library/Referencia.php");
	include_once("../library/Indicaciones.php");
	include_once("../library/ConexionExterna.php");
	include_once("../library/Ddv.php");
	include_once("../library/Ducto.php");
	include_once("../library/FotografiaReparacion.php");

	$area = new Area();
	$disciplina = new Disciplina();
	$referencia =  new Referencia();
	$indicaciones = new Indicaciones();
	$conexion_externa = new ConexionExterna ();
	$ducto = new Ducto();
	$ddv = new Ddv();
	$fotografia_reparacion = new FotografiaReparacion();


	

	$referencia->loadById($_GET['id_referencia']);
	$area->loadById($referencia->getArea());
	$disciplina->loadById($area->getDisciplina());
	$conexion_externa->loadByIdContrato($disciplina->getContrato());
	//echo $area->getClasificacion() ;
	if($area->getClasificacion() == 'DDV'){
		$ddv->loadById($area->getElemento());
	}
	else{
		$ducto->loadById($area->getElemento());
	}

	if(isset($_GET['id_ducto'])){
		$ducto ->loadById($_GET['id_ducto']);
		$folder = str_replace('Ñ', 'N',"../files/".$conexion_externa->getNumero()."/".str_replace('Ñ', 'N', $disciplina->getNombre() )."/".str_replace('Ñ', 'N', $area->getClasificacion()."-".$area->getNombre()."-".$area->getDiametro())."/".str_replace('Ñ', 'N', $referencia->getDescripcion())."/".$ducto->getTipoDucto()."-".$ducto->getNombre()."-".$ducto->getDiametro() ) ;
	//	echo $folder ;
	}
	else{
		$folder = str_replace('Ñ', 'N', "../files/".$conexion_externa->getNumero()."/".$disciplina->getNombre()."/".$area->getClasificacion()."-".$area->getNombre()."-".$area->getDiametro()."/".$referencia->getDescripcion() );
	}
	
	if(isset($_POST) && !empty($_POST) ){
		if($_POST['tipo'] == 1){
				$_POST['tipo_discontinuidad'] = $_POST['tipo_discontinuidad_e'] ;
			}
			else{
				$_POST['tipo_discontinuidad'] = $_POST['tipo_discontinuidad_i'] ;
			}
	
		if( $_POST['tipo_discontinuidad'] == 'CE' || $_POST['tipo_discontinuidad'] == 'M' || $_POST['tipo_discontinuidad'] == 'R' || $_POST['tipo_discontinuidad'] == 'D' || $_POST['tipo_discontinuidad'] == 'CI' || $_POST['tipo_discontinuidad'] == 'DI'){
			$_POST['espesor_remanente'] = $_POST['espesor_minimo'] - $_POST['profundidad'] ;
			
			$_POST['perdida'] = $_POST['profundidad'] / $_POST['espesor_minimo'] ;
		}
		else{
			$_POST['espesor_remanente'] = 0 ;
			
			$_POST['perdida'] = 0 ;
		}
		
		
		if(isset($_GET['accion'])){
			$indicaciones->update($_POST);
			?>
			<script type="text/javascript">
				alert("Actualización exitosa");
				window.location="indicaciones.php?id_referencia=<?php echo $_GET['id_referencia']; ?>";
			</script>
			<?php
		}
		else{

		//	print_r($_POST) ;




			$posicion_f = $fotografia_reparacion->getUltimoLugar($referencia->getId());
			$posicion2_f = $indicaciones->getMaxLugar($referencia->getId()) ;
		//	echo $posicion_f . "---" . $posicion2_f . "---" ;
			if($posicion_f < $posicion2_f) {
				$posicion_f = $posicion2_f ;
			}



			
			$_POST['fotografia'] = '' ;
			$_POST['posicion'] = 0 ;
			$id_insert = $indicaciones->insert($_POST);	
			if(!empty($_FILES['fotografia']['tmp_name'])){
				$pos = $posicion_f + 1  ;
				$name = $pos .'.jpg';
            	copy($_FILES['fotografia']['tmp_name'], $folder.'/'.$name) ;
            	$indicaciones->updateFotografia($id_insert,$name);
            	$indicaciones->updatePosicion($pos , $id_insert);
           		include("ejecutar.php");
           		echo $pos ;
       		}

			?>
			<script type="text/javascript">
				alert("Inserción exitosa");
			</script>
			<?php
		}
	}



	if(isset($_GET['id_indicacion'])){

		$indicaciones->loadById($_GET['id_indicacion']);
		$id_indicacion = $indicaciones->getId();
		$elemento = $indicaciones->getElemento();
		$numero_indicacion = $indicaciones->getNumeroIndicacion() ;
		$referencia_indicacion = $indicaciones->getReferenciaIndicacion();
		$distancia = $indicaciones->getDistancia();
		$horario = $indicaciones->getHorario();
		$tipo_discontinuidad = $indicaciones->getTipoDiscontinuidad();
		$largo = $indicaciones->getLargo();
		$ancho = $indicaciones->getAncho();
		$profundidad = $indicaciones->getProfundidad();
		$espesor_minimo = $indicaciones->getEspesorMinimo();
		$espesor_maximo = $indicaciones->getEspesorMaximo();
		//$espesor_remanente = $indicaciones->getEspesorRemanente();
		//$perdida = $indicaciones->getPerdida();
		$fotografia = $indicaciones->getFotografia();
		$comentario = $indicaciones->getComentario();
		$fecha = $indicaciones->getFecha();
		$posicion = $indicaciones->getPosicion();
		$id_referencia = $indicaciones->getReferencia();
	}
	else{
		$id_indicacion = '';
		$elemento = '';
		$numero_indicacion = '';
		$referencia_indicacion = '';
		$distancia = '';
		$horario = '';
		$tipo_discontinuidad = '';
		$largo = '';
		$ancho = '';
		$profundidad = '';
		$espesor_minimo = '';
		$espesor_maximo = '';
		//$espesor_remanente = '';
		//$perdida = '';
		$fotografia = '';
		$id_referencia = '';
		$id_referencia = $_GET['id_referencia'] ;
		$comentario = '';
		$fecha = '0000-00-00' ;
	}

//	$array_areas = $conexion_externa->getAreas();


?>



<!DOCTYPE html>
<!-- Website template by freewebsitetemplates.com -->
<html>
<head>
	<meta charset="UTF-8">
	<title>Servicios Marinos y Terrestres S. A. de C. V.</title>
	<link rel="stylesheet" href="../css/style.css" type="text/css">
	<link type="text/css" href="../css/tooltip/atooltip.css" rel="stylesheet"  media="screen" />

	<link rel="stylesheet" href="../css/ui-lightness/jquery-ui.css" />

	<script type="text/javascript" src="../js/jquery.min.js"></script>
	<script src="../js/jquery-1.8.3.js"></script>
	<script src="../js/jquery-ui.js"></script>

	<script type="text/javascript" src="../js/jquery.atooltip.js"></script>

	

	<script type="text/javascript">
			$(function(){ 

				

				$("#fecha").datepicker({
			          changeYear: true,
			          changeMonth: true,
			          yearRange: "2012:2030",
			          dateFormat:"yy-mm-dd",
			          monthNamesShort:["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
			          dayNamesMin:["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa"]
			        });

			$('a.normalTip').aToolTip();
				
			}); 

			

		function confirmation(a) {
			var answer = confirm("¿Desea borrar permanentemente el elemento? ");
			if (answer){
				 $.get("eliminar_indicacion.php?id_indicacion="+a);
				alert("Indicación eliminada con éxito");
			}
		}

		function calculaLargo(){
			var valor = document.getElementById("largo").value ;
			var arreglo = valor.split(' ');
			if(arreglo.length>2){
				//alert("Dato erróneo") ;
				document.getElementById("largo").value="";
			}else if(arreglo.length == 1){
				if(isNaN(arreglo[0])){
					var a = arreglo[0].substring(0,arreglo[0].indexOf("/")) ;
					var b = arreglo[0].substring(arreglo[0].indexOf("/") + 1) ;
					document.getElementById("largo").value=(a/b).toFixed(3);
				}
			}else if(arreglo.length == 2){
				var a = parseFloat(arreglo[1].substring(0,arreglo[1].indexOf("/")) );
					var b = parseFloat(arreglo[1].substring(arreglo[1].indexOf("/") + 1) );
					var c = parseFloat(arreglo[0]) + parseFloat( (a/b)) ;
					//alert(c);
					document.getElementById("largo").value=c.toFixed(3);
			}

			if( isNaN(document.getElementById("largo").value) ){
				alert("error");
				document.getElementById("largo").value = '';
			}
		}

		function calculaAncho(){
			var valor = document.getElementById("ancho").value ;
			var arreglo = valor.split(' ');
			if(arreglo.length>2  ){
				//alert("Dato erróneo") ;
				document.getElementById("ancho").value="";
			}else if(arreglo.length == 1){
				if(isNaN(arreglo[0])){
					var a = arreglo[0].substring(0,arreglo[0].indexOf("/")) ;
					var b = arreglo[0].substring(arreglo[0].indexOf("/") + 1) ;
					document.getElementById("ancho").value=(a/b).toFixed(3);
				}
			}else if(arreglo.length == 2){
				var a = parseFloat(arreglo[1].substring(0,arreglo[1].indexOf("/")) );
					var b = parseFloat(arreglo[1].substring(arreglo[1].indexOf("/") + 1) );
					var c = parseFloat(arreglo[0]) + parseFloat( (a/b)) ;
					//alert(c);
					document.getElementById("ancho").value=c.toFixed(3);
			}

			if( isNaN(document.getElementById("ancho").value) ){
				alert("error");
				document.getElementById("ancho").value = '';
			}
		}

		function formatear(){
			var valor = document.getElementById("horario").value ;
			var cadena = "" ;
			 
			valor = valor.replace(/ /g,"");
			valor = valor.replace(/:/g,"");
			
			//console.log(valor);
			if(valor.length == 4){
				document.getElementById("horario").value = valor.slice(0,2)+":"+valor.slice(2,4);
			}
			else if(valor.length == 8){
				document.getElementById("horario").value = 
													valor.slice(0,2)
													+":"+
													valor.slice(2,4)
													+" - "+
													valor.slice(4,6)
													+":"+
													valor.slice(6,8);

			}
			else{
				alert("El horario no cumple con la estructura");
				document.getElementById("horario").value = '' ;
			}
		}

		function muestra1(){
			document.getElementById("discontinuidad_visual").style.display='block';
			document.getElementById("discontinuidad_ci").style.display='none';
		}

		function muestra2(){
			document.getElementById("discontinuidad_ci").style.display='block';
			document.getElementById("discontinuidad_visual").style.display='none';
		}


		</script>

</head>
<body>
	<div class="border">
		<div id="bg">
			background
		</div>
		<div class="page">
			<div class="sidebar">
				<a href="../index.html" id="logo"><img src="../images/logo.png" alt="logo" with="120" height="120" style="float:right; margin:10px;"></a>

				<ul>
					<li>
						<a href="../index.php">Inicio</a>
					</li>
					<li>
						<a href="about.html">Acerca</a>
					</li>
					<li class="selected">
						<a href="captura.php">Captura</a>
					</li>
					<li>
						<a href="portfolio.html">Presentación</a>
					</li>
					<li>
						<a href="../administracion/administracion.php">Administración</a>
					</li>
					
				</ul>

				<div style="text-align:right; margin-right:30px; margin-top:20px;"><a href="../cerrar.php">Cerrar sesión</a></div>

				<div class="copy">
				
				<p>
					Copyright 2013
				</p>
				<p>
					Servicios Marinos y Terrestres S. A. de C. V.
				</p>
				</div>
			</div>
			<div class="body">
				<div class="submenu" >
					<a href="captura.php" >Disciplinas</a>
					<a href="area.php?id_disciplina=<?php echo $area->getDisciplina(); ?>">Areas</a>
					<a href="referencia.php?id_area=<?php echo $referencia->getArea(); ?>" >Referencias</a>
				</div>
				<div class="contact">
					<h2>Referencia</h2>
					
					<form method="POST" enctype="multipart/form-data">

						<input type="hidden" name="id_referencia" value="<?php echo $id_referencia; ?>" >
						<input type="hidden" name="id_indicacion" value="<?php echo $id_indicacion ; ?>">

						<label for="id_ducto">Ducto</label>

								<input type="hidden" name="id_ducto" value="<?php echo $ducto->getId(); ?>">
								<input class="texto" disabled="disabled" type="text" name="nombre_ducto" value="<?php echo $ducto->getTipoDucto() . " " . $ducto->getDiametro() . " Ø " . $ducto->getNombre() ; ?>">


						
						

						<label for="elemento">Elemento</label>
						<input type="text" id="elemento" name="elemento" value="<?php echo $elemento; ?>" class="texto" required >
						
						<label for="numero_indicacion">Número de Indicación</label>
						<input type="text" id="numero_indicacion" name="numero_indicacion" value="<?php echo $numero_indicacion; ?>" class="texto" required >

						<label for="referencia_indicacion">Referencia de la Indicación</label>
						<input type="text" id="referencia_indicacion" name="referencia_indicacion" value="<?php echo $referencia_indicacion; ?>" class="texto" required >

						<label for="distancia">Distancia</label>
						<input type="text" id="distancia" name="distancia" value="<?php echo $distancia; ?>" class="texto" required >

						<label for="horario">Horario</label>
						<input type="text" id="horario" onchange="formatear();" name="horario" value="<?php echo $horario; ?>" class="texto" required >

						<label for="tipo_discontinuidad">Tipo de Discontinuidad</label>
						<br>

						<input type="radio" onclick="muestra1();" name="tipo" value="1" > Indicaciones externas
						<input type="radio" onclick="muestra2();" name="tipo" value="2" checked="checked"> Indicaciones internas

						

						<div id="discontinuidad_visual" style="display:none;">
						<select id="tipo_discontinuidad" name="tipo_discontinuidad_e" class="opciones">
							<option <?php echo ($tipo_discontinuidad=='CE') ? "selected='selected'" : "" ; ?> value="CE">(CE) CORROSIÓN EXTERNA</option>
							<option <?php echo ($tipo_discontinuidad=='DS') ? "selected='selected'" : "" ; ?> value="DS">(DS) DEPÓSITO DE SOLDADURA</option>
							<option <?php echo ($tipo_discontinuidad=='Q') ? "selected='selected'" : "" ; ?> value="Q">(Q) QUEMADURA POR ARCO ELÉCTRICO</option>
							<option <?php echo ($tipo_discontinuidad=='AB') ? "selected='selected'" : "" ; ?> value="AB">(AB) ABOLLADURA</option>
							<option <?php echo ($tipo_discontinuidad=='DM') ? "selected='selected'" : "" ; ?> value="DM">(DM) DAÑO MECÁNICO</option>
							<option <?php echo ($tipo_discontinuidad=='M') ? "selected='selected'" : "" ; ?> value="M">(M) MUESCA</option>
							<option <?php echo ($tipo_discontinuidad=='R') ? "selected='selected'" : "" ; ?> value="R">(R) RAYADURA</option>
							<option <?php echo ($tipo_discontinuidad=='D') ? "selected='selected'" : "" ; ?> value="D">(D) DESBASTE</option>
							<option <?php echo ($tipo_discontinuidad=='P') ? "selected='selected'" : "" ; ?> value="P">(P) POROS</option>
							<option <?php echo ($tipo_discontinuidad=='PA') ? "selected='selected'" : "" ; ?> value="PA">(PA) POROS AGRUPADOS</option>
							<option <?php echo ($tipo_discontinuidad=='EL') ? "selected='selected'" : "" ; ?> value="EL">(EL) ESCALA LAMINAR</option>
							<option <?php echo ($tipo_discontinuidad=='S') ? "selected='selected'" : "" ; ?> value="S">(S) SOCABADO</option>
							<option <?php echo ($tipo_discontinuidad=='S') ? "selected='selected'" : "" ; ?> value="CB">(CB) CORONA BAJA</option>
							<option <?php echo ($tipo_discontinuidad=='S') ? "selected='selected'" : "" ; ?> value="CA">(CA) CORONA ALTA</option>
							
						</select>
						</div>

						<div id="discontinuidad_ci" style="display:block;">
							<select id="tipo_discontinuidad" name="tipo_discontinuidad_i" class="opciones">
							<option  value="SIR">(SIR) Sin Indicaciones Relevantes</option>
								<option <?php echo ($tipo_discontinuidad=='CI') ? "selected='selected'" : "" ; ?> value="CI">(CI) CORROSIÓN INTERNA</option>
								<option <?php echo ($tipo_discontinuidad=='IP') ? "selected='selected'" : "" ; ?> value="IP">(IP) INDICACIÓN PUNTUAL</option>
								<option <?php echo ($tipo_discontinuidad=='IA') ? "selected='selected'" : "" ; ?> value="IA">(IA) INDICACIÓN AGRUPADA</option>
								<option <?php echo ($tipo_discontinuidad=='DI') ? "selected='selected'" : "" ; ?> value="DI">(DI) DESGASTE INTERNO</option>
								<option <?php echo ($tipo_discontinuidad=='IPA') ? "selected='selected'" : "" ; ?> value="IPA">(IPA) INDICACIÓN PUNTUAL AGRUPADA</option>
								<option <?php echo ($tipo_discontinuidad=='E') ? "selected='selected'" : "" ; ?> value="E">(E) ELÍPTICA</option>
								<option <?php echo ($tipo_discontinuidad=='RE') ? "selected='selected'" : "" ; ?> value="RE">(RE) RECTANGULAR</option>
								<option <?php echo ($tipo_discontinuidad=='C') ? "selected='selected'" : "" ; ?> value="C">(C) CIRCULAR</option>
								<option <?php echo ($tipo_discontinuidad=='L') ? "selected='selected'" : "" ; ?> value="L">(L) LINEAL</option>
								<option <?php echo ($tipo_discontinuidad=='LA') ? "selected='selected'" : "" ; ?> value="LA">(LA) LAMINACIONES</option>
								<option <?php echo ($tipo_discontinuidad=='I') ? "selected='selected'" : "" ; ?> value="I">(I) INCLUSIONES</option>
								<option <?php echo ($tipo_discontinuidad=='IL') ? "selected='selected'" : "" ; ?> value="IL">(IL)</option>
								<option <?php echo ($tipo_discontinuidad=='DL') ? "selected='selected'" : "" ; ?> value="DL">(DL) DELAMINACIÓN</option>
							</select>
						</div>



				

						<label for="largo">Largo</label>
						<input type="text" id="largo" name="largo" onchange="calculaLargo();" value="<?php echo $largo; ?>" class="texto" required >

						<label for="ancho">Ancho</label>
						<input type="text" id="ancho" name="ancho" onchange="calculaAncho();" value="<?php echo $ancho; ?>" class="texto" required >

						<label for="profundidad">Profundidad</label>
						<input type="text" id="profundidad" name="profundidad" value="<?php echo $profundidad; ?>" class="texto" required >

						<label for="espesor_minimo">Espesor mínimo</label>
						<input type="text" id="espesor_minimo" name="espesor_minimo" value="<?php echo $espesor_minimo; ?>" class="texto" required >

						<label for="espesor_maximo">Espesor máximo</label>
						<input type="text" id="espesor_maximo" name="espesor_maximo" value="<?php echo $espesor_maximo; ?>" class="texto" required >

						<label for="fecha">Fecha</label>
						<input type="text" id="fecha" name="fecha" value="<?php echo $fecha; ?>" class="texto"  >
						
						

						<?php if(!isset($_GET['accion'])){ ?>
							<label for="fotografia">Fotografia</label>
							<input type="file" id="fotografia" name="fotografia" value="<?php echo $fotografia; ?>" class="texto" >

							<label for="comentario">Comentario</label>
							<textarea id="comentario" name="comentario"></textarea>
						<?php
							}
							else{
								?>
								<br>
								 <label for="fotografia">Fotografia</label>
								<img id="fotografia" src="<?php echo $folder.'/'.$fotografia ?>" with="250" height="200" >

								<input type="hidden" name="fotografia" value="<?php echo $fotografia ; ?>" >
								<input type="hidden" name="comentario" value="<?php echo $comentario ; ?>" >
								<input type="hidden" name="posicion" value="<?php echo $posicion  ; ?>" >

								<br>

								<?php
								echo $comentario;
							}
						?>

						<input type="submit" class="boton" value="Guardar">
					</form>


										<div class="tabla">

						<table class="tabla_contenido_indicaciones">
							<tr>
								<th colspan="15" style="background:#484848;">
									<?php
									
										echo "Contrato: " . $conexion_externa->getNumero();
									?>
									<br>
									<?php echo $disciplina->getNombre() . " - " . $area->getNombre() . " - " . $referencia->getDescripcion() ; ?>
								</th>
							</tr>
							<tr>
								<th>Elemento</th>
								<th>No. Ind.</th>
								<th>Ref. Ind.</th>
								<th>Dist.</th>
								<th>Hor.</th>
								<th>Tipo Disc.</th>
								<th>Largo</th>
								<th>Ancho</th>
								<th>Profundidad</th>
								<th>Esp. mín.</th>
								<th>Esp. máx.</th>
								<th>Esp. Rem.</th>
								<th>Pérdida</th>
								<th>Fotografía</th>
								<th>Acciones</th>
							</tr>
							<?php
							$array_indicaciones=$indicaciones->getByReferencia($_GET['id_referencia']);

							
								foreach ($array_indicaciones as $value) {
									?>
										<tr>
											<td class="info"><?php echo $value['elemento']; ?></td>
											<td class="info"><?php echo $value['numero_indicacion']; ?></td>
											<td class="info"><?php echo $value['referencia_indicacion']; ?></td>
											<td class="info"><?php echo $value['distancia']; ?></td>
											<td class="info"><?php echo $value['horario']; ?></td>
											<td class="info"><?php echo $value['tipo_discontinuidad']; ?></td>
											<td class="info"><?php echo $value['largo']; ?></td>
											<td class="info"><?php echo $value['ancho']; ?></td>
											<td class="info"><?php echo $value['profundidad']; ?></td>
											<td class="info"><?php echo $value['espesor_minimo']; ?></td>
											<td class="info"><?php echo $value['espesor_maximo']; ?></td>
											<td class="info"><?php echo $value['espesor_remanente']; ?></td>
											<td class="info"><?php echo round($value['perdida'], 2) ; ?></td>
											<td class="info">
															<?php
															if($value['fotografia'] != '')
																 echo "<a href='".$folder.'/'.$value['fotografia']."' target='_blank'>Ver</a>" ; 
															 ?>
											</td>
											
											<td class="acciones">
												<center>
												<div class="accion"><a class="normalTip" title="Editar" href="indicaciones.php?id_referencia=<?php echo $_GET['id_referencia']; ?>&id_indicacion=<?php echo $value['id_indicacion']; ?>&accion=ACTUALIZAR"><img src="../images/iconos/vcard_edit.png"></a></div>
												<div class="accion"><a class="normalTip" onclick="confirmation(<?php echo $value['id_indicacion']; ?>);" title="Eliminar" href=""><img src="../images/iconos/delete.png"></a></div>
												
												</center>
											</td>
										</tr>
									<?php
								}
							?>
							
						</table>


						<!--  tabla de captura  -->

					</div>

				</div>
				
			</div>
		</div>
	</div>
	<SCRIPT TYPE="text/javascript">

	</SCRIPT>
</body>
</html>
<?php
	}
	else{
		?>
		<script type="text/javascript">
			alert("Acceso no permitido");
			window.location = "../index.php" ;
		</script>
	<?php
	}
?>