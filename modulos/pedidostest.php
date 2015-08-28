<!doctype html>
<?php
	session_start();
	if (!$_SESSION["log"]){
		header("Location:../index.php");
	}
	//VARIABLES DROPDOWN


	 	$DB = 'pruebasCOSYSA';
		$serverName = "intelisis"; //serverName\instanceName
		$connectionInfo = array( "Database"=>$DB, "UID"=>"intelisis", "PWD"=>"");
		$conn = mssql_connect( $serverName, "intelisis", "");
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

	 		$con7="set language spanish";
	 		$con7= mssql_query($con7);


	 		$con8= mysql_query("SET NAMES 'UTF8'");

	 		$hoy = date("d-m-Y");
	 		$today=date("Y-d-m");
			$fut= mktime(0, 0, 0, date("m"), date("d")+4, date("Y"));
			$futuro=date("d-m-Y", $fut);
			$future=date("Y-d-m", $fut);






	if ($_POST){
		
		$almacen=$_POST["almacen"];
		$proyecto=$_POST["proyecto"];
		$sucursal=$_POST["sucursal"];
		$condiciones=$_POST["condicion"];
		$impuestos=$_POST["impuestos"];
		$envio=$_POST["envio"];
		$precios=$_POST["precios"];
		$ordencompra=$_POST["ordencompra"];
		$observaciones=$_POST["observaciones"];
		$movid=$_POST["p_folio"];
		$idcliente=$_POST["p_clienteid"];
		$p_cliente = $_POST['p_cliente'];
		$idart=$_POST['id_articulo'];
		$futurex=explode('-', $_POST['futuro']);
		$future=$futurex[2].'-'.$futurex[0].'-'.$futurex[1];

		echo $idart;
		//echo "INSERT INTO ventabb (Empresa, Mov, MovID, Cliente, EnviarA, FechaEmision, Fecharequerida, Almacen, Proyecto, Condicion, FormaEnvio, ListaPreciosEsp, ZonaImpuestos, Referencia, Agente, Observaciones, OrdenCompra) VALUES ('ROCHE','Pedido',".$movid.",'".$idcliente."','".$sucursal."','".$today."','".$future."','".$almacen."','".$proyecto."','".$condiciones."','".$envio."','".$precios."','".$impuestos."',NULL,'".$_SESSION["user"]."','".$observaciones."','".$ordencompra."'); SELECT @@IDENTITY";
		//echo $proyecto;

		//echo $idcliente;


		if ($idart != ''){
			$sql ="spConfirmaPedidoBB ".$idart."";
			$save=mssql_query($sql);
			header("Location:../contenedor.php");


		}

		if($idart!=''){
			$sql= "spInsertaPedidoBB 'ROCHE','Pedido',".$movid.",'".$idcliente."','".$sucursal."','".$today."','".$future."','".$almacen."','".$proyecto."','".$condiciones."','".$envio."','".$precios."','".$impuestos."','".$_SESSION["user"]."','".$observaciones."','".$ordencompra."'";

		}


		 //$sql = "INSERT INTO ventabb (Empresa, Mov, MovID, Cliente, EnviarA, FechaEmision, Fecharequerida, Almacen, Proyecto, Condicion, FormaEnvio, ListaPreciosEsp, ZonaImpuestos, Referencia, Agente, Observaciones, OrdenCompra) VALUES ('ROCHE','Pedido',".$movid.",'".$idcliente."','".$sucursal."','".$today."','".$future."','".$almacen."','".$proyecto."','".$condiciones."','".$envio."','".$precios."','".$impuestos."',NULL,'".$_SESSION["user"]."','".$observaciones."','".$ordencompra."'); SELECT @@IDENTITY";
		 $insertion=mssql_query($sql);
		 $arreglo = mysql_fetch_array($insertion, MYSQL_NUM);


		 while ($row = mssql_fetch_array($insertion)) {
			  $id_articulo = $row[0];
			  //echo $id_articulo;
		}


		 if( $insertion === false ) {
		      die( print_r( sqlsrv_errors(), true));
		 }



		//echo "almacen=>".$almacen." proyecto=>".$proyecto." Sucursal=>".$sucursal." Condiciones=>".$condiciones." impuestos=>".$impuestos."<br>";
		//echo "envio=>".$envio." precios=>".$precios." orden de compra=>".$ordencompra." observaciones".$observaciones." folio=>".$movid." idcliente=>".$idcliente;


	}

		 $query=mssql_query("spConsultaPedidoBB 'Cliente','".$_SESSION["user"]."',NULL,1");


		while ($row = mssql_fetch_array($query)) {
			 $results[] = $row;
		}


		foreach($results as $key => $value){

			$descripciones[$results[$key]['Cliente']] = array(
				'Nombre' => $results[$key]['Nombre'],
				'Condicion' => $results[$key]['Condicion'],
				'ListaPreciosEsp' => $results[$key]['ListaPreciosEsp'],
				'FormaEnvio' => $results[$key]['FormaEnvio'],
				'ZonaImpuesto' => $results[$key]['ZonaImpuesto'],
				'Proyecto' => $results[$key]['Proyecto']
			);

		}
		$i=0;
		foreach($results as $key => $value){
			foreach($descripciones as $descripcion => $arr){
				if($descripcion == $results[$key]['Cliente'] && $descripcion != NULL){
					$nombre[$i] = utf8_encode($results[$key]['Nombre']);
					$i++;
				}
			}
		}





