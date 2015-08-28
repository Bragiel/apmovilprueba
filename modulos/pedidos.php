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


	 		//$con8= mssql_query("SET NAMES 'UTF8'");

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
		$futu=$_POST['futuros'];
		$futurex=explode('-', $_POST['futuro']);
		$future=$futurex[2].'-'.$futurex[0].'-'.$futurex[1];
		$sucursalText=$_POST['sucursalText'];
		$fecha_orden = $_POST['fecha_orden'];

		$orden_check = date_parse($fecha_orden);

	
		// echo $idcliente;

		//echo "INSERT INTO ventabb (Empresa, Mov, MovID, Cliente, EnviarA, FechaEmision, Fecharequerida, Almacen, Proyecto, Condicion, FormaEnvio, ListaPreciosEsp, ZonaImpuestos, Referencia, Agente, Observaciones, OrdenCompra) VALUES ('ROCHE','Pedido',".$movid.",'".$idcliente."','".$sucursal."','".$today."','".$future."','".$almacen."','".$proyecto."','".$condiciones."','".$envio."','".$precios."','".$impuestos."',NULL,'".$_SESSION["user"]."','".$observaciones."','".$ordencompra."'); SELECT @@IDENTITY";
		//echo $proyecto;

		//echo $idcliente;


	

		if($idart == ''){
			//echo "spInsertaPedidoBB 'ROCHE','Pedido',".$movid.",'".$idcliente."','".$sucursal."','".$today."','".$future."','".$almacen."','".$proyecto."','".$condiciones."','".$envio."','".$precios."','".$impuestos."','".$_SESSION["user"]."','".$observaciones."','".$ordencompra."'";
			if($fecha_orden){
				
				if($orden_check["error_count"]==0){
					$sql = "spInsertaPedidoBB 'ROCHE','Pedido','".$movid."','".$idcliente."','".$sucursal."','".$today."','".$futu."','".$almacen."','".$proyecto."','".$condiciones."','".$envio."','".$precios."','".$impuestos."','".$_SESSION["user"]."','".$observaciones."','".$ordencompra."','".$fecha_orden."'";
				}else{
					echo "<script>alert('El campo de fecha debe tener una fecha válida.');</script>"; 
				}
			}else{
				$sql = "spInsertaPedidoBB 'ROCHE','Pedido','".$movid."','".$idcliente."','".$sucursal."','".$today."','".$futu."','".$almacen."','".$proyecto."','".$condiciones."','".$envio."','".$precios."','".$impuestos."','".$_SESSION["user"]."','".$observaciones."','".$ordencompra."',NULL";
			 
			}

			$insertion=mssql_query($sql);

			while ($row = mssql_fetch_array($insertion)) {
			  $id_articulo = $row[0];
			  $typeError = $row[1];
			  $messError = $row[2];
			  //echo $id_articulo;
			}
		}



		

		if($typeError == 1){
			echo 'Error: '.utf8_encode($messError).'<br>';

			$query6=mssql_query("spConsultaPedidoBB 'Sucursal','".$idcliente."','".$_SESSION["user"]."'");
			while ($row6 = mssql_fetch_array($query6)) {
				$results6[] = $row6;
			}
			
			
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
					<input type="hidden" name="direccion" value="">
					<input type="hidden" name="estado" value="">

					<div id="p_folio">

						<label>Folio:</label>
						<?php if($id_articulo!=''){?>
							<input type="text" disabled onkeyup='change(this)' name="p_folio" value='<?php echo (isset($movid) ? $movid : ""); ?>'><img id='imgFolio'src='' style='display: none; margin-left: 2px;'>
						<?php }else{ ?>
							<input type="text"  onkeyup='change(this)' name="p_folio" value='<?php echo (isset($movid) ? $movid : ""); ?>'><img id='imgFolio'src='' style='display: none; margin-left: 2px;'>
						<?php  }?>
						<script>
							function change(folio){
								var folio=folio.value;
									father = $('#login'),
									clienteid = father.find('input[name=p_clienteid]'),
									propietario = father.find('input#p_inputCliente'),
									proyecto = father.find('select[name=proyecto]'),
									direccion = father.find('input[name=direccion]'),
									estado = father.find('input[name=estado]'),
									lista_precios = father.find('select[name=precios]'),
									forma_envio = father.find('select[name=envio]'),
									agente_id = father.find('input[name=agente_id]'),
									fecha = father.find('#p_fecha').find('label').eq(0).text(),
									condiciones = father.find('select[name=condicion]'),
									sucursal = father.find('select[name=sucursal]'),
									almacen = father.find('select[name=almacen]'),
									// zona_impuestos = father.find('select[name=impuestos]'),
									orden_compra = father.find('input[name=ordencompra]'),
									observaciones = father.find('input[name=observaciones]');



								$.post('pedidos2.php', {foliovalue: folio}, function(data){
											if(data == 1){
										 		$("#imgFolio").attr('src','../assets/img/ok.png').show();
										 		almacen.prop('disabled', false);
										 		propietario.prop('disabled', false);
										 		proyecto.prop('disabled', false);
										 		sucursal.prop('disabled', false);
										 		condiciones.prop('disabled', false);
										 		// zona_impuestos.prop('disabled', false);
										 		forma_envio.prop('disabled', false);
										 		lista_precios.prop('disabled', false);


										 	}else{
										 		$("#imgFolio").attr('src','../assets/img/no.png').show();
										 		almacen.prop('disabled', true);
										 		propietario.prop('disabled', true);
										 		proyecto.prop('disabled', true);
										 		sucursal.prop('disabled', true);
										 		condiciones.prop('disabled', true);
										 		// zona_impuestos.prop('disabled', true);
										 		forma_envio.prop('disabled', true);
										 		lista_precios.prop('disabled', true);
										 	}
									 	});
							}
						</script>
					</div>
					<div id="p_cliente">

						<label>Cliente:<br></label>

						<input id="p_inputCliente" type="text" disabled='true' name="p_cliente"  value='<?php echo (isset($p_cliente) ? $p_cliente : ""); ?>'>
						<script type="text/javascript">
						    $(document).ready(function(){
						        var arrayValoresAutocompletar = <?php echo json_encode($nombre);?>;

							    $("#p_inputCliente").autocomplete({
							            source: arrayValoresAutocompletar,
							            close: function(select, ui){
							            var inputvalue= this.value;
									 	    //console.log(inputvalue);
									 	$.post('pedidos2.php', {clientevalue: inputvalue}, function(data){
									 		console.log(data);
									 		var condiciones = data.Condiciones,
									 			impuestos = data.ZonaImpuestos,
									 			envio = data.FormaEnvio,
									 			precios = data.Precios,
									 			cliente = data.Nombres,
									 			sucursal= data.Sucursal,
									 			sucursalVal=data.SucursalVal,
									 			id=data.Nombres.Cliente,
									 			direccion = data.Direccion,
									 			estado = data.Estado;

									 			


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
													$('select[name=sucursal]').append($('<option>', { text: sucursal[j], 'value': sucursalVal[j] }) );
												}
												$('input[name=p_clienteid]').attr('value', id);

												$('input[name=direccion]').val(direccion);
												$('input[name=estado]').val(estado);



									 		//console.log(id);
									 		//console.log(data);
									 	}, 'json');

							            }
							    })


						    })


						</script>
					</div>
					<div id='p_contfecha' >

						<div id='p_fechaLabel' style="margin-top:10px;">
							<label>Fecha Emisión:<br><br></label>
							<label>Fecha Requerida:</label>
						</div>
						<div id='p_fecha' style="margin-top:10px;">
							<label><?php echo $hoy; ?><br><br></label>
							<?php
							if($futu=='') {
							?>
								<label><input  type="text" name="futuros" class="futuro" value='<?php echo $futuro?>'></label>
							<?php
							}else{
							?>
								<label><input  type="text" name="futuros" class="futuro" value='<?php echo $futu?>'></label>
							<?php
							}
							?>
						</div>
					</div>
					<div id='p_contCaracteristicas'>
						<div id='cont1'>

							<div class='p_dropLabel'><label>Almacén:<br></label></div>
							<div class='p_dropLabel'><label>Proyecto:<br></label></div>
							<div class='p_dropLabel'><label>Sucursal Cliente:<br></label></div>
							<div class='p_dropLabel'><label>Condiciones:<br></label></div>
							<!-- <div class='p_dropLabel'><label>Zona de Impuestos:<br></label></div> -->
							<div class='p_dropLabel'><label>Forma de Envío:<br></label></div>
							<div class='p_dropLabel'><label>Lista de Precios:<br></label></div>
							<div class='p_dropLabel'><label>Orden de Compra:<br></label></div>
							<div class='p_dropLabel'><label>Fecha de Orden:<br></label></div>
							<div class='p_dropLabel'><label>Observaciones:<br></label></div>
						</div>
						<div id='cont2'>

							<div class='p_contSelect'><select disabled='true' name='almacen'>
								<option>::</option>
								<?php
								if($almacen!=''){
									echo '<option selected>'.$almacen.'</option>';
								}
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
							<div class='p_contSelect'><select disabled='true' name='proyecto'>
								<option>::</option>
								<?php
								if($idart!=''){
									echo '<option selected>'.$proyecto.'</option>';
								}
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
							<?php 
								if($typeError == 1){
									//echo 'Error: '.utf8_encode($messError).'<br>';
									?>
									<div class='p_contSelect'><select name='sucursal'>
									<?php

										foreach ($results6 as $key => $value) {
											echo "<option value='".$value['computed']."'>".$value['computed1']."</option>";
										}	
									?>
									</select><br>
									<?php
								}else{
							?>
								<div class='p_contSelect'><select disabled='true' name='sucursal'>
									<?php 
										echo (isset($sucursalText)) ? "<option value='" . $sucursal . "'>" . $sucursalText . "</option>" : ""; 
									?>
								</select><br>
							<?php
								}
							?>

								<input name='sucursalText' type='hidden' value=''></div>
							<div class='p_contSelect'><select disabled='true' name='condicion'>
								<?php echo (isset($condiciones)) ? "<option value='" . $condiciones . "'>" . $condiciones . "</option>" : ""; ?>
							</select><br></div>
							<!-- <div class='p_contSelect'><select disabled='true' name='impuestos'> -->
								<?php // echo (isset($impuestos)) ? "<option value='" . $impuestos . "'>" . $impuestos . "</option>" : ""; ?>
							<!-- </select><br></div> -->
							<div class='p_contSelect'><select disabled='true' name='envio'>
								<?php echo (isset($envio)) ? "<option value='" . $envio . "'>" . $envio . "</option>" : ""; ?>
							</select><br></div>
							<div class='p_contSelect'><select disabled='true' name='precios'>
								<?php echo (isset($precios)) ? "<option value='" . $precios . "'>" . $precios . "</option>" : ""; ?>
							</select><br></div>
							<div class='p_contSelect'><input type="text" name="ordencompra" value="<?php echo (isset($ordencompra)) ? $ordencompra : ''; ?>"><br></div>
							<div class='p_contSelect'><input  type="text" name="fecha_orden"  value='<?php echo $fecha_orden?>'><br></div>
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
							<div class='pd_cases1'>
								<input type='text' class='pdinput' onkeyup='' name="articulo">
								<label>F. Req:</label>
							</div>
							<div class='pd_cases1'>
								<input type='text' class='pdinput' onkeyup='' name="cantidad">
								<input  type="text" name="futuro" class="futuro" value='<?php echo $futu?>'>
							</div>
							<div class='pd_cases2'><input type='text' name='Inventario' disabled></div>
							<div class='pd_cases2'><input type='text' name='Desc.' disabled></div>
							<div class='pd_cases2'><input type='text' name='IVA' disabled></div>
							<div class='pd_cases3'><input type='text' name='SUBTOTAL' disabled></div>
							<input type='hidden' name='IMPORTEDESC'>
							<input type='hidden' name='TOTALES'>
							<input type='hidden' name='descripcion'>
							<input type='hidden' name='p_tonelada'>
							<input type='hidden' name='importe'>
							<div class='pd_cases4'><span class="ok submit-n"><img src='../assets/img/oks.png' height="30" width="30" >  </span></span></div>
						</div>
					</div>
					<div id="sumas" <?php if(isset($id_articulo)) echo 'style="display:block;"'; else echo 'style="display:none;"' ?>>
						<div>
							<div>Subtotal: <span id="importe1"></span></div>
							<div>D.P.A.: <span id="dpa"></span></div>
							<div>D. Flete: <span id="flete_siva"></span></div>
							<div>Subtotal: <span id="subtotal2"></span></div>
							<div>IVA: <span id="ivas"></span></div>
							<div>Total: <span id="total"></span></div>
						</div>

						<input type="hidden" name="dpa">
						<input type="hidden" name="flete_siva">
						<input type="hidden" name="iva">
						<input type="hidden" name="importe1">
						<input type="hidden" name="subtotal2">
						<input type="hidden" name="subtotal_flete">

						<div id='reload'>
							
							<INPUT TYPE="submit" name='send' VALUE="Enviar">
						</div>
					</div>


				</div>
			</div>
		</form>
		<input type='hidden' name='id_articulo' value=<?php echo $id_articulo; ?>>
		<script type="text/javascript">


			$(function(){

				var id_articulo = $('input[name=id_articulo]').val(),
					div_pedidodetalle = $('#pedidodetalle'),
					body = $('body');

					

				function getDatepicker(){
					var futuro = $('.futuro'),
						order = $('input[name=fecha_orden]');


					futuro.datepicker({
					minDate: +4,
					dateFormat: "dd-mm-yy"

					});

					order.datepicker({dateFormat: "dd-mm-yy"});
				}

					getDatepicker();

				//$('input[name=cantidad]').mask('00000');

				// body.on('click', 'input[name=send]', function(){
				// 	var $this = $(this);
				// 	alert('Pedido Enviado');

				// });
				

				body.on('click', 'input[name=send]', function(e){
					// var $this = $(this);

					e.preventDefault();

					var father = $('#login'),
						folio = father.find('input[name=p_folio]').val(),
						proyecto = father.find('select[name=proyecto]').val(),
						clienteid = father.find('input[name=p_clienteid]').val(),
						propietario = father.find('input#p_inputCliente').val(),
						direccion = father.find('input[name=direccion]').val(),
						estado = father.find('input[name=estado]').val(),
						lista_precios = father.find('select[name=precios]').val(),
						forma_envio = father.find('select[name=envio]').val(),
						agente_id = father.find('input[name=agente_id]').val(),
						fecha = father.find('#p_fecha').find('label').eq(0).text(),
						futuro = father.find('input[name=futuros]').val(),
						condiciones = father.find('select[name=condicion]').val(),
						sucursal = father.find('select[name=sucursal]').val(),
						almacen = father.find('select[name=almacen]').val(),
						// zona_impuestos = father.find('select[name=impuestos]').val(),
						orden_compra = father.find('input[name=ordencompra]').val(),
						observaciones = father.find('input[name=observaciones]').val(),
						pd_cases = $('.pd_cases'),
						rows_raw = [],
						rows = [],
						suma_subtotal = $('#importe1').text(),
						suma_total = $('#total').text(),
						sumas = $('#sumas'),
						dpa = sumas.find('input[name=dpa]').val(),
						flete_siva = sumas.find('input[name=flete_siva]').val(),
						iva = sumas.find('input[name=iva]').val(),
						importe = sumas.find('input[name=importe1]').val(),
						subtotal2 = sumas.find('input[name=subtotal2]').val(),
						subtotal_flete = sumas.find('input[name=subtotal_flete]').val();


						
						pd_cases.each(function(){
							if(typeof $(this).attr('data-count') === 'undefined'){
								//
							}else{
								rows_raw.push($(this));
							}
						});

						$.each(rows_raw, function(i, el){
							var //$this = $(this),
								cantidad = el.find('input[name=cantidad]').val(),
								clave = el.find('input[name=articulo]').val(),
								descripcion = el.find('input[name=descripcion]').val(),
								inventario = el.find('input[name=Inventario]').val(),
								p_tonelada = el.find('input[name=p_tonelada]').val(),
								subtotal = el.find('input[name=SUBTOTAL]').val(),
								desc = el.find('input[name="Desc."]').val(),
								importe = el.find('input[name=importe]').val(),
								totales = el.find('input[name=TOTALES]').val(),
								fechaRowT=el.find('input[name=futuro]').val();
								fechaRowEx=fechaRowT.split("-");
								fechaRow=fechaRowEx[2]+'-'+fechaRowEx[0]+'-'+fechaRowEx[1],
								row = {
									'cantidad': cantidad,
									'clave': clave,
									'descripcion': descripcion,
									'inventario': inventario,
									'p_tonelada': p_tonelada,
									'subtotal': subtotal,
									'desc': desc,
									'importe': importe,
									'totales': totales,
									'fechaRow': fechaRow
								};

							rows.push(row);
						});
					
					console.log(futuro);

					var data = {
						'template': 1,
						'folio': folio,
						'clienteid': clienteid,
						'propietario': propietario,
						'direccion': direccion,
						'estado': estado,
						'lista_precios': lista_precios,
						'forma_envio': forma_envio,
						'agente_id': agente_id,
						'fecha': futuro,
						'condiciones': condiciones,
						'sucursal': sucursal,
						'almacen': almacen,
						// 'zona_impuestos': zona_impuestos,
						'precio_flete': subtotal_flete,
						'rows': rows,
						'subtotal1': importe,
						'dpa': dpa,
						'flete_siva': flete_siva,
						'iva': iva,
						'subtotal2': subtotal2,
						'total': suma_total,
						'orden_compra': orden_compra,
						'observaciones': observaciones,
						'proyecto': proyecto,
						'idart':<?php if($id_articulo!=''){echo $id_articulo;}else{echo 'a';}; ?>
						
					};

					 $.post('pedidos2.php', data, function(response){
					 	console.log(response);
					 	if(response){
					 		$.post('pedidos2.php', {'enviar_reporte': 1, 'message': response, 'folioPost':folio}, function(r){
					 			console.log(r);
					 			alert('Pedido enviado');
					 			window.location ="../contenedor.php";
					 		});
					 	}
					 });

					 //console.log(data);

				});

				body.on('change', 'select[name=sucursal]', function(){
					var father = $('#login'),
						sucursal=father.find('select[name=sucursal] option:selected').text(),
						sucursalText=father.find('input[name=sucursalText]'),
						cliente=father.find('input[name=p_cliente]'),
						almacen=father.find('select[name=almacen]'),
						proyecto=father.find('select[name=proyecto]'),
						condiciones=father.find('select[name=condicion]'),
						impuestos=father.find('select[name=impuestos]'),
						envio=father.find('select[name=envio]'),
						precios=father.find('select[name=precios]');

						//console.log(father);
						cliente.prop('disabled', false);
						almacen.prop('disabled', false);
						proyecto.prop('disabled', false);
						condiciones.prop('disabled', false);
						impuestos.prop('disabled', false);
						envio.prop('disabled', false);
						precios.prop('disabled', false);
						sucursalText.val(sucursal);
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
					}).append($('<span>',{
						text: 'F.Req:'
					})));

					n.push($('<div>', {
						class: 'pd_cases1',
						html: $('<input>', {
							type: 'text',
							class: 'pdinput',
							name: 'cantidad'
						})//.mask('00000')
					}).append($('<input>',{
						type: 'text',
						class:'futuro',
						name: 'futuro',
						value: '<?php echo $futu; ?>'
					})));

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
					n.push($('<input>', {
							type: 'hidden',
							name: 'descripcion'
					}));
					n.push($('<input>', {
							type: 'hidden',
							name: 'p_tonelada'
					}));
					n.push($('<input>', {
							type: 'hidden',
							name: 'importe'
					}));

					var options = [];

					options.push($('<span>', {
						class: 'ok submit-n',
						html: $('<img>', {
							src: '../assets/img/oks.png',
							width: '30px',
							height: '30px'
						})
					}));
					
					// options.push($('<span>', {
					// 	class: 'edit submit-n',
					// 	html: $('<img>', {
					// 		src: '../assets/img/edit.png',
					// 		width: '16px',
					// 		height: '16px'
					// 	})
					// }));

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
						spanSubtotal = $('#importe1'),
						spanFlete=$('#flete_siva'),
						spanImpuestos = $('#ivas'),
						spanTotal = $('#total'),
						spanDpa = $('#dpa'),
						spanSubtotal2 = $('#subtotal2'),
						dpa = $('input[name=dpa]'),
						flete_siva = $('input[name=flete_siva]'),
						iva = $('input[name=iva]'),
						importe1 = $('input[name=importe1]'),
						subtotal2 = $('input[name=subtotal2]'),
						sub_flete = $('input[name=subtotal_flete]');

					

					$.post(action, post, function(data){

						//console.log(data);

						var sumas = data[0],
							subtotal_flete = (sumas.SubTotalFleta != null ? sumas.SubTotalFleta : formatNumber(0)),
							importe = (sumas.Importe != null ? sumas.Importe : formatNumber(0)),
							subtotal = (sumas.SubTotal != null ? sumas.SubTotal : formatNumber(0)),
							DescxFlete = (sumas.DescxFlete != null ? sumas.DescxFlete : 0.00),
							DescxPA = (sumas.DescxPA != null ? sumas.DescxPA : formatNumber(0)),
							impuestos = (sumas.Impuestos != null ? floatNumber(sumas.Impuestos) : 0.00),
							total = sumas.Total;
							console.log(sumas.Total);
							if(sumas.Total==null){
								total = formatNumber(0);
							}
						//console.log(sumas);

							

						spanSubtotal.text(importe);
						spanImpuestos.text(formatNumber(impuestos));
						spanTotal.text(total);
						spanDpa.text(DescxPA);
						spanSubtotal2.text(subtotal);
						spanFlete.text(DescxFlete);
						dpa.val(DescxPA);
						flete_siva.val(DescxFlete);
						iva.val(formatNumber(impuestos));
						importe1.val(importe);
						subtotal2.val(subtotal);
						sub_flete.val(DescxFlete);

					}, 'json');

				}


				if(id_articulo != ''){

					$('input[name=articulo]').focus();

					body.on('click', '.submit-n', function(){

						//Acciones

						var $this = $(this),
							n = $('.n'),
						 	p = $this.closest('.n'),
						 	inputArticulo = p.find('input[name=articulo]');
						 	inputCantidad = p.find('input[name=cantidad]');
							articulo = inputArticulo.val(),
							cantidad = inputCantidad.val(),
							fecha = p.find('input[name=futuro]').val(),
							inventario = p.find('input[name=Inventario]'),
							divContainer = $this.closest('div'),
							noButton=$('<span>', {
										class: 'no submit-n',
										html: $('<img>', {
										src: '../assets/img/nos.png',
										height: '30',
										})
									}),
							desc = p.find('input[name="Desc."]'),
							iva = p.find('input[name=IVA]'),
							subtotal = p.find('input[name=SUBTOTAL]'),
							importedesc = p.find('input[name=IMPORTEDESC]'),
							totales = p.find('input[name=TOTALES]'),
							descripcion = p.find('input[name=descripcion]'),
							p_tonelada = p.find('input[name=p_tonelada]'),
							importe = p.find('input[name=importe]'),

						

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
									'idcliente': '<?php echo $idcliente; ?>',
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
										dataImporteDesc = dataImporteDesc,
										dataDescripcion = data[0].Descripcion,
										dataP_tonelada = data[0]['P/TONELADA'],
										dataImporte = data[0].Importe;

										

									inventario.val(dataInventario);
									desc.val(dataDesc);
									iva.val(dataIva);
									subtotal.val(dataImporte);
									importedesc.val(dataImporteDesc),
									totales.val(dataTotales);
									descripcion.val(dataDescripcion);
									p_tonelada.val(dataP_tonelada);
									importe.val(dataImporte);
									//console.log('save path');
									

									inputArticulo.attr('disabled', true);
									inputCantidad.attr('disabled', true);

									sumas();

									if($this.hasClass('ok')){
										$this.remove();
										divContainer.append(noButton);
										nuevo = getN();
										div_pedidodetalle.append(nuevo);

										getDatepicker();
									}

								}else if(data.result == 'delete'){
									
									//console.log(data);
									
									p.remove();
									sumas();
								}else if(data.result == 'none'){
									alert('No existe ese artículo');
								}

								if(data.result=='error'){

									alert(data.errMessage);
								}

								console.log(data)

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


