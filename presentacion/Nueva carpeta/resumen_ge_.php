
<?php
session_start() ;

include_once("../library/ConexionExterna.php");

$conexion_externa = new ConexionExterna();

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

            var chart_hc ;

            var charDataHc=[{
                titulo: "PAT 2013(P,FP)",
                titulo2: "PAT 2013",
                color: "#754DEB",
                valor: 176,
                etiqueta: "PAT 2013"
            }, {
                titulo: "PROGRAMADO FEB-JUL(P,FP)",
                titulo2: "PROG. FEB-JUL",
                color: "#CC3300",
                valor: 114,
                etiqueta:"PROGRAMADO FEB-JUL"
            }, {
                titulo: "EN ATENCIÓN(P,FP)",
                titulo2: "EN ATENCIÓN",
                color: "#00CC00",
                valor: 128,
                etiqueta: "EN ATENCIÓN"
            }];


            var chartData = [{
                titulo: "PAT 2013(P,FP)",
                titulo2: "PAT 2013",
                color: "#754DEB",
                valor: 76,
                etiqueta: "PAT 2013"
            }, {
                titulo: "PROGRAMADO FEB-JUL(P,FP)",
                titulo2: "PROG. FEB-JUL",
                color: "#CC3300",
                valor: 44,
                etiqueta:"PROGRAMADO FEB-JUL"
            }, {
                titulo: "EN ATENCIÓN(P,FP)",
                titulo2: "EN ATENCIÓN",
                color: "#00CC00",
                valor: 70,
                etiqueta: "EN ATENCIÓN"
            }];


            AmCharts.ready(function () {
                // SERIAL CHART
                chart = new AmCharts.AmSerialChart();
                chart.dataProvider = chartData;
                chart.categoryField = "titulo2";
                chart.color = "#000000";
                chart.fontSize = 14;
                chart.startDuration = 1;
                chart.plotAreaFillAlphas = 0.2;
                // the following two lines makes chart 3D
                chart.angle = 30;
                chart.depth3D = 60;

                // AXES
                // category
                var categoryAxis = chart.categoryAxis;
                categoryAxis.gridAlpha = 0.2;
                categoryAxis.gridPosition = "start";
                categoryAxis.gridColor = "#333333";
                categoryAxis.axisColor = "#333333";
                categoryAxis.axisAlpha = 0.5;
                categoryAxis.dashLength = 5;

                // value
                var valueAxis = new AmCharts.ValueAxis();
                valueAxis.stackType = "3d"; // This line makes chart 3D stacked (columns are placed one behind another)
                valueAxis.gridAlpha = 0.2;
                valueAxis.gridColor = "#333333";
                valueAxis.axisColor = "#333333";
                valueAxis.axisAlpha = 0.5;
                valueAxis.dashLength = 5;
                valueAxis.title = "Actividades"
                valueAxis.titleColor = "#000000";
                
                chart.addValueAxis(valueAxis);

                // GRAPHS         
                // first graph
               
                // second graph
                var graph2 = new AmCharts.AmGraph();
                graph2.title = "AVANCE GENERAL SECTOR CARDENAS";
                graph2.valueField = "valor";
                graph2.colorField = "color";
                graph2.labelField = "etiqueta";
                graph2.type = "column";
                graph2.lineAlpha = 0;
                graph2.lineColor = "#FF00000";
                graph2.fillAlphas = 1;
                graph2.balloonText = "[[category]] : [[value]]";
                graph2.labelColorField = "#FF0000";
                graph2.labelPosition = "top";
                graph2.labelText = "[[value]]";
                
                chart.addGraph(graph2);

                chart.write("chart_ei");
            });



		AmCharts.ready(function () {
                // SERIAL CHART
                chart_hc = new AmCharts.AmSerialChart();
                chart_hc.dataProvider = charDataHc;
                chart_hc.categoryField = "titulo2";
                chart_hc.color = "#000000";
                chart_hc.fontSize = 14;
                chart_hc.startDuration = 1;
                chart_hc.plotAreaFillAlphas = 0.2;
                // the following two lines makes chart 3D
                chart_hc.angle = 30;
                chart_hc.depth3D = 60;

                // AXES
                // category
                var categoryAxis = chart_hc.categoryAxis;
                categoryAxis.gridAlpha = 0.2;
                categoryAxis.gridPosition = "start";
                categoryAxis.gridColor = "#333333";
                categoryAxis.axisColor = "#333333";
                categoryAxis.axisAlpha = 0.5;
                categoryAxis.dashLength = 5;

                // value
                var valueAxis = new AmCharts.ValueAxis();
                valueAxis.stackType = "3d"; // This line makes chart 3D stacked (columns are placed one behind another)
                valueAxis.gridAlpha = 0.2;
                valueAxis.gridColor = "#333333";
                valueAxis.axisColor = "#333333";
                valueAxis.axisAlpha = 0.5;
                valueAxis.dashLength = 5;
                valueAxis.title = "Actividades"
                valueAxis.titleColor = "#000000";
                
                chart_hc.addValueAxis(valueAxis);

                // GRAPHS         
                // first graph
               
                // second graph
                var graph2 = new AmCharts.AmGraph();
                graph2.title = "AVANCE GENERAL SECTOR CARDENAS";
                graph2.valueField = "valor";
                graph2.colorField = "color";
                graph2.labelField = "etiqueta";
                graph2.type = "column";
                graph2.lineAlpha = 0;
                graph2.lineColor = "#FF00000";
                graph2.fillAlphas = 1;
                graph2.balloonText = "[[category]] : [[value]]";
                graph2.labelColorField = "#FF0000";
                graph2.labelPosition = "top";
                graph2.labelText = "[[value]]";
                
                chart_hc.addGraph(graph2);

                chart_hc.write("chart_hc");
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
			Contrato No. <?php echo $conexion_externa->getNumero() . " - Sector Cárdenas"; ?>
			<br>
			Avances Generales
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
				
				<div id="titulo1">
					Equipo instrumentado
				</div>
				<div id="chart_ei" ></div>
				<div id="titulo2">
					Hallazgos por Celaje
				</div>
				<div id="chart_hc" >
				</div>
			</div>
			
			
		</div>

		<div id="lateral_derecha"></div>
		<div id="pie_pagina">
			<div id="menu_pie">

				<!--		<a href="resumen_ge_int_tot.php?id_contrato=<?php echo $_GET['id_contrato']; ?>">- Totales</a>
						<a href="resumen_ge_int.php?id_contrato=<?php echo $_GET['id_contrato']; ?>">- Indicaciones Internas</a> -->

			</div>
		</div>
	

</div><!-- fin de contenedor general -->





<!--
	
	FIN DEL CUERPO EDITABLE PARA LA PRESENTACION
	
-->





</div>
</body>
</html>