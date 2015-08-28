<?php
 session_start();
	if (!$_SESSION["log"]){
		header("Location:index.php");
	} 
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="../assets/css/style.css">
	<link type="text/css" href="../assets/css/ui-lightness/jquery-ui-1.10.4.custom.css" rel="Stylesheet" />
	<meta name="HandheldFriendly" content="True">
	<title>Pedidos</title>
</head>
<body>
	<?php echo $_SESSION["user"]."lolol";?>
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
		
		<form action="" method="POST">
			<div id="container">
				<div>
					<label for="pedido">Pedido:<input  type="text" name="pedido" ></label>
					<input type="button" name="buscar" value="Buscar">
					
				</div>
				<div id="detalles">
					<div>Cliente:</div>
					<div class="field">&nbsp</div>
					<div class="sell_details label">Fecha Emisión:</div>
					<div class="sell_details">&nbsp</div>
					<div class="sell_details label">Fecha Requerida:</div>
					<div class="sell_details">&nbsp</div>
					<div class="sell_details label">Almacén:</div>
					<div class="sell_details">&nbsp</div>
					<div class="sell_details label">Proyecto:</div>
					<div class="sell_details">&nbsp</div>
					<div class="sell_details label">Sucursal Cliente:</div>
					<div class="sell_details">&nbsp</div>
					<div class="sell_details label">Condiciones:</div>
					<div class="sell_details">&nbsp</div>
					<div class="sell_details label">Forma Envío:</div>
					<div class="sell_details">&nbsp</div>
					<div class="sell_details label">Lista de Precios:</div>
					<div class="sell_details">&nbsp</div>
					<div class="sell_details label">Orden de Compra:</div>
					<div class="sell_details">&nbsp</div>
					<div class="sell_details label">Fecha de Orden:</div>
					<div class="sell_details">&nbsp</div>
					<div class="sell_details label">Observaciones:</div>
					<div class="sell_details">&nbsp</div>
					
				</div>
				
			</div>

			

		</form>
	<script type="text/javascript" src="../assets/js/jquery.js"></script>
	<script type="text/javascript" src="../assets/js/jquery-ui-1.10.4.custom.min.js"></script>
	<script type="text/javascript" src="../assets/js/jquery.mask.min"></script>
	<script type="text/javascript" src="../assets/js/pedidosesp.js"></script>
</body>
</html>