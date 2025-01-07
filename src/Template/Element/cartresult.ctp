<div id="carrito-items" class="carrito_items">
	<table id="tabla" class="carritos_items_tabla hide ">
		<thead>
			<tr>
				<th class="carrito_item_descripcion_th">Descripción</th>
				<th class="carrito_item_cantidad_th text-center">Cant.</th>
				<th class="actions"></th>
			</tr>
		</thead>
		<table cellpadding="0" id="table" cellspacing="0" class="carritos_items_tabla  hide ">

		</table>
	</table>
	<table cellpadding="0" id="tablaprueba" cellspacing="0" class="tablaprueba0 carritos_items_tabla">
		<thead>
			<tr>
				<th class="carrito_item_descripcion_th">Descripción</th>
				<th class="carrito_item_cantidad_th text-center">Cant.</th>
				<th class="actions"></th>
			</tr>
		</thead>
		<tbody id="tablacarr">
			<?php $indice = 1000; ?>
			<?php foreach ($this->request->session()->read('carritos') as $carrito) : ?>
				<?php
				if ($carrito['descuento'] != null) {
					if ($carrito['cantidad'] < $carrito['unidad_minima']) {
						echo '<tr class="carrito_item_sinoferta" title=" Dto: ' . $carrito['descuento'] . '% Uni. Min: ' . $carrito['unidad_minima'] . ' T. Of.: ' . $carrito['tipo_oferta'] . '"id="tr' . $carrito['articulo_id'] . '">';
					} else {
						echo '<tr id="tr' . $carrito['articulo_id'] . '">';
					}
				} else {
					echo '<tr id="tr' . $carrito['articulo_id'] . '">';
				}
				?>
				<!-- descripcion -->
				<td class="carrito_item_descripcion ">
					<a class="ico" data-ean="<?php echo $carrito['articulo']['imagen']; ?>" href="#"><?= $carrito['descripcion'] ?>
						<?php //echo $this->Html->image('productos/'.$carrito['articulo']['imagen'],['class'=>'icon']); 
						?>
					</a>
					<?php if ($carrito['descuento'] != null) if ($carrito['cantidad'] < $carrito['unidad_minima']) {
						echo $this->Html->image('oferta_perdida.png', ['class' => 'off_perdida imgoferta' . $carrito['articulo_id'] . '']);
					} else {
						echo $this->Html->image('oferta_adquirida.png', ['class' => 'off_perdida imgoferta' . $carrito['articulo_id'] . '']);
					}
					?>
				</td>
				<!-- cantidad -->
				<td class="carrito_item_cantida">
					<div class=carrito_item_cantidad_2>
						<button class="btn btn-sm resta" onclick="decrement(<?php echo $carrito['articulo_id'] ?>,<?php echo $carrito['descuento_id'] ?>,<?php echo $carrito['articulo_id'] ?>,<?php echo $carrito['id'] ?>)">-</button>
						<?php
						$indice += 1;
						echo $this->Form->input('car' . $carrito['articulo_id'], ['tabindex' => $indice, 'value' => $carrito['cantidad'], 'data-pv-id' => $carrito['descuento_id'], 'data-id' => $carrito['articulo_id'], 'class' => 'formcarritocant  text-center', 'onkeypress' => 'return soloNumeros(event)', 'maxlength' => '3']);
						?>
						<button class="btn btn-sm suma" onclick="increment(<?php echo $carrito['articulo_id'] ?>,<?php echo $carrito['descuento_id'] ?>,<?php echo $carrito['articulo_id'] ?>)">+</button>
					</div>
				</td>
				<?= $this->Form->end() ?>
				<td class="carrito_item_borrar">
					<a href="#" onclick="preguntarSiNo(<?php echo $carrito['id'] ?>,<?php echo $carrito['articulo_id'] ?>)">
						<?php echo $this->Html->image('delete_ico.png', ['title' => 'Delete']); ?>
					</a>
				</td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
</div>

