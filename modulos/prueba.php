<!doctype html>

<?php 
	session_start();
	if (!$_SESSION["log"]){
		header("Location:index.php");
	}
	$mov = $_POST["movimiento"];
	$tipo= $_POST["tipo"];
	$temp= $_POST["tiempo"];
	$year= $_POST["year"];
?>

<html>
<head>
<script type="text/javascript" language="javascript" src="../assets/js/jquery.js"></script>
<meta  content="text/html; charset=utf-8" />
<meta name="robots" content="all" />
<meta name="viewport" content="width=device-width, height=device-height, user-scalable=no" >
<link rel="stylesheet" href="../assets/css/style.css">
<script type="text/javascript" language="javascript" src="../assets/js/jquery.dataTables.js"></script>


<meta charset="UTF-8">
<meta name="HandheldFriendly" content="True">
<script>
	$(document).ready(function() {
	  var anOpen = [];
	    var sImageUrl = "../assets/img/";
	     
	    var oTable = $('#example').dataTable( {
	        "bProcessing": true,
	        "sAjaxSource": "../assets/js/source.txt",
	        "aoColumns": [
	            {
	               "mDataProp": null,
	               "sClass": "control center",
	               "sDefaultContent": '<img src="'+sImageUrl+'details_open.png'+'">'
	            },
	            { "mDataProp": "engine" },
	            { "mDataProp": "browser" },
	            { "mDataProp": "grade" }
	        ]
	    } );
	} );

	$('#example td.control').live( 'click', function () {
  var nTr = this.parentNode;
  var i = $.inArray( nTr, anOpen );
   
  if ( i === -1 ) {
    $('img', this).attr( 'src', sImageUrl+"details_close.png" );
    var nDetailsRow = oTable.fnOpen( nTr, fnFormatDetails(oTable, nTr), 'details' );
    $('div.innerDetails', nDetailsRow).slideDown();
    anOpen.push( nTr );
  }
  else {
    $('img', this).attr( 'src', sImageUrl+"details_open.png" );
    $('div.innerDetails', $(nTr).next()[0]).slideUp( function () {
      oTable.fnClose( nTr );
      anOpen.splice( i, 1 );
    } );
  }
} );
</script>

<title>Ventas</title>
<?php
	


	 	$DB = 'COSYSA';
		$serverName = "intelisis"; //serverName\instanceName
		$connectionInfo = array( "Database"=>$DB, "UID"=>"intelisis", "PWD"=>"");
		$conn = mssql_connect( $serverName, "intelisis", "");
		mssql_select_db($DB, $conn);
		$user=$_SESSION["user"];

	 		if (!$conn ) {

	 	    	die('Something went wrong while connecting to MSSQL');

	 		}
		
	 	 echo ("Su usuario es ". $_SESSION["user"]);
		 $query=mssql_query("spRepVtasBB '".$_SESSION["user"]."','".$tipo."','".$temp."','".$year."'");


		while ($row = mssql_fetch_array($query)) {
			 $results[] = $row;
		}
?>
</head>

<body>
	<div class="wrap">

	

 
    	<form action="" method="post">
	    	<div id="selectors">
						<select name="movimiento">
							<option value="Ventas"> Ventas </option>
							<option> CxC </option>
							<option> AMB </option>
							<option> Inv </option>
							<option> Mov </option>
							<option> Pedido </option>
						</select>

						<select name="tipo">
							<option value="cliente"> Cliente </option>
							<option value="Tsal"> TSal </option>
							<option value="almacen"> Almacén </option>
							<option value="articulo"> Artículo </option>
						</select>

						<select name="tiempo">
							<option value='Hoy'> Hoy</option>
							<option value='Semana'> Semana </option>
							<option selected value='Mes'> Mes </option>
							<option value='Enero'> Enero </option>
							<option value='Febrero'> Febrero </option>
							<option value='Marzo'> Marzo </option>
							<option value='Abril'> Abril </option>
							<option value='Mayo'> Mayo </option>
							<option value='Junio'> Junio </option>
							<option value='Julio'> Julio </option>
							<option value='Agosto'> Agosto </option>
							<option value='Septiembre'> Septiembre </option>
							<option value='Octubre'> Octubre </option>
							<option value='Noviembre'> Noviembre </option>
							<option value='Diciembre'> Diciembre </option>
							<option value='Acumulado'> Acumulado </option>
						</select>
						<select name="year">
							<option value="2008"> 2008</option>
							<option value="2009"> 2009 </option>
							<option value="2010"> 2010 </option>
							<option value="2011"> 2011 </option>
							<option value="2012"> 2012 </option>
							<option value="2013"> 2013 </option>
							<option value="2014" selected> 2014 </option>
							<option value="2015"> 2015 </option>
							<option value="2016"> 2016 </option>
							<option value="2017"> 2017 </option>
							
						</select>

						<input id="btnBuscar" type="submit"  value="Buscar"> 
			</div>
		</form>



<table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
    <thead>
        <tr>
            <th></th>
            <th>Rendering engine</th>
            <th>Browser</th>
            <th>CSS grade</th>
        </tr>
    </thead>
    <tbody></tbody>
</table>

</body>

</html>