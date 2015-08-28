<!DOCTYPE html>
<?php 
	session_start();

	if (!$_SESSION["log"]){
		header("Location:../index.php");
	}
	$post=$_POST['DBselect'];
	if($post=='Roche'){
		$DB = 'pruebasCOSYSA';
	}else{
		$DB = 'pruebasGastos';
	}

		
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

	 		$user=trim($_SESSION["user"]);
	 		$query=mssql_query("spSalDatosAgentes '$user'");

			while ($row = mssql_fetch_array($query)) {
				$results = $row;
			}

			$acreedor=$results['Acreedor'];

			$query2=mssql_query("spSalConceptoGas");

	 		while ($row2 = mssql_fetch_array($query2)) {
			 $results2[] = $row2;
		
			}

			

			$qry=mssql_query("select ID from salgasto where Estatus = 'SINCONFIRMAR' AND Agente='".$user."'");
			
			$result= mssql_fetch_array($qry);

			
			if(mssql_num_rows($qry)==0){
				$qry1=mssql_query("INSERT INTO salgasto (Agente, Estatus, Observaciones, Acreedor) VALUES ('".$user."','SINCONFIRMAR', 'Observaciones', '$acreedor'); SELECT @@IDENTITY");
				$movId= mssql_fetch_array($qry1);
				
			}else{
				$movId=$result;
				
			}

			$qry2=mssql_query("SELECT Observaciones FROM salgasto WHERE ID=".$movId[0]);
			$observaciones= mssql_fetch_array($qry2);

			//echo "<pre>", print_r($observaciones), "</pre>";


			function constructor($id, $results2){

				$qry=mssql_query("SELECT * FROM salgastod WHERE ID =".$id." ORDER BY Renglon");

				while ($row = mssql_fetch_array($qry)) {
					$result[]=$row;
				}

				

				foreach($result as $key => $value){
					
						$lines[$value['Renglon']] = array(
						            'Concepto' => $result[$key]['Concepto'],
						            'Referencia' => $result[$key]['Referencia'],
						            'Subtotal' => $result[$key]['Subtotal'],
						            'IVA' => $result[$key]['IVA'],
						            'Total' => $result[$key]['Total'],
						            'Impuesto' => $result[$key]['Impuesto'],
						            'Retencion' => $result[$key]['Retencion'],
						            'RutaXML' => $result[$key]['RutaXML'],
						            'RutaPDF' => $result[$key]['RutaPDF'],
						            'Renglon' => $result[$key]['Renglon']

						 );
				
				}
				
				
				foreach($lines as $line => $lined){
					$numFila=$lined['Renglon'];
					$numFila=$numFila/1024;
					echo '<tr>';
						echo '<td>';
							echo '<select name="concepto" class="gselect" disabled>';
								echo '<option value=""></option>';
								
								foreach ($results2 as $key=>$concepto){
									if($lined['Concepto']==$concepto[0]){
										echo '<option selected value="'.$concepto[1].utf8_encode($concepto[0]).'">'.utf8_encode($concepto[0]).'</option>';
									}else{
										echo '<option value="'.$concepto[1].utf8_encode($concepto[0]).'">'.utf8_encode($concepto[0]).'</option>';
									}
									

								}

								
								
						echo '</select>';
						echo '</td>';
						echo '<td>';
							echo '<input name="referencia" type="text" class="ginput" value="'.$lined['Referencia'].'" disabled>';
						echo '</td>';
						echo '<td>';
							echo '<input name="subtotal" type="text" class="ginput suma" value="'.$lined['Subtotal'].'"disabled>';
						echo '</td>';
						echo '<td>';
							echo '<input name="iva" type="text" class="ginput suma" value="'.$lined['IVA'].'"disabled>';
						echo '</td>';
						echo '<td>';
							echo '<input name="total" type="text" class="ginput" value="'.$lined['Total'].'"disabled>';
						echo '</td>';
						echo '<td>';
							echo '<button name="xml" class="file" disabled>';
							echo 'XML';
								echo '<input type="file" name="xml" disabled>';
							echo '</button>';
						echo '</td>';
						echo '<td>';
							
							echo '<button  name="pdf" class="file" disabled>';
								echo 'PDF';
								echo '<input type="file" name="pdf" disabled>';
							echo '</button>';
						echo '</td>';
						echo '<td>';
							echo '<button class="nuevaFila" class="file" disabled>';
							echo '+';
							echo '</button>';
							echo '<input name="tasa" type=hidden value="'.$lined['Impuesto'].'">';
							echo '<input name="retencion" type=hidden value="'.$lined['Retencion'].'">';
							echo '<input name="rutaxml" type=hidden value="'.$lined['RutaXML'].'">';
							echo '<input name="rutapdf" type=hidden value="'.$lined['RutaPDF'].'">';
							echo '<input name="uuid" type=hidden value="'.$lined['UUID'].'">';
							echo '<input name="fila" type=hidden value='.$numFila.'>';
						echo '</td>';
						echo '<td>';
							echo '<button class="eliminarFila" class="file">';
								echo '-';
							echo '</button>';
						echo '</td>';
					echo '</tr>';

					
				}
				return $numFila;
			}

			

			
 ?>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="HandheldFriendly" content="True">
	<meta name="viewport" content="width=device-width, height=device-height" >
	<title>Document</title>

	<link rel="stylesheet" href="../assets/css/style.css">