<script type="text/javascript">
	/*

	$('.carrito_item_descripcion').on("mouseover", function(s) {


 if(this.children[0].children[0]){
	

 }else{


var descripcion = this.children[0].innerText;
 var ean = this.children[0].dataset['ean'];
$(this).html("");
$(this).append('<a class="ico" href="#" data-ean="'+ean+'">'+descripcion+'<img src="https://www.drogueriasur.com.ar/ds/webroot/img/productos/' + ean + '"  class="icon" alt="' + ean + '"></a>');


 }


});
*/
	var count = 0;
	var countidd = 0;
	var codigobarras= "";

	$('.carrito_item_descripcion').on("mouseover", function(s) {


		if (this.children[0].children[0]) {


		} else {

			var descripcion = this.children[0].innerText;
			var ean = this.children[0].dataset['ean'];

			if (this.children[1]) {
				var oferta = this.children[1].outerHTML;
				$(this).html("");
				$(this).append('<a class="ico" href="#" data-ean="' + ean + '">' + descripcion + '<img src="https://www.drogueriasur.com.ar/ds/webroot/img/productos/' + ean + '"  class="icon" alt="' + ean + '"></a>' + oferta + '');



			} else {
				$(this).html("");
				$(this).append('<a class="ico" href="#" data-ean="' + ean + '">' + descripcion + '<img src="https://www.drogueriasur.com.ar/ds/webroot/img/productos/' + ean + '"  class="icon" alt="' + ean + '"></a>');

			}


		}


	});

	function mostrarimgproducto() {
		if (this.children[0].children[0]) {


		} else {

			var descripcion = this.children[0].innerText;
			var ean = this.children[0].dataset['ean'];

			if (this.children[1]) {
				var oferta = this.children[1].outerHTML;
				$(this).html("");
				$(this).append('<a class="ico" href="#" data-ean="' + ean + '">' + descripcion + '<img src="https://www.drogueriasur.com.ar/ds/webroot/img/productos/' + ean + '"  class="icon" alt="' + ean + '"></a>' + oferta + '');



			} else {
				$(this).html("");
				$(this).append('<a class="ico" href="#" data-ean="' + ean + '">' + descripcion + '<img src="https://www.drogueriasur.com.ar/ds/webroot/img/productos/' + ean + '"  class="icon" alt="' + ean + '"></a>');

			}

		}

	}

	$('.cantidadoferta').on("change", function() {

		var quantity = Math.round($(this).val());
		ajaxcartOferta($(this).attr("data-id"), quantity, $(this).attr("data-pv-id"), $(this).attr("data-id-input"));
	});
		$('.formcartcantt').on("change", function() {
				var idactive = $("div.active.page-number")[0].attributes.id.value;
		if ($(this).val() > 999)
		{
        $(this).html(0);
		$(this).val(0);
	    ajaxcartAgregar($(this).attr("data-id"), 0, $(this).attr("data-pv-id"), $(this).attr("data-id-input"),null);
		}else{
		var quantity = Math.round($(this).val());

		ajaxcart($(this).attr("data-id"), quantity, $(this).attr("data-pv-id"), $(this).attr("data-id-input"),null);
		}
$('.page_cart2').remove();
$('table.tablasearch').each(function () {


var currentPage = 0;
var numPerPage = 50;
var $table = $(this);
var rowCount = $('table.tablasearch tbody tr td.formcartcanttd1').length;
$table.bind('repaginate', function () {
$table.find('tbody tr').hide().slice(currentPage * numPerPage, (currentPage + 1) * numPerPage).show();
});
$table.trigger('repaginate');
var numRows = $table.find('tbody tr').length;
var numPages = Math.ceil(numRows / numPerPage);
var $pager = $('<div class="page_cart2" style="text-align: center;"></div>');


var $anterior = $('<li class="prev disabled anterior" style="border: 0px solid #ddd!important;display: inline!important;"><a disabled "href="#"onclick="anterior();">	<?php echo $this->Html->image("pag_ant.png", ["alt" => "Anterior"]); ?></a></li>');
var $case = $('<li class="prev"></li>');
var $siguiente = $('<li class="prev siguiente" style="border: 0px solid #ddd!important;display: inline!important;"><a onclick="siguiente();" onsubmit="return false;"><?php echo $this->Html->image("pag_sig.png", ["alt" => "Siguiente"]); ?></a></li>');
// var $total = $('<li class="pagination_count"><span>' + rowCount + ' Articulos</span></li>');
var $ul = $('<ul id="uli" style="display: inline-flex;flex-direction: row;flex-wrap: nowrap;align-content: center;justify-content: center;align-items: center;"class=""></ul>');
$anterior.appendTo($ul);


for (var page = 0; page < numPages; page++) {
var $linum = $('<div class="page-number" style="height: 35px;border: 0px solid #ddd!important;font-weight: 700;display: inline-flex;flex-direction: row;flex-wrap: nowrap;align-content: center;justify-content: center;align-items: center;border-radius: 4px;" id=pag' + (page + 1) + '><a></a></div>').text(page + 1).bind('click', {
newPage: page
}, function (event) {
currentPage = event.data['newPage'];
$table.trigger('repaginate');

$(this).addClass('active').siblings().removeClass('active');

$(this).addClass('colorgris').siblings().removeClass('colorgris');

}).appendTo($ul).addClass('clickeable');
}

$siguiente.appendTo($ul);

//$total.appendTo($ul);
$ul.appendTo($pager);
$pager.insertAfter($table).find('div.page-number#'+idactive+'').addClass('active colorgris');
$('#'+idactive).click();



});

		
			});
	
