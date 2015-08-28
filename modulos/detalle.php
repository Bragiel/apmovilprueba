<!doctype html>

<?php 
	session_start();
	// if (!$_SESSION["log"]){
	// 	header("Location:../index.php");
	// }
	

	// if ($_POST){
	// 	$mov = $_POST["movimiento"];
	// $tipo= $_POST["tipo"];
	// $temp= $_POST["tiempo"];
	// $year= $_POST["year"];
	// }else{
	// 	$tipo= 'Tsal';
	// 	$temp= 'mes';
	// 	$year= date('Y');
	// }
	
	$id=$_GET['id'];
	$mov = $_GET["movimiento"];
	$tipo= $_GET["tipo"];
	$temp= $_GET["tiempo"];
	$year= $_GET["year"];
	$origen= $_GET["origen"];

	// echo $id;
	// echo $mov;
	// echo $tipo;
	// echo $temp;
	// echo $year;


	//Coneccion a la base de datos
		$DB="COSYSA";
	 	$serverName = "intelisis"; //serverName\instanceName
	 	$connectionInfo = array( "Database"=>$DB, "UID"=>"intelisis", "PWD"=>"");
	 	$conn = mssql_connect( $serverName, "intelisis", "");


	 	$conn = mssql_connect($serverName, 'intelisis', '');
	 	mssql_select_db($DB, $conn);

	 	if (!$conn ) {

	 	    die('Something went wrong while connecting to MSSQL');

	 	}

	 	$con1="set dateformat dmy";
	 	$con1= mssql_query($con1);

		$con2="SET DATEFIRST 7";
	 	$con2= mssql_query($con2);

	 	$con3="SET ANSI_NULLS OFF";
	 	$con3= mssql_query($con3);

	 	$con4="SET TRANSACTION ISOLATION LEVEL READ UNCOMMITTED";
	 	$con4= mssql_query($con4);

	 	$con5="SET LOCK_TIMEOUT -1";
	 	$con5= mssql_query($con5);

	 	$con6="SET QUOTED_IDENTIFIER OFF";
	 	$con6= mssql_query($con6);

	//FIN de la coneccion a la base de datos.	

	//Llenado de los array con la informacion de los Storage Procedures.
	 	//echo $id;

	 	$query=mssql_query("spRepVerMovBB ".$id);

	 	$query2=mssql_query('spRepVerMovDBB '.$id);

	 	while ($row = mssql_fetch_array($query)) {
			 $results[] = $row;
		}

		while ($row2 = mssql_fetch_array($query2)) {
			 $results2[] = $row2;
		}

		



		foreach($results as $key => $value){

			$facturas[$results[$key]['MovID']] = array(
			'Mov' => $results[$key]['Mov'],
			'Cliente' => $results[$key]['Cliente'],
			'FechaEmision' => $results[$key]['FechaEmision'],
			'FechaRequerida' => $results[$key]['FechaRequerida'],
			'Almacen' => $results[$key]['Almacen'],
			'Agente' => $results[$key]['Agente'],
			'Direccion' => $results[$key]['Direccion'],
			'Importe' => $results[$key]['Importe'],
			'DescuentoPagoAnt' => $results[$key]['DescuentoPagoAnt'],
			'DescuentoxFlete' => $results[$key]['DescuentoxFlete'],
			'Subtotal' => $results[$key]['Subtotal'],
			'Impuestos' => $results[$key]['Impuestos'],
			'Total' => $results[$key]['Total']	

		);
		}

		foreach($results2 as $key => $value){

			$facturas2[$results2[$key]['Articulo']] = array(
			'Cantidad' => $results2[$key]['Cantidad'],
			'Inventario' => $results2[$key]['Inventario'],
			'Precio' => $results2[$key]['Precio'],
			'Descuento' => $results2[$key]['Descuento'],
			'Importe' => $results2[$key]['Importe'],
			'IVA' => $results2[$key]['IVA'],
			'Unidad' => $results2[$key]['Unidad']			

		);
		}
		//echo "<pre>", print_r($results2), "</pre>";
		//Fin del llenado.
		
?>

		<html>
		<head>
			<meta  content="text/html; charset=utf-8" />
			<meta name="robots" content="all" />
			<meta name="viewport" content="width=device-width, height=device-height" >
			<link rel="stylesheet" href="../assets/css/style.css">
			<title></title>
		</head>
		<body>

			<div class='wrapper'>
				<div id='login'>
					<?php

						

							 foreach ($facturas as $factura => $datoFactura){

							 	$fechain = substr_replace(substr($datoFactura['FechaRequerida'], 0, -14), '-', 3, -7);
							 	$fechaco = substr_replace($fechain, '-', 5, -5);
							 	$originalDate = $fechaco;
								$newDate = date("d-m-Y", strtotime($originalDate));

								$fechain2 = substr_replace(substr($datoFactura['FechaRequerida'], 0, -14), '-', 3, -7);
							 	$fechaco2 = substr_replace($fechain, '-', 5, -5);
							 	$originalDate2 = $fechaco;
								$newDate2 = date("d-m-Y", strtotime($originalDate));
							 	

							 	echo '<div id=contDetalle>';
							 	echo '<div class="detalles1"> Factura Electronica:</div><div class="detalles2"> '.$factura.'</div>';
							 	echo '<div class="block">';
							 	echo '<div class="detalles1"> Cliente:</div><div class="detalles2"> '.$datoFactura['Cliente'].'</div>';
							 	echo '<div class="detalles1"> FechaEmision:</div><div class="detalles2">  '.$newDate. '</div>';
							 	echo '<div class="detalles1"> FechaReq:</div><div class="detalles2"> '.$newDate2.'</div>';
							 	echo '<div class="detalles1"> Almacen:</div><div class="detalles2"> '.$datoFactura['Almacen'].'</div>';
							 	echo '<div class="detalles1"> Agente:</div><div class="detalles2"> '.$datoFactura['Agente'].'</div>';
							 	echo '<div class="detalles1"> Direccion:</div><div class="detalles2"> '.$datoFactura['Direccion'].'</div>';
							 	echo '</dvi>';
							 	echo '<div class="block">';
							 	echo '<div class="detalles1 "> Importe:</div><div class="detalles2 num"> '.number_format($datoFactura['Importe'], 2).'</div>';
							 	echo '<div class="detalles1 "> D.P.A.:</div><div class="detalles2 num"> '.number_format($datoFactura['DescuentoPagoAnt'], 2).'</div>';
							 	echo '<div class="detalles1 "> Desc. Flete:</div><div class="detalles2 num"> '.number_format($datoFactura['DescuentoxFlete'], 2).'</div>';
							 	echo '<div class="detalles1 "> Subtotal:</div><div class="detalles2 num"> '.number_format($datoFactura['Importe'], 2).'</div>';
							 	echo '<div class="detalles1 "> Impuestos:</div><div class="detalles2 num"> '.$datoFactura['Impuestos'].' </div>';
							 	echo '<div class="detalles1 "> Total:</div><div class="detalles2 num"> '.$datoFactura['Total'].'</div>';
							 	echo '</div>';
							 	echo '</div>';


							 }


							 echo'<div id="tabledetalle">';
							 echo'<div id="art">Art</div>';
							 echo'<div id="cant">Cant</div>';
							 echo'<div id="inv">Inv</div>';
							 echo'<div id="desc">Desc</div>';
							 echo'<div id="sub">Subtotal</div>';
							 echo'<div id="iva">IVA</div>';
							 	
							 
							 foreach ($facturas2 as $factura2 => $datoFactura2){

							 	
							 	echo'<div id="art" class="num">'.$factura2.'</div>';
							 	echo'<div id="cant" class="num">'.$datoFactura2['Cantidad'].'</div>';
							 	echo'<div id="inv" class="num">'.$datoFactura2['Inventario'].'</div>';
							 	echo'<div id="desc" class="num">'.$datoFactura2['Descuento'].'</div>';
							 	echo'<div id="sub" class="num">'.$datoFactura2['Importe'].'</div>';
							 	echo'<div id="iva" class="num">'.$datoFactura2['IVA'].'</div>';

							 }
							 
							 
							 echo'</div>';
						

						 

						 //echo "<pre>", print_r($results2), "</pre>";

							 echo  "<div class='boton2'>";

							if ($origen=='cuentas'){
							 	echo "<a href='cuentas.php?tipo=cliente&tiempo=".$temp."&year=".$year."' ><img id='logoroche' src='../assets/img/cobrar.png'></a>";
								echo "</div>";
							}else{
							 	echo "<a href='ventas.php?tipo=cliente&tiempo=".$temp."&year=".$year."' ><img id='logoroche' src='../assets/img/ventas.png'></a>";
							 	echo "</div>";
							}


					?>
						
					</div>
				</div>
			</div>
		
		</body>
		</html>