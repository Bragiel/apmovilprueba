<!doctype html>

<?php 
	session_start();
	if (!$_SESSION["log"]){
		header("Location:../index.php");
	}
	

	

	$tipo= 'Cliente';

	switch (date('m')):

		case 01:
			$temp= "Enero";
			break;
		case 02:
			$temp= "Febrero";
			break;
		case 03:
			$temp= "Marzo";
			break;
		case 04:
			$temp= "Abril";
			break;
		case 05:
			$temp= "Mayo";
			break;
		case 06:
			$temp= "Junio";
			break;
		case 07:
			$temp= "Julio";
			break;
		case 08:
			$temp= "Agosto";
			break;
		case 09:
			$temp= "Septiembre";
			break;
		case 10:
			$temp= "Octubre";
			break;
		case 11:
			$temp= "Noviembre";
			break;
		case 12:
			$temp= "Diciembre";
			break;
	endswitch;

	$year= date('Y');
	$origen='cuentas';
	
	
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
		
	 	 
		 $query=mssql_query("SpRepCxcAntxAge '".$_SESSION["user"]."'");


		while ($row = mssql_fetch_array($query)) {
			 $results[] = $row;
		}
		asort($results);

		$post=$_POST['cliente'];


		if ($post != 'cliente'){

			foreach($results as $key => $value){

							 $categorias[$results[$key]['Estado']] = array(
							 			'Cliente' => $results[$key]['Cliente'],
							            'VencidoxCliente' => $results[$key]['VencidoxCliente'],
					 		            'Moneda' => $results[$key]['Moneda'],
							            'Saldo' => $results[$key]['Saldo'],
							            'SaldoxEstado' => $results[$key]['SaldoxEstado']
							  );

							}

							foreach($results as $key => $value){

							      foreach($categorias as $categoria => $arr){
							            if($categoria == $results[$key]['Estado']){
							                  $categorias[$categoria]['Nombres'][$results[$key]['Nombre']] = array(
							                        'SaldoxEstado' => $results[$key]['SaldoxEstado']
							                        
							                  );
							            }
							      }
							}

							foreach($results as $key => $value){
							      
							      foreach($categorias as $categoria => $datosCategoria){
							            foreach($datosCategoria as $datoCategoria => $clientes){
							                  if($datoCategoria == 'Nombres'){
							                        foreach($clientes as $cliente => $datosCliente){
							                              if($categoria == $results[$key]['Estado'] && $cliente == $results[$key]['Nombre']){
							                                    $categorias[$categoria]['Nombres'][$cliente]['Movimientos'][$key] = array(
							                                         $results[$key]['Mov'] => array(
							                                                'Vencimiento' => $results[$key]['Vencimiento'],
							                                                'Saldo' => $results[$key]['Saldo'],
							                                                'Cliente' =>$results[$key]['Cliente'],
							                                                'ID' =>$results[$key]['ID']
							                                          ) 
							                                    );
							                              }
							                        }
							                  }

							            }

							      }


							}
		}else{
			foreach($results as $key => $value){

							 $categorias[$results[$key]['Nombre']] = array(
							 			'Cliente' => $results[$key]['Cliente'],
							            'VencidoxCliente' => $results[$key]['VencidoxCliente'],
					 		            'Moneda' => $results[$key]['Moneda'],
							            'Saldo' => $results[$key]['Saldo'],
							            'SaldoxEstado' => $results[$key]['SaldoxEstado']
							  );

							}

							foreach($results as $key => $value){

							      foreach($categorias as $categoria => $arr){
							            if($categoria == $results[$key]['Nombre']){
							            	
							                  $categorias[$categoria]['Estados'][$results[$key]['Estado']] = array(
							                        'SaldoxEstado' => $results[$key]['SaldoxEstado']
							                        
							                  );
							                  
							            }
							      }
							      
							     
							}

							foreach($results as $key => $value){
							      
							      foreach($categorias as $categoria => $datosCategoria){
							            foreach($datosCategoria as $datoCategoria => $clientes){
							                  if($datoCategoria == 'Estados'){
							                        foreach($clientes as $cliente => $datosCliente){
							                              if($categoria == $results[$key]['Nombre'] && $cliente == $results[$key]['Estado']){
							                                    $categorias[$categoria]['Estados'][$cliente]['Movimientos'][$key] = array(
							                                         $results[$key]['Mov'] => array(
							                                                'Vencimiento' => $results[$key]['Vencimiento'],
							                                                'Saldo' => $results[$key]['Saldo'],
							                                                'Cliente' =>$results[$key]['Cliente'],
							                                                'ID' =>$results[$key]['ID']
							                                          ) 
							                                    );
							                              }
							                        }
							                  }

							            }

							      }


							}
		}

		
	
foreach ($categorias as $key => $value) {
	ksort($categorias[$key]['Estados']);
}







		

?>




