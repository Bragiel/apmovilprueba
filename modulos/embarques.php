<!doctype html>

<?php 
	session_start();
	if (!$_SESSION["log"]){
		header("Location:../index.php");
	}
	

	if ($_POST){
		$mov = $_POST["movimiento"];
	$tipo= $_POST["tipo"];
	$temp= $_POST["tiempo"];
	$year= $_POST["year"];

		
			

		}elseif ($_GET){

			$mov = $_GET["movimiento"];
			$tipo= $_GET["tipo"];
			$temp= $_GET["tiempo"];
			$year= $_GET["year"];

		}else{

			$tipo= 'Tsal';
			$temp= 'acumulado';
			$year= date('Y');
		}
	
	
?>




<html>
<head>
<meta  content="text/html; charset=utf-8" />
<meta name="robots" content="all" />
<meta name="viewport" content="width=device-width, height=device-height" >

<title>Ventas</title>

<!-- Assets drilldown -->
<link href="css/dcdrilldown.css" rel="stylesheet" type="text/css" />
<link href="css/skins/graphite.css" rel="stylesheet" type="text/css" />
<link href="css/skins/blue.css" rel="stylesheet" type="text/css" />
<link href="css/skins/grey.css" rel="stylesheet" type="text/css" />
<link href="css/skins/demo.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../assets/js/jquery.js"></script>
<link rel="stylesheet" href="../assets/css/style.css">
<meta charset="UTF-8">
<meta name="HandheldFriendly" content="True">



<!-- end assets drilldown -->
<!-- Database conection -->
<?php
	


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
		
	 	 
		 $query=mssql_query("spRepEmbSalineraAgenteCliente '".$_SESSION["user"]."','".$tipo."','".$temp."'");
 


		while ($row = mssql_fetch_array($query)) {
			 $results[] = $row;
		}
		
		
	switch ($tipo){
		case 'cliente':
			$i=0;
			$j=0;
			foreach($results as $key => $value){

				$categorias[$results[$key]['MovID']] = array(
					'Cliente' => $results[$key]['ClienteNombre'],
					'SumaPen' => $results[$key]['SumaPendiente'],
					'SumaProg' => $results[$key]['SumaProgramado'],
					'SumaSol' => $results[$key]['SumaSolicitado'],
					'Orden' => $results[$key]['Orden']
				);
							
			}

							
							
			foreach($results as $key => $value){

				foreach($categorias as $categoria => $arr){
					if($categoria == $results[$key]['MovID']){
						$categorias[$categoria]['Descripciones'][$results[$key]['FechaRequerida'].$j] = array(
							    'FechaEmision' => $results[$key]['FechaEmision'],
							    'FechaRequerida' => $results[$key]['FechaRequerida'],
							    'Programado' => $results[$key]['Programado'],
							    'Solicitado' => $results[$key]['Solicitado'],
							    'Pendiente' => $results[$key]['Pendiente'],
							    'Articulo' => $results[$key]['Articulo']
							    
						);
						$j++;
							                  
					}
				}
			}
		break;
		case 'Tsal':


			foreach($results as $key => $value){

				$categorias[$results[$key]['Categoria']] = array(
					'SumaPen' => $results[$key]['SumaPendiente'],
					'SumaProg' => $results[$key]['SumaProgramado'],
					'SumaSol' => $results[$key]['SumaSolicitado']
				);
							
			}

							
			foreach($results as $key => $value){

				foreach($categorias as $categoria => $arr){
					if($categoria == $results[$key]['Categoria']){
						$categorias[$categoria]['Descripciones'][$results[$key]['ClienteNombre']] = array(
							    'ClienteNombre' => $results[$key]['ClienteNombre'],
							    'Programado' => $results[$key]['Programado'],
							    'Solicitado' => $results[$key]['Solicitado'],
							    'Pendiente' => $results[$key]['Pendiente'],
							    'Articulo' => $results[$key]['Articulo']
							                        
						);
							                  
					}
				}
			}
		break;
		case 'articulo':
			foreach($results as $key => $value){

				$categorias[$results[$key]['Articulo']] = array(
					'ArtNombre' => $results[$key]['ArtNombre'],
					'SumaPen' => $results[$key]['SumaPendiente'],
					'SumaProg' => $results[$key]['SumaProgramado'],
					'SumaSol' => $results[$key]['SumaSolicitado']
				);
							
			}

							
			foreach($results as $key => $value){

				foreach($categorias as $categoria => $arr){
					if($categoria == $results[$key]['Articulo']){
						$categorias[$categoria]['Descripciones'][$results[$key]['ClienteNombre']] = array(
							    'ClienteNombre' => $results[$key]['ClienteNombre'],
							    'Programado' => $results[$key]['Programado'],
							    'Solicitado' => $results[$key]['Solicitado'],
							    'Pendiente' => $results[$key]['Pendiente'],
							    'Articulo' => $results[$key]['Articulo']
							                        
						);
							                  
					}
				}
			}
		break;
		case 'almacen':
			foreach($results as $key => $value){

				$categorias[$results[$key]['Almacen']] = array(
					
					'SumaPen' => $results[$key]['SumaPendiente'],
					'SumaProg' => $results[$key]['SumaProgramado'],
					'SumaSol' => $results[$key]['SumaSolicitado']
				);
							
			}

							
			foreach($results as $key => $value){

				foreach($categorias as $categoria => $arr){
					if($categoria == $results[$key]['Almacen']){
						$categorias[$categoria]['Descripciones'][$results[$key]['ClienteNombre']] = array(
							    'ClienteNombre' => $results[$key]['ClienteNombre'],
							    'Programado' => $results[$key]['Programado'],
							    'Solicitado' => $results[$key]['Solicitado'],
							    'Pendiente' => $results[$key]['Pendiente'],
							    'Articulo' => $results[$key]['Articulo']
							                        
						);
							                  
					}
				}
			}
		break;
	}
							
