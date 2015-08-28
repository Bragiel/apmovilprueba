<!doctype html>

<?php
	 if (isset($_POST["usuario"])){

		$user = $_POST["usuario"];
	 	$pass = $_POST["contrasena"];
	 	$supUser = 0;

	 	$DB="pruebasCOSYSA";
	 	$serverName = "intelisis"; //serverName\instanceName
	 	$connectionInfo = array( "Database"=>$DB, "UID"=>"intelisis", "PWD"=>"");
	 	$conn = mssql_connect( $serverName, "intelisis", "");


	 	$conn = mssql_connect($serverName, 'intelisis', '');
	 	mssql_select_db($DB, $conn);

	 		if (!$conn ) {

	 	    	die('Something went wrong while connecting to MSSQL');

	 		}
		
		 if ($user>1){
		 	 $sql="SELECT Agente, Nombre, Mensaje FROM Agente WHERE Agente = ".$user." AND Mensaje='".$pass."'";

			 $stmt = mssql_query( $sql );
			 $row = mssql_fetch_array($stmt);
			 
		 }else{
		 	
		 	$pass=md5(strtoupper($pass));
		 	$pass=md5('KnTZyc0MBadRkAA'.strtolower($pass).'0skkrlFuO/i');
		 	$user=strtoupper($user);

		 	
		 	$sql="SELECT Usuario, Contrasena FROM usuario WHERE Usuario = '".$user."' AND Contrasena='".$pass."'";
		 	$stmt = mssql_query( $sql );
			$row = mssql_fetch_array($stmt);
			//echo "<pre>", print_r($row), "</pre>";
			$supUser = 1;

		 }
			
	}

?>

<html>
	<head>
		<link rel="icon" type='image/x-icon' href="favicon.ico">
		<link rel="icon"  href="roche.png">
		<meta charset="UTF-8">
		<meta name="HandheldFriendly" content="True">
		<meta name="viewport" content="width=device-width, height=device-height, user-scalable=no" >	
		<title>Login RP</title>
		<link rel="stylesheet" href="assets/css/style.css">

		<title>Login RP</title>
	</head>
	<body>
		<div id="wrapper">
		<div id="login">
			<form action="" method="post">

				<?php 
				 	if($user!=""){
						if (isset($error)){
							echo $error;
							
						}

						if (empty($row[1])){
							
							echo("Error su usuario o contraseña no son correctos.");

							//	$Agente = sqlsrv_get_field( $stmt, 0);
							// 	$Nombre = sqlsrv_get_field( $stmt, 1);
							// 	$Mensaje = sqlsrv_get_field( $stmt, 1);

						}else{

							if($pass==''){

					
							}else{
								session_start();
								$_SESSION["log"]=true;
								$_SESSION["user"]=$user;
								
								if($supUser == 1){
									header("Location:supervisor/contenedor.php");
								}else{
									header("Location:contenedor.php");
								}
								
							}
						}
					}

				 ?>
				
				<div id="frame">
					<img src ="assets/img/gindustrial.jpg"  width='330' height='98'>
				</div>

				<div>
					<h2>Iniciar sesión</h2>
				</div>
				
				<div>
					<label for="usuario">Usuario: <br></label>
					<input type="text"  name="usuario">
				</div>
				<div>
					<label for="contrasena">Contraseña: <br></label>
					<input type="password"  name="contrasena">
				</div>
				<div>
					<input type="submit"  value="Acceso">
					

				</div>

				 	
			</form>
		</div><!-- end login -->
	</div><!-- end wrapper -->

	</body>


</html>