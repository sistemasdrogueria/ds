
<div class="product-content">
<?php if ($articulos!=null )
{echo $this->element('carrito_search_result'); }
else
{echo $this->element('searchsinresult'); } ?>
</div> 
<div class="product-content">
<?php echo $this->element('referencia'); ?>
</div> 

<?php //echo $this->element('metodos_de_pago_datos'); ?>
</div>


<script>
	
	var count = 0;
	var countidd = 0;
	var codigobarras= "";

	$('.formcartcantletters').on("keyup", function(s) {
		var codigo = s.which || s.keyCode;

 			var countid=  $(this).attr("data-id");
		 if(countidd== 0){
			countidd=countid;
		 }
		if (codigo >= 65 && codigo <= 90) {

			$('#terminobuscar').focus();
			$('#terminobuscar').val(String.fromCharCode(codigo));
		}else{
			
			if(countidd == countid){
			var letras =String.fromCharCode(codigo);
			codigobarras=codigobarras+letras;
		
			count++;
			}else{
				countidd=0;
		 codigobarras= "";

			}
					
		}
		
	});

$('.tablasearch thead  tr th a').on('click', function(event){

event.preventDefault();
//console.log(this);
var hreflink= this.href;
	$.ajax({
			data: {
			},
			url: hreflink,
			type: "put",
			success: function(data) {
               $('#resultarticulos').html(data);

			}

		});
});



		
		
$('.formcarritocant,.formcartcant,.formcartcantt,.fragcant,.cantidad').on("change", function(s) {
		
			if ($(this).val() > 1000)
		{
		
		$(this).val("");
		//ajaxcartAgregar($(this).attr("data-id"), 0, $(this).attr("data-pv-id"), $(this).attr("data-id-input"));
			$('#terminobuscar').val(codigobarras);
				busquedaClick();
				countidd=0;
			codigobarras="";				
	}		
	else{
		var quantity = Math.round($(this).val());

		ajaxcartAgregar($(this).attr("data-id"), quantity, $(this).attr("data-pv-id"), $(this).attr("data-id-input"));
				var codigo = s.which || s.keyCode;
				
		}
	});



    $('.formcartcant,.fragcant,.cantidad,#cart-cant').on("keydown", function(s) {

		if (s.keyCode == '38' || s.keyCode == '40') {

			if (s.keyCode == '38') {
				var tab = $(this).attr('tabIndex');
				ta = parseInt(tab);
				total = (ta) - parseInt(1);

				if ($('input[tabIndex=' + total + ']').length) {
					$('input[tabIndex=' + total + ']').focus();
				} else {

					if ($('#terminobuscar').length) {
						$('#terminobuscar').focus();

					} else {

						$('input[tabIndex=' + ta + ']').blur();

					}

				}
			}




			if (s.keyCode == '40') {
				var tab = $(this).attr('tabIndex');
				ta = parseInt(tab);
				total = (ta) + parseInt(1);

				if ($('input[tabIndex=' + total + ']').length) {
					$('input[tabIndex=' + total + ']').focus();
				} else {

					if ($('#terminobuscar').length) {
						$('#terminobuscar').focus();

					} else {

						$('input[tabIndex=' + ta + ']').blur();

					}

				}
			}



		}
		return tab;
	});

	$('.formcartcant,.fragcant,.cantidad,#cart-cant').on("keypress", function(s) {

		if (s.keyCode == 13) {

			if ($('#terminobuscar').length) {
				$('#terminobuscar').val("");
				$('#terminobuscar').focus();
			
			} else {
					$('#terminobuscar').val("");
				var tab = $(this).attr('tabIndex');
				ta = parseInt(tab);
				total = (ta) + parseInt(1);

				$('input[tabIndex=' + total + ']').focus();
			}

		}

		return tab;
	});
	$(".remove").each(function() {
		$(this).replaceWith('<a class="remove" id="' + $(this).attr('id') + '" href="' + Shop.basePath + 'shop/remove/' + $(this).attr('id') + '" title="Remove item"><img src="' + Shop.basePath + 'img/icon-remove.gif" alt="Remove" /></a>');
	});
	$(".remove").click(function() {
		ajaxcartAgregar($(this).attr("id"), 0);
		return false;
	});

	$('#flat,#flat1').on('click', function() {
		$('#creditd').attr('type', function(index, attr) {
			return attr == 'text' ? 'password' : 'text';
		});
		$('#creditd1').attr('type', function(index, attr) {
			return attr == 'text' ? 'password' : 'text';
		});
		$('#clickme').attr('class', function(index, attr) {
			return attr == 'hide' ? '' : 'hide';
		});
		$('#clickme1').attr('class', function(index, attr) {
			return attr == 'hide' ? '' : 'hide';
		});
		$('#flat').attr('class', function(index, attr) {
			return attr == 'hide' ? 'hide' : 'hide';
		});
		$('#flat1').attr('class', function(index, attr) {
			return attr == 'hide' ? 'hide' : 'hide';
		});
		sessionStorage.setItem('ocultar', '1');
		var x = sessionStorage.ocultar;
		$.ajax({
			data: {

				"credito_visualizar": x,

			},
			url: myBaseUrlsclientecredito,
			type: "post",
			success: function(data) {


			}

		});


	});

	$('#clickme,#clickme1').on('click', function() {
		$('#creditd').attr('type', function(index, attr) {
			return attr == 'text' ? 'password' : 'text';
		});
		$('#creditd1').attr('type', function(index, attr) {
			return attr == 'text' ? 'password' : 'text';
		});
		$('#flat').attr('class', function(index, attr) {
			return attr == 'hide' ? '' : 'hide';
		});
		$('#flat1').attr('class', function(index, attr) {
			return attr == 'hide' ? '' : 'hide';
		});
		$('#clickme').attr('class', function(index, attr) {
			return attr == 'hide' ? 'hide' : 'hide';
		});
		$('#clickme1').attr('class', function(index, attr) {
			return attr == 'hide' ? 'hide' : 'hide';
		});
		sessionStorage.setItem('ocultar', '2');
		var x = sessionStorage.ocultar;
		$.ajax({
			data: {

				"credito_visualizar": x,

			},
			url: myBaseUrlsclientecredito,
			type: "post",
			success: function(data) {


			}

		});

	});

	//ATRAS CLICK IMAGEN PERFUMERIA
	$('#light_perfu').on("click", function() {
		$('.div-fragancia_search').addClass("hide");
		$('.div-fragancia').removeClass("hide");

	});
	$('.oferdiv').on("click", function() {
		var h = "IT"
		var j = "TD"
		var v = $(this).attr("data-vista");
		var x = $(this).attr("data-de");
		var w = $(this).attr("data-desc");
		var y = $(this).attr("data-des");
		var z = $(this).attr("id");
		var cat = 4;
		if (z !== " ") {
			buscarCarritosPromocion(w, x, z, v, cat, y);

		} else {
			console.log("error");

		}

	});

	//VALIDAR QUE NO SE ESCRIBAN LETRAS EN LOS INPUTS NUMERICOS
	function soloNumeros(e) {

		var key = e.keyCode || e.which,
			tecla = String.fromCharCode(key).toLowerCase(),
			numeros = "0123456789",
			especiales = [8, 37, 39, 46],
			tecla_especial = false;

		for (var i in especiales) {
			if (key == especiales[i]) {
				tecla_especial = true;
				break;
			}
		}

		if (numeros.indexOf(tecla) == -1 && !tecla_especial) {
			return false;
		}
	}


	function validarChech(e) {

		if ($("#codigobarras").is(":checked")) {
			$("#terminobuscar").focus();


		} else {



		}
	}
	
</script>
