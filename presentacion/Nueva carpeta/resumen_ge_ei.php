
<?php
session_start() ;

	include_once("../library/ConexionExterna.php");
	include_once("../library/Disciplina.php");
	include_once("../library/Area.php");
	include_once("../library/Indicaciones.php");


	$conexion_externa = new ConexionExterna();
	$disciplina = new Disciplina();
	$area = new Area() ;
	$indicacion = new Indicaciones();



	$conexion_externa->loadByIdContrato($_GET['id_contrato']);
//	$disciplinas = $disciplina->loadByContrato($conexion_externa->getId());
	
//	$disciplina->loadById($_GET['id_disciplina']);
//	$conexion_externa->loadByIdContrato($disciplina->getContrato());
//	$areas = $area->getByDisciplina($disciplina->getId());
	//echo $conexion_externa->getNumero();

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!-- saved from url=(0065)http://www.yoxigen.com/yoxview/demo/demo%20-%20basic%20usage.html -->
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">


		<title>Servicios Marinos y Terrestres S. A. de C. V.</title>
		<link rel="Stylesheet" type="text/css" href="css/<?php echo $conexion_externa->getNumero(); ?>/style.css">

		<script src="../js/jquery.min.js" type="text/javascript"></script>
		<script src="../js/amcharts.js" type="text/javascript"></script> 

		<script type="text/javascript">
			var chart;
            var legend;
			var chartData = (function () {
		    var json = null;
		    $.ajax({
		        'async': false,
		        'global': false,
		        'url': 'extraeIndGeExt.php?id_contrato='+<?php echo $_GET['id_contrato'] ; ?>,
		        'dataType': "json",
		        'success': function (data) {
		            json = data;
		        }
		    });
		    return json;
		})(); 


		AmCharts.ready(function () {
                // PIE CHART
                chart = new AmCharts.AmPieChart();
                chart.dataProvider = chartData;
                chart.titleField = "tipo";
                chart.valueField = "cantidad";
                chart.outlineColor = "#FFFFFF";
                chart.color="#0000FF";
                chart.colors = ["#B0DE09", "#04D215", "#0D8ECF", "#0D52D1", "#2A0CD0", "#8A0CCF", "#CD0D74"];["#FF0F00", "#FF6600", "#FF9E01", "#FCD202", "#F8FF01", "#B0DE09", "#04D215", "#0D8ECF", "#0D52D1", "#2A0CD0", "#8A0CCF", "#CD0D74", "#754DEB", "#DDDDDD", "#999999", "#333333", "#000000", "#57032A", "#CA9726", "#990000", "#4B0C25"] ;
                chart.outlineAlpha = 0.8;
                chart.outlineThickness = 2;
                //chart.baseColor="#0000FF";
                // this makes the chart 3D
                chart.depth3D = 25;
                chart.angle = 40;
                chart.startEffect="bounce";
                chart.marginTop=0;
                chart.marginBottom=0;


                // WRITE
                chart.write("chartdiv");
            });


		</script>
		

	</head>

	<body>
		<div>







<!--
	
	INICIO DEL CUERPO EDITABLE PARA LA PRESENTACION
	
-->

	<div id="contenedor_general">

		<div id="encabezado_down">
		<div id="encabezado">
			<center>

			LINEAS REGULARES
			<br>
			CONTRATO No. <?php echo $conexion_externa->getNumero(); ?>
			</center>
		</div>
		</div>
		<div id="lateral_izquierda"></div>



		
		

		<div id="container">

			<div id="submenu">
				<table id="tabla_submenu">
					<tr>
						<td><a href="disciplinas.php?id_contrato=<?php echo $_GET['id_contrato']; ?>"> < Disciplinas </a></td>
					</tr>
				</table>
			</div>

			<div id="indice" >
				<?php

					$registros = $indicacion->getForResumenTotExt($_GET['id_contrato']) ;

					//$registros_int = $indicacion->getForResumenInt($disciplina->getId(), $disciplina->getContrato()) ;


				//	var_dump($registros);
					$gran_total = 0 ;
				//	$gran_total_int = 0 ;

$tipos_indicaciones = array(
							"CE"=>'CORROSIÓN EXTERNA',
							"DS"=>'DEPÓSITO DE SOLDADURA',
							"Q"=>'QUEMADURA POR ARCO ELÉCTRICO',
							"AB"=>'ABOLLADURA',
							"DE"=>'DESBASTE',
							"DL"=>'DELAMINACIÓN',
							"DM"=>'DAÑO MECÁNICO',
							"M"=>'MUESCA',
							"R"=>'RAYADURA',
							"D"=>'DESALINEAMIENTO',
							"P"=>'POROS',
							"PA"=>'POROS AGRUPADOS',
							"EL"=>'ESCALA LAMINAR',
							"S"=>'SOCABADO',
							"CI"=>'CORROSIÓN INTERNA',
							"IP"=>'INDICACIÓN PUNTUAL',
							"IA"=>'INDICACIÓN AGRUPADA',
							"DI"=>'DESGASTE INTERNO',
							"IPA"=>'INDICACIÓN PUNTUAL AGRUPADA',
							"E"=>'ELÍPTICA',
							"RE"=>'RECTANGULAR',
							"C"=>'CIRCULAR',
							"L"=>'LINEAL',
							"LA"=>'LAMINACIONES',
							"I"=>'INCLUSIONES',
							"IL"=>'INDICACIÓN LINEAL'
						);
				?>
				<div id="tabla_totales" >
					<table id="titulo_disciplina">
						<tr>
							<th><?php echo $disciplina->getNombre(); ?></th>
						</tr>
					</table>

					<table id="tabla_conteo">
						<tr>
							<th colspan="2">Tipo</th>
							<th>Total</th>
						</tr>
							<?php
								foreach ( json_decode( $registros) as $key => $value) {
									?>
									<tr>
										<td><?php echo $key ; ?></td>
										<td><?php echo $tipos_indicaciones[$key]; ?></td>
										<td><?php echo $value; ?></td>
									</tr>
									<?php
									$gran_total += $value;
								}
							?>
						<tr>
							<td colspan="2"><strong>Total</strong></td>
							<td><strong><?php echo $gran_total ; ?></strong></td>
						</tr>
					</table>
				</div>
				<div id="chartdiv" ></div>
			</div>
			
			
		</div>

		<div id="lateral_derecha"></div>
		<div id="pie_pagina">
			<div id="menu_pie">

						<a href="resumen_ge_int_tot.php?id_contrato=<?php echo $_GET['id_contrato']; ?>">- Totales</a>
						<a href="resumen_ge_int.php?id_contrato=<?php echo $_GET['id_contrato']; ?>">- Indicaciones Internas</a>

			</div>
		</div>
	

</div><!-- fin de contenedor general -->





<!--
	
	FIN DEL CUERPO EDITABLE PARA LA PRESENTACION
	
-->





</div>
</body>
</html>