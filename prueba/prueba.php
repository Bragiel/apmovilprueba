<!doctype html>

<html>



	<head>
		<link rel="stylesheet" href="style.css">
		<script type="text/javascript" src="jquery.js"></script>


	</head>
	<body>
		<table>
    <thead>
        <tr><th>Summary Row #1</th></tr>
    </thead>
    
    <tbody class="collapsed">
        <tr><td><table>
    <thead>
        <tr><th>Summary Row #1</th></tr>
    </thead>
    
    <tbody class="collapsed">
        <tr><td>Drill Down Data</td></tr>
        <tr><td>Drill Down Data</td></tr>
    </tbody>
    
    <thead>
        <tr><th>Summary Row #2</th></tr>
    </thead>
    
    <tbody class="collapsed">
        <tr><td>Drill Down Data</td></tr>
        <tr><td>Drill Down Data</td></tr>
    </tbody>
    
    
    
</table></td></tr>
        <tr><td>Drill Down Data</td></tr>
    </tbody>
    
    <thead>
        <tr><th>Summary Row #2</th></tr>
    </thead>
    
    <tbody class="collapsed">
        <tr><td>Drill Down Data</td></tr>
        <tr><td>Drill Down Data</td></tr>
    </tbody>
    
    
    
</table>

		<script>
			$('thead').on('click', function(){

				alert("picale");
			    $(this).next('tbody').toggleClass('collapsed');

			});
		</script>
			
	</body>

</html>