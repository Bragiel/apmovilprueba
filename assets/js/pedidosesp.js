$(function(){
	var body = $('body');

	

	body.on('click','input[name=buscar]',function(){
		var pedido_id = body.find("input[name=pedido]").val();
			params = {
				"db":"pruebasCOSYSA",
				"pedido_id":pedido_id
			}

		 $.post('pedidosesp_func.php', {pedido:params}, function(response){
		 		var detalles = body.find('#detalles');

		 		detalles.append(response.html)
		 		console.log(response);
		}, 'json');

	});

	body.on('click','input[name=actualizar]',function(){
		var articulo = body.find("input[name=art]"),
			art_origen =  body.find("input[name=art_origen]"),
			renglon = body.find("input[name=renglon]"),
			impuesto = body.find("input[name=impuesto]"),
			cliente_id = body.find("input[name=cliente]"),
			a_articulos = new Array(),
			a_arts_origen = new Array(),
			a_renglon = new Array(),
			a_impuesto = new Array();
			

			for (var i = 0; i <= articulo.length - 1; i++) {
				a_articulos.push(articulo.eq(i).val());
				a_renglon.push(renglon.eq(i).val());
				a_impuesto.push(impuesto.eq(i).val());
				a_arts_origen.push(art_origen.eq(i).val());
			};
		var params = {
				"db":"pruebasCOSYSA",
				"articulos":a_articulos,
				"renglones":a_renglon,
				"impuestos":a_impuesto,
				"a_arts_origen":a_arts_origen,
				"cliente_id": cliente_id
			};

			console.log(params);

			$.post('pedidosesp_func.php', {update:params}, function(response){
			 		
			 		console.log(response);
			}, 'json');

		

	});
});