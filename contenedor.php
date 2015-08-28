<!doctype html>

<?php 
	session_start();
	if (!$_SESSION["log"]){
		header("Location:index.php");
	}
?>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="HandheldFriendly" content="True">
		<meta name="viewport" content="width=device-width, height=device-height, user-scalable=no" >	
		<title>Login RP</title>
		<link rel="stylesheet" href="assets/css/style.css">
	</head>
	<body>
		<div id="wrapper">
			<div id="login">
				<form action="" method="post">
					<div id="menu">

						<div id="frame">
							<img src="assets/img/comercialroche.jpg">
						</div>
						<div class="boton group1">
							<a href="modulos/embarques.php"><img src="assets/img/embarques.png"/>
							<br>Embarques</a>
						</div>
						<div class="boton group3">
							<a href="modulos/ventas.php"><img src="assets/img/ventas.png" />
							 <br>Ventas </a>
						</div>
						<div class="boton group2">
							<a href="modulos/cuentas.php"><img src="assets/img/cobrar.png" />
							<br>C x C</a>
						</div>
						<div class="boton group1">
							<a href='modulos/inventario.php'><img src="assets/img/inventarios.png" />
							<br>Inventarios</a>
						</div>
						<div class="boton group3">
							<a href='modulos/gastos.php'><img src="assets/img/gastos.png" />
							<br>Gastos</a>
						</div>
						<div class="boton group2">
							<a href='modulos/pedidos.php'><img src="assets/img/pedidos.png" />
							<br>Pedidos</a>
						</div>
						<div class="boton group1">
							<a href='modulos/pedidosesp.php'><img src="assets/img/pedidos.png" />
							<br>Pedidos 2</a>
						</div>
						<div id="logout" class="group1">
							<a href="logout.php" > <img src="assets/img/logout.png" /> </a>
							
						</div>
					</div>
					

			
					 	
				</form>
			</div><!-- end login -->
		</div><!-- end wrapper -->

	<script type="text/javascript" src="assets/js/jquery.js"></script>
	<script type="text/javascript" src="assets/js/scripts.js"></script>

	</body>


</html>