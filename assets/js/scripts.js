$(function(){
	var cont = $("#login"), 
		formulario = cont.find("form"),
		btnAcceso = $("input[type=submit]")
		body = $("body");



	btnAcceso.click(function(event){
		console.log($("input[name=usuario]").val());
		event.preventDefault();
		formulario.slideUp(function(){
			formulario.remove();
			cont.animate({
				width:"100%"
			}, function(){
				cont.load("Nominas.php", function(){
					var nomina = $('#nomina');
					nomina.slideDown(
						function(){
						var user =  $("input[name=usuario]").val();						
							contenedor = $("#contenedor"),
							action = "contenedor.php",
							//contenedor.load("contenedor.php");
							$.post(action, { 'user' : user}, function(result){ });

						}
						
						);
				});
				
			});
		});


	});

	
});

$('thead').on('click', function(){
	    $(this).next('tbody').toggleClass('collapsed');
	});