$('.formcarritocant,.formcartcant,.fragcant,.cantidad').on("change", function(s) {
		$('.page_cart2').remove();
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

		ajaxcartAgregar($(this).attr("data-id"), quantity, $(this).attr("data-pv-id"), $(this).attr("data-id-input"),null);
				var codigo = s.which || s.keyCode;
				
		}
	});

	/*$('.formcarritocant,.formcartcant,.formcartcantt,.fragcant,.cantidad').on("change", function() {
		if ($(this).val() > 999)
		{
        $(this).html(0);
		$(this).val(0);
	ajaxcartAgregar($(this).attr("data-id"), 0, $(this).attr("data-pv-id"), $(this).attr("data-id-input"));
		}else{
			var quantity = Math.round($(this).val());

		ajaxcartAgregar($(this).attr("data-id"), quantity, $(this).attr("data-pv-id"), $(this).attr("data-id-input"));
		}
	});*/
	function eliminarItemsFalta(s) {

		var quantity = Math.round($(s).val());

		ajaxcartAgregar($(s).attr("data-id"), quantity, $(s).attr("data-pv-id"), $(s).attr("data-id-input"),null);
		var id = $(s).attr("data-id");
		var inputdelete = $(s).attr("data-id-input");



		arti = id;
		id = "id=" + id;
		$.ajax({
			type: "post",
			url: myBaseUrldeletefalta,
			data: id,
			success: function(data) {

				if (response = "ok") {


					$('#trfalta' + arti + '').remove();

					alertify.message('').dismissOthers();
					alertify.success("Eliminado con exito!");

				} else {

					alertify.error("Fallo el servidor :(");
				}

			}
		});
	}

	$('.formcartcante').on("change", function() {
		var quantity = Math.round($(this).val());

		ajaxcartImport($(this).attr("data-id"), quantity, $(this).attr("data-pv-id"), $(this).attr("data-um"), $(this).attr("data-dscto"));



	});

	$('.formcartcant,.fragcant,.cantidad,#cart-cant').on("keypress", function(s) {

		if (s.keyCode == 13) {

			if ($('#terminobuscar').length) {
				$('#terminobuscar').html("");
				$('#terminobuscar').focus();
			} else {

				var tab = $(this).attr('tabIndex');
				ta = parseInt(tab);
				total = (ta) + parseInt(1);

				$('input[tabIndex=' + total + ']').focus();
			}
		}

		return tab;
	});
