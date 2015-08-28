<?php
		session_start();
		if (!$_SESSION["log"]){
			header("Location:../index.php");

		}


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

	 	//$con8= mysql_query("SET NAMES 'UTF8'");

	 	if(isset($_POST['clientevalue'])){

	 		$nombrecliente = $_POST['clientevalue'];
	 		
	 		/*$query=mssql_query("spConsultaPedidoBB 'ClienteClave','".$nombrecliente."','".$_SESSION["user"]."',1");
	 		$row = mssql_fetch_array($query)*/

	 		$query=mssql_query('spConsultaPedidoBB "ClienteClave","'.utf8_decode($nombrecliente).'","'.$_SESSION["user"].'",1');
	 	 	while ($row = mssql_fetch_array($query)) {
			  	$results[] = $row;
			 }
			 

			foreach($results as $key => $value){

				$descripciones[$results[$key]['Cliente']] = array(
					'Nombre' => utf8_encode($results[$key]['Nombre']),
					'Cliente'=> utf8_encode(trim($results[$key]['Cliente'])),
					'Condicion' => utf8_encode($results[$key]['Condicion']),
					'ListaPreciosEsp' => utf8_encode($results[$key]['ListaPreciosEsp']),
					'FormaEnvio' => utf8_encode($results[$key]['FormaEnvio']),
					'ZonaImpuesto' => utf8_encode($results[$key]['ZonaImpuesto']),
					'Proyecto' => utf8_encode($results[$key]['Proyecto']),
					'Direccion' => utf8_encode($results[$key]['Direccion']),
					'Estado' => utf8_encode($results[$key]['Estado'])
				);

			}

			foreach($descripciones as $descripcion 	=> $datoDescripcion){

				if($datoDescripcion['Nombre']==$nombrecliente){
					$nombres=$descripciones[$results[$key]['Cliente']];

					$query2=mssql_query("spConsultaPedidoBB 'Condicion','".$nombres['Cliente']."','".$user."'");
					while ($row2 = mssql_fetch_array($query2)) {
					 	$results2[] = $row2;
					}
					$i=0;
					foreach($results2 as $key => $value){
						$condiciones[$i] =utf8_encode($results2[$key]['Condicion']);
							$i++;
					}

					$query3=mssql_query("spConsultaPedidoBB 'ZonaImpuestos','".$descripcion."','".$user."'");
					while ($row3 = mssql_fetch_array($query3)) {
					 	$results3[] = $row3;
					}
					$i=0;
					foreach($results3 as $key => $value){
						$impuestos[$i] =utf8_encode($results3[$key]['ZonaImpuesto']);
							$i++;
					}

					$query4=mssql_query("spConsultaPedidoBB 'FormaEnvio','".$descripcion."','".$user."'");
					while ($row4 = mssql_fetch_array($query4)) {
					 	$results4[] = $row4;
					}
					$i=0;
					foreach($results4 as $key => $value){
						$formaEnvio[$i] =utf8_encode($results4[$key]['FormaEnvio']);
							$i++;
					}

					$query5=mssql_query("spConsultaPedidoBB 'ListaPrecios','".$descripcion."','".$user."'");
					while ($row5 = mssql_fetch_array($query5)) {
					 	$results5[] = $row5;
					}
					$i=0;
					foreach($results5 as $key => $value){
						$precios[$i] =utf8_encode($results5[$key]['ListaPreciosEsp']);
							$i++;
					}

					$query6=mssql_query("spConsultaPedidoBB 'Sucursal','".$descripcion."','".$user."'");
					while ($row6 = mssql_fetch_array($query6)) {
					 	$results6[] = $row6;
					}
					$i=0;
					foreach($results6 as $key => $value){
						$sucursal[$i] =utf8_encode($results6[$key][1]);
						$sucursalVal[$i] =utf8_encode($results6[$key][0]);
							$i++;

					}

					$jsonarray['Clientes']=$nombres;
					$jsonarray['Nombres']=$datoDescripcion;
					$jsonarray['Condiciones']=$condiciones;
					$jsonarray['ZonaImpuestos']=$impuestos;
					$jsonarray['FormaEnvio']=$formaEnvio;
					$jsonarray['Precios']=$precios;
					$jsonarray['Sucursal']=$sucursal;
					$jsonarray['SucursalVal']=$sucursalVal;
					$jsonarray['Direccion']=$datoDescripcion['Direccion'];
					$jsonarray['Estado']=$datoDescripcion['Estado'];
					echo json_encode($jsonarray);


				}
			}

			//echo json_encode($results);

	 	}

	 	if(isset($_POST['foliovalue'])){
	 		$folio = $_POST['foliovalue'];
	 		$query2=mssql_query("spValidaFolio '".$folio."'");
	 		while ($row = mssql_fetch_array($query2)) {
			 	$results2[] = $row;
			}

			foreach($results2 as $key2 => $value2){

				$foliosv[$results2[$key2]['Ok']] = array(
					'Valido' => utf8_encode($results2[$key2]['Ok'])
				);

			}

			foreach($foliosv as $foliov => $datofoliov){

				$foliovalido=$foliosv[1]['Valido'];
				echo $foliovalido;

			}

	 	}







	 	if(isset($_POST['sucursalc'])){
	 		$sucursalc=$_POST['sucursalc'];
	 		$nombrecliente = $_POST['nombreCliente'];
	 		$query=mssql_query("spConsultaPedidoBB 'Cliente','".$_SESSION["user"]."',NULL,1");
	 		while ($row = mssql_fetch_array($query)) {
			 	$results[] = $row;
			}
			//echo $nombrecliente;


			foreach($results as $key => $value){
				$descripciones[$results[$key]['Cliente']] = array(
					'Nombre' => utf8_encode($results[$key]['Nombre'])
				);
			}
			$i=0;
			foreach($descripciones as $descripcion 	=> $datoDescripcion){

				if($datoDescripcion['Nombre']==$nombrecliente){

					$query2=mssql_query("spConsultaPedidoBB 'Sucursal','".$descripcion."',NULL");
					while ($row2 = mssql_fetch_array($query2)) {
					 	$results2[] = $row2;
					}

					foreach($results2 as $key => $value){
						$condiciones[$i] =utf8_encode($results2[$key][1]);
							$i++;
					}
					echo json_encode($condiciones);

				}
			}

	 	}

	 	if(isset($_POST['pedidodetalle'])){

	 		if(isset($_POST['articulo'])){

	 			$articulo = $_POST['articulo'];
	 			$cantidad = $_POST['cantidad'];
	 			$id_articulo = $_POST['id_articulo'];
	 			$count = $_POST['count'];
	 			$action = $_POST['action'];
	 			$fecha = $_POST['fecha'];
	 			$idcliente = $_POST['idcliente'];

	 			$qry = "SELECT SalDestino FROM Cte WHERE Cliente = '".$idcliente."'";
	 			$sal_destino = mssql_fetch_assoc(mssql_query($qry));
	 			$sal_destino = $sal_destino['SalDestino'];

	 			$qry = "SELECT Impuesto1 FROM Art WHERE Articulo = '".$articulo."'";
	 			$impuesto1 = mssql_fetch_assoc(mssql_query($qry));
	 			$impuesto1 = $impuesto1['Impuesto1'];
	 			
	 			$row_pedidodetalle['impuesto'] = $impuesto1;
	 			$row_pedidodetalle['destino'] = $sal_destino;

	 			// $impuesto1 = 16;
	 			// $sal_destino = 'Alimenticio';

	 			$row_pedidodetalle['impuesto'] = $impuesto1;
	 			$row_pedidodetalle['destino'] = $sal_destino;

	 			$qry = "SELECT Articulo FROM SalArtSinAditivos WHERE Articulo ='".$articulo."'";
	 			$validar_articulo = mssql_fetch_assoc(mssql_query($qry));
	 			$validar_articulo = $validar_articulo['Articulo'];

	 			if(!$validar_articulo){
	 				if ($sal_destino!='Alimenticio'&&$sal_destino!='Ambos'&&$impuesto1==0){
	 					$row_pedidodetalle['result'] = 'error';
						$row_pedidodetalle['errMessage'] = 'Este artículo es solo para clientes con destino alimenticio.';
		 				
						
		 			}else{
		 				

						$sql_pedidodetalle = "EXEC spConsultaPedidoDBB '" . $articulo . "','" . $cantidad . "','" . $fecha . "','" . $id_articulo . "','" . $count . "', '" . $action . "'";

						$result_pedidodetalle = mssql_query($sql_pedidodetalle);

						if($result_pedidodetalle){

							if($action != 'B'){
								while($row_pedidodetalle[] = mssql_fetch_assoc($result_pedidodetalle));
								if($row_pedidodetalle[0]['Unidad'] == NULL){
									$row_pedidodetalle['result'] = 'none';
									// echo json_encode($row_pedidodetalle);
								}else{
									$row_pedidodetalle['result'] = 'save';
									// echo json_encode($row_pedidodetalle);
								}
							}else{
								$sql_pedidodetalle = "EXEC spConsultaPedidoDBB '" . $articulo . "','" . $cantidad . "','" . $fecha . "','" . $id_articulo . "','" . $count . "', NULL";

								$result_pedidodetalle = mssql_query($sql_pedidodetalle);

								while($row_pedidodetalle[] = mssql_fetch_assoc($result_pedidodetalle));
								$row_pedidodetalle['result'] = 'delete';
								

								//$result = array('result' => 'delete');
								//echo json_encode($result);
							}
						}
		 			}
	 			}else{
	 				$row_pedidodetalle['result'] = 'error';
					$row_pedidodetalle['errMessage'] = 'Este artículo no es capturable.';
	 			}

	 			


	 			echo json_encode($row_pedidodetalle);

			}

	 	}

	 	if(isset($_POST['iddetalle'])){

	 		$iddetalle = $_POST['iddetalle'];

	 		$sql_iddetalle = "spConsultaPedidoTBB '" . $iddetalle . "'";

			$result_iddetalle = mssql_query($sql_iddetalle);

			while($row_iddetalle[] = mssql_fetch_assoc($result_iddetalle));

			echo json_encode($row_iddetalle);

	 	}



	 	if(isset($_POST['template'])){



	 	 	$agente_query = mssql_query('SELECT Nombre FROM agente WHERE Agente = ' . $_POST['agente_id']);
	 	 	while($row_agente[] = mssql_fetch_assoc($agente_query));

	 	 	$data = $_POST;
	 	 	$data['agente'] = $row_agente[0]['Nombre'];
	 	 	$folio=$data['idart'];
	 	 	$clienteid=$data['clienteid'];
	 	 	$today=date("d-m-Y");

	 	 	
	 		// $sql= mssql_query("spInsertaPedidoBB 'ROCHE','Pedido',".$data['folio'].",'".$data['clienteid']."','".$data['sucursal']."','".$today."','".$data['fecha']."','".$data['almacen']."','".$data['proyecto']."','".$data['condiciones']."','".$data['forma_envio']."','".$data['lista_precios']."','".$data['zona_impuestos']."','".$_SESSION["user"]."','".$data['observaciones']."','".$data['orden_compra']."',".$folio);

	 		$sql= mssql_query("spInsertaPedidoBB 'ROCHE','Pedido',".$data['folio'].",'".$data['clienteid']."','".$data['sucursal']."','".$today."','".$data['fecha']."','".$data['almacen']."','".$data['proyecto']."','".$data['condiciones']."','".$data['forma_envio']."','".$data['lista_precios']."',NULL,'".$_SESSION["user"]."','".$data['observaciones']."','".$data['orden_compra']."',".$folio);

	 	 	$sql ="spConfirmaPedidoBB ".$folio."";
			 $save=mssql_query($sql);

			$qry=mssql_query("spReportePedidoBB ".$folio);
			while ($row = mssql_fetch_array($qry)) {
				$results[] = $row;
			}
			foreach($results as $key => $value){

				$datas[$results[$key]['Cliente']] = array(
					'Cliente' => $results[$key]['Cliente'],
					'Nombre' => $results[$key]['Nombre'],
					'ListaPrecios' => $results[$key]['ListaPrecios'],
					'MovID' => $results[$key]['MovID'],
					'Estado' => $results[$key]['Estado'],
					'Almacen' => $results[$key]['Almacen'],
					'FormaEnvio' => $results[$key]['FormaEnvio'],
					'Condiciones' => $results[$key]['Condiciones'],
					'ZonaImpuesto' => $results[$key]['ZonaImpuesto'],
					'NombreCliente' => $results[$key]['NombreCliente'],
					'Direccion' => utf8_encode($results[$key]['Direccion']),
					'Sucursal' => utf8_encode($results[$key]['Sucursal']),
					'Fecha' => $results[$key]['Fecha'],
					'PrecioFlete' => $results[$key]['PrecioFlete'],
					'Subtotal' => $results[$key]['Subtotal'],
					'DPA' => $results[$key]['DPA'],
					'DescXFlete' => $results[$key]['DescXFlete'],
					'Sub' => $results[$key]['Sub'],
					'Impuesto' => $results[$key]['Impuesto'],
					'Total' => $results[$key]['Total']
				);
			}

			
			
			
			
			
	 		require_once 'reporte_template.php';

	 	}

	 	if(isset($_POST['enviar_reporte'])){
	 		$folio=$_POST['folioPost'];

	 		require_once 'phpmailer/PHPMailerAutoload.php';

			$mail = new PHPMailer;

			$mail->isSMTP();

			$mail->Host = 'mail2.isysa.com.mx';
			$mail->SMTPAuth = true;
			$mail->Username = 'appmovil';
			$mail->Password = 'Salinera';
			$mail->Port = 587;
			$mail->SMTPSecure = 'tls';

			$mail->From = 'appmovil@isysa.com.mx';
			$mail->FromName = 'Notificaciones Comercial Roche';

			$mail_query = mssql_query("spAgenteCtoBB '".$user."'");
	 		while($emails[] = mssql_fetch_assoc($mail_query));

	 		 foreach($emails as $email){
				 $mail->addAddress($email['eMail']);
	 		 }

			 //$mail->addAddress('villa.gaboso@gmail.com');

			// $mail->addReplyTo('villa.gaboso@gmail.com');
			$mail->isHTML(true);
			$mail->CharSet = 'UTF-8';

			$mail->Subject = 'Pedido '.$folio;
			$mail->Body = $_POST['message'];

			$file = '/var/www/uploads/reporte_' . date('Y_m_d_H_i_s') . '.html';

			file_put_contents($file, $_POST['message']);

			$mail->addAttachment($file);

			if($mail->send()){
				echo 'success';
			}else{
				echo 'fail';
			}

	 	}



		//echo "Folio=>".$foliovalido;

		// if($results[0]==1){
		// 	echo 'Folio Valido';
		// }else{
		// 	echo 'Folio Invalido';
		// }



		// echo '<option>'.$condicion.'</option>';
		// echo '<option>'.$listaPrecio.'</option>';
		// echo '<option>'.$formaEnvio.'</option>';
		// echo '<option>'.$zonaImpuesto.'</option>';
		// echo '<option>'.$proyecto.'</option>';

		//echo "<pre>", print_r($results2), "</pre>";

?>