//echo "<pre>", print_r($categorias), "</pre>";	

?>

</head>
<body>
	<div id='menu2'>
		<div class='boton2'>
			<a href='../contenedor.php'><img id='logoroche' src="../assets/img/comercialrochelogo.png"></a>
		</div>
		<div class='boton2'>
			<a href='inventario.php'><img src="../assets/img/inventarios.png"/></a>
		</div>
		<div class='boton2'>
			<a href='ventas.php'><img src="../assets/img/ventas.png" /></a>

		</div>
		<div class='boton2'>
			<a href='cuentas.php'><img src="../assets/img/cobrar.png" /></a>
		</div>
		<div class='boton2'>
			<a href='gastos.php'><img src="../assets/img/gastos.png" /></a>
		</div>
		<div class='boton2'>
			<a href='pedidos.php'><img src="../assets/img/pedidos.png" /></a>
		</div>
	</div>
	<div class="wrapper">
		<div id='menu1'>
		<ul >
		   <li>
		    <form action="" method="post">
		    	<li>
		    	<form action="" method="post">
			    	<div id="selectors">

			    				<?php $tipos=array(
			    					'Tsal'=>'Tsal',
			    					'cliente'=>'Cliente',
			    					'almacen'=>'Almacén',
			    					'articulo'=>'Articulo'); 

			    					$tiempos=array(
			    					'Mes'=>'Mes',
			    					'Hoy'=>'Hoy',
			    					'Semana'=>'Semana',
			    					'Enero'=>'Enero',
			    					'Febrero'=>'Febrero',
			    					'Marzo'=>'Marzo',
			    					'Abril'=>'Abril',
			    					'Mayo'=>'Mayo',
			    					'Junio'=>'Junio',
			    					'Julio'=>'Julio',
			    					'Agosto'=>'Agosto',
			    					'Septiembre'=>'Septiembre',
			    					'Octubre'=>'Octubre',
			    					'Noviembre'=>'Noviembre',
			    					'Diciembre'=>'Diciembre',
			    					'Acumulado'=>'Acumulado'
		    						);

		    						function years($min, $max){
											$contador = 0;
											$date1 = (int)$min;
											$date2 = (int)$max;
										while ( $date1<= $date2) {
											$years[$contador]= $date1;
											$date1++;
											$contador++;

										}
										return $years;


									}

									$years = years("2013", date("Y"));

		    							
			    				?>
								<select name="tipo">
									<?php 
										foreach ($tipos as $key => $value) {
											if ($tipo == $key){
												echo '<option value="'.$key.'" selected>'.$value.'</option>';
											}else{
												echo '<option value="'.$key.'" >'.$value.'</option>';
											}
										}

									 ?>
								</select>

								<select name="tiempo">
									<?php 
										foreach ($tiempos as $key => $value) {
											if ($temp == $key){
												echo '<option value="'.$key.'" selected>'.$value.'</option>';
											}else{
												echo '<option value="'.$key.'" >'.$value.'</option>';
											}
										}

									 ?>
								</select>
								

								<div id='contBuscar'>
										<input id="btnBuscar" type="submit"  value="Buscar">
								</div>
								
					</div>
	 
				</form>
		    </li>
		    	
		    <li>
		    	<div id='titles2'>
		    		
		    		<div>
		    			Soli.
		    		</div>
		    		<div>
		    			Prog.
		    		</div>
		    		<div>
		    			Pend.
		    		</div>
		    		
		    	</div>
		    </li>
		    
			<li> 
			         <?php
						if (!mssql_num_rows($query)) {
											echo 'No records found';
							}else{

								//ksort($categorias);
								
								switch($tipo){

									case 'cliente':
										//******** Nivel uno DrillDown
										foreach ($categorias as $categoria => $datoCategoria){
											echo '<table>';

												if( $categoria!=''){

													if ($datoCategoria["SumaProg"] > 0){
														echo "<thead><tr><th><div class='infoventas1 '>".$categoria."</div><div class='infoventas2'>".utf8_encode($datoCategoria["Cliente"])."</div>";
														echo "<div class='datos3 caution'>".number_format($datoCategoria["SumaPen"],2)."</div><div class='datos3 caution'>".number_format($datoCategoria["SumaProg"],2)."</div><div class='datos3 caution'>".number_format($datoCategoria["SumaSol"],2)."</div><br> </th></tr></thead>";
													}else{
														echo "<thead><tr><th><div class='infoventas1'>".$categoria."</div><div class='infoventas2'>".$datoCategoria["Cliente"]."</div>";
														echo "<div class='datos3 neutral'>".number_format($datoCategoria["SumaPen"],2)."</div><div class='datos3 neutral'>".number_format($datoCategoria["SumaProg"],2)."</div><div class='datos3 neutral'>".number_format($datoCategoria["SumaSol"],2)."</div><br> </th></tr></thead>";	
													}
													echo "<tbody class='collapsed'><tr><td><table>";
													//********** Nivel dos DrillDown

													foreach ($datoCategoria["Descripciones"] as $Cliente => $datosCliente) {
														$fechain = substr($datosCliente['FechaEmision'], 0, -14);
										 				$FechaEmision = date("d-m-Y", strtotime($fechain));

										 				$fechain2 = substr($datosCliente['FechaRequerida'], 0, -14);
										 				$FechaRequerida = date("d-m-Y", strtotime($fechain2));

										 				if($datosCliente['Programado'] > 0){
															echo "<thead ><tr><th class='level2 '><div style='margin-top:8px;'><div class='info3'>Emisión: ".$FechaEmision."</div><div class='info3'>Surtido: ".$FechaRequerida."</div></div>";
															echo "<div style='width:10%; display: inline-block; margin-bottom: 4px;'>Art:</div><div class='info4'>Pend:</div><div class='info4'>Prog:</div><div class='info4'>Sol:</div>";
															echo "<div style='block'><div class='info2' >".$datosCliente["Articulo"]."</div><div class='info4' >".number_format($datosCliente['Pendiente'],3)."</div><div class='info4'>".number_format($datosCliente['Programado'],3)."</div><div class='info4'>".number_format($datosCliente['Solicitado'],3)."</div></div></th></tr></thead>";
															echo "<tbody class='collapsed'><tr><td><table>";
															echo "</table></th></td></tbody>";
														}else{
															echo "<thead ><tr><th class='level2'><div style='margin-top:8px;'><div class='info3'>Emisión: ".$FechaEmision."</div><div class='info3'>Surtido: ".$FechaRequerida."</div></div>";
															echo "<div style='width:10%; display: inline-block; margin-bottom: 4px;'>Art:</div><div class='info4'>Pen:</div><div class='info4'>Prog:</div><div class='info4'>Sol:</div>";
															echo "<div style='block'><div class='info2' >".$datosCliente["Articulo"]."</div><div class='info4' >".number_format($datosCliente['Pendiente'],3)."</div><div class='info4'>".number_format($datosCliente['Programado'],3)."</div><div class='info4'>".number_format($datosCliente['Solicitado'],3)."</div></div></th></tr></thead>";
															echo "<tbody class='collapsed'><tr><td><table>";
															echo "</table></th></td></tbody>";
														}
													}
						
												}

												if($categoria==''){
													foreach ($datoCategoria["Descripciones"] as $Cliente => $datosCliente) {
														if ($datoCategoria["SumaProg"] > 0){
															echo "<thead><tr><th><div class='infoventas1'>".$categoria."</div><div class='infoventas2'>".$datoCategoria["Cliente"]."</div>";
															echo "<div class='datos3 caution'>".number_format($datoCategoria["SumaPen"],2)."</div><div class='datos3 caution'>".number_format($datoCategoria["SumaProg"],2)."</div><div class='datos3 caution'>".number_format($datoCategoria["SumaSol"],2)."</div><br> </th></tr></thead>";
														}else{
															echo "<thead><tr><th><div class='infoventas1'>".$categoria."</div><div class='infoventas2'>".$datoCategoria["Cliente"]."</div>";
															echo "<div class='datos3 neutral'>".number_format($datosCliente['Pendiente'],3)."</div><div class='datos3 neutral'>".number_format($datosCliente['Programado'],3)."</div><div class='datos3 neutral'>".number_format($datosCliente['Solicitado'],3)."</div><br> </th></tr></thead>";	
														}
														echo "<tbody class='collapsed'><tr><td><table>";
													}
												}
												echo "</table></th></td></tbody></table>";
										}
									break;

									case 'Tsal':
										foreach ($categorias as $categoria => $datoCategoria){
											echo '<table>';
											if($categoria!=''){
											
												if ($datoCategoria["SumaProg"] > 0){
													echo "<thead><tr><th><div class='infoventasTsal '>".$categoria."</div>";
													echo "<div class='datos3 caution'>".number_format($datoCategoria["SumaPen"],2)."</div><div class='datos3 caution'>".number_format($datoCategoria["SumaProg"],2)."</div><div class='datos3 caution'>".number_format($datoCategoria["SumaSol"],2)."</div><br> </th></tr></thead>";
												}else{
													echo "<thead><tr><th><div class='infoventasTsal'>".$categoria."</div>";
													echo "<div class='datos3 neutral'>".number_format($datoCategoria["SumaPen"],2)."</div><div class='datos3 neutral'>".number_format($datoCategoria["SumaProg"],2)."</div><div class='datos3 neutral'>".number_format($datoCategoria["SumaSol"],2)."</div><br> </th></tr></thead>";	
												}
												echo "<tbody class='collapsed'><tr><td><table>";
												//********** Nivel dos DrillDown

												foreach ($datoCategoria["Descripciones"] as $Cliente => $datosCliente) {
													

									 				if($datosCliente['Programado'] > 0){
														
														
														echo "<thead ><tr><th class='level2'><div style='block'><div class='info2' >".utf8_encode($datosCliente["ClienteNombre"])."</div><div class='info4 caution' >".number_format($datosCliente['Pendiente'],3)."</div><div class='info4 caution'>".number_format($datosCliente['Programado'],3)."</div><div class='info4 caution'>".number_format($datosCliente['Solicitado'],3)."</div></div></th></tr></thead>";
														echo "<tbody class='collapsed'><tr><td><table>";
														echo "</table></th></td></tbody>";
													}else{
														
														
														echo "<thead ><tr><th class='level2'><div style='block'><div class='info2' >".$datosCliente["ClienteNombre"]."</div><div class='info4' >".number_format($datosCliente['Pendiente'],3)."</div><div class='info4'>".number_format($datosCliente['Programado'],3)."</div><div class='info4'>".number_format($datosCliente['Solicitado'],3)."</div></div></th></tr></thead>";
														echo "<tbody class='collapsed'><tr><td><table>";
														echo "</table></th></td></tbody>";
													}
												}
												echo "</table></th></td></tbody></table>";
											}else{
												foreach ($categorias as $categoria => $datoCategoria){
													foreach ($datoCategoria["Descripciones"] as $Cliente => $datosCliente) {
														if($categoria==''){
															if($datosCliente['Programado'] > 0){
																
																echo "<thead ><tr><th><div style='block'><div class='info2' >".$datosCliente["ClienteNombre"]."</div><div class='info4' >".number_format($datosCliente['Pendiente'],3)."</div><div class='info4'>".number_format($datosCliente['Programado'],3)."</div><div class='info4'>".number_format($datosCliente['Solicitado'],3)."</div></div></th></tr></thead>";
																echo "<tbody class='collapsed'><tr><td><table>";
																echo "</table></th></td></tbody>";
															}else{
															
																echo "<thead ><tr><th><div style='block'><div class='info2' >".$datosCliente["ClienteNombre"]."</div><div class='info4' >".number_format($datosCliente['Pendiente'],3)."</div><div class='info4'>".number_format($datosCliente['Programado'],3)."</div><div class='info4'>".number_format($datosCliente['Solicitado'],3)."</div></div></th></tr></thead>";
																echo "<tbody class='collapsed'><tr><td><table>";
																echo "</table></th></td></tbody>";
															}
														}
													}
												}
											}
										}

									break;
									case 'articulo':
										foreach ($categorias as $categoria => $datoCategoria){
											echo '<table>';
											if($categoria!=''){
											
												if ($datoCategoria["SumaProg"] > 0){
													echo "<thead><tr><th><div class='infoventas1'>".$categoria."</div><div class='infoventas2'>".$datoCategoria["ArtNombre"]."</div>";
													echo "<div class='datos3 caution'>".number_format($datoCategoria["SumaPen"],2)."</div><div class='datos3 caution'>".number_format($datoCategoria["SumaProg"],2)."</div><div class='datos3 caution'>".number_format($datoCategoria["SumaSol"],2)."</div><br> </th></tr></thead>";
												}else{
													echo "<thead><tr><th><div class='infoventas1'>".$categoria."</div><div class='infoventas2'>".$datoCategoria["ArtNombre"]."</div>";
													echo "<div class='datos3 neutral'>".number_format($datoCategoria["SumaPen"],2)."</div><div class='datos3 neutral'>".number_format($datoCategoria["SumaProg"],2)."</div><div class='datos3 neutral'>".number_format($datoCategoria["SumaSol"],2)."</div><br> </th></tr></thead>";	
												}
												echo "<tbody class='collapsed'><tr><td><table>";
												//********** Nivel dos DrillDown

												foreach ($datoCategoria["Descripciones"] as $Cliente => $datosCliente) {
													

									 				if($datosCliente['Programado'] > 0){
														
														
														echo "<thead ><tr><th class='level2'><div style='block'><div class='info2' >".utf8_encode($datosCliente["ClienteNombre"])."</div><div class='info4' >".number_format($datosCliente['Pendiente'],3)."</div><div class='info4'>".number_format($datosCliente['Programado'],3)."</div><div class='info4'>".number_format($datosCliente['Solicitado'],3)."</div></div></th></tr></thead>";
														echo "<tbody class='collapsed'><tr><td><table>";
														echo "</table></th></td></tbody>";
													}else{
														
														
														echo "<thead ><tr><th class='level2'><div style='block'><div class='info2' >".$datosCliente["ClienteNombre"]."</div><div class='info4' >".number_format($datosCliente['Pendiente'],3)."</div><div class='info4'>".number_format($datosCliente['Programado'],3)."</div><div class='info4'>".number_format($datosCliente['Solicitado'],3)."</div></div></th></tr></thead>";
														echo "<tbody class='collapsed'><tr><td><table>";
														echo "</table></th></td></tbody>";
													}
												}
												echo "</table></th></td></tbody></table>";
											}else{
												foreach ($categorias as $categoria => $datoCategoria){
													foreach ($datoCategoria["Descripciones"] as $Cliente => $datosCliente) {
														if($categoria==''){
															if($datosCliente['Programado'] > 0){
																
																echo "<thead ><tr><th><div style='block'><div class='info2' >".$datosCliente["ClienteNombre"]."</div><div class='info4' >".number_format($datosCliente['Pendiente'],3)."</div><div class='info4'>".number_format($datosCliente['Programado'],3)."</div><div class='info4'>".number_format($datosCliente['Solicitado'],3)."</div></div></th></tr></thead>";
																echo "<tbody class='collapsed'><tr><td><table>";
																echo "</table></th></td></tbody>";
															}else{
															
																echo "<thead ><tr><th><div style='block'><div class='info2' >".$datosCliente["ClienteNombre"]."</div><div class='info4' >".number_format($datosCliente['Pendiente'],3)."</div><div class='info4'>".number_format($datosCliente['Programado'],3)."</div><div class='info4'>".number_format($datosCliente['Solicitado'],3)."</div></div></th></tr></thead>";
																echo "<tbody class='collapsed'><tr><td><table>";
																echo "</table></th></td></tbody>";
															}
														}
													}
												}
											}
										}
									break;

									case 'almacen':
										foreach ($categorias as $categoria => $datoCategoria){
											echo '<table>';
											if($categoria!=''){
											
												if ($datoCategoria["SumaProg"] > 0){
													echo "<thead><tr><th><div class='infoventasTsal'>".$categoria."</div>";
													echo "<div class='datos3 caution'>".number_format($datoCategoria["SumaPen"],2)."</div><div class='datos3 caution'>".number_format($datoCategoria["SumaProg"],2)."</div><div class='datos3 caution'>".number_format($datoCategoria["SumaSol"],2)."</div><br> </th></tr></thead>";
												}else{
													echo "<thead><tr><th><div class='infoventasTsal'>".$categoria."</div>";
													echo "<div class='datos3 neutral'>".number_format($datoCategoria["SumaPen"],2)."</div><div class='datos3 neutral'>".number_format($datoCategoria["SumaProg"],2)."</div><div class='datos3 neutral'>".number_format($datoCategoria["SumaSol"],2)."</div><br> </th></tr></thead>";	
												}
												echo "<tbody class='collapsed'><tr><td><table>";
												//********** Nivel dos DrillDown

												foreach ($datoCategoria["Descripciones"] as $Cliente => $datosCliente) {
													

									 				if($datosCliente['Programado'] > 0){
														
														
														echo "<thead ><tr><th class='level2'><div style='block'><div class='info2' >".utf8_encode($datosCliente["ClienteNombre"])."</div><div class='info4' >".number_format($datosCliente['Pendiente'],3)."</div><div class='info4'>".number_format($datosCliente['Programado'],3)."</div><div class='info4'>".number_format($datosCliente['Solicitado'],3)."</div></div></th></tr></thead>";
														echo "<tbody class='collapsed'><tr><td><table>";
														echo "</table></th></td></tbody>";
													}else{
														
														
														echo "<thead ><tr><th class='level2'><div style='block'><div class='info2' >".$datosCliente["ClienteNombre"]."</div><div class='info4' >".number_format($datosCliente['Pendiente'],3)."</div><div class='info4'>".number_format($datosCliente['Programado'],3)."</div><div class='info4'>".number_format($datosCliente['Solicitado'],3)."</div></div></th></tr></thead>";
														echo "<tbody class='collapsed'><tr><td><table>";
														echo "</table></th></td></tbody>";
													}
												}
												echo "</table></th></td></tbody></table>";
											}else{
												foreach ($categorias as $categoria => $datoCategoria){
													foreach ($datoCategoria["Descripciones"] as $Cliente => $datosCliente) {
														if($categoria==''){
															if($datosCliente['Programado'] > 0){
																
																echo "<thead ><tr><th><div style='block'><div class='info2' >".$datosCliente["ClienteNombre"]."</div><div class='info4' >".number_format($datosCliente['Pendiente'],3)."</div><div class='info4'>".number_format($datosCliente['Programado'],3)."</div><div class='info4'>".number_format($datosCliente['Solicitado'],3)."</div></div></th></tr></thead>";
																echo "<tbody class='collapsed'><tr><td><table>";
																echo "</table></th></td></tbody>";
															}else{
															
																echo "<thead ><tr><th><div style='block'><div class='info2' >".$datosCliente["ClienteNombre"]."</div><div class='info4' >".number_format($datosCliente['Pendiente'],3)."</div><div class='info4'>".number_format($datosCliente['Programado'],3)."</div><div class='info4'>".number_format($datosCliente['Solicitado'],3)."</div></div></th></tr></thead>";
																echo "<tbody class='collapsed'><tr><td><table>";
																echo "</table></th></td></tbody>";
															}
														}
													}
												}
											}
										}

									break;
								}


								
							}
						
							//echo "<pre>", print_r($results2), "</pre>";
		
							// Free the query result
							mssql_free_result($query);

					?>
		  </li>
		</ul>    
		</div>

		<div class="clear">

		</div>
		
		</div>

		<script type="text/javascript"> 

			$('thead').on('click', function(){
		    	$(this).next('tbody').toggleClass('collapsed');
				});

			$('body').on('click', '.level3', function(){

				var $this = $(this),
				temp = $this.data('temp'),
				year = $this.data('year'),
				cliente = $this.data('cliente'),
				categoria = $this.data('categoria'),
				articulo = $this.data('articulo'),
				flag = $this.data('flag'),
				tipo = $this.data('tipo')
				data = {
					'temp': temp,
					'year': year,
					'cliente': cliente,
					'categoria': categoria,
					'articulo': articulo,
					'flag': flag,
					'tipo': tipo
																			
				},
				level3 = $this.closest('tr').closest('thead'),
				tbody = level3.next('tbody');

				var action = 'level4.php';

				console.log(data);

				$.post(action, data, function(html){

					if(tbody.length){
						tbody.remove();
					}else{
						level3.after(html);
						var tbodyappended = level3.next('tbody');
						tbodyappended.removeClass('collapsed');
					}

					


					//console.log(html);
				});



			});


		
			
				
			
		</script>
</body>
</html>