$('.formcartcant').on("keydown", function(s) {
					  var codigo = event.which || event.keyCode;
    if(codigo >= 65 && codigo <= 90){
		$('#terminobuscar').focus();
			$('#terminobuscar').val(String.fromCharCode(codigo));
    }

		});
	$('.formcartcant,.formcartcantfaltas,.fragcant,.cantidad,#cart-cant').on("keydown", function(s) {

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

	//TABULACION CON TECLA ENTER 
	$('.formcartcant,.formcartcantfaltas,.formcarritocant,.fragcant,.cantidad').on("keypress", function(s) {
		var tab = $(this).attr('tabIndex');
		if (s.keyCode == 40 || s.keyCode == 38 || s.keyCode == 18 || s.keyCode == 9) {
			ta = parseInt(tab);
			total = (ta) + parseInt(1);
			if ($("#tab" + total).length) {

				$("#tab" + total).focus();

			} else {

				$("#tab2").focus();
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
	//PREGUNTAR SI SE ELIMINA UN ITEM DEL CARRITO
	function preguntarSiNo(id, arti) {
		alertify.confirm('Eliminar Datos', '¿Esta seguro de eliminar este Articulo?',
			function() {
				eliminarDatos(id, arti)
			},
			function() {
				alertify.error('Se cancelo la operación')

			}).set('labels', {
			ok: 'Ok',
			cancel: 'Cancelar'
		});
	}

		function preguntarSiNoFaltas(id, arti) {
		alertify.confirm('Eliminar Datos', '¿Esta seguro de eliminar este Articulo?',
			function() {
				eliminarDatosFaltas(id, arti)
			},
			function() {
				alertify.error('Se cancelo la operación')

			}).set('labels', {
			ok: 'Ok',
			cancel: 'Cancelar'
		});
	}

	//PREGUNTAR SI SE ELIMINA UN ITEM DEL CARRITO
	function preguntarSiNoMenos(id, arti) {
		alertify.confirm('Eliminar Datos', '¿Esta seguro de eliminar este Articulo?',
			function() {
				eliminarDatos(id, arti)

			},
			function() {
				alertify.error('Se cancelo la operación')
				document.getElementById('car' + arti).value++;

				$('input[data-id=' + arti + ']').val("1");
			}).set('labels', {
			ok: 'Ok',
			cancel: 'Cancelar'
		});
	}


	//PREGUNTAR SI SE ELIMINA UN ITEM DEL CARRITO
	function preguntarSiNoMenosImport(id, arti) {
		alertify.confirm(
			"Eliminar Datos",
			"¿Esta seguro de eliminar este Articulo?",
			function() {
				eliminarItemsTemps(id, arti);
			},
			function() {
				alertify.error("Se cancelo la operación");
				document.querySelector("[data-valor=ca" + arti + "]").value++;
				$("input[data-valor=ca" + arti + "]").val("1");
			}
		).set('labels', {
			ok: 'Ok',
			cancel: 'Cancelar'
		});
	}
	//PREGUNTAR SI SE ELIMINAN LOS ARTICULOS DEL CARRITO
	function preguntarSI(id, val) {
		alertify.confirm('Eliminar Datos', '¿Esta seguro de eliminar los Articulos del carrito?',
			function() {
				var valor = $('#openerts').attr('data-value');

				if (valor == 0) {
					alertify.error("El Carrito Esta Vacio, No Se Puede Eliminar.");

				} else {
					vaciarCarrito(id);
				}


				//aca llamaremos a la funcion



			},
			function() {
				alertify.error('Se cancelo la operación')
			}).set('labels', {
			ok: 'Ok',
			cancel: 'Cancelar'
		});
	}
	//INCREMENTAR VALOR NUMERICO AL PRESIONAR EL "+" DEL CARRITO
	function increment(id, di, d) {

		id = "" + id;
		document.getElementById('car' + id).value++;
		var quantity = $("#car" + id).val();
		ajaxcart(d, quantity, di);

		//alertify.success("Cantidad Agregada Con Exito!");


	}




	//DECREMENTAR VALOR NUMERICO AL PRESIONAR EL BUTTON AGREGAR EN IMPORTRESUL
	function decrementImport(id, di, d, idcarrotemp, um, dcto) {
		id = "" + id;
		document.querySelector('[data-valor="ca' + id + '"]').value--;
		var quantity = $("input[data-valor=ca" + id + "]").val();
		//alertify.success("Cantidad Eliminada Con Exito!");
		if (quantity == 0) {
			$('input[data-valor="ca' + id + '"]').val("");
			preguntarSiNoMenosImport(idcarrotemp, id);
		} else {
			ajaxcartImport(d, quantity, di, um, dcto);
			$('input[data-valor="ca' + id + '"]').val(quantity);
		}
	}
	//INCREMENTAR VALOR NUMERICO AL PRESIONAR EL BUTTON AGREGAR EN IMPORTRESULT
	function incrementImport(id, di, d, um, dcto) {
		id = "" + id;
		document.querySelector('[data-valor="ca' + id + '"]').value++;
		var quantity = $("input[data-valor=ca" + id + "]").val();

		ajaxcartImport(d, quantity, di, um, dcto);
	}

	//INCREMENTAR VALOR NUMERICO AL PRESIONAR EL BUTTON AGREGAR EN ESTETICA
	function incrementEstetica(id, di, d) {
		id = id;

		document.getElementById('bu' + id).value++;
		var quantity = $("#bu" + id).val();

		ajaxcartOferta(d, quantity, di);

	}
	//INCREMENTAR VALOR NUMERICO AL PRESIONAR EL BUTTON AGREGAR EN FARMAPOINT
	function incrementFarmapoint(id, di, d) {
		id = id;

		document.getElementById('bu' + id).value++;
		var quantity = $("#bu" + id).val();


		ajaxcartOferta(d, quantity, di);

	}
	//INCREMENTAR VALOR NUMERICO AL PRESIONAR EL BUTTON AGREGAR EN CARRITOS SECTOR MES

	//INCREMENTAR VALOR NUMERICO AL PRESIONAR EL BUTTON "+" EN VIEW CARRITOS 
	function incrementCarritos(id, di, d) {
		id = id;

		var quantity = $('#bu' + id).attr("data-value");
		var suma = parseFloat(quantity) + parseFloat(1);
		$('#bu' + id).attr("data-value", suma);

		var datos = $('#bu' + id).attr("data-value");
		ajaxcartOferta(d, quantity, di);


	}
	//DECREMENTAR VALOR NUMERICO AL PRESIONAR EL "-" DEL CARRITO
	function decrement(id, di, d, idcarro) {
		id = "" + id;
		document.getElementById('car' + id).value--;
		var quantity = $("#car" + id).val();

		//alertify.success("Cantidad Eliminada Con Exito!");

		if (quantity == 0) {

			$('input[data-id=' + id + ']').val("");
			preguntarSiNoMenos(idcarro, id);

		} else {

			ajaxcart(d, quantity, di);
			$('input[data-id=' + id + ']').val(quantity);
		}

	}
	//INCREMENTAR VALOR NUMERICO AL PRESIONAR EL BUTTON "-" EN VIEW CARRITOS 
	function decrementCarritoView(id, di, d, idcarro) {
		id = "" + id;
		document.getElementById('' + id).value--;
		var quantity = $("#" + id).val();

		//alertify.success("Cantidad Eliminada Con Exito!");

		if (quantity == 0) {

			$('input[data-id=' + id + ']').val("");
			idcarro = idcarro;
			d = d;
			preguntarSiNoMenos(idcarro, d);

		} else {

			$('input[data-id=' + id + ']').val(quantity);
			ajaxcart(d, quantity, di);
		}

	}

	//VACIAR CARRITOS 

	//CERRAR MENSAJE DE ALERTA POR NO TENER PRIVILEGIOS
	function cerrarDiv() {
		$('#__notifyBar4826526').remove();
	}

	//ACTUALIZAR ITEMS AL CARRITO

	function Paginacioncar() {
		$('table.tablasearch').each(function() {
	var currentPage = 0;
    var numPerPage = 100;
    var $table = $(this);
    var $thead = $table.find('thead');
    var $tbody = $table.find('tbody');
    var rowCount = $tbody.find('tr').length;

    function showCurrentPage() {
        var startIndex = currentPage * numPerPage;
        var endIndex = startIndex + numPerPage;
        $tbody.find('tr').hide().slice(startIndex, endIndex).show();
    }

    $table.on('repaginate', function () {
        showCurrentPage();
    });

    $table.trigger('repaginate');

    var numRows = rowCount;
			var numPages = Math.ceil(numRows / numPerPage);
			var $pager = $('<div class="page_cart1"></div>');
			var $anterior = $('<li class="prev disabled anterior"><a disabled "href="page_cart1#"onclick="anterior();">Anterior</a></li>');
			var $case = $('<li class="prev"></li>');
			var $siguiente = $('<li class="prev siguiente"><a onclick="siguiente();" onsubmit="return false;">Siguiente></a></li>');
			var $total = $('<li class="pagination_count"><span>' + rowCount + ' Articulos</span></li>');
			var $ul = $('<ul id="uli" style="display: inline-flex;" class="pagination"></ul>');
			$anterior.appendTo($ul);

			for (var page = 0; page < numPages; page++) {
				var $linum = $('<div class="page-number" id=pag' + (page + 1) + '><a></a></div>').text(page + 1).bind('click', {
					newPage: page
				}, function(event) {
					currentPage = event.data['newPage'];
					$table.trigger('repaginate');

					$(this).addClass('active').siblings().removeClass('active');
				}).appendTo($ul).addClass('clickeable');
			}
			$siguiente.appendTo($ul);

			$total.appendTo($ul);
			$ul.appendTo($pager);
			$pager.insertAfter($table).find('div.page-number:first').addClass('active');
		});

	}

	function sortdescripcion() {
		var tabla = document.querySelectorAll("tbody.ajuste tr ");
		var keys = Object.keys(tabla);
		var terminosort = keys.sort(function(a, b) {
			return b - a;
		});

		for (var i = 0; i < keys.length; i++) {
			$('.ajuste').append(tabla[keys[i]]);

			//console.log( keys[i], tabla[ keys[i] ] );

		}
	}

	function Paginacion() {

		$('form#formaddcart').each(function() {


			var currentPage = 0;
			var numPerPage = 200;
			var $table = $(this);
			var rowCount = $('form tbody tr td.formcartcanttd').length;
			$table.bind('repaginate', function() {
				$table.find('tr').hide().slice(currentPage * numPerPage, (currentPage + 1) * numPerPage).show();
			});
			$table.trigger('repaginate');
			var numRows = $table.find('tbody tr').length;
			var numPages = Math.ceil(numRows / numPerPage);
			var $pager = $('<div class="page_cart1"></div>');


			var $anterior = $('<li class="prev disabled anterior"><a disabled "href="page_cart1#"onclick="anterior();">Anterior</a></li>');
			var $case = $('<li class="prev"></li>');
			var $siguiente = $('<li class="prev siguiente"><a onclick="siguiente();" onsubmit="return false;">Siguiente></a></li>');
			var $total = $('<li class="pagination_count"><span>' + rowCount + ' Articulos</span></li>');
			var $ul = $('<ul id="uli" style="display: inline-flex;" class="pagination"></ul>');
			$anterior.appendTo($ul);


			for (var page = 0; page < numPages; page++) {
				var $linum = $('<div class="page-number" id=pag' + (page + 1) + '><a></a></div>').text(page + 1).bind('click', {
					newPage: page
				}, function(event) {
					currentPage = event.data['newPage'];
					$table.trigger('repaginate');

					$(this).addClass('active').siblings().removeClass('active');
				}).appendTo($ul).addClass('clickeable');
			}




			$siguiente.appendTo($ul);

			$total.appendTo($ul);
			$ul.appendTo($pager);
			$pager.insertAfter($table).find('div.page-number:first').addClass('active');



		});

	}

	function Paginacioncarcar() {

		$('table.tablasearch').each(function() {


			var currentPage = 0;
			var numPerPage = 50;
			var $table = $(this);
			var rowCount = $('table.tablasearch tbody tr td.formcartcanttd1').length;
			$table.bind('repaginate', function() {
				$table.find('tr').hide().slice(currentPage * numPerPage, (currentPage + 1) * numPerPage).show();
			});
			$table.trigger('repaginate');
			var numRows = $table.find('tbody tr').length;
			var numPages = Math.ceil(numRows / numPerPage);
			var $pager = $('<div class="page_cart1"></div>');


			var $anterior = $('<li class="prev disabled anterior"><a disabled "href="#"onclick="anterior();">Anterior</a></li>');
			var $case = $('<li class="prev"></li>');
			var $siguiente = $('<li class="prev siguiente"><a onclick="siguiente();" onsubmit="return false;">Siguiente></a></li>');
			var $total = $('<li class="pagination_count"><span>' + rowCount + ' Articulos</span></li>');
			var $ul = $('<ul id="uli" style="display: inline-flex;" class="pagination"></ul>');
			$anterior.appendTo($ul);


			for (var page = 0; page < numPages; page++) {
				var $linum = $('<div class="page-number" id=pag' + (page + 1) + '><a></a></div>').text(page + 1).bind('click', {
					newPage: page
				}, function(event) {
					currentPage = event.data['newPage'];
					$table.trigger('repaginate');

					$(this).addClass('active').siblings().removeClass('active');
				}).appendTo($ul).addClass('clickeable');
			}




			$siguiente.appendTo($ul);

			$total.appendTo($ul);
			$ul.appendTo($pager);
			$pager.insertAfter($table).find('div.page-number:first').addClass('active');



		});

	}

	function siguiente() {

		var $divs = $(".page-number.clickeable").toArray().length;
		var regex = /(\d+)/g;
		const page = document.querySelector(".page-number.clickeable.active").getAttribute("id");
		pagenext = parseInt(page.match(regex)) + (1);
		if ($divs == pagenext) {
			$('.siguiente').addClass("disabled");
		}
		$('.page-number.clickeable#pag' + pagenext).click()
		$('.anterior').removeClass("disabled");
		$('#ubicacion').focus();



	}

	function anterior() {
		var $divs = $(".page-number.clickeable").toArray().length;
		var regex = /(\d+)/g;
		const page = document.querySelector(".page-number.clickeable.active").getAttribute("id");
		pagenext = parseInt(page.match(regex)) - (1);

		$('.siguiente').removeClass("disabled");
		$('.page-number.clickeable#pag' + pagenext).click()
		if (pagenext == 1) {
			$('.anterior').addClass("disabled");

		}
		$('#ubicacion').focus();

	}
	$('.tablaprueba0').each(function() {
		var currentPage = 0;
		var numPerPage = 10;
		var $table = $(this);
		$table.bind('repaginate', function() {
			$table.find('tbody tr').hide().slice(currentPage * numPerPage, (currentPage + 1) * numPerPage).show();
		});
		$table.trigger('repaginate');
		var numRows = $table.find('tbody tr').length;
		var numPages = Math.ceil(numRows / numPerPage);
		var $pager = $('<div class="page_cart"></div>');
		for (var page = 0; page < numPages; page++) {
			$('<div class="page-number"></div>').text(page + 1).bind('click', {
				newPage: page
			}, function(event) {
				currentPage = event.data['newPage'];
				$table.trigger('repaginate');
				$(this).addClass('active').siblings().removeClass('active');
			}).appendTo($pager).addClass('clickable');
		}
		$pager.insertAfter($table).find('div.page-number:first').addClass('active');
	});


	function sortTableviewp(n, tabla, tbody) {
		var main = document.querySelectorAll('#' + tabla + ' tbody tr');
		var maintable = document.getElementById(tbody);

		if (dir == "asc") {
			[].map.call(main, Object).sort(function(a, b) {
				return +a.cells[n].textContent.replace(/[^,0-9]/g, '').replace(/,/g, '.').match(/\d+/) - +b.cells[n].textContent.replace(/[^,0-9]/g, '').replace(/,/g, '.').match(/\d+/);
			}).forEach(function(elem) {
				maintable.appendChild(elem);
			});

			dir = "desc";
		} else {
			[].map.call(main, Object).sort(function(a, b) {
				return +b.cells[n].textContent.replace(/[^,0-9]/g, '').replace(/,/g, '.').match(/\d+/) - +a.cells[n].textContent.replace(/[^,0-9]/g, '').replace(/,/g, '.').match(/\d+/);
			}).forEach(function(elem) {
				maintable.appendChild(elem);
			});
			dir = "asc";
		}

		var active = $('#uli .active');

		active[0].click();

	}


	function sort_descripcion(n, tabla, tbody) {
		var main = document.querySelectorAll('#' + tabla + ' tbody tr');
		var maintable = document.getElementById(tbody);

		if (dir == "desc") {
			[].map.call(main, Object).sort(function(a, b) {

				return (
					a.cells[n].textContent
					.toUpperCase()
					.localeCompare(
						b.cells[n].textContent.toUpperCase()
					)
				);
			}).forEach(function(elem) {
				maintable.appendChild(elem);
			});

			dir = "asc";
		} else {
			[].map.call(main, Object).sort(function(a, b) {
				return (
					b.cells[n].textContent
					.toUpperCase()
					.localeCompare(
						a.cells[n].textContent.toUpperCase()
					)
				);

			}).forEach(function(elem) {
				maintable.appendChild(elem);
			});
			dir = "desc";
		}

		var active = $('#uli .active');

		active[0].click();
	}

	function incrementCarritosMes(id, di, d) {
		id = id;

		d = "" + d;
		var quantity = $("#ofert" + d).val();
		ajaxcartOferta(d, quantity, di);
	}

	function incrementOfertas(id, di, d) {

		id = "" + id;


		document.getElementById("ofert" + id).value++;
		var quantity = $("#ofert" + id).val();
		$("input[data-id=" + id + "]").val(quantity);
		ajaxcartOferta(d, quantity, di);
	}

	function decrementOfertas(id, di, d) {
		id = "" + id;
		document.getElementById("ofert" + id).value--;
		var quantity = $("#ofert" + id).val();

		if (Math.sign(quantity) == -1) {

			quantity = 0;

		}
		//alertify.success("Cantidad Eliminada Con Exito!");

		if (quantity == 0) {
			$("input[data-id=" + id + "]").val(0);
			ajaxcartOferta(d, quantity, di);
			// preguntarSiNoMenos(idcarro, id);
		} else {
			// ajaxcart(d, quantity, di);
			$("input[data-id=" + id + "]").val(quantity);
			$("input[data-id=" + id + "]").html(quantity);
			ajaxcartOferta(d, quantity, di);
		}


	}

	var cont = 0;

/*
	functime();

	function functime() {
		var hora = new Date().getMinutes();
		restante = (75 - hora) * 60000;


		let timefunction = setTimeout(updateFaltas, restante);
	}

	function updateFaltas() {
		$.ajax({
			type: "post",
			url: myBaseUrlsUpdateFalta,
			dataType: "json",
			success: function(response) {
				
				$('.notificacionfaltacantidad').text(response.notificacionfalta);

			functime();
			}
		});
	}

*/

function eliminarDatosFaltas(id, arti) {

		articulo_id = "id=" + arti;


		$.ajax({
			type: "post",
			url: myBaseUrldeletefalta,
			data: articulo_id,
			dataType: "json",
			success: function(response) {
				console.log(response);
				if (response.responseText = "ok") {

					$('tr[id=trfalta' + arti + ']').remove();

					alertify.message('').dismissOthers();
					alertify.success("Eliminado con exito!");




					$('.page_cart').remove();
					$('table.table-striped').each(function() {
						var currentPage = 0;
						var numPerPage = 10;
						var $table = $(this);
						$table.bind('repaginate', function() {
							$table.find('tr').hide().slice(currentPage * numPerPage, (currentPage + 1) * numPerPage).show();
						});
						$table.trigger('repaginate');
						var numRows = $table.find('tr').length;
						var numPages = Math.ceil(numRows / numPerPage);
						var $pager = $('<div class="page_cart"></div>');
						for (var page = 0; page < numPages; page++) {
							$('<div class="page-number"></div>').text(page + 1).bind('click', {
								newPage: page
							}, function(event) {
								currentPage = event.data['newPage'];
								$table.trigger('repaginate');
								$(this).addClass('active').siblings().removeClass('active');
							}).appendTo($pager).addClass('clickable');
						}
						$pager.insertAfter($table).find('div.page-number:first').addClass('active');
					});

					$(' #tablaprueba').each(function() {
						var currentPage = 0;
						var numPerPage = 10;
						var $table = $(this);
						$table.bind('repaginate', function() {
							$table.find('tr').hide().slice(currentPage * numPerPage, (currentPage + 1) * numPerPage).show();
						});
						$table.trigger('repaginate');
						var numRows = $table.find('tr').length;
						var numPages = Math.ceil(numRows / numPerPage);
						var $pager = $('<div class="page_cart"></div>');
						for (var page = 0; page < numPages; page++) {
							$('<div class="page-number"></div>').text(page + 1).bind('click', {
								newPage: page
							}, function(event) {
								currentPage = event.data['newPage'];
								$table.trigger('repaginate');
								$(this).addClass('active').siblings().removeClass('active');
							}).appendTo($pager).addClass('clickable');
						}
						$pager.insertAfter($table).find('div.page-number:first').addClass('active');
					});
				} else {

					alertify.error("Fallo el servidor :(");
				}


			}
		});
	}

		function saveconditions(s){
			$.ajax({
			type: "post",
			url: myBaseUrlsaveconditions,
			data: {conditions:s},
			dataType: "json",
			success: function(response) {
				if (response.save = 1) {
					alertify.success("Aceptaste los términos.");
				} else {
					alertify.error("Fallo el servidor :(");
				}

			}
		});
	}
</script>