</head>
<body>

	<div id='menu2'>
		
		<div class='boton2'>
			<a href='../contenedor.php'><img id='logoroche' src="../assets/img/comercialrochelogo.png"></a>
		</div>
		<div class='boton2'>
			<a href='embarques.php'><img src="../assets/img/embarques.png"/></a>
			
		</div>
		
		<div class='boton2'>
			<a href='ventas.php'><img src="../assets/img/ventas.png" /></a>

		</div>
		<div class='boton2'>
			<a href='inventario.php'><img src="../assets/img/inventarios.png" /></a>

			
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
			


			<form action='' method="post">
				<?php if($post != 'cliente'){ ?>
					<input type='hidden' name='cliente' value='cliente'>
					<input type='submit' id='btnBuscar' value='Por Cliente'>
					
				<?php }else{ ?>
					<input type='hidden' name='cliente' value='xdia'>
					<input type='submit' id='btnBuscar' value='Por Día'>
				<?php } ?>

		   
		    </form>
		    <!-- <li>
		    	<div id='titles'>
		    		<div>
		    			AA
		    		</div>
		    		<div>
		    			Ventas
		    		</div>
		    		<div>
		    			Pres.
		    		</div>
		    		
		    	</div>
		    </li>
		    
			<li> -->
				

		    

			         <?php
						if (!mssql_num_rows($query)) {
											echo 'No records found';
							}
							else{

								//ksort($categorias);

									//******** Nivel uno DrillDown	

									$sumaTotal = 0;	
									ksort($categorias);
								foreach ($categorias as $categoria => $datoCategoria){
									
									echo '<table>';
									if( $datoCategoria['Cliente'] != 'TOTAL'){
										if($post != 'cliente'){
												$sumaTemp = 0;

												foreach ($datoCategoria["Nombres"] as $Cliente => $datosCliente) {
													$sumaTemp = $sumaTemp + floatval(str_replace(',', '', $datosCliente['SaldoxEstado']));
												}

												$sumaTotal = $sumaTotal + $sumaTemp;
									
											echo "<thead><tr><th><div class='info'>".$categoria."</div>";
											echo "<div class='datos2 neutral'>".number_format($sumaTemp, 2)."</div></th></tr></thead>";
											echo "<tbody class='collapsed'><tr><td><table>";
												//********** Nivel dos DrillDown

												foreach ($datoCategoria["Nombres"] as $Cliente => $datosCliente) {

													echo "<thead ><tr><th class='level2'><div class='info'>".$Cliente." </div>";
													echo "<div class='datos2 neutral'>".$datosCliente['SaldoxEstado']."</div></th></tr></thead>";
													echo "<tbody class='collapsed'><tr><td><table>";
																	
													//**************Nivel 3 DrillDown
														foreach ($datosCliente["Movimientos"] as $k => $Producto) {
															foreach ($Producto as $nombreProducto => $datosProducto) {
																$fechain = substr_replace(substr($datosProducto["Vencimiento"], 0, -14), '-', 3, -7);
															 	$fechaco = substr_replace($fechain, '-', 5, -5);
															 	$originalDate = $fechaco;
																$newDate = date("d-m-Y", strtotime($originalDate));

																echo "<thead ><tr><th class='level3'><div class='info'><a href='detalle.php?id=".$datosProducto['ID']."&tiempo=".$temp."&year=".$year."&tipo=".$tipo.".&origen=".$origen." '>".$nombreProducto."</div>";
																echo "<div class='datos2 neutral'>".$datosProducto["Saldo"]."</div><div class='datos2 neutral'>".$newDate."</div></th></tr></thead>";
																				
															}
																					
														}
													echo "</table></th></td></tbody>";
												}

										}else{

													
												//ksort($categorias[$categoria]['Estados']);

												$sumaTemp = 0;

												foreach ($datoCategoria["Estados"] as $Cliente => $datosCliente) {

													$sumaTemp = $sumaTemp + floatval(str_replace(',', '', $datosCliente['SaldoxEstado']));
												}

												$sumaTotal = $sumaTotal + $sumaTemp;
									
											echo "<thead><tr><th><div class='info'>".$categoria."</div>";
											echo "<div class='datos2 neutral'>".number_format($sumaTemp, 2)."</div></th></tr></thead>";
											echo "<tbody class='collapsed'><tr><td><table>";
												//********** Nivel dos DrillDown
												//asort($datoCategoria["Estados"]);
												foreach ($datoCategoria["Estados"] as $Cliente => $datosCliente) {

													echo "<thead ><tr><th class='level2'><div class='info'>".$Cliente." </div>";
													echo "<div class='datos2 neutral'>".$datosCliente['SaldoxEstado']."</div></th></tr></thead>";
													echo "<tbody class='collapsed'><tr><td><table>";
																	
													//**************Nivel 3 DrillDown
														foreach ($datosCliente["Movimientos"] as $k => $Producto) {
															foreach ($Producto as $nombreProducto => $datosProducto) {
																$fechain = substr_replace(substr($datosProducto["Vencimiento"], 0, -14), '-', 3, -7);
															 	$fechaco = substr_replace($fechain, '-', 5, -5);
															 	$originalDate = $fechaco;
																$newDate = date("d-m-Y", strtotime($originalDate));

																echo "<thead ><tr><th class='level3'><div class='info'><a href='detalle.php?id=".$datosProducto['ID']."&tiempo=".$temp."&year=".$year."&tipo=".$tipo.".&origen=".$origen." '>".$nombreProducto."</div>";
																echo "<div class='datos2 neutral'>".$datosProducto["Saldo"]."</div><div class='datos2 neutral'>".$newDate."</div></th></tr></thead>";
																				
															}
																					
														}
													echo "</table></th></td></tbody>";
												}

										}


											
										
														
												
									}
									echo "</table></th></td></tbody></table>";
								}
											echo '<table>';

											echo "<thead ><tr><th class='level1'><div class='info'>TOTAL</div>";

											echo "<div class='datos2 neutral'>".number_format($sumaTotal, 2)."</div></th></tr></thead>";

															

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
				tipo = 'cliente'
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
