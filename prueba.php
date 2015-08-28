

<?php
	$serverName = "intelisis"; //serverName\instanceName
	 	$connectionInfo = array( "Database"=>"COSYSA", "UID"=>"intelisis", "PWD"=>"");
	 	$conn = mssql_connect( $serverName, "intelisis", "");


	 	$connectingnn = mssql_connect($serverName, 'intelisis', '');
	 	mssql_select_db("COSYSA", $conn);

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

	 		$query="spRepVtasBB '010', 'articulo', 'enero', '2013'";
	 		$query=mssql_query($query);
	 			//spRepVtasBB '010', 'articulo', 'enero', '2013'");






		while ($row = mssql_fetch_array($query)) {
			 $results[] = $row;
		}

		echo 'Total records in database   f: ' . mssql_num_rows($query);

		echo '<pre>',print_r($results),'</pre>';

?>

<?php
// $serverName = "intelisis"; //serverName\instanceName
// $connectionInfo = array( "Database"=>"COSYSA", "UID"=>"intelisis", "PWD"=>"");
// $conn = sqlsrv_connect( $serverName, $connectionInfo);

// if( $conn ) {
//      echo "Connection established.<br />";
// }else{
//      echo "Connection could not be established.<br />";
//      die( print_r( sqlsrv_errors(), true));
// }

// $sql = "spRepVtasBB '009', 'tSal ', 'junio', '2014'";
// $stmt = sqlsrv_query( $conn, $sql );
// if( $stmt === false) {
//     die( print_r( sqlsrv_errors(), true) );
// }

// while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
//       echo $row['Categoria'].", ".$row['Cliente']."<br />";
// }

// sqlsrv_free_stmt( $stmt);


?>