</head>
<body>
	
	<div id="menu2">
		<div class="boton2"><a href="../contenedor.php">
			<img id="logoroche" src="../assets/img/comercialrochelogo.png"></a>
		</div>
		<div class="boton2">
			<img alt="" src="../assets/img/embarques.png">
		</div>
		<div class="boton2">
			<a href="ventas.php">
				<img alt="" src="../assets/img/ventas.png">
			</a>
		</div>
		<div class="boton2">
			<a href="cuentas.php">
				<img alt="" src="../assets/img/cobrar.png">
			</a>
		</div>
		<div class="boton2">
			<a href="inventario.php">
				<img alt="" src="../assets/img/inventarios.png">
			</a>
		</div>
		<div class="boton2">
			<a href="pedidos.php">
				<img alt="" src="../assets/img/pedidos.png">
			</a>
		</div>
	</div><!-- End menu2 -->
	
	<div class="wrapper">
		<div id="login">
			<div id="gastos1">
				<?php if($post==''){?>
					<div>
						<form action='' method='POST'>
							<div>
								<label for="DBselect">Empresa:</label>
								<select name="DBselect">
									<option value=''></option> 
									<option value='Roche'>Roche</option>
									<option value='Otra'>Otra</option>
								</select>
								<input type='submit' id='continuar' value='Continuar'>
							</div>
						</form>
					</div>
				</div>
			</div><!-- End login -->
		</div><!-- End wrapper -->
		<?php }else{ 
					if(is_null($acreedor)){
						echo "acreedor es nulo";
						?>
							<script type="text/javascript">
								alert("El agente no tiene un acreedor asignado en esta empresa.");
								window.location.href = "../contenedor.php";
							</script>

						<?php
						}//fin $acreedor
					?>
				<div>
					<label for="fechaEmision">Fecha Emisión:</label>
					<input name="fechaEmision" type="text" value="<?=date('d-m-Y')?>" disabled>
				</div>
				<div>
					<label for="acreedor">Acreedor:</label>
					<input name="acreedor" type="text" value='<?=$acreedor;?>' disabled>
				</div>
				<div>
					<label for="observaciones">Observaciones:</label>
					<input id='observaciones' name="observaciones" type="text" value='<?php echo ''.$observaciones['Observaciones'].'';?>'>
				</div>
			</div>
			
			<table id="gastos2">
				<thead>
					<tr>
						<th>Concepto</th>
						<th>Referencia</th>
						<th>Subtotal</th>
						<th>IVA</th>
						<th>Total</th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<?php
						if(mysql_num_rows($qry)==0){
							$numFila= constructor($movId[0], $results2);
							
						}else{
							$numFila=0;
						}
					?>
					<tr>
						<td>
							<select name="concepto" class="gselect">
								<option value=''></option>
								<?php
								foreach ($results2 as $key=>$concepto){
									echo '<option value="'.$concepto[1].utf8_encode($concepto[0]).'">'.utf8_encode($concepto[0]).'</option>';

								}

								?>
								
							</select>
						</td>
						<td>
							<input name="referencia" type="text" class="ginput" value='' disabled>
						</td>
						<td>
							<input name="subtotal" type="text" class="ginput suma" value='' disabled>
						</td>
						<td>
							<input name="iva" type="text" class="ginput suma" value='' disabled>
						</td>
						<td>
							<input name="total" type="text" class="ginput" value='' disabled>
						</td>
						<td>
							<button name='xml' class="file" disabled>
								XML
								<input type="file" name="xml" disabled>
							</button>
						</td>
						<td>
							
							<button  name='pdf' class='file' disabled>
								PDF
								<input type="file" name="pdf" disabled>
							</button>
						</td>
						<td>
							<button class="nuevaFila" class='file' disabled>
								+
							</button>
							<input name='tasa' type=hidden value='0'>
							<input name='retencion' type=hidden value='0'>
							<input name='rutaxml' type=hidden value=>
							<input name='rutapdf' type=hidden value=>
							<input name='uuid' type=hidden value=>
							<input name='fila' type=hidden value=<?php echo $numFila+1;?>>
						</td>
						<td>
							<button class="eliminarFila" class='file'>
								-
							</button>
						</td>
					</tr>
					<tr id='totalizers'>
						<td></td>
						<td><div >Totales:</div></td>
						<td><input name="sumaSubtotal" type="text" class="ginput" value='0'></td>
						<td><input name="sumaIva" type="text" class="ginput" value='0'></td>
						<td><input name="sumaTotal" type="text" class="ginput" value='0'></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
				</tbody>
			</table>

			<div>
				<button id="guardar" class='file'>
					Enviar
				</button>
			</div>

		</div><!-- End login -->
	</div><!-- End wrapper -->
	<?php } ?>
	


	<script type="text/javascript" src="../assets/js/jquery.js"></script>

	<script type="text/javascript">

	$(function () {



		var body = $('body'),
			gastos2_tbody = $('#gastos2').find('tbody');

		Number.prototype.formatMoney = function(decPlaces, thouSeparator, decSeparator) {
   			 var n = this,
			    decPlaces = isNaN(decPlaces = Math.abs(decPlaces)) ? 2 : decPlaces,
			    decSeparator = decSeparator == undefined ? "." : decSeparator,
			    thouSeparator = thouSeparator == undefined ? "," : thouSeparator,
			    sign = n < 0 ? "-" : "",
			    i = parseInt(n = Math.abs(+n || 0).toFixed(decPlaces)) + "",
			    j = (j = i.length) > 3 ? j % 3 : 0;
			    return sign + (j ? i.substr(0, j) + thouSeparator : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + thouSeparator) + (decPlaces ? decSeparator + Math.abs(n - i).toFixed(decPlaces).slice(2) : "");
			};



		function addRow(line){
			var totals=$('#totalizers'),
				row = getRow(line);

			totals.detach();
			gastos2_tbody.append(row);
			totals.insertAfter(row);

		}

		function getRow(line){

			var tr = [],
				td = [],
				linea=line.find('input[name=fila]').val(),
				inputNames = [
					['referencia', ''],
					['subtotal', 'suma'],
					['iva', 'suma'],
					['total', '']
				],
				select = $('tbody').find('tr').eq(0).find('.gselect').clone();
				select.find('option[selected]').removeAttr('selected');
				//select.find('option').eq(0).attr('selected');
				select.removeAttr('disabled');




			td.push($('<td>', {
				html: select
				})
			);

			

			$.each(inputNames, function(index, val){

				td.push($('<td>', {
					html: getGinput(val)
				}));

			});

			td.push($('<td>', {
				html: $('<button>',{
					text: 'XML',
					class: 'file',
					name: 'xml',
					'disabled':'disabled'
				}).append($('<input>',{
						type: 'file',
						name: 'xml',
						'disabled':'disabled'
					}))
			}));

			td.push($('<td>', {
				html: $('<button>', {
					text: 'PDF',
					class: 'file',
					name: 'pdf',
					'disabled':'disabled'
				}).append($('<input>',{
						type: 'file',
						name: 'pdf',
						'disabled':'disabled'
					}))
			}));

			td.push($('<td>', {
				html: $('<button>',{
					text: '+',
					class: 'nuevaFila',
					'disabled':'disabled'
					
				})
			}).append($('<input>',{
						type: 'hidden',
						name: 'tasa',
						value: null
						
					})).append($('<input>',{
						type: 'hidden',
						name: 'retencion',
						value: ''
					})).append($('<input>',{
						type: 'hidden',
						name: 'rutaxml',
						value: ''
					})).append($('<input>',{
						type: 'hidden',
						name: 'rutapdf',
						value: ''
					})).append($('<input>',{
						type: 'hidden',
						name: 'fila',
						value: parseFloat(linea)+1
					})).append($('<input>',{
						type: 'hidden',
						name: 'uuid',
						value: parseFloat(linea)+1
					})));

			td.push($('<td>', {
				html: $('<button>',{
					text: '-',
					class: 'eliminarFila'
					
				})
			}));

			tr.push($('<tr>', {
				html: td
			}));



			return tr;

		}

		

		function getGinput(val){

			var input = $('<input>', {
				type: 'text',
				class: 'ginput '+val[1],
				name: val[0],
				'disabled':'disabled'

			});

			return input;

		}

		function getSpParams(row){
			var numFila=row.find('input[name=fila]').val(),
				numFila=parseFloat(numFila)*1024,
				concepto=row.find('select[name=concepto] option:selected').text(),
				referencia=row.find('input[name=referencia]').val(),
				subtotal=row.find('input[name=subtotal]').val(),
				iva=row.find('input[name=iva]').val(),
				inputTotal=row.find('input[name=total]').val();
				inputTasa=row.find('input[name=tasa]').val(),
				inputRetencion=row.find('input[name=retencion]').val(),
				inputRutaXml=row.find('input[name=rutaxml]').val(),
				inputRutaPdf=row.find('input[name=rutapdf]').val(),
				uuid=row.find('input[name=uuid]').val(),
				user = '<?php echo $user;?>';
				movId= <?php echo $movId[0];?>;
				db='<?php echo $DB ?>';
				observaciones=body.find('input[name=observaciones]').val();

			spParams = [
				concepto,
				referencia,
				subtotal,
				iva,
				inputTotal,
				inputTasa,
				inputRetencion,
				inputRutaXml,
				inputRutaPdf,
				numFila,
				user,
				movId,
				db,
				uuid,
				observaciones
			];

			return spParams;
		}


		function getConceptos(arrayConceptos){

			var options = [];

			$.each(arrayConceptos, function(index, val){
				options.push($('<option>', {
					value: val,
					text: val
				}));
			});

			return options;
		}

		function getFlagConceptos(select){
			var str = select.val(),
				val = str.substr(0, 1);

			return val;


		}

		function floatNumber(number){
					if(isNaN(number)){
						number = number.replace(",","");
					}
					var floated = parseFloat(number);
					return floated;
		}


		 function sumas(row, input){
			var subtotal=row.find('input[name=subtotal]'),
				iva=row.find('input[name=iva]'),
				inputTotal=row.find('input[name=total]'),
				suma= row.find('.suma');

		 		function aritmetica(param){
		 			
					var name=param.attr('name'),
						total=0.00,
						inputValue=param.val();

					if(name=='subtotal'){
						var inputOther=iva;
					}else if(name=='iva'){
						var inputOther=subtotal;

					}

					var inputOtherVal =inputOther.val();

					if(inputOtherVal==''){
						inputOther.val(0);
					}
					total= parseFloat(inputValue)+parseFloat(inputOther.val());
					total= total.formatMoney(2,',','.');

					return total;

		 		}

				var 
					total=aritmetica(input);
						inputTotal.val(total);
						//console.log(total);

				
		}//End function sumas

		function totales(row, name){
			var totalizers = $('table').find('tr#totalizers'),
				sumaSubtotal = totalizers.find('input[name=sumaSubtotal]').val(),
				sumaIva=totalizers.find('input[name=sumaIva]').val(),
				sumaTotal=totalizers.find('input[name=sumaTotal]').val(),
				inputSub=row.find('input[name=subtotal]').val(),
				inputIva=row.find('input[name=iva]').val(),
				inputTotal=row.find('input[name=total]').val(),
				Subtotal=0,
				iva=0,
				total=0;

				if(name=='nuevaFila'){

					subtotal=floatNumber(sumaSubtotal)+floatNumber(inputSub);
					totalizers.find('input[name=sumaSubtotal]').val(subtotal.formatMoney(2,',','.'));
					console.log(subtotal);
					iva=floatNumber(sumaIva)+floatNumber(inputIva);
					totalizers.find('input[name=sumaIva]').val(iva.formatMoney(2,',','.'));

					total=floatNumber(sumaTotal)+floatNumber(inputTotal);
					totalizers.find('input[name=sumaTotal]').val(total.formatMoney(2,',','.'));
				}else{

					subtotal=floatNumber(sumaSubtotal)-floatNumber(inputSub);
					if(subtotal<0){
						totalizers.find('input[name=sumaSubtotal]').val(0);
					}else{
						totalizers.find('input[name=sumaSubtotal]').val(subtotal.formatMoney(2,',','.'));
					}
					iva=floatNumber(sumaIva)-floatNumber(inputIva);
					if(iva<0){
						totalizers.find('input[name=sumaIva]').val(0);
					}else{
						totalizers.find('input[name=sumaIva]').val(iva.formatMoney(2,',','.'));
					}
					
					total=floatNumber(sumaTotal)-floatNumber(inputTotal);
					if(total<0){
						totalizers.find('input[name=sumaTotal]').val(0);
					}else{
						totalizers.find('input[name=sumaTotal]').val(total.formatMoney(2,',','.'));
					}
					
				}



		}

		function sumatotales(){
			var tbody = $('tbody'),
				totalizers = $('table').find('tr#totalizers'),
				totalrows=tbody.find('tr');
				sumaSubtotal = totalizers.find('input[name=sumaSubtotal]'),
				sumaIva=totalizers.find('input[name=sumaIva]'),
				sumaTotal=totalizers.find('input[name=sumaTotal]'),
				subtotal=sumaSubtotal.val();
				iva=sumaIva.val();
				total=sumaTotal.val();

				

				$.each(totalrows, function(i, val){
					var	row = $(this),
						
						inputSub=row.find('input[name=subtotal]').val(),
						inputIva=row.find('input[name=iva]').val(),
						inputTotal=row.find('input[name=total]').val();

						
						if(inputSub==null||inputSub==''){
							inputSub=0;
						}


						subtotal=parseFloat(subtotal)+parseFloat(inputSub);

						if(inputIva==''||inputIva==null){
							inputIva=0;
						}
						
						iva=parseFloat(iva)+parseFloat(inputIva);

						if(inputTotal==''||inputTotal==null){
							inputTotal=0;
						}

						total=parseFloat(total)+parseFloat(inputTotal);

						//console.log(inputIva);
				});
				


				sumaSubtotal.val(subtotal.formatMoney(2,',','.'));

				sumaIva.val(iva.formatMoney(2,',','.'));
				sumaTotal.val(total.formatMoney(2,',','.'));

		}
//*******************************************************************************************

		sumatotales();

		body.on('change','#observaciones',function(){
			var observaciones=$(this).val(),
				db= '<?php echo $DB ?>';

			observParams = [db, <?php echo $movId[0] ?>,observaciones];

			$.post('sat.php', {observParams: observParams}, function(response){
				console.log(response);
					
			},'json');

		});


		body.on('keyup','.suma',function(){
			var $this=$(this),
				row=$this.closest('tr'),
				btnNewFile=row.find('button.nuevaFila'),
				select=row.find('.gselect'),
				flag=getFlagConceptos(select);

				if(flag==0){
					sumas(row, $this);
				}

				btnNewFile.removeAttr('disabled');
		});

	

		body.on('change','.gselect', function(){
			var	$this= $(this),
				row=$this.closest('tr'),
				btnfile= row.find('.file'),
				buttonXML= row.find('button[name=xml]'),
				inputIva= row.find('input[name=iva]'),
				inputfile= btnfile.find('input'),
				inputReferencia=row.find('input[name=referencia]'),
				inputSubtotal=row.find('input[name=subtotal]'),
				inputTasa=row.find('input[name=tasa]'),
				inputRetencion=row.find('input[name=retencion]'),
				flag=getFlagConceptos($this);

			if(flag==1){
				buttonXML.removeAttr('disabled');
				inputfile.removeAttr('disabled');
				inputReferencia.attr('disabled', 'true');
				inputSubtotal.attr('disabled', 'true');
			}

			if(flag==0){
				btnfile.attr('disabled', 'true');
				inputIva.attr('disabled', 'true');
				inputfile.attr('disabled', 'true');
				inputTasa.val(0);
				inputRetencion.val(0);
				inputReferencia.removeAttr('disabled');
				inputSubtotal.removeAttr('disabled');

			}
		});

		
		//Eliminar filas
		body.on('click', '.eliminarFila', function(){
			var $this = $(this),
				name=$this.attr('class');
				row = $this.closest('tr');
				prevBtn=row.prev().find('button.nuevaFila'),
				numFila=row.find('input[name=fila]').val(),
				inputRutaXml=row.find('input[name=rutaxml]').val(),
				inputRutaPdf=row.find('input[name=rutapdf]').val(),
				numFila=parseFloat(numFila)*1024,
				db= '<?php echo $DB ?>';

				//console.log(prevBtn);

				delParams = [numFila,
							inputRutaXml,
							inputRutaPdf,
							db,
							<?php echo $movId[0] ?>
							];
				
				
				
				if(confirm('¿Está seguro de eliminar este elemento?')){
					$.post('sat.php', {delParams: delParams}, function(response){
						console.log(response);
						if(response.error=='si'){
							alert(response.message);
							console.log(response.console);
						}else{
							totales(row, name);
							prevBtn.removeAttr('disabled');
							row.remove();
						}
					},'json');
					
				}

		});

		body.on('click', '#guardar', function(){

			confirm=confirm('¿Está seguro de haber terminado?');

			if(confirm){
				var tbody = $('tbody'),
					totalrows=tbody.find('tr');
					counter = 2,
					limit = totalrows.length;
					//console.log('totalrows=>'+limit);

				$.each(totalrows, function(i, val){
					var	row = $(this),
						inputRutaXml=row.find('input[name=rutaxml]').val(),
						inputRutaPdf=row.find('input[name=rutapdf]').val(),
						inputRef=row.find('input[name=referencia]').val(),
						numFila=row.find('input[name=fila]').val(),
						db= '<?php echo $DB ?>';
						numFila=parseFloat(numFila)*1024,
						observaciones=body.find('input[name=observaciones]').val();
						confirmParams=[ db, <?php echo $movId[0] ?>];
						
					saveParams=[<?php echo $movId[0] ?>,
								inputRutaXml,
								inputRutaPdf,
								numFila,
								db,
								observaciones];

								//console.log(saveParams);

					$.post('sat.php', {saveParams: saveParams}, function(response){
						//console.log(response);
						if(response.error=='si'){
							alert(response.message);
							console.log(response.console);
						}else{
							counter++;
							console.log(counter+' '+limit);
							if(counter==limit){

								$.post('sat.php', {confirmParams: confirmParams}, function(response){
									//console.log(response);
									if(response.error=='si'){
										alert(response.message);
										console.log(response.console);
										//window.location.href = "../contenedor.php";
									}else{
										alert('Gastos envíados.');
										window.location.href = "../contenedor.php";
										
									}
										
								},'json');

							}
						}
						//console.log(response);
					},'json');



				});

			//

			//console.log('okay, cool');
			}
			//$this.unbind('change');
			
			//location.reload();
			
				


		});

		

		body.on('change', '.file input[type=file]', function(){


			//Aquí lo que hacemos es poner en variables todo lo que necesitamos
			//para poder enviar datos por ajax

			var $this = $(this), //Input de tipo file
				row = $this.closest('tr'),
				inputUUID=row.find('input[name=uuid]'),
				inputRef=row.find('input[name=referencia]'),
				inputSub=row.find('input[name=subtotal]'),
				inputIva=row.find('input[name=iva]'),
				inputTotal=row.find('input[name=total]'),
				inputTasa=row.find('input[name=tasa]'),
				inputRutaXml=row.find('input[name=rutaxml]'),
				inputRutaPdf=row.find('input[name=rutapdf]'),
				rutaXML=row.find('input[name=rutaxml]').val(),
				inputRetencion=row.find('input[name=retencion]'),
				buttonPDF=row.find('button[name=pdf]'),
				buttonNewFile=row.find('button.nuevaFila'),
				fileXML = $this.get(0).files[0], //Archivo
				formData = new FormData(), //Objeto FormData
				db= '<?php echo $DB ?>',
				bitacoraParams=[<?php echo $movId[0] ?>, '<?php echo $user;?>'],
				name4='bitacora',
				name = $this.attr('name'), //Valor del atributo name del input
				name2= 'ruta',
				name3= 'DB';

				if(name == 'xml'){
					formData.append(name, fileXML); //Metemos el archivo al objeto de FormData con el name del input.
					formData.append(name3, db);
					formData.append(name4, bitacoraParams); 
				}else{
					//formData.append(name, rutaPdf, fileXML);
					formData.append(name, fileXML);
					formData.append(name2, rutaXML);
					formData.append(name3, db);
					formData.append(name4, bitacoraParams); 
				}
				

				

			
			$.ajax({ //Tenemos un ajax I can see that
			    url: "sat.php", //Tenemos una url de nuestro php en el servidor
			    data: formData, //Tenemos un data que se va a enviar al servidor con el FormData
			    dataType: 'json',//Tenemos que queremos que los datos los reciba en formato JSON
			    processData: false,//Tenemos que no queremos que jQuery procese nuestro data
			    contentType: false,//Tenemos que no queremos que jQuery le asigne un tipo de contenido
			    type: 'POST',//Tenemos que queremos enviar los datos por POST
			    success: function(response){//Tenemos que si se envían y reciben los datos con éxito, se ejecute la función

			    	console.log(response);

			       	if(response){

			       		if(response.error == 'si'){
		       				alert(response.errorMsg);
		       			}else if(response.error == 'badtype'){
		       				alert(response.errorMsg);
		       			}else{
		       				if(response.estado == 'No Encontrado'){
		       					alert('XML no encontrado en el servicio del SAT');
		       				}else{
		       					alert('Archivo válido');
		       					var flag =getFlagConceptos($this),
		       						gastos=$('#gastos2');

		       					if(flag=1&&response.pdf!='si'){
		       						var subt= parseFloat(response.subtotal),
		       							imp = parseFloat(response.impuestos),
		       							tot = parseFloat(response.total);
		       						//console.log(response.referencia);

		       						//.formatMoney(2,',','.')
		       						inputUUID.val(response.uuid);
		       						inputRef.val(response.referencia);
		       						inputSub.val(subt.formatMoney(2,',','.'));
		       						inputIva.val(imp.formatMoney(2,',','.'));	
		       						inputTotal.val(tot.formatMoney(2,',','.'));
		       						inputTasa.val(response.tasa);
		       						inputRutaXml.val(response.ruta);
		       						inputRutaPdf.val(response.path);
		       						if(response.retenciones!=''){
		       							inputRetencion.val(response.retenciones);
		       						}else{
		       							inputRetencion.val(0.0);
		       						}
		       						buttonPDF.removeAttr('disabled');
		       					}

		       					if(response.pdf=='si'){
		       						inputRutaPdf.val(response.ruta);
		       						buttonNewFile.removeAttr('disabled');
		       					}
		       					
		       					//console.log(referencia);
		       					//console.log(flag);
		       					
		       				}
		       			}
		       		}

			   	}//Aquí termina suscess

			});//Aquí termina el ajax 
			
			$this.unbind('change');
			

		});// End change .xml input[type=file]	

		body.on('click', '.nuevaFila', function(){
			var $this=$(this),
				row = $this.closest('tr'),
				prevBtn=row.prev().find('button.nuevaFila'),
				select=row.find('select');
				inputRef=row.find('input[name=referencia]'),
				inputSub=row.find('input[name=subtotal]'),
				inputIva=row.find('input[name=iva]'),
				inputTotal=row.find('input[name=total]'),
				buttonPDF=row.find('button[name=pdf]'),
				inputFilePdf=buttonPDF.find('input'),
				buttonXML=row.find('button[name=xml]'),
				inputFileXml=buttonXML.find('input'),
				name=$this.attr('class');
				

				$this.attr('disabled', 'true');
				select.attr('disabled', 'true');
				inputRef.attr('disabled', 'true');
				inputSub.attr('disabled', 'true');
				inputIva.attr('disabled', 'true');
				inputTotal.attr('disabled', 'true');
				buttonPDF.attr('disabled', 'true');
				buttonXML.attr('disabled', 'true');
				inputFileXml.attr('disabled', 'true');
				inputFilePdf.attr('disabled', 'true');

			spParams=getSpParams(row);
			

			$.post('sat.php', {params: spParams}, function(response){
						console.log(response);
						if(response.error=='si'){
							alert(response.message);
							console.log(response.sql);
							prevBtn.removeAttr('disabled');
							row.remove();
						}else{
							totales(row, name);	
						}
					},'json');

			addRow(row);
		});

	});

	</script>
	

</body>
</html>