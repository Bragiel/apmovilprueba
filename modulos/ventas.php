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
			$temp= 'Mes';
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
		$user=$_SESSION["user"];

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
		
	 	 
		 $query=mssql_query("spRepVtasBB '".$_SESSION["user"]."','".$tipo."','".$temp."','".$year."'");


		while ($row = mssql_fetch_array($query)) {
			 $results[] = $row;
		}

		

		switch ($tipo){

				

					case "Tsal":

							foreach($results as $key => $value){

							 $categorias[$results[$key]['Categoria']] = array(
							            'AA' => $results[$key]['SumaA'],
							            'Venta' => $results[$key]['SumaV'],
							            'Presupuesto' => $results[$key]['SumaP']
							  );

							}

							foreach($results as $key => $value){

							      foreach($categorias as $categoria => $arr){
							            if($categoria == $results[$key]['Categoria']){
							                  $categorias[$categoria]['Clientes'][$results[$key]['Cliente']] = array(
							                        'SumaAC' => $results[$key]['SumaAC'],
							                        'SumaVC' => $results[$key]['SumaVC'],
							                        'SumaPC' => $results[$key]['SumaPC']
							                  );
							            }
							      }
							}

							foreach($results as $key => $value){
							      
							      foreach($categorias as $categoria => $datosCategoria){
							            foreach($datosCategoria as $datoCategoria => $clientes){
							                  if($datoCategoria == 'Clientes'){
							                        foreach($clientes as $cliente => $datosCliente){
							                              if($categoria == $results[$key]['Categoria'] && $cliente == $results[$key]['Cliente']){
							                                    $categorias[$categoria]['Clientes'][$cliente]['Productos'][$key] = array(
							                                         $results[$key]['Descripcion1'] => array(
							                                                'SumaA' => $results[$key]['AA'],
							                                                'SumaV' => $results[$key]['Venta'],
							                                                'SumaP' => $results[$key]['Presupuesto'],
							                                                'Articulo' => $results[$key]['Articulo'],
							                                                'Categoria' => $results[$key]['Categoria'],
							                                                'Cliente' => $results[$key]['Cliente']
							                                          ) 
							                                    );
							                              }
							                        }
							                  }

							            }

							      }


							}
				break;

				case "almacen":

						foreach($results as $key => $value){

							 $categorias[$results[$key]['Almacen']] = array(
							            'AA' => $results[$key]['SumaA'],
							            'Venta' => $results[$key]['SumaV'],
							            'Presupuesto' => $results[$key]['SumaP']
							  );

							}

							foreach($results as $key => $value){

							      foreach($categorias as $categoria => $arr){
							            if($categoria == $results[$key]['Almacen']){
							                  $categorias[$categoria]['Clientes'][$results[$key]['Cliente']] = array(
							                        'SumaAC' => $results[$key]['SumaAC'],
							                        'SumaVC' => $results[$key]['SumaVC'],
							                        'SumaPC' => $results[$key]['SumaPC']
							                  );
							            }
							      }
							}

							foreach($results as $key => $value){
							      
							      foreach($categorias as $categoria => $datosCategoria){
							            foreach($datosCategoria as $datoCategoria => $clientes){
							                  if($datoCategoria == 'Clientes'){
							                        foreach($clientes as $cliente => $datosCliente){
							                              if($categoria == $results[$key]['Almacen'] && $cliente == $results[$key]['Cliente']){
							                                    $categorias[$categoria]['Clientes'][$cliente]['Productos'][$key] = array(
							                                         $results[$key]['Descripcion1'] => array(
							                                                'SumaA' => $results[$key]['AA'],
							                                                'SumaV' => $results[$key]['Venta'],
							                                                'SumaP' => $results[$key]['Presupuesto'],
							                                                'Articulo' => $results[$key]['Articulo'],
							                                                'Categoria' => $results[$key]['Categoria'],
							                                                'Cliente' => $results[$key]['Cliente']
							                                          ) 
							                                    );
							                              }
							                        }
							                  }

							            }

							      }


							}
				break;

				case "articulo":

						foreach($results as $key => $value){

							 $categorias[$results[$key]['Descripcion1']] = array(
							            'AA' => $results[$key]['SumaA'],
							            'Venta' => $results[$key]['SumaV'],
							            'Presupuesto' => $results[$key]['SumaP']
							  );

							}

							foreach($results as $key => $value){

							      foreach($categorias as $categoria => $arr){
							            if($categoria == $results[$key]['Descripcion1']){
							                  $categorias[$categoria]['Clientes'][$results[$key]['Cliente']] = array(
							                        'SumaAC' => $results[$key]['AA'],
							                        'SumaVC' => $results[$key]['Venta'],
							                        'SumaPC' => $results[$key]['Presupuesto'],
							                        'Articulo' => $results[$key]['Articulo'],
							                        'Categoria' => $results[$key]['Categoria'],
							                        'Cliente' => $results[$key]['Cliente']
							                  );
							            }
							      }
							}

							
				break;

				case "cliente":

							foreach($results as $key => $value){

							 $categorias[$results[$key]['CteNombre']] = array(
							            'AA' => $results[$key]['SumaA'],
							            'Venta' => $results[$key]['SumaV'],
							            'Presupuesto' => $results[$key]['SumaP'],
							           	'Cliente' => $results[$key]['Cliente'],
							           	'Articulo' => $results[$key]['Articulo']
							  );

							}

							foreach($results as $key => $value){

							      foreach($categorias as $categoria => $arr){
							            if($categoria == $results[$key]['CteNombre']){
							                  $categorias[$categoria]['Clientes'][$results[$key]['Categoria']] = array(
							                        'SumaAC' => $results[$key]['SumaAC'],
							                        'SumaVC' => $results[$key]['SumaVC'],
							                        'SumaPC' => $results[$key]['SumaPC']
							                  );
							            }
							      }
							}

							foreach($results as $key => $value){
							      
							      foreach($categorias as $categoria => $datosCategoria){
							            foreach($datosCategoria as $datoCategoria => $clientes){
							                  if($datoCategoria == 'Clientes'){
							                        foreach($clientes as $cliente => $datosCliente){
							                              if($categoria == $results[$key]['CteNombre'] && $cliente == $results[$key]['Categoria']){
							                                    $categorias[$categoria]['Clientes'][$cliente]['Productos'][$key] = array(
							                                         $results[$key]['Descripcion1'] => array(
							                                                'SumaA' => $results[$key]['AA'],
							                                                'SumaV' => $results[$key]['Venta'],
							                                                'SumaP' => $results[$key]['Presupuesto'],
							                                                'Articulo' => $results[$key]['Articulo'],
							                                                'Categoria' => $results[$key]['Categoria'],
							                                                'Cliente' => $results[$key]['Cliente']
							                                          ) 
							                                    );
							                              }
							                        }
							                  }

							            }

							      }


							}

							
				break;
				

		}
