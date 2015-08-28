<?php 

 session_start();
	if (!$_SESSION["log"]){
		header("Location:../index.php");
	} 

function conn($DB){
	
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
}

if(isset($_POST['pedido'])){
	$x = $_POST['pedido'];
	$movID = $x['pedido_id'];
	$db = $x['db'];

	conn($db);

	$qry = "SELECT v.ID, c.Cliente, c.Nombre, v.FechaEmision, v.FechaRequerida, v.Almacen, v.Proyecto, v.Condicion, v.FormaEnvio, v.ListaPreciosEsp, v.OrdenCompra, v.FechaOrdenCompra, v.Observaciones FROM Venta v JOIN Cte c ON v.Cliente = c.Cliente WHERE v.Mov = 'Pedido' AND v.Estatus = 'Pendiente' AND v.MovID = '".$movID."' AND v.Agente ='".$_SESSION["user"]."'";
	$details = mssql_fetch_array(mssql_query($qry));



	$qry = "SELECT * FROM VentaD v JOIN VentaTCalc c ON v.Renglon = c.Renglon AND v.ID = c.ID WHERE v.ID = ".$details["ID"]." ORDER BY v.Renglon";
	$qry = mssql_query($qry);

	while ($row = mssql_fetch_assoc($qry)) {
		$sell_details[] = $row;
	}

	if($details){

			$html = '<div id="detalles_venta">';
				$html .= '<div class="titulos">';
					$html .= '<div><strong>Art.</strong></div>';
					$html .= '<div><strong>Cant.</strong></div>';
					$html .= '<div><strong>Inv.</strong></div>';
					$html .= '<div><strong>Desc.</strong></div>';
					$html .= '<div><strong>IVA</strong></div>';
					$html .= '<div><strong>Sub.</strong></div>';
				$html .= '</div>';

		foreach ($sell_details as $key => $value) {
			
				$html .= '<div class="contenidos">';
					$html .= '<div><input type="text" name="art" value='.$value['Articulo'].'><input type="hidden" name="renglon" value="'.$value['Renglon'].'"><input type="hidden" name="impuesto" value="'.$value['Impuesto1'].'"><input type="hidden" name="art_origen" value="'.trim($value['Articulo']).'"></div>';
					$html .= '<div><input type="text" value='.$value['Cantidad'].'></div>';
					$html .= '<div>&nbsp'.$value['CantidadInventario'].'</div>';
					$html .= '<div>&nbsp'.number_format($value['DescuentosTotales'], 2).'</div>';
					$html .= '<div>&nbsp'.number_format($value['Impuesto1Total'], 2).'</div>';
					$html .= '<div class="num">&nbsp'.number_format($value['ImporteTotal'], 2).'</div>';
				$html .= '</div>';

		}
			$html .= '</div>';
			$html .= '<div>';
				$html .= '<input type="hidden" name="cliente" value="'.$value['Cliente'].'">';
				$html .= '<input type="button" name="actualizar" value="Actualizar">';
			$html .= '</div>';

		$result = array(
			'error'=>'no',
			'Nombre'=>utf8_encode($details["Nombre"]),
			'FechaEmision'=>date("d-m-Y",strtotime($details["FechaEmision"])),
			'FechaRequerida'=>date("d-m-Y",strtotime($details["FechaRequerida"])),
			'Almacen'=>$details["Almacen"],
			'Proyecto'=>$details["Proyecto"],
			'Condicion'=>$details["Condicion"],
			'FormaEnvio'=>$details["FormaEnvio"],
			'ListaPreciosEsp'=>$details["ListaPreciosEsp"],
			'OrdenCompra'=>$details["OrdenCompra"],
			'FechaOrdenCompra'=>date("d-m-Y",strtotime($details["FechaOrdenCompra"])),
			'Observaciones'=>$details["Observaciones"],
			'html'=>$html
		);


	}else{
		$result = array(
		'error'=>'si',
		'errorMssg'=>'No existe el pedido.'
		);
	}

	echo json_encode($result);

	
}//END _POST[pedido]


if(isset($_POST['update'])){
	$x = $_POST['update'];
	// $db = $x["db"];
	// $articulos = $x['articulos'];
	// $impuestos = $x['impuestos'];
	// $renglones = $x['renglones'];
	// $a_arts_origen = $x['a_arts_origen'];
	// $cliente_id = $x['cliente_id'];

	// conn($db);

	// $qry = "SELECT SalDestino FROM Cte WHERE Cliente = '".$idcliente."'";
	// $sal_destino = mssql_fetch_assoc(mssql_query($qry));
	// $sal_destino = $sal_destino['SalDestino'];


	// foreach ($articulos as $key => $value) {
	// 	$qry = "SELECT Articulo FROM SalArtSinAditivos WHERE Articulo ='".$value."'";
	// 	$validar_articulo = mssql_fetch_assoc(mssql_query($qry));
	// 	$validar_articulo = $validar_articulo['Articulo'];

	// 	if($validar_articulo){
	// 		$response = array(
	// 			'error' => 'no' , );
	// 	}else{
	// 		$response = array(
	// 			'error' => 'si' ,
	// 			'errorMssg' => 'Este articulo no se puede capturar.' );
	// 	}
	// }

	echo json_encode($x);

}

?>