<!doctype html>
<?php 
	session_start();
	if (!$_SESSION["log"]){
		header("Location:../index.php");
	}



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

	 		$con7="set language spanish";
	 		$con7= mssql_query($con7);

	 		
	 		$con8= mysql_query("SET NAMES 'UTF8'");

?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/> 
<meta name="robots" content="all" />
<meta name="viewport" content="width=device-width, height=device-height" >

<title>Ventas</title>


<script type="text/javascript" src="../assets/js/jquery.js"></script>
<script type="text/javascript" src="../assets/js/jquery-ui-1.10.4.custom.min.js"></script>
<link rel="stylesheet" href="../assets/css/style.css">
<link type="text/css" href="../assets/css/ui-lightness/jquery-ui-1.10.4.custom.css" rel="Stylesheet" />
<meta charset="UTF-8">
<meta name="HandheldFriendly" content="True">
</head>
	<body>

		<div id='menu2'>

			
			<div class='boton2'>
				<a href='../contenedor.php'><img id='logoroche' src="../assets/img/comercialrochelogo.png"></a>
			</div>
			<div class='boton2'>
				<a href='embarques.php'><img src="../assets/img/embarques.png"/>
				
			</div>
			
			<div class='boton2'>
				<a href='ventas.php'><a href='ventas.php'><img src="../assets/img/ventas.png" /></a>

			</div>
			<div class='boton2'>
				<a href='cuentas.php'><img src="../assets/img/cobrar.png" /></a>

				
			</div>
			<div class='boton2'>
				<a href='gastos.php'><img src="../assets/img/gastos.png" /></a>

			</div>
			<div class='boton2'>
				<a href='inventario.php'><img src="../assets/img/inventarios.png" /></a>
		
			</div>
		</div>

		<form action='' method='post'>
			<div class="wrapper">
				<div id="login">

					<div class='pd_cases'>
						<div class='pd_cases1'>Art.</div>
						<div class='pd_cases1'>Cant.</div>
						<div class='pd_cases2'>Inv.</div>
						<div class='pd_cases2'>Desc.</div>
						<div class='pd_cases2'>IVA</div>
						<div class='pd_cases3'>Subtotal</div>
						<div class='pd_cases4'>Boton</div>
					</div>
					
					<div class='pd_cases'>
						<div class='pd_cases1'><input type='text' class='pdinput' onkeyup='check(this)'></div>
						<div class='pd_cases1'><input type='text' class='pdinput' onkeyup='check(this)'></div></div>
						<div class='pd_cases2'>a</div>
						<div class='pd_cases2'>a</div>
						<div class='pd_cases2'>a</div>
						<div class='pd_cases3'>a</div>
						<div class='pd_cases4'><img src='../assets/img/ok.png' width='16px' height='16px'><img src='../assets/img/no.png' width='16px' height><img src='../assets/img/edit.png' width='16px' height></div>
					</div>

				</div>
			</div>
		</form>
						
	
		</div>
		<script>
			function check(Art){
				var art=Art.value,
					

				console.log('Art=>'+art);

			}
		</script>
	</body>
</html>
