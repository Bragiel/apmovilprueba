<?php	
	session_start();
	if (!$_SESSION["log"]){
		header("Location:../index.php");
	}

		$DB="pruebasCOSYSA";
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


// //Aquí recibes los valores que mandaste por ajax con $_POST y los declaras

// //Ejemplo $temp = $_POST['temp'];

	 	$temp = $_POST['temp'];
	 	$year = $_POST['year'];
	 	$cliente = $_POST['cliente'];
	 	$categoria = $_POST['categoria'];
	 	$articulo = $_POST['articulo'];
	 	$flag = $_POST['flag'];
	 	$tipo=$_POST['tipo'];



	 	if($tipo=='cliente'){
			 if( $flag > 0){
			 	
			 	//function level4($user, $temp, $year, $cliente, $categoria, $articulo ){

			 		$query2=mssql_query("spRepVtasBBD '".$_SESSION["user"]."','".$temp."','".$year."','".$cliente."','".$categoria."','".$articulo."'");

			 	//}

			 	while ($row2 = mssql_fetch_array($query2)) {
					 $results2[] = $row2;
				}

				foreach($results2 as $key => $value){

				 $facturas[$results2[$key]['ID']] = array(
					'Movimiento' => $results2[$key]['Movimiento'],
					'FechaEmision' => $results2[$key]['FechaEmision'],
					'Ton' => $results2[$key]['Ton']
						);

				}
				
				$html = "<tbody class='collapsed'><tr><td><table><form action='detalle.php' method='post'>";
				$html .= "<thead ><tr><th class='level4'><div class='info'>Movimiento</div><div class='datosf'>Fecha Emision</div><div class='datosf'>Ton</div></th></tr></thead>";
				
				
				foreach ($facturas as $factura => $datoFactura){

					
					$newDate = date("d-m-Y", strtotime($datoFactura['FechaEmision']));

																			
					$html .= "<thead ><tr><th class='level4'><div class='info'><a href='detalle.php?id=".$factura."&tiempo=".$temp."&year=".$year."&tipo=".$tipo."'> ".$datoFactura['Movimiento']."</a></div>";
					$html .= "<div class='datosf neutral'>".$newDate."</div><div class='datosf neutral'>".$datoFactura["Ton"]."</div></div></th></tr></thead>";
																		
																		
																		

				}

				

				$html .= '</form></table></td></tr></tbody>';



				echo $html;


				//echo "<pre>", print_r($facturas), "</pre>";	

				//return $html;
			}
		}
?>
<script type="text/javascript">

	
</script>