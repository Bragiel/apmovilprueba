<!doctype html>

<?php 
	session_start();
	if (!$_SESSION["log"]){
		header("Location:../index.php");
	}
	

	if ($_POST){
		
		$AlmacenP= $_POST["Almacen"];
		$Cat= $_POST["CategoriaP"];
	
	}elseif ($_GET){

		$AlmacenP= $_GET["Almacen"];
		$Cat= $_GET["CategoriaP"];
		

	}else{

			$AlmacenP= '(Todos)';
			$Cat= '(Todos)';
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
		
	 	 
		 $query=mssql_query("spRepExistenciaBB 'ROCHE','".$AlmacenP."','".$Cat."'");


		while ($row = mssql_fetch_array($query)) {
			 $results[] = $row;
		}

		

			foreach($results as $key => $value){

							 $categorias[$results[$key]['Categoria']] = array(
							 			'Articulo' => $results[$key]['Articulo']
							          
							  );

							}

							foreach($results as $key => $value){

							      foreach($categorias as $categoria => $arr){
							            if($categoria == $results[$key]['Categoria']){
							                  $categorias[$categoria]['Descripciones'][$results[$key]['Descripcion']] = array(
							                        'Disponible' => $results[$key]['Disponible'],
							                        'Pendiente' => $results[$key]['Pendiente'],
							                        'Programado' => $results[$key]['Programado'],
							                        'Saldo' => $results[$key]['Saldo'],
							                        'Articulo' => $results[$key]['Articulo']
							                        
							                  );
							            }
							      }
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
			<img src="../assets/img/embarques.png"/>
			
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
		    	<div id="selectors">

			    				<?php $Almacenes=array(
			    					'(Todos)'=>'Todos',
			    					'Cancun'=>'Cancun',
			    					'Coloradas'=>'Coloradas',
			    					'Guadalajara'=>'Guadalajara',
			    					'Mexico'=>'México',
			    					'Puebla'=>'Puebla',
			    					'Queretaro'=>'Queretaro',
			    					'Tampico'=>'Tampico',
			    					'Tizimin'=>'Tizimín',
			    					'Veracruz'=>'Veracruz',
			    					'Villa'=>'Villa'
			    					); 

			    					$CategoriaP=array(
			    					'(Todos)'=>'Todos',
			    					'Bote'=>'Bote',
			    					'Flete'=>'Flete',
			    					'Granel'=>'Granel',
			    					'Paquete'=>'Paquete',
			    					'Sacos'=>'Sacos',
			    					'Salsas'=>'Salsas',
			    					'Super saco'=>'Super saco'			    					
		    						);

		    							
			    				?>
								<select name="Almacen">
									<?php 
										foreach ($Almacenes as $key => $value) {
											if ($AlmacenP == $key){
												echo '<option value="'.$key.'" selected>'.$value.'</option>';
											}else{
												echo '<option value="'.$key.'" >'.$value.'</option>';
											}
										}

									 ?>
								</select>

								<select name="CategoriaP">
									<?php 
										foreach ($CategoriaP as $key => $value) {
											if ($Cat == $key){
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
		    			Disp.
		    		</div>
		    		<div>
		    			Pend.
		    		</div>
		    		<div>
		    			Prog.
		    		</div>
		    		<div>
		    			Saldo
		    		</div>
		    		
		    	</div>
		    </li>
		    
			<li> 
				

		    

			         <?php
						if (!mssql_num_rows($query)) {
											echo 'No records found';
							}
							else{

								ksort($categorias);

								

									
									//******** Nivel uno DrillDown	

									$sumaTotal = 0;	
								foreach ($categorias as $categoria => $datoCategoria){
									echo '<table>';
									if( $datoCategoria['Cliente'] != 'TOTAL'){

												$sumaTempD = 0;
												$sumaTempP = 0;
												$sumaTempPr = 0;
												$sumaTempS = 0;

												 foreach ($datoCategoria["Descripciones"] as $Cliente => $datosCliente) {
												 	$sumaTempD = $sumaTempD + floatval($datosCliente['Disponible']);
												 	$sumaTempP = $sumaTempP + floatval($datosCliente['Pendiente']);
												 	$sumaTempPr = $sumaTempPr + floatval($datosCliente['Programado']);
												 	$sumaTempS = $sumaTempS + floatval($datosCliente['Saldo']);
												 }

												$sumaTotal = $sumaTotal + $sumaTemp;
									
											echo "<thead><tr><th><div class='infoInv'>".$categoria."</div>";
											echo "<div class='datos3 neutral'>".number_format($sumaTempS, 2)."</div><div class='datos3 neutral'>".number_format($sumaTempPr, 2)."</div><div class='datos3 neutral'>".number_format($sumaTempP, 2)."</div><div class='datos3 neutral'>".number_format($sumaTempD, 2)."</div></th></tr></thead>";
											echo "<tbody class='collapsed'><tr><td><table>";
												//********** Nivel dos DrillDown

												foreach ($datoCategoria["Descripciones"] as $Cliente => $datosCliente) {

													echo "<thead ><tr><th class='level2'><div class='infoInv'>".$Cliente." </div>";
													echo "<div class='datos4 neutral'>".number_format($datosCliente['Saldo'], 2)."</div><div class='datos4 neutral'>".number_format($datosCliente['Programado'], 2)."</div><div class='datos4 neutral'>".number_format($datosCliente['Pendiente'], 2)."</div><div class='datos4 neutral'>".number_format($datosCliente['Disponible'], 2)."</div></th></tr></thead>";
													echo "<tbody class='collapsed'><tr><td><table>";
													echo "</table></th></td></tbody>";
												}

											
										
														
												
									}
									echo "</table></th></td></tbody></table>";
								}
											// echo '<table>';

											// echo "<thead ><tr><th class='level1'><div class='info'>TOTAL</div>";

											// echo "<div class='datos2 neutral'>".number_format($sumaTotal, 2)."</div></th></tr></thead>";

															

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