//echo "<pre>", print_r($results), "</pre>";	





		

?>




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
			<a href='cuentas.php'><img src="../assets/img/cobrar.png" /></a>

		</div>
		<div class='boton2'>
			<a href='inventario.php'><img src="../assets/img/inventarios.png" />

			
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

									$years = years("2008", date("Y"));

		    							
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
								<select name="year">
									<?php 
										foreach ($years as $key => $value) {
											if ($year == $value){
												echo '<option value="'.$value.'" selected>'.$value.'</option>';
											}else{
												echo '<option value="'.$value.'" >'.$value.'</option>';
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
		    
			<li>
				

		    

			         <?php
						if (!mssql_num_rows($query)) {
											echo 'No records found';
							}
							else{
									
									//******** Nivel uno DrillDown		
								foreach ($categorias as $categoria => $datoCategoria){
									echo '<table>';
									if( $categoria!=''){
									echo "<thead><tr><th><div class='info'>".utf8_encode($categoria)."</div>";

												
														if($datoCategoria['Presupuesto']> 0){
															if ($datoCategoria["Venta"]<$datoCategoria['Presupuesto']){

																echo "<div class='datos danger'>".number_format($datoCategoria["Presupuesto"], 2)."</div><div class='datos danger'> ".number_format($datoCategoria["Venta"], 2)."</div><div class='datos danger ' id='AA'> ".number_format($datoCategoria["AA"], 2)." </div></div></th></tr></thead>";
																
															}else{

																echo "<div class='datos neutral'>".number_format($datoCategoria["Presupuesto"], 2)."</div><div class='datos neutral'> ".number_format($datoCategoria["Venta"], 2)."</div><div class='datos neutral'> ".number_format($datoCategoria["AA"], 2)." </div></div></th></tr></thead>";

															}
															echo "<tbody class='collapsed'><tr><td><table>";
														}else{
															 if($datoCategoria['Venta']- $datoCategoria['AA'] < 0 && $datoCategoria['Venta']- $datoCategoria['AA'] < -20){

															 	echo "<div class='datos danger'>".number_format($datoCategoria["Presupuesto"], 2)."</div><div class='datos danger'> ".number_format($datoCategoria["Venta"], 2)."</div><div class='datos danger ' id='BB'> ".number_format($datoCategoria["AA"], 2)." </div></div></th></tr></thead>";
																
															 }else{

															 	echo "<div class='datos neutral'>".number_format($datoCategoria["Presupuesto"], 2)."</div><div class='datos neutral'> ".number_format($datoCategoria["Venta"], 2)."</div><div class='datos neutral'> ".number_format($datoCategoria["AA"], 2)." </div></div></th></tr></thead>";

															 }
															 echo "<tbody class='collapsed'><tr><td><table>";
														}

															//********** Nivel dos DrillDown
															foreach ($datoCategoria["Clientes"] as $Cliente => $datosCliente) {

																
																
																echo "<thead ><tr><th class='level2'><div class='info'>".utf8_encode($Cliente)." </div>";

																if($datosCliente['SumaPC'] > 0){


																	//echo 'SumaPC es Mayor que 0';
																	if($datosCliente["SumaPC"] > $datosCliente['SumaVC']){							
																			
																		
																			echo "<div class='datos danger'>".number_format($datosCliente["SumaPC"], 2)."</div><div class='datos danger'>".number_format($datosCliente["SumaVC"], 2)."</div><div class='datos danger'>".number_format($datosCliente["SumaAC"], 2)."</div></div></th></tr></thead>";
																		
																	}else{
																		echo "<div class='datos neutral'>".number_format($datosCliente["SumaPC"], 2)."</div><div class='datos neutral'>".number_format($datosCliente["SumaVC"], 2)."</div><div class='datos neutral'>".number_format($datosCliente["SumaAC"], 2)."</div></div></th></tr></thead>";
																	}
																	echo "<tbody class='collapsed'><tr><td><table>";
																
																	
																}else{

																	//echo 'Suma PC es 0';
																	if(($datosCliente["SumaVC"] - $datosCliente['SumaAC']) < 0){							
																			
																		if(($datosCliente["SumaVC"] - $datosCliente['SumaAC']) < -20) {
																			echo "<div class='datos danger'>".number_format($datosCliente["SumaPC"], 2)."</div><div class='datos danger'>".number_format($datosCliente["SumaVC"], 2)."</div><div class='datos danger'>".number_format($datosCliente["SumaAC"], 2)."</div></div></th></tr></thead>";
																		}else{
																			echo "<div class='datos caution'>".number_format($datosCliente["SumaPC"], 2)."</div><div class='datos caution'>".number_format($datosCliente["SumaVC"], 2)."</div><div class='datos caution'>".number_format($datosCliente["SumaAC"], 2)."</div></div></th></tr></thead>";
																		}
																	}else{
																		echo "<div class='datos neutral'>".number_format($datosCliente["SumaPC"], 2)."</div><div class='datos neutral'>".number_format($datosCliente["SumaVC"], 2)."</div><div class='datos neutral'>".number_format($datosCliente["SumaAC"], 2)."</div></div></th></tr></thead>";
																	}
																	echo "<tbody class='collapsed'><tr><td><table>";
													


																}



																//**************Nivel 3 DrillDown
																foreach ($datosCliente["Productos"] as $k => $Producto) {
																	foreach ($Producto as $nombreProducto => $datosProducto) {


																			echo "<thead ><tr><th class='level3' data-temp='".$temp."' data-year='".$year."' data-cliente='".$datosProducto['Cliente']."' data-categoria='".$datosProducto['Categoria']."' data-articulo='".$datosProducto['Articulo']."' data-flag='".$datosProducto["SumaV"]."' data-tipo='".$tipo."' '><div class='info'>".utf8_encode($nombreProducto)."</div>";

																			if($datosProducto['SumaP']==0){
																				if(($datosProducto["SumaV"] - $datosProducto['SumaA']) < 0) {

																					if(($datosProducto["SumaV"] - $datosProducto['SumaA']) < -20){
																						echo "<div class='datos danger'>".number_format($datosProducto["SumaP"], 2)."</div><div class='datos danger'>".number_format($datosProducto["SumaV"], 2)."</div><div class='datos danger'>".number_format($datosProducto["SumaA"], 2)."</div></div></th></tr></thead>";
																					}else{
																						echo "<div class='datos caution'>".number_format($datosProducto["SumaP"], 2)."</div><div class='datos caution'>".number_format($datosProducto["SumaV"], 2)."</div><div class='datos caution'>".number_format($datosProducto["SumaA"], 2)."</div></div></th></tr></thead>";

																					}
																				}else{
																					echo "<div class='datos neutral'>".number_format($datosProducto["SumaP"], 2)."</div><div class='datos neutral'>".number_format($datosProducto["SumaV"], 2)."</div><div class='datos neutral'>".number_format($datosProducto["SumaA"], 2)."</div></div></th></tr></thead>";

																				}
																			}else{
																				if($datosProducto["SumaV"] < $datosProducto['SumaP']) {

																					
																						echo "<div class='datos danger'>".number_format($datosProducto["SumaP"], 2)."</div><div class='datos danger'>".number_format($datosProducto["SumaV"], 2)."</div><div class='datos danger'>".number_format($datosProducto["SumaA"], 2)."</div></div></th></tr></thead>";
																					
																				}else{
																					echo "<div class='datos neutral'>".number_format($datosProducto["SumaP"], 2)."</div><div class='datos neutral'>".number_format($datosProducto["SumaV"], 2)."</div><div class='datos neutral'>".number_format($datosProducto["SumaA"], 2)."</div></div></th></tr></thead>";

																				}

																			}

																																
																			
																	}
																				
																}
																echo "</table></th></td></tbody>";
															}
														
												
											}else{

												foreach ($categorias as $categoria => $datoCategoria){
													foreach ($datoCategoria["Clientes"] as $Cliente => $datosCliente) {
														foreach ($datosCliente["Productos"] as $k => $Producto) {
															foreach ($Producto as $nombreProducto => $datosProducto) {

																if($nombreProducto=='TOTAL'){


																	echo "<thead ><tr><th class='level1'><div class='info'>".$nombreProducto."</div>";

																	if($datosProducto["SumaV"]<$datosProducto['SumaP'] || $datosProducto["SumaV"] < $datosProducto['SumaA']){

																		if($datosProducto["SumaV"]<$datosProducto['SumaP'] && $datosProducto["SumaV"] < $datosProducto['SumaA']){
																			echo "<div class='datos danger'>".number_format($datosProducto["SumaP"], 2)."</div><div class='datos danger'>".number_format($datosProducto["SumaV"], 2)."</div><div class='datos danger'>".number_format($datosProducto["SumaA"], 2)."</div></div></th></tr></thead>";
																		}else{
																			echo "<div class='datos caution'>".number_format($datosProducto["SumaP"], 2)."</div><div class='datos caution'>".number_format($datosProducto["SumaV"], 2)."</div><div class='datos caution'>".number_format($datosProducto["SumaA"], 2)."</div></div></th></tr></thead>";

																		}
																	}else{
																		echo "<div class='datos neutral'>".number_format($datosProducto["SumaP"], 2)."</div><div class='datos neutral'>".number_format($datosProducto["SumaV"], 2)."</div><div class='datos neutral'>".number_format($datosProducto["SumaA"], 2)."</div></div></th></tr></thead>";

																	}
																}			
															}
																		
														}

													}

												}

											}
									echo "</table></th></td></tbody></table>";
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
