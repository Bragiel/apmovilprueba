<?php
session_start();
if (!$_SESSION["log"]){
		header("Location:../index.php");
	}

if($_POST['DB']){
	$DB = $_POST['DB'];
}
if($_POST['delParams']){
	$temp = $_POST['delParams'];
	$DB = $temp[3];
}
if($_POST['saveParams']){
	$temp = $_POST['saveParams'];
	$DB = $temp[4];
}
if($_POST['params']){
	$temp = $_POST['params'];
	$DB = $temp[12];
}
if($_POST['confirmParams']){
	$temp = $_POST['confirmParams'];
	$DB = $temp[0];
}
if($_POST['observParams']){
	$temp = $_POST['observParams'];
	$DB = $temp[0];
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




function path(){

	$year=date('Y');
	$month=date('m');
	
	//$path='/var/www/uploads/';
	//COMPRUEBA SI EXÍSTE AÑO
	if(is_dir('/var/www/uploads/'.$year.'/')){
		//COMPRUEBA SI EXÍSTE MES
		if(is_dir('/var/www/uploads/'.$year.'/'.$month.'/')){
			$path='/var/www/uploads/'.$year.'/'.$month.'/';
		}else{
			mkdir('/var/www/uploads/'.$year.'/'.$month.'/',0700);
			$path='/var/www/uploads/'.$year.'/'.$month.'/';
		}
	}else{
		mkdir('/var/www/uploads/'.$year.'/', 0700);
		mkdir('/var/www/uploads/'.$year.'/'.$month.'/',0700);
		$path='/var/www/uploads/'.$year.'/'.$month.'/';
	}

	return $path;

}//END function path

function saveFile($oldpath, $DB, $movId){
	$year=date('Y');
	$month=date('m');
	$oldpathex=explode("/", $oldpath);

	if($oldpathex[4]!='anexos'){
		//Comprueba que exista la BD
		if(is_dir('/var/www/uploads/anexos/'.$DB.'/')){
			//Comprueba que exista COSYSA
			if(is_dir('/var/www/uploads/anexos/'.$DB)){
				//COMPRUEBA SI EXISTE AÑO
				if(is_dir('/var/www/uploads/anexos/'.$DB.'/'.$year.'/')){
					//COMPRUEBA SI EXÍSTE MES
					if(is_dir('/var/www/uploads/anexos/'.$DB.'/'.$year.'/'.$month.'/')){
						//COMPRUEBA SI EXISTE CLIENTE
						if(is_dir('/var/www/uploads/anexos/'.$DB.'/'.$year.'/'.$month.'/'.$oldpathex[6].'/')){
							$path='/var/www/uploads/anexos/'.$DB.'/'.$year.'/'.$month.'/'.$oldpathex[6].'/';

						}else{
							mkdir('/var/www/uploads/anexos/'.$DB.'/'.$year.'/'.$month.'/'.$oldpathex[6].'/',0700);
							$path='/var/www/uploads/anexos/'.$DB.'/'.$year.'/'.$month.'/'.$oldpathex[6].'/';
							
						}
						
					}else{
						mkdir('/var/www/uploads/anexos/'.$DB.'/'.$year.'/'.$month.'/',0700);
						mkdir('/var/www/uploads/anexos/'.$DB.'/'.$year.'/'.$month.'/'.$oldpathex[6].'/',0700);
						$path='/var/www/uploads/anexos/'.$DB.'/'.$year.'/'.$month.'/'.$oldpathex[6].'/';
						
					}
					
				}else{
					mkdir('/var/www/uploads/anexos/'.$DB.'/'.$year.'/', 0700);
					mkdir('/var/www/uploads/anexos/'.$DB.'/'.$year.'/'.$month.'/',0700);
					mkdir('/var/www/uploads/anexos/'.$DB.'/'.$year.'/'.$month.'/'.$oldpathex[6].'/',0700);
					$path='/var/www/uploads/anexos/'.$DB.'/'.$year.'/'.$month.'/'.$oldpathex[6].'/';
				}

			}else{
				mkdir('/var/www/uploads/anexos/'.$DB.'/',0700);
				mkdir('/var/www/uploads/anexos/'.$DB.'/'.$year.'/',0700);
				mkdir('/var/www/uploads/anexos/'.$DB.'/'.$year.'/'.$month.'/',0700);
				mkdir('/var/www/uploads/anexos/'.$DB.'/'.$year.'/'.$month.'/'.$oldpathex[6].'/',0700);
				$path='/var/www/uploads/anexos/'.$DB.'/'.$year.'/'.$month.'/'.$oldpathex[6].'/';
			}
			

		}else{
			mkdir('/var/www/uploads/anexos/'.$DB.'/',0700);
			mkdir('/var/www/uploads/anexos/'.$DB.'/'.$year.'/',0700);
			mkdir('/var/www/uploads/anexos/'.$DB.'/'.$year.'/'.$month.'/',0700);
			mkdir('/var/www/uploads/anexos/'.$DB.'/'.$year.'/'.$month.'/'.$oldpathex[6].'/',0700);
			$path='/var/www/uploads/anexos/'.$DB.'/'.$year.'/'.$month.'/'.$oldpathex[6].'/';

		}
		
		$newpath=$path.$movId.date('d','m','G').$oldpathex[7];
		$changedir= rename($oldpath, $newpath);

		if($changedir==true){
			return	$newpath;
		}else{
			return	$newpath;
		}
		//return $newpath;
	}else{
		return $oldpath;
	}
}//END function saveFile

if($_POST){

	if(isset($_POST['params'])){
		$param=$_POST['params'];

		$concepto=$param[0];
		$referencia=$param[1];
		$subtotal=$param[2];
		$iva=$param[3];
		$inputTotal=$param[4];
		$inputTasa=$param[5];
		$inputRetencion=$param[6];
		$inputRutaXml=$param[7];
		$inputRutaPdf=$param[8];
		$rutaPdf=explode("/", $inputRutaPdf);
		$nombrePdf=$rutaPdf[7];
		$numFila=$param[9];
		$user=$param[10];
		$movId=$param[11];
		$db=$param[12];
		$uuid=$param[13];
		$observaciones=$param[14];

		if(!$inputTasa){
			$inputTasa = 0.0;
		}

		if(!$referencia){
			$referencia='sinreferencia';
		}


		if($concepto!=''&&$subtotal!=''){

			$qry1=mssql_query("UPDATE salgasto SET Observaciones='".$observaciones."' WHERE ID=".$movId);

			$duplicate=mssql_query("EXEC spSalValidaAnexos $movId, $numFila,'$nombrePdf','$uuid'");

			while ($row = mssql_fetch_array($duplicate)) {
			 	$results = $row;
			}

			if(is_null($results[0])){
				$qry=mssql_query("INSERT INTO salgastod VALUES (".$param[11].",".$param[9].",'".utf8_decode($concepto)."','".$referencia."',".str_replace(",", "", $subtotal).",".str_replace(",","", $iva).",".str_replace(",", "", $inputTotal).",".str_replace(",", "", $inputTasa).",".str_replace(",", "", $inputRetencion).",'".$inputRutaXml."','".$inputRutaPdf."')");

				if($qry==true){
					$response = array(
						'error' => 'no',
						'message' => 'success'
					);
					echo json_encode($response);
				}else{
						$response = array(
						'error' => 'si',
						'message' => 'Error al guardar su gasto. SQLERROR',
						'sql' => "INSERT INTO salgastod VALUES (".$param[11].",".$param[9].",'".utf8_decode($concepto)."','".$referencia."',".str_replace(",", "", $subtotal).",".str_replace(",","", $iva).",".str_replace(",", "", $inputTotal).",".str_replace(",", "", $inputTasa).",".str_replace(",", "", $inputRetencion).",'".$inputRutaXml."','".$inputRutaPdf."')"
					);
					echo json_encode($response);
				}
			}else{
				$response = array(
					'error' => 'si',
					'message' => $results[1],
					'sql' => "EXEC spSalValidaAnexos $movId, $numFila,'$nombrePdf','$uuid'"
				);
				echo json_encode($response);
				
			}

			$qry1=mssql_query("EXEC spSalBitacoraXML 'GAS',".$movId.",'".$user."','','".utf8_decode($response["message"])."'");

		}

	}//END $_POST['params']

	if(isset($_POST['delParams'])){
		$param=$_POST['delParams'];

		
		$delXML= unlink($param[1]);
		$delPDF= unlink($param[2]);	
		
		if(is_null($param[1])){
			if($delXML==true&&$delPDF==true){

				$qry=mssql_query("DELETE FROM salgastod WHERE Renglon =".$param[0]." AND ID=".$param[4]);

				if($qry==true){
					
					$response = array(
							'error' => 'no',
							'message' => 'success'
						);
						echo json_encode($response);	
					
				}else{
					$response = array(
						'error' => 'si',
						'message' => 'No se pudo eliminar el registro SQL ERROR.',
						'console'=>"DELETE FROM salgastod WHERE Renglon =".$param[0]." AND ID=".$param[4]
					);
					echo json_encode($response);
				}
				
			}else{
				if($delXML!=true){
					$xml='XML';
				}
				if($delPDF!=true){
					$pdf='PDF';
				}
				$response = array(
					'error' => 'si',
					'message' => 'No se pudo eliminar el '.$xml.' '.$pdf.' del servidor.',
					'console'=>'Params=>'.$param[1].' '.$param[2]
				);
				echo json_encode($response);
			}
			echo json_encode('Params=>'.$param[1].' '.$param[2]);
		}else{
			$qry=mssql_query("DELETE FROM salgastod WHERE Renglon =".$param[0]." AND ID=".$param[4]);

				if($qry==true){
					
					$response = array(
							'error' => 'no',
							'message' => 'success'
						);
						echo json_encode($response);	
					
				}else{
					$response = array(
						'error' => 'si',
						'message' => 'No se pudo eliminar el registro SQL ERROR.',
						'console'=>"DELETE FROM salgastod WHERE Renglon =".$param[0]." AND ID=".$param[4]
					);
					echo json_encode($response);
				}
			
		}
			

	}//$_POST['delParams']

	if(isset($_POST['saveParams'])){
		$param=$_POST['saveParams'];

		$movId=$param[0];
		$rutaXml=$param[1];
		$rutaPdf=$param[2];
		$numFila=$param[3];
		$db=$param[4];
		$observaciones=$param[5];

		 $pathXML=saveFile($rutaXml, $DB, $movId);
		 $pathPDF=saveFile($rutaPdf, $DB, $movId);
		 $pathXMLex=explode("/", $pathXML);
		 $pathPDFex=explode("/", $pathPDF);


		 //echo json_encode($pathXML);
		if($rutaXml!=''){
			if($pathXMLex[8]!=''||$pathPDFex[8]!=''){
			 	//$qry1=mssql_query("UPDATE salgasto SET Observaciones='".$observaciones."' WHERE ID=".$movId); 
			 
				$qry2=mssql_query("UPDATE salgastod SET RutaXML='".$pathXML."', RutaPDF='".$pathPDF."' WHERE Renglon =".$numFila." AND ID=".$movId); 
				if($qry2==true){
					$response = array(
						'error' => 'no',
						'message' => '',
						'console'=>''.$pathXML
					);
					echo json_encode($response);
					
				}else{
					$response = array(
						'error' => 'si',
						'message' => 'No se actualizaron las rutas de los archivos. SQLERROR',
						'console'=>"UPDATE salgastod SET RutaXML='".$pathXML."', RutaPDF='".$pathPDF."' WHERE Renglon =".$numFila." AND ID=".$movId
					);
					echo json_encode($response);
				}
			}
			
		}else{
			
			$response = array(
				'error' => 'no',
				'message' => '',
				'console'=>"Condepto No deducible".$rutaXml
			);
			echo json_encode($response);
			
		}
		
	}//END $_POST['saveParams']

	if(isset($_POST['confirmParams'])){
		$param=$_POST['confirmParams'];
		$DB=$param[0];
		$movId=$param[1];
		$user=$_SESSION['user'];
		
		//echo json_encode("spSalInsertaGasto ".$movId.",'".$DB."'");
		$qry=mssql_query("spSalInsertaGasto ".$movId.",'".$DB."'");
		//$qry=mssql_query("spSalInsertaGasto 29,'Gastos'");
		while ($row = mssql_fetch_array($qry)) {
			$insert = $row;
		}
		
		if($insert[1]>0){
			$response = array(
				'error' => 'si',
				'message' => 'No se inserto el encabezado correctamente. SQLERROR '.$insert[2],
				'console'=>"spSalInsertaGasto ".$movId.",'".$DB."' Error msg=>$insert[2]"
			);
			echo json_encode($response);

			$qry1=mssql_query("EXEC spSalBitacoraXML 'GAS',".$movId.",'".$user."','','".utf8_decode($response["message"])."'");
		}else{
			$response = array(
				'error' => 'no',
				'message' => ''
			);
			echo json_encode($response);
		}

	}//end confirmParams

	if(isset($_POST['observParams'])){
		$param=$_POST['observParams'];
		$DB=$param[0];
		$movId=$param[1];
		$observaciones=$param[2];
		
		$qry1=mssql_query("UPDATE salgasto SET Observaciones='".$observaciones."' WHERE ID=".$movId);

		echo json_encode("UPDATE salgasto SET Observaciones='".$observaciones."' WHERE ID=".$movId);

	}//end confirmParams
	
}//END $_POST

if($_FILES){

	if(isset($_FILES['xml'])){ //Revisar si el name xml existe
                
        $file = $_FILES['xml'];
        $bitacora = $_POST['bitacora'];
        $bitacoraex = explode(',', $bitacora);

		if($file['type'] == 'text/xml'){

			


			function uploadXML($fileXML){

				$temp = $fileXML['tmp_name'];
				$filename = $fileXML['name'];
				$path=path();
				$destination = $path . $filename;


				$uploaded = move_uploaded_file($temp, $destination);

				if($uploaded){
					return $destination;
				}else{
					return false;
				}

				

			}//End uploadXML

			function moveXML($oldpath, $finalPath, $filename){

				
				$destination = $finalPath . $filename;
				mkdir($finalPath, 0700);

				$uploaded = rename($oldpath, $destination);

				if($uploaded){
					return $destination;
				}else{
					$error=error_get_last();
					return $error;
				}
			
			}



			function loadXML($destination){

				$xml = simplexml_load_file($destination); //Permisos de escritura
				//$xml = simplexml_load_file($destination); //Permisos de escritura

				return $xml;
			}//End loadXML

			function getVariableXML($path, $name, $destination){

				$xml = loadXML($destination);
				$ns = $xml->getNamespaces(true);
				$xml->registerXPathNamespace('c', $ns['cfdi']);
				$xml->registerXPathNamespace('t', $ns['tfd']);

				$array = $xml->xpath($path);

				if($name=='tasa'){
					foreach($array as $iteration){
						$var[] = $iteration[$name];
					}
				}else{
					foreach($array as $iteration){
						$var = $iteration[$name];
					}
				}
				

				return $var;

			}//End getVariableXML

			function validarSAT($destination, $fileXML){
				$filename=$fileXML['name'];

				//Emisor
				$rfc_emisor = getVariableXML('//cfdi:Comprobante//cfdi:Emisor', 'rfc', $destination);

				//Receptor
				$rfc_receptor = getVariableXML('//cfdi:Comprobante//cfdi:Receptor', 'rfc', $destination);

				//Total
				$total = getVariableXML('//cfdi:Comprobante', 'total', $destination);

				//UUID
				$id = getVariableXML('//t:TimbreFiscalDigital', 'UUID', $destination);

				//folio
				$folio = getVariableXML('//cfdi:Comprobante', 'folio', $destination);

				//Serie
				$serie = getVariableXML('//cfdi:Comprobante', 'serie', $destination);


				//Subtotal
				$subtotal= getVariableXML('//cfdi:Comprobante', 'subTotal', $destination);

				//Total
				$total= getVariableXML('//cfdi:Comprobante', 'total', $destination);

				//Impuestos
				$impuestos= getVariableXML('//cfdi:Comprobante//cfdi:Impuestos', 'totalImpuestosTrasladados', $destination);

				//Tasa
				$tasa=getVariableXML('//cfdi:Comprobante//cfdi:Impuestos//cfdi:Traslados//cfdi:Traslado', 'tasa', $destination);

				//Retenciones
				$retenciones=getVariableXML('//cfdi:Comprobante//cfdi:Impuestos//cfdi:Retenciones//cfdi:Retencion', 'importe', $destination);

				//Path
				$path= path();
				$finalPath = $path . $rfc_emisor.'/';

				$cadena = 're=' . $rfc_emisor;
				$cadena .= '&rr=' . $rfc_receptor;
				$cadena .= '&tt=' . $total;
				$cadena .= '&id=' . $id;

				$param = array(
					'expresionImpresa' => $cadena
				);

				try {

					$client = new SoapClient('https://consultaqr.facturaelectronica.sat.gob.mx/ConsultaCFDIService.svc?wsdl');

				} catch (Exception $e) {

					$error = $e->getMessage();

					echo 'Excepción capturada: ' . $error;

				}



				$valores = $client->Consulta($param);

				$success=moveXML($destination, $finalPath, $filename);

				$response = array(
					'codigo' => $valores->ConsultaResult->CodigoEstatus,
					'estado' => $valores->ConsultaResult->Estado,
					'error' => 'no',
					'referencia' =>''.$serie.$folio.'',
					'subtotal'=> ''.$subtotal.'',
					'total'=> ''.$total.'',
					'impuestos'=> ''.$impuestos.'',
					'tasa' => ''.$tasa[0].'',
					'ruta' => ''.$success.'',
					'retenciones' => ''.$retenciones.'',
					'uuid' => ''.$id.''
				);
				return json_encode($response);

			}//End validarSAT

			$destination = uploadXML($file); //Veamos si obtiene el destino

			//Lógica

			if($destination){
				$rfc_receptor = getVariableXML('//cfdi:Comprobante//cfdi:Receptor', 'rfc', $destination);

				
				$metodoDePago = getVariableXML('//cfdi:Comprobante', 'metodoDePago', $destination);
				
				
				$qry=mssql_query("SELECT dbo.fn_SalValidaDatosXML('metodoDePago', ' ".utf8_decode($metodoDePago)."')");
				$qry2=mssql_query("SELECT dbo.fn_SalValidaDatosXML('Receptorrfc', ' ".$rfc_receptor."')");
				
				$rr = mssql_fetch_array($qry2);
				$mdp = mssql_fetch_array($qry);

				if($DB=="COSYSA"){
					if($rr[0]==1 && $mdp[0]==1){
						$valores = validarSAT($destination, $file);
						echo $valores;
					}else{
					 	if($rr[0]==0){
					 		$msgerror1='El rfc del receptor no es correcto. '.$rfc_receptor;
							$handlerRfc=1;
						
					 	}
					 	if($mdp[0]==0){
					 		$msgerror2='El método de pago no es correcto. '.$metodoDePago;
							$handlerMdp=1;
					 	}
					 	$error = array(
					 		'error' => 'si',
					 		'errorMsg' => 'Error XML '.$msgerror1.' '.$msgerror2,
							'handlerRfc' => $handlerRfc,
							'handlerMdp' => $handlerMdp
					 	);
					 	$valores = json_encode($error);
					 	echo $valores;
					 }//end $rr[0]==1 && $mdp[0]==1
				}else{
					if($rr[0]==1){
						$valores = validarSAT($destination, $file);
						echo $valores;
					}else{

					 	$msgerror1='El rfc del receptor no es correcto. '.$rfc_receptor;
						$handlerRfc=1;
					 	$error = array(
					 		'error' => 'si',
					 		'errorMsg' => 'Error XML '.$msgerror1,
							'handlerRfc' => $handlerRfc
					 	);
					 	$valores = json_encode($error);
					 	echo $valores;
					 }//end $rr[0]==1
				}

				
				 

			}else{
				$error = array(
					'error' => 'si',
					'errorMsg' => 'No se pudo subir el archivo XML'
				);
				$valores = json_encode($error);
				echo $valores;
			}

		}else{//End type
			$response = array(
						'error' => 'badtype',
						'errorMsg' => 'Tipo de archivo no valído.');

			echo json_encode($response);
		}

		$qry=mssql_query("EXEC spSalBitacoraXML 'GAS',".$bitacoraex[0].",'".$bitacoraex[1]."','".$destination."','".utf8_decode($error["errorMsg"])."'");
	}//End isset xml
	if(isset($_FILES['pdf'])){
		$file = $_FILES['pdf'];
		$ruta= $_POST['ruta'];
		$bitacora = $_POST['bitacora'];
        $bitacoraex = explode(',', $bitacora);

		//$destino=$_POST['rutaPdf'];
		if($file['type'] == 'application/pdf'){

			

			function uploadPDF($filePDF, $ruta){

				$temp = $filePDF['tmp_name'];
				$filename = $filePDF['name'];
				$rutaex=explode("/", $ruta);
				$path= '/'.$rutaex[1].'/'.$rutaex[2].'/'.$rutaex[3].'/'.$rutaex[4].'/'.$rutaex[5].'/'.$rutaex[6].'/';
				$destination = $path . $filename;

				$uploaded = move_uploaded_file($temp, $destination);

				if($uploaded){
					$success = array(
					'error' => 'no',
					'pdf'	=> 'si',
					'ruta'	=> ''.$destination
					);
					return $success;
				}else{
					$error = array(
					'error' => 'si',
					'errorMsg' => 'No se pudo subir el archivo PDF'
					);
					return($error);
				}


			}//End uploadt

			$response=uploadPDF($file, $ruta);

			echo json_encode($response);


		}else{
			$response = array(
						'error' => 'badtype',
						'errorMsg' => 'Tipo de archivo no valído.');

			echo json_encode($response);

		}
		$qry=mssql_query("EXEC spSalBitacoraXML 'GAS',".$bitacoraex[0].",'".$bitacoraex[1]."','".$destination."','".utf8_decode($error["errorMsg"])."'");

	}
}

?>