//echo "<pre>", print_r($descripciones2), "</pre>";



?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<meta name="robots" content="all" />
<meta name="viewport" content="width=device-width, height=device-height" >

<title>Ventas</title>


<script type="text/javascript" src="../assets/js/jquery.js"></script>
<script type="text/javascript" src="../assets/js/jquery-ui-1.10.4.custom.min.js"></script>
<script type="text/javascript" src="../assets/js/jquery.mask.min"></script>
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
			<input type="hidden" name="id_articulo" value="<?php echo (isset($id_articulo)) ? $id_articulo : ''; ?>">
			<div class="wrapper">
				<div id="login">
				<input type="hidden" name="agente_id" value="<?php echo $user; ?>">
					<div id="p_folio">

						<label>Folio:</label>
						<input type="text"  onkeyup='change(this)' name="p_folio" value='<?php echo (isset($movid) ? $movid : ""); ?>'><img id='imgFolio'src='' style='display: none; margin-left: 2px;'>
						<script>
							function change(folio){
								var folio=folio.value;


								$.post('pedidos2.php', {foliovalue: folio}, function(data){
											if(data == 1){
										 		$("#imgFolio").attr('src','../assets/img/ok.png').show();
										 	}else{
										 		$("#imgFolio").attr('src','../assets/img/no.png').show();
										 	}
									 	});
							}
						</script>
					</div>
					<div id="p_cliente">

						<label>Cliente:<br></label>

						<input id="p_inputCliente" type="text"  name="p_cliente"  value='<?php echo (isset($p_cliente) ? $p_cliente : ""); ?>'>
						<script type="text/javascript">
						    $(document).ready(function(){
						        var arrayValoresAutocompletar = <?php echo json_encode($nombre);?>;

							    $("#p_inputCliente").autocomplete({
							            source: arrayValoresAutocompletar,
							            close: function(select, ui){
							            var inputvalue= this.value;
									 	    //console.log(this.value);
									 	$.post('pedidos2.php', {clientevalue: inputvalue}, function(data){
									 		var condiciones = data.Condiciones,
									 			impuestos = data.ZonaImpuestos,
									 			envio = data.FormaEnvio,
									 			precios = data.Precios,
									 			cliente = data.Nombres,
									 			sucursal= data.Sucursal,
									 			id=data.Nombres.Cliente;

									 			console.log(data);


									 			$('select[name=condicion]').empty();
												for(var j=0;j<condiciones.length;j++){
													$('select[name=condicion]').append($('<option>', { text: condiciones[j], 'value': condiciones[j] }) );
												}
												for(var j=0;j<impuestos.length;j++){
													$('select[name=impuestos]').append($('<option>', { text: impuestos[j], 'value': impuestos[j] }) );
												}
												for(var j=0;j<envio.length;j++){
													$('select[name=envio]').append($('<option>', { text: envio[j], 'value': envio[j] }) );
												}
												for(var j=0;j<precios.length;j++){
													$('select[name=precios]').append($('<option>', { text: precios[j], 'value': precios[j] }) );
												}
												for(var j=0;j<sucursal.length;j++){
													$('select[name=sucursal]').append($('<option>', { text: sucursal[j], 'value': j }) );
												}
												$('input[name=p_clienteid]').attr('value', id);



									 		//console.log(id);
									 		//console.log(data);
									 	}, 'json');

							            }
							    })


						    })


						</script>
					</div>
					<div id='p_contfecha'>

						<div id='p_fechaLabel'>
							<label>Fecha Emisión:<br><br></label>
							<label>Fecha Requerida:</label>
						</div>
						<div id='p_fecha'>

							<label><?php echo $hoy; ?><br><br></label>
							<label><input type="text" name="futuro" id="futuro" value='<?php echo $futuro?>'></label>
						</div>
					</div>
					<div id='p_contCaracteristicas'>
						<div id='cont1'>

							<div class='p_dropLabel'><label>Almacén:<br></label></div>
							<div class='p_dropLabel'><label>Proyecto:<br></label></div>
							<div class='p_dropLabel'><label>Sucursal Cliente:<br></label></div>
							<div class='p_dropLabel'><label>Condiciones:<br></label></div>
							<div class='p_dropLabel'><label>Zona de Impuestos:<br></label></div>
							<div class='p_dropLabel'><label>Forma de Envío:<br></label></div>
							<div class='p_dropLabel'><label>Lista de Precios:<br></label></div>
							<div class='p_dropLabel'><label>Orden de Compra:<br></label></div>
							<div class='p_dropLabel'><label>Observaciones:<br></label></div>
						</div>
						<div id='cont2'>

							<div class='p_contSelect'><select name='almacen'>
								<option>::</option>
								<?php
								//DROPDOWN ******************************************************************************************
									$query2=mssql_query("spConsultaPedidoBB 'Almacen',NULL,NULL");


									while ($row2 = mssql_fetch_array($query2)) {
										 $results2[] = $row2;
									}
									$j=0;
									foreach($results2 as $key => $value){

										$descripciones2[$results2[$key]['Default'].$j] = array(
											'Almacen' => $results2[$key]['Almacen']
										);
										if(isset($almacen))
											if($almacen == $results2[$key]['Almacen'])
												echo '<option selected="selected" value="'.trim($results2[$key]['Almacen']).'" >'.trim($results2[$key]['Almacen']).'</option>';
										echo '<option value="'.trim($results2[$key]['Almacen']).'" >'.trim($results2[$key]['Almacen']).'</option>';
										$j++;
									}
								?>

							</select><br></div>
							<div class='p_contSelect'><select name='proyecto'>
								<option>::</option>
								<?php
								$query3=mssql_query("spConsultaPedidoBB 'Proyecto',NULL,NULL");


									while ($row3 = mssql_fetch_array($query3)) {
										 $results3[] = $row3;
									}

									$k=0;
									foreach($results3 as $key => $value){

										$descripciones3[$results3[$key]['Default'].$k] = array(
											'computed' => $results3[$key]['computed']
										);
										if(isset($proyecto))
											if($proyecto == $results3[$key]['computed'])
												echo '<option selected="selected" value="'.$results3[$key]['computed'].'">'.$results3[$key]['computed'].'</option>';
										echo '<option value="'.$results3[$key]['computed'].'">'.$results3[$key]['computed'].'</option>';
										$j++;
									}
								?>
							</select><br></div>
							<div class='p_contSelect'><select name='sucursal'>
								<?php echo (isset($sucursal)) ? "<option value='" . $sucursal . "'>" . $sucursal . "</option>" : ""; ?>
							</select><br></div>
							<div class='p_contSelect'><select name='condicion'>
								<?php echo (isset($condiciones)) ? "<option value='" . $condiciones . "'>" . $condiciones . "</option>" : ""; ?>
							</select><br></div>
							<div class='p_contSelect'><select name='impuestos'>
								<?php echo (isset($impuestos)) ? "<option value='" . $impuestos . "'>" . $impuestos . "</option>" : ""; ?>
							</select><br></div>
							<div class='p_contSelect'><select name='envio'>
								<?php echo (isset($envio)) ? "<option value='" . $envio . "'>" . $envio . "</option>" : ""; ?>
							</select><br></div>
							<div class='p_contSelect'><select name='precios'>
								<?php echo (isset($precios)) ? "<option value='" . $precios . "'>" . $precios . "</option>" : ""; ?>
							</select><br></div>
							<div class='p_contSelect'><input type="text" name="ordencompra" value="<?php echo (isset($ordencompra)) ? $ordencompra : ''; ?>"><br></div>
							<div class='p_contSelect'><input type="text" name="observaciones" value="<?php echo (isset($observaciones)) ? $observaciones : ''; ?>"><br></div>
						</div>
					</div>
					<input type='text' name='p_clienteid' style='display: none;' value="<?php echo (isset($idcliente)) ? $idcliente : ''; ?>">
					<div id='p_input'>
						<input type='submit' value='Agregar Artículo'>
					</div>

					<div id='pedidodetalle' <?php if(isset($id_articulo)) echo 'style="display:block;"'; else echo 'style="display:none;"' ?>>
						<div class='pd_cases' >
							<div class='pd_cases1'>Art.</div>
							<div class='pd_cases1'>Cant.</div>
							<div class='pd_cases2'>Inv.</div>
							<div class='pd_cases2'>Desc.</div>
							<div class='pd_cases2'>IVA</div>
							<div class='pd_cases3'>Subtotal</div>
							<div class='pd_cases4'></div>
						</div>

						<div class='pd_cases n'>
							<div class='pd_cases1'><input type='text' class='pdinput' onkeyup='' name="articulo"></div>
							<div class='pd_cases1'><input type='text' class='pdinput' onkeyup='' name="cantidad"></div>
							<div class='pd_cases2'><input type='text' name='Inventario' disabled></div>
							<div class='pd_cases2'><input type='text' name='Desc.' disabled></div>
							<div class='pd_cases2'><input type='text' name='IVA' disabled></div>
							<div class='pd_cases3'><input type='text' name='SUBTOTAL' disabled></div>
							<input type='hidden' name='IMPORTEDESC'>
							<input type='hidden' name='TOTALES'>
							<div class='pd_cases4'><span class="ok submit-n"><img src='../assets/img/ok.png' width='16px' height='16px'></span><span class="no submit-n"><img src='../assets/img/no.png' width='16px' height></span><span class="edit submit-n"><img src='../assets/img/edit.png' width='16px' height></span></div>
						</div>
					</div>
					<div id="sumas" <?php if(isset($id_articulo)) echo 'style="display:block;"'; else echo 'style="display:none;"' ?>>
						<div>
							<div>Subtotal: <span id="suma_subtotal"></span></div>
							<div>Descuentos: <span id="suma_descuentos"></span></div>
							<div>Impuestos: <span id="suma_impuestos"></span></div>
							<div>Total: <span id="total"></span></div>
						</div>

						<div id='reload'>
							<input type='hidden' name='enviar' value=1>
							<INPUT TYPE="submit" name='send' onClick="history.go(0)" VALUE="Enviar">
							<a id="test-reporte">Test</a>
						</div>
					</div>


				</div>
			</div>
		</form>

		<script type="text/javascript">


			$(function(){

				var id_articulo = $('input[name=id_articulo]').val(),
					div_pedidodetalle = $('#pedidodetalle'),
					body = $('body'),
					futuro = $('#futuro');

				futuro.datepicker({
					minDate: +4,
					dateFormat: "dd-mm-yy"

				});

				$('input[name=cantidad]').mask('00000');

				body.on('click', '#test-reporte', function(){
					// var $this = $(this);

					var father = $('#login'),
						folio = father.find('input[name=p_folio]').val(),
						clienteid = father.find('input[name=p_clienteid]').val(),
						propietario = father.find('input#p_inputCliente').val(),
						//direccion
						//estado
						lista_precios = father.find('select[name=precios]').val(),
						forma_envio = father.find('select[name=envio]').val(),
						agente_id = father.find('input[name=agente_id]').val(),
						fecha = father.find('#p_fecha').find('label').eq(0).text(),
						condiciones = father.find('select[name=condicion]').val(),
						sucursal = father.find('select[name=sucursal]').val(),
						almacen = father.find('select[name=almacen]').val(),
						zona_impuestos = father.find('select[name=impuestos]').val(),
						//precio_flete
						pd_cases = $('.pd_cases'),
						rows_raw = [],
						rows = [];

						pd_cases.each(function(i, el){
							// if(el.attr('data-count')){
								rows_raw.push(el);
							// }
						});

						// rows_raw.each(function(i, el){
						// 	var cantidad = el.find('input[name=cantidad]').val(),
						// 		clave = el.find('input[name=articulo]').val(),
						// 		//descripcion
						// 		//peso
						// 		//p_ton
						// 		subtotal = el.find('input[name=SUBTOTAL]').val(),
						// 		desc = el.find('input[name=Desc.]').val(),
						// 		//importe
						// 		//totales
						// 		row = {
						// 			'cantidad': cantidad,
						// 			'clave': clave,
						// 			'subtotal': subtotal,
						// 			'desc': desc
						// 		};

						// 	rows.push(row);
						// });


					var data = {
						'folio': folio,
						'clienteid': clienteid,
						'propietario': propietario,
						'lista_precios': lista_precios,
						'forma_envio': forma_envio,
						'agente_id': agente_id,
						'fecha': fecha,
						'condiciones': condiciones,
						'sucursal': sucursal,
						'almacen': almacen,
						'zona_impuestos': zona_impuestos,
						'pd_cases': pd_cases,
						'rows': rows_raw
					};

					console.log(data);

					// $.post('pedidos2.php', data, function(response){
					// 	console.log(response);
					// });

					alert('Pedido Enviado');

				});


				function getN(){
					var n = [],
						div = $('<div>', {
							class: 'pd_cases n'
						});

					n.push($('<div>', {
						class: 'pd_cases1',
						html: $('<input>', {
							type: 'text',
							class: 'pdinput',
							name: 'articulo'
						})
					}));

					n.push($('<div>', {
						class: 'pd_cases1',
						html: $('<input>', {
							type: 'text',
							class: 'pdinput',
							name: 'cantidad'
						}).mask('00000')
					}));

					n.push($('<div>', {
						class: 'pd_cases2',
						html: $('<input>', {
							type: 'text',
							name: 'Inventario',
							'disabled':'disabled'
						})
					}));
					n.push($('<div>', {
						class: 'pd_cases2',
						html: $('<input>', {
							type: 'text',
							name: 'Desc.',
							'disabled':'disabled'
						})
					}));
					n.push($('<div>', {
						class: 'pd_cases2',
						html: $('<input>', {
							type: 'text',
							name: 'IVA',
							'disabled':'disabled'
						})
					}));
					n.push($('<div>', {
						class: 'pd_cases3',
						html: $('<input>', {
							type: 'text',
							name: 'SUBTOTAL',
							'disabled':'disabled'
						})
					}));
					n.push($('<input>', {
							type: 'hidden',
							name: 'IMPORTEDESC'
					}));
					n.push($('<input>', {
							type: 'hidden',
							name: 'TOTALES'
					}));

					var options = [];

					options.push($('<span>', {
						class: 'ok submit-n',
						html: $('<img>', {
							src: '../assets/img/ok.png',
							width: '16px',
							height: '16px'
						})
					}));
					options.push($('<span>', {
						class: 'no submit-n',
						html: $('<img>', {
							src: '../assets/img/no.png',
							width: '16px',
							height: '16px'
						})
					}));
					options.push($('<span>', {
						class: 'edit submit-n',
						html: $('<img>', {
							src: '../assets/img/edit.png',
							width: '16px',
							height: '16px'
						})
					}));

					n.push($('<div>', {
						class: 'pd_cases4',
						html: options
					}));

					div.append(n);

					return div;
				}
				function formatNumber(number)
				{
				    number = number.toFixed(2) + '';
				    x = number.split('.');
				    x1 = x[0];
				    x2 = x.length > 1 ? '.' + x[1] : '';
				    var rgx = /(\d+)(\d{3})/;
				    while (rgx.test(x1)) {
				        x1 = x1.replace(rgx, '$1' + ',' + '$2');
				    }
				    return x1 + x2;
				}

				function floatNumber(number){
					if(isNaN(number)){
						number = number.replace(",","");
					}
					var floated = parseFloat(number);
					return floated;
				}

				function sumas(){
						// Inputs
					var inputs_descuentos = $('input[name=IMPORTEDESC]'),
						inputs_subtotal = $('input[name=SUBTOTAL]'),

						// Inicializar contadores de sumas
						suma_subtotal = 0.00,
						suma_descuentos = 0.00,

						//Para el ajax
						action = 'pedidos2.php',
						post = {'iddetalle': id_articulo},

						//Spans en donde se van a poner los totales
						span_suma_subtotal = $('#suma_subtotal'),
						span_suma_descuentos = $('#suma_descuentos'),
						span_suma_impuestos = $('#suma_impuestos'),
						span_total = $('#total');

					inputs_subtotal.each(function(index){
						var val = $(this).val();
						suma_subtotal = suma_subtotal + floatNumber(val);
					});

					inputs_descuentos.each(function(index){
						var val = $(this).val();
						suma_descuentos = suma_descuentos + floatNumber(val);
					});

					$.post(action, post, function(data){

						//console.log(data);

						var sumas = data[0],
							DescxFlete = (sumas.DescxFlete != null ? sumas.DescxFlete : 0.00),
							DescxPA = (sumas.DescxPA != null ? sumas.DescxPA : 0.00),
							descuentos = floatNumber(DescxFlete) + floatNumber(DescxPA) + floatNumber(suma_descuentos),
							impuestos = (sumas.Impuestos != null ? floatNumber(sumas.Impuestos) : 0.00),
							total = (sumas.Total != null ? floatNumber(sumas.Total) : 0.00);

						span_suma_subtotal.text(formatNumber(suma_subtotal));
						span_suma_descuentos.text(formatNumber(descuentos));
						span_suma_impuestos.text(formatNumber(impuestos));
						span_total.text(formatNumber(total));

					}, 'json');

				}


				if(id_articulo != ''){

					$('input[name=articulo]').focus();

					body.on('click', '.submit-n', function(){

						//Acciones

						var $this = $(this),
							n = $('.n'),
						 	p = $this.closest('.n'),
							articulo = p.find('input[name=articulo]').val(),
							cantidad = p.find('input[name=cantidad]').val(),
							fecha = futuro.val(),
							inventario = p.find('input[name=Inventario]'),
							desc = p.find('input[name="Desc."]'),
							iva = p.find('input[name=IVA]'),
							subtotal = p.find('input[name=SUBTOTAL]'),
							importedesc = p.find('input[name=IMPORTEDESC]'),
							totales = p.find('input[name=TOTALES]');

						n.each(function(index){
							$(this).attr('data-count', index+1);
						});

							var count = p.data('count');

						if($this.hasClass('ok') || $this.hasClass('edit')){
							var action = 'G',
								post = {
									'articulo': articulo,
									'cantidad': cantidad,
									'id_articulo': id_articulo,
									'count': count,
									'action': action,
									'fecha': fecha,
									pedidodetalle: 1 };
						}else if($this.hasClass('no')){
							var action = 'B',
								post = {
									'articulo': articulo,
									'cantidad': cantidad,
									'id_articulo': id_articulo,
									'count': count,
									'action': action,
									'fecha': fecha,
									pedidodetalle: 1 };
						}

						//console.log(post);

						$.post('pedidos2.php', post, function(data){

								if(data.result == 'save'){

									var dataInventario = data[0].Inventario,
										dataDesc = data[0]['Desc.'],
										dataIva = data[0].IVA,
										dataSubtotal = data[0].SUBTOTAL,
										dataImporteDesc = data[0].IMPORTEDESC,
										dataTotales = data[0].TOTALES,
										dataSubtotal = dataSubtotal,
										dataTotales = dataTotales,
										dataImporteDesc = dataImporteDesc;


									inventario.val(dataInventario);
									desc.val(dataDesc);
									iva.val(dataIva);
									subtotal.val(dataSubtotal);
									importedesc.val(dataImporteDesc),
									totales.val(dataTotales);

									sumas();

									if($this.hasClass('ok')){
										$this.remove();
										nuevo = getN();
										div_pedidodetalle.append(nuevo);
									}

								}else if(data.result == 'delete'){
									p.remove();
									sumas();
								}else if(data.result == 'none'){
									alert('No existe ese artículo');
								}

								//console.log(data);

						}, 'json');

						$this.unbind('click');

						return false;

					});

				}

			});

		</script>

		<?php
			//echo "<pre>", print_r($results3), "</pre>";
		?>
	</body>
</html>


