
<div id="carrito-items" class="carrito_items ">

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
			<?php $indice = 13; ?>
			<?php foreach ($carritos as $carrito) : ?>
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
					<?= $carrito['descripcion'] ?>
				</td>
				<!-- cantidad -->

				<td class="carrito_item_cantida">
					<button class="btn btn-sm resta" onclick="decrement(<?php echo $carrito['articulo_id'] ?>,<?php echo $carrito['descuento_id'] ?>,<?php echo $carrito['articulo_id'] ?>,<?php echo $carrito['id'] ?>)">-</button>

					<?php
					$indice += 1;
					echo $this->Form->input('car' . $carrito['articulo_id'], ['tabindex' => $indice, 'value' => $carrito['cantidad'], 'data-pv-id' => $carrito['descuento_id'], 'data-id' => $carrito['articulo_id'], 'class' => 'formcarritocant  text-center', 'onkeypress' => 'return soloNumeros(event)', 'maxlength' => '3']);

					?>


					<button class="btn btn-sm suma" onclick="increment(<?php echo $carrito['articulo_id'] ?>,<?php echo $carrito['descuento_id'] ?>,<?php echo $carrito['articulo_id'] ?>)">+</button>

				</td>

				<?= $this->Form->end() ?>
				<td class="c">
					<a href="#" onclick="preguntarSiNo(<?php echo $carrito['id'] ?>,<?php echo $carrito['articulo_id'] ?>)"><img src="/ds3/img/delete_ico.png" alt=""></a>

				</td>

				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
</div>

<script type="text/javascript">

	$('.cantidadoferta').on("change", function() {

		var quantity = Math.round($(this).val());


		ajaxcartOferta($(this).attr("data-id"), quantity, $(this).attr("data-pv-id"), $(this).attr("data-id-input"));


	});
	$('.formcarritocant,.formcartcant,.fragcant,.cantidad').on("change", function() {
		var quantity = Math.round($(this).val());

		ajaxcartAgregar($(this).attr("data-id"), quantity, $(this).attr("data-pv-id"), $(this).attr("data-id-input"));

	});
	$('.formcartcante').on("change", function() {
		var quantity = Math.round($(this).val());

		ajaxcartImport($(this).attr("data-id"), quantity, $(this).attr("data-pv-id"), $(this).attr("data-id-input"));

	});

	//TABULACION CON TECLA ENTER 
	$('.formcartcant,.formcarritocant,.fragcant,.cantidad').on("keypress", function(s) {
		var tab = $(this).attr('tabIndex');
		if (s.keyCode == 13 || s.keyCode == 40 || s.keyCode == 38 || s.keyCode == 18 || s.keyCode == 9) {
			ta = parseInt(tab);
			total = (ta) + parseInt(2);
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
	//BUSQUEDA CHANGE BUSCAR CARRITOS 
	$('#terminobuscar').on("change", function(event) {

		$("#elSpan").text("");
		if ($('#terminobuscar').val() == 0 && $('#monodroga-id').val() == 0 && $('#accionfar-id').val() == 0 && $('#laboratorio-id').val() == 0 && $('#ofertas ').val() == 0) {
			$("#mydivbuscar").removeClass("hide");
			$("#footinteresarte").removeClass("hide");
			$("#foot").addClass("hide");
			$(".page_cart1").remove();
		} else {
			if ($('#terminobuscar').val() == 0) {
				clickbusqueda()
			}

		}
	});

	//BUSQUEDA CLICK IMAGEN LAB NUTRICION
	$('.nutricionmarcadiv').on("click", function(event) {
		var s = $(this).attr("id");
		BusquedaNutricion(s);

	});
	//BUSQUEDA CLICK IMAGEN PERFUMERIA
	$('.fraganciamarcadiv').on("click", function(event) {
		var s = $(this).attr("id");
		BusquedaPerfumeriaImg(s);

	});
	//BUSQUEDA CLICK IMAGEN DERMO
	$('.dermomarcadiv').on("click", function(event) {
		var s = $(this).attr("id");
		BusquedaDermoImg(s);

	});
	//BUSQUEDA CLICK IMAGEN PRODMEDICO
	$('.divprodm').on("click", function(event) {
		var s = $(this).attr("id");
		BusquedaPromedicoImg(s);

	});

	//CAMBIO EN SELEC TRANSFER 
	$('.transferselect').on("change", function(event) {
		var s = $(this).val();

		if ($(this).val() == 0) {
			if ($('.terminobuscartransfer').val() == 0) {
				$('.gallery-contenedor_search').addClass("hide");
				$('.gallery-contenedor').removeClass("hide");
				//alert("ambos no tienen valores")


			} else {


				BusquedaTransferSelect(s);
			}
		} else {


			BusquedaTransferSelect(s);
			//alert("el select tiene un valor mayor a 0")

		}


	});

	//CAMBIO EN SELEC NUTRICION
	$('.marca-id').on("change", function(event) {
		var s = $(this).val();

		if ($(this).val() == "Marcas") {
			if ($('#terminobuscar').val() == 0) {
				$('.nutricion_div_marcas_search').addClass("hide");
				$('.nutricion_div_marcas').removeClass("hide");
				//alert("ambos no tienen valores")


			} else {


				clickBusquedaNutricion();
			}
		} else {


			clickBusquedaNutricion();
			//alert("el select tiene un valor mayor a 0")

		}


	});

	//CAMBIO EN SELECT MARCA Y GENERO PERFUMERIA
	$('.marca-id-perfu,.genero-id-perfu').on("change", function(event) {
		if ($('#terminobuscarfragancia').val() == 0 && $('.marca-id-perfu').val() == 0 && $('.genero-id-perfu').val() == 0) {
			$('.div-fragancia_search').addClass("hide");
			$('.div-fragancia').removeClass("hide");
			//alert("ambos no tienen valores")


		} else {
			BusquedaPerfumeriaSelect();
		}
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
	//CAMBIO EN SELECT PRODMEDICO
	$('.prodmedicoid').on("change", function(event) {
		if ($('.terminobuscarprodmed').val() == 0 && $('.prodmedicoid').val() == 0) {
			$('.prodmcontenedor_search').addClass("hide");
			$('.prodmcontenedor').removeClass("hide");


		} else {
			BusquedaPromedicoSelect();
		}
	});

	//CAMBIO EN INPUT PRODMEDICO
	$('#terminobuscarprodmed').on("keyup", function(event) {
		if ($('.terminobuscarprodmed').val() == 0 && $('.prodmedicoid').val() == 0) {
			$('.prodmcontenedor_search').addClass("hide");
			$('.prodmcontenedor').removeClass("hide");
		} else {
			if ($('.terminobuscarprodmed').val() == 0)

			{
				BusquedaPromedicoSelect();

			} else {
				BusquedaPromedicoEnter();

			}

		}
	});

	//CAMBIOS EN INPUT PERFUMERIA
	$('#terminobuscarfragancia').on("change", function(event) {
		if ($('#terminobuscarfragancia').val() == 0 && $('.marca-id-perfu').val() == 0 && $('.genero-id-perfu').val() == 0) {
			$('.div-fragancia_search').addClass("hide");
			$('.div-fragancia').removeClass("hide");
			//alert("ambos no tienen valores")


		} else {
			BusquedaPerfumeriaEnter();
		}
	});
	//CAMBIO EN SELECT DERMO PROXIMAMENTE
	$('.dermomarca_id,.dermogrupo_id,.dermosubgrupo_id').on("change", function(event) {
		if ($('#terminobuscardermo').val() == 0 && $('#marca-id').val() == 0 && $('#grupo-id').val() == 0 && $('#subgrupo-id').val() == 0) {
			$('.dermocontenedor_search').addClass("hide");
			$('.dermocontenedor').removeClass("hide");
			//alert("ambos no tienen valores")


		} else {
			BusquedaDermoSelect();
		}
	});
	//CHANGE EN INPUT DERMO PROXIMAMENTE
	$('#terminobuscardermo').on("change", function(event) {
		if ($('#terminobuscardermo').val() == 0 && $('#marca-id').val() == 0 && $('#grupo-id').val() == 0 && $('#subgrupo-id').val() == 0) {
			$('.dermocontenedor_search').addClass("hide");
			$('.dermocontenedor').removeClass("hide");
		} else {
			BusquedaDermoEnter();
		}
	});
	//FOCUS BUSCAR TRANSFER 
	$('.terminobuscartransfer').on("blur", function(event) {
		if ($('.terminobuscartransfer').val().length == 0) {
			if ($('.transferselect').val().length == 0) {
				$('.gallery-contenedor_search').addClass("hide");
				$('.gallery-contenedor').removeClass("hide");
			} else {

				var s = $('.transferselect').val();

				BusquedaTransferSelect(s);

			}
		} else {

			EnterBusquedaTransfer();


		}

	});
	//FOCUS BUSCAR TRANSFER 
	$('.terminobuscarnutri').on("blur", function(event) {
		if ($('.terminobuscarnutri').val().length == 0) {
			if ($('.marca-id').val().length == 0) {
				$('.nutricion_div_marcas_search').addClass("hide");
				$('.nutricion_div_marcas').removeClass("hide");
			} else {

				var s = $('.marca-id').val();

				clickBusquedaNutricion(s);

			}
		} else {

			EnterBusquedaNutricion();


		}

	});
	//REGRESAR BUSQUEDA CLICK IMAGEN NUTRICION
	$('#light').on("click", function() {
		$('#nutricion_div_marcas').removeClass("hide");
		$('#mydivBuscar').addClass("hide");

	});

	//BUSQUEDA CLICK IMAGEN LAB TRANSFER
	$('.transferimg').on("click", function(event) {
		var s = $(this).attr("id");

		BusquedaTransferImg(s);

	});

	$('.colstockpat').on("click", function(event) {
		var a = true;
		var b = "tablasearch";
		var c = "varptable";

		sort(a, b, c);

	});

	//VALIDAR SI SE TILDA O DESTILDA EL LECTOR DE BARRA
	function validarChech(e) {

		if ($("#codigobarras").is(":checked")) {
			$("#monodroga-id").prop("disabled", true);
			$("#accionfar-id").prop("disabled", true);
			$("#laboratorio-id").prop("disabled", true);
			$("#ofertas").prop("disabled", true);
			$("#terminobuscar").attr("id", "checkbar");
			$("#terminobuscar").val("");
			$("#checkbar").attr("placeholder", "Escanear codigo de barra");
			$("#checkbar").focus();
			$("#checkbar").val("");
			$("#elSpan").text("");
			$("#checkbar").keyup(function(e) {

				var code = (e.keyCode ? e.keyCode : e.which);
				if (code == 13) {

					validarChechenter();
				}

			});



		} else {
			$("#monodroga-id").prop("disabled", false);
			$("#accionfar-id").prop("disabled", false);
			$("#laboratorio-id").prop("disabled", false);
			$("#ofertas").prop("disabled", false);
			$("#checkbar").attr("id", "terminobuscar");
			$("#terminobuscar").attr("placeholder", "Buscar Producto");

			$("#mydivbuscar").removeClass("hide");
			$("#footinteresarte").removeClass("hide");
			$("#foot").addClass("hide");


		}
	}
	//VALIDAR SI APRETA TECLA ENTER EN EL LECTOR DE BARRA
	function validarChechenter() {

		buscarBarra();
		$("#checkbar").val("");


	}
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
	//PREGUNTAR SI SE ELIMINA UN ITEM DEL CARRITO
	function preguntarSiNo(id, arti) {
		alertify.confirm('Eliminar Datos', '¿Esta seguro de eliminar este Articulo?',
			function() {
				eliminarDatos(id, arti)
			},
			function() {
				alertify.error('Se cancelo la operación')

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
			});
	}

	//PREGUNTAR SI SE ELIMINA UN ITEM DEL CARRITO
	function preguntarSiNoMenosImport(id, arti) {
		alertify.confirm('Eliminar Datos', '¿Esta seguro de eliminar este Articulo?',
			function() {
				eliminarItemsTemps(id, arti)

			},
			function() {
				alertify.error('Se cancelo la operación')
				document.querySelector('[data-valor=ca' + arti + ']').value++;
				$('input[data-valor=ca' + arti + ']').val("1");
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

	function incrementImport(id, di, d) {

		id = "" + id;

		document.querySelector('[data-valor="ca' + id + '"]').value++;
		var quantity = $('input[data-valor=ca' + id + ']').val();

		ajaxcartImport(d, quantity, di);

	}

	function decrementImport(id, di, d, idcarrotemp) {
		id = "" + id;
		document.querySelector('[data-valor="ca' + id + '"]').value--;
		var quantity = $('input[data-valor=ca' + id + ']').val();

		//alertify.success("Cantidad Eliminada Con Exito!");

		if (quantity == 0) {

			$('input[data-valor="ca' + id + '"]').val("");
			preguntarSiNoMenosImport(idcarrotemp, id);

		} else {

			ajaxcartImport(d, quantity, di);
			$('input[data-valor="ca' + id + '"]').val(quantity);
		}

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
	function incrementCarritosMes(id, di, d) {
		id = id;

		d = "" + d;
		document.getElementById('bar' + d).value++;
		var quantity = $("#bar" + d).val();
		ajaxcartOferta(d, quantity, di);



	}
	//INCREMENTAR VALOR NUMERICO AL PRESIONAR EL BUTTON "+" EN VIEW CARRITOS 
	function incrementCarritos(id, di, d) {
		id = id;

		var quantity = $('#bu' + id).attr("data-value");
		var suma = parseFloat(quantity) + parseFloat(1);
		$('#bu' + id).attr("data-value", suma);
		s
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
	function decrementCarritoView(id, di, d,idcarro) {
		id = "" + id;
		document.getElementById('' + id).value--;
		var quantity = $("#" + id).val();

		//alertify.success("Cantidad Eliminada Con Exito!");

		if (quantity == 0) {
		
			$('input[data-id=' + id + ']').val("");
			idcarro=idcarro;
			d=d;
			preguntarSiNoMenos(idcarro,d);

		} else {
			
			$('input[data-id=' + id + ']').val(quantity);
			ajaxcart(d, quantity, di);
		}
		
	}
	//ELIMINAR ITEMS DEL CARRITOS 
	function eliminarDatos(id, arti) {

		id = "id=" + id;
		arti = arti;

		$.ajax({
			type: "post",
			url: "<?php echo \Cake\Routing\Router::url(array('controller' => 'Carritos', 'action' => 'delete')); ?>",
			data: id,
			arti,
			dataType: "json",
			success: function(data, response) {

				if (response = "ok") {
					var numero = data.subtotal[1];
					const noTruncarDecimales = {
						maximumFractionDigits: 2,
						minimumFractionDigits: 2
					};
					ptos = numero.toLocaleString('es', noTruncarDecimales);


					$('input[data-id=' + arti + ']').val("");
					$('tr[id=tr' + arti + ']').remove();

					if ($('tr[id=trBody' + arti + ']').length) {
						$('tr[id=trBody' + arti + ']').remove();
					}

					if (data.subtotal[3] >= 100) {
						document.getElementById('openerts').innerHTML = "+99";
						document.getElementById('modalitems').innerHTML = data.subtotal[0] + "/" + data.subtotal[3];
						if ($("#modalitems1").length) {
							document.getElementById('modalitems1').innerHTML = data.subtotal[0] + "/" + data.subtotal[3];
						}
						if ($('#unidades').length) {
							document.getElementById('unidades').innerHTML = data.subtotal[0] + "/" + data.subtotal[3];
						}

					} else {
						document.getElementById('openerts').innerHTML = data.subtotal[3];
						document.getElementById('modalitems').innerHTML = data.subtotal[0] + "/" + data.subtotal[3];
						if ($("#modalitems1").length) {
							document.getElementById('modalitems1').innerHTML = data.subtotal[0] + "/" + data.subtotal[3];
						}

						if ($('#unidades').length) {
							document.getElementById('unidades').innerHTML = data.subtotal[0] + "/" + data.subtotal[3];
						}
					}
					$("#carrito_importe_view").html("$ " + ptos);
					$("#carrito_importe").html("$ " + ptos);
					$("#carrito_importe1").html("$ " + ptos);
					if ($("#modalitems1").length) {
						document.getElementById('modalitems1').innerHTML = data.subtotal[0] + "/" + data.subtotal[3];
					}


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

	function eliminarItemsTemps(id, arti) {

		id = "id=" + id;
		arti = arti;

		$.ajax({
			type: "post",
			url: "<?php echo \Cake\Routing\Router::url(array('controller' => 'Carritos', 'action' => 'deletecarritotemps')); ?>",
			data: id,
			arti,
			dataType: "json",
			success: function(data, response) {

				if (response = "ok") {
					var numero = data.subtotal[1];
					var unidades = data.subtotal[3];

					const noTruncarDecimales = {
						maximumFractionDigits: 2,
						minimumFractionDigits: 2
					};
					ptos = numero.toLocaleString('es', noTruncarDecimales)

					const contenidocarritostemp = data.contenidocarrotemps;

					$('#totalitemss').text(contenidocarritostemp.length + " items");
					$('#totalunidadess').text(unidades + "Unid.");
					$('#totaltall').text("Total $ " + ptos);


					$('tr[id=trimport' + arti + ']').remove();

					if ($('tr[id=trBody' + arti + ']').length) {
						$('tr[id=trBody' + arti + ']').remove();
					}
					/*
					if (data.subtotal[3] >= 100) {
					document.getElementById('openerts').innerHTML = "+99";
					document.getElementById('modalitems').innerHTML = data.subtotal[0] + "/" + data.subtotal[3];
					if ($("#modalitems1").length) {
						document.getElementById('modalitems1').innerHTML = data.subtotal[0] + "/" + data.subtotal[3];
					}
					if ($('#unidades').length) {
						document.getElementById('unidades').innerHTML = data.subtotal[0] + "/" + data.subtotal[3];
					}

					} else {
					document.getElementById('openerts').innerHTML = data.subtotal[3];
					document.getElementById('modalitems').innerHTML = data.subtotal[0] + "/" + data.subtotal[3];
					if ($("#modalitems1").length) {
						document.getElementById('modalitems1').innerHTML = data.subtotal[0] + "/" + data.subtotal[3];
					}
					//	document.getElementById('unidades').innerHTML = data.subtotal[0]+"/"+data.subtotal[3];

					}
					$("#carrito_importe_view").html("$ " + ptos);
					$("#carrito_importe").html("$ " + ptos);
					$("#carrito_importe1").html("$ " + ptos);
					if ($("#modalitems1").length) {
					document.getElementById('modalitems1').innerHTML = data.subtotal[0] + "/" + data.subtotal[3];
					}

					*/
					alertify.success("Eliminado con exito!");


					$('.page_cart1').remove();
					$('table#formaddcart').each(function() {

						var currentPage = 0;
						var numPerPage = 80;
						var $table = $(this);
						var rowCount = $('table.tablasearch tbody tr td.formcartcanttd').length;
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
						var $total = $('<li class="pagination_count"><span id="totalitemss">' + contenidocarritostemp.length + ' Articulos</span></li><li class="pagination_count"><span id="totalunidadess">' + unidades + 'Unid.</span></li><li class="pagination_count"><span id="totaltall">Total $ ' + ptos + '</span></li>');
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





					/*
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
					});*/
				} else {

					alertify.error("Fallo el servidor :(");
				}


			}
		});
	}
	//VACIAR CARRITOS 
	function vaciarCarrito(id) {
		id = "id=" + id;
		$.ajax({
			type: "post",
			url: "<?php echo \Cake\Routing\Router::url(array('controller' => 'Carritos', 'action' => 'vaciar')); ?>",
			data: id,
			success: function(response) {

				if (response = "ok") {

					$('#openerts').attr('data-value', 0);
					$("#openerts").html("0");
					$("#carrito_importe").html("0");
					$("#carrito_importe1").html("0");
					$("#mydivBuscar").html("");
					$("#modalitems").html("0/0");
					$("#modalitems1").html("0/0");
					$('#terminobuscar').val("");
					$("#tablaprueba1").html("");
					$("#table1").html("");
					$("#table").html("");
					$("#tablaprueba").html("");
					$(".carrito-items").html("");
					$('.formcartcant').val("");
					$('.fragcant').val("");
					$('.cantidad').val("");
					$('.product-promotion-button-submit').val("");
					$('.cantidadoferta').val("");
					$("#foot").removeClass("hide");
					$(".gallery-contenedor").removeClass("hide");
					$(".page_cart").html("");





					alertify.success("Eliminado con exito!");

				} else {

					alertify.error("Fallo el servidor :(");
				}
			}
		});
	}
	//CERRAR MENSAJE DE ALERTA POR NO TENER PRIVILEGIOS
	function cerrarDiv() {
		$('#__notifyBar4826526').remove();
	}
	//BUSQUEDA CLICK EN CARRITOS
	function busquedaClick() {
		var numeroCaracteres = 0;
		var textoArea = $('#terminobuscar').val();
		numeroCaracteres = textoArea.length;


		if ($('#terminobuscar').length) {
			var texto = document.getElementById("terminobuscar").value;
			var laboratorio = $('#laboratorio-id').val();
			var monodroga = $('#monodroga-id').val();
			var accionfar = $('#accionfar-id').val();
			var ofertas = $('#ofertas').val();
			var terminobuscar = {
				"terminobuscar": texto

			};



			if (terminobuscar == "" && laboratorio == "" && monodroga == "" && accionfar == "" && ofertas == "") {
				$("#mydivbuscar").removeClass("hide");
				$("#footinteresarte").removeClass("hide");
				$("#refer").removeClass("hide");
				$(".page_cart1").remove();
				$(".page_cart1").remove();
				$("#foot").addClass("hide");
			} else {

				if (numeroCaracteres >= 3) {
					$("#elSpan").text("");
					$.ajax({
						data: {
							"terminobuscar": texto,
							"monodroga_id": monodroga,
							"accionfar_id": accionfar,
							"laboratorio_id": laboratorio,
							"ofertas": ofertas
						},
						url: "<?php echo \Cake\Routing\Router::url(array('controller' => 'Carritos', 'action' => 'buscar')); ?>",
						type: "post",
						success: function(response) {

							$("#foot").removeClass("hide");
							$('#foot').html(response);
							$("#mydivbuscar").addClass("hide");
							$("#refer").addClass("hide");
							$("#footinteresarte").addClass("hide");
							$("#elSpan").text("");
							$("#tab2").focus();
							$(".page_cart1").remove();
							Paginacioncar();
							makeAllSortable();

						}

					});


				} else {
					$("#elSpan").addClass("text-danger");
					$("#elSpan").text("Ingrese mínimo tres caracteres y presione Enter");
				}
			}



		} else { //preguntar si no existe ese id no hacer nada
			//console.log("no existe este id");
		}

	}
	//BUSQUEDA BARRAS EN CARRITOS
	function buscarBarra() {

		if ($('#checkbar').length) {
			var texto = document.getElementById("checkbar").value;
			if (texto == "") {
				$('#mydivBuscar').html('');
				$("#foot").removeClass("hide");


			} else {
				$("#mydivbuscar").removeClass("hide");
				$("#footinteresarte").removeClass("hide");
				$("#foot").addClass("hide");



				$.ajax({
					data: {
						"checkbar": texto,
					},
					url: "<?php echo \Cake\Routing\Router::url(array('controller' => 'Carritos', 'action' => 'buscar')); ?>",
					type: "post",
					success: function(response) {
						$("#foot").removeClass("hide");
						$('#foot').html(response);
						$("#mydivbuscar").addClass("hide");
						$("#footinteresarte").addClass("hide");
						$("#elSpan").text("");
						$('#tab2').attr("val", 1);
						var inputValor = $('#tab2').val();
						var dataid = $('#tab2').attr("data-id");
						tab2 = "tab2";
						var cantidad = $('#tab2').attr("val");
						var datapvid = $('#tab2').attr("data-pv-id");


						if (inputValor == '') {



							ajaxcart(dataid, cantidad, datapvid, tab2);


						} else {

							//var num = +$("#tab2").val() + 1;          
							var num = Number($("#tab2").val()) + 1;
							$('#tab2').val(num);

							dataid = $('#tab2').attr("data-id");
							cantidad = num;
							datapvid = $('#tab2').attr("data-pv-id");
							tab2 = "tab2";
							ajaxcart(dataid, cantidad, datapvid, tab2);

						}


					}

				});
			}
		} else {

			//por si no existe el id del input
			//console.log("no existe este id");
		}
	}
	//BUSQUEDA CLICK SELECT EN CARRITOS
	function clickbusqueda() {

		if ($('#terminobuscar').length) {
			var texto = document.getElementById("terminobuscar").value;
			var laboratorio = $('#laboratorio-id').val();
			var monodroga = $('#monodroga-id').val();
			var accionfar = $('#accionfar-id').val();
			var ofertas = $('#ofertas').val();

			if (texto == "" && laboratorio == "" && texto == "" && monodroga == "" && accionfar == "" && ofertas == "") {
				$("#mydivbuscar").removeClass("hide");
				$("#footinteresarte").removeClass("hide");
				$("#refer").removeClass("hide");
				$(".page_cart1").remove();
				$(".page_cart1").remove();
				$("#foot").addClass("hide");

			} else {

				$.ajax({
					data: {
						"terminobuscar": texto,
						"monodroga_id": monodroga,
						"accionfar_id": accionfar,
						"laboratorio_id": laboratorio,
						"ofertas": ofertas
					},
					url: "<?php echo \Cake\Routing\Router::url(array('controller' => 'Carritos', 'action' => 'buscar')); ?>",
					type: "post",
					success: function(response) {
						$("#foot").removeClass("hide");
						$('#foot').html(response);
						$("#mydivbuscar").addClass("hide");
						$("#refer").addClass("hide");
						$("#footinteresarte").addClass("hide");
						$("#elSpan").text("");
						$("#tab2").focus();
						$(".page_cart1").remove();
						Paginacioncar();
						makeAllSortable();
					}

				});
			}

		} else { //preguntar si no existe ese id no hacer nada
			//console.log("no existe este id");
		}

	}
	//BUSQUEDA ENTER  EN CARRITOS
	function busqueda() {
		var numeroCaracteres = 0;
		var textoArea = $('#terminobuscar').val();
		numeroCaracteres = textoArea.length;

		var texto = document.getElementById("terminobuscar").value;
		var laboratorio = $('#laboratorio-id').val();
		var monodroga = $('#monodroga-id').val();
		var accionfar = $('#accionfar-id').val();
		var ofertas = $('#ofertas').val();
		var terminobuscar = {
			"terminobuscar": texto
		};

		if (terminobuscar == "" && laboratorio == "" && texto == "" && monodroga == "" && accionfar == "" && ofertas == "") {
			$("#mydivbuscar").removeClass("hide");
			$("#footinteresarte").removeClass("hide");
			$("#refer").removeClass("hide");
			$("#foot").addClass("hide");
			$(".page_cart1").remove();
			$(".page_cart1").remove();
		} else {
			var keycode = event.keyCode;
			if (keycode == '13') {

				if (numeroCaracteres >= 3) {
					$("#elSpan").text("");

					$.ajax({
						data: {
							"terminobuscar": texto,
							"monodroga_id": monodroga,
							"accionfar_id": accionfar,
							"laboratorio_id": laboratorio,
							"ofertas": ofertas
						},
						url: "<?php echo \Cake\Routing\Router::url(array('controller' => 'Carritos', 'action' => 'buscar')); ?>",
						type: "post",
						success: function(response) {

							$("#foot").removeClass("hide");
							$('#foot').html(response);
							$("#mydivbuscar").addClass("hide");
							$("#refer").addClass("hide");
							$("#footinteresarte").addClass("hide");
							$("#elSpan").text("");
							$("#tab2").focus();
							$(".page_cart1").remove();
							Paginacioncar();
							makeAllSortable();

						}

					});
				} else {
					$("#elSpan").addClass("text-danger");
					$("#elSpan").text("Ingrese mínimo tres caracteres y presione Enter");

				}
			}
		}
	}
	//BUSQUEDA CLICK SELECT EN NUTRICION
	function clickBusquedaNutricion() {

		var x = $('#terminobuscar').val();
		var y = $('.marca-id').val();

		if (x == "" && y == "") {
			$('#nutricion_div_marcas').removeClass("hide");
			$('#nutricion_div_marcas_search').addClass("hide");
			$("#foot").removeClass("hide");

		} else {
			$.ajax({
				data: {
					"terminobusqueda": x,
					"marca_id": y,
				},
				url: "<?php echo \Cake\Routing\Router::url(array('controller' => 'Carritos', 'action' => 'buscarnutricionydeportes')); ?>",
				type: "post",
				success: function(response) {
					$('#nutricion_div_marcas').addClass("hide");
					$('#nutricion_div_marcas_search').removeClass("hide");
					$('#nutricion_div_marcas_search').html(response);
					$("#foot").addClass("hide");
					$("#elSpan").text("");
					$("#tab2").focus();
					Paginacioncar();
					makeAllSortable();

				}

			});

		}
	}
	//BUSQUEDA CLICK SELECT EN PERFUMERIA
	function BusquedaPerfumeriaSelect() {
		var s = $('.marca-id-perfu').val();
		var x = $('#terminobuscarfragancia').val();
		var y = $('.genero-id-perfu').val();

		$.ajax({
			data: {
				"perfurgenero": y,
				"perfurterminobuscar": x,
				"perfurmarca": s,

			},
			url: "<?php echo \Cake\Routing\Router::url(array('controller' => 'Carritos', 'action' => 'buscarperfumesdelia')); ?>",
			type: "post",
			success: function(response) {
				$('.div-fragancia').addClass("hide");
				$('.div-fragancia_search').removeClass("hide");
				$('.div-fragancia_search').html(response);
				$("#foot").addClass("hide");
				$("#elSpan").text("");
				$("#tab2").focus();
				Paginacionperfu();
				makeAllSortable();

			}

		});
		//if ($('.terminobuscartransfer').val().length == 0) { //} //else {}




	}
	//BUSQUEDA ENTER INPUT EN PERFUMERIA
	function BusquedaPerfumeriaEnter() {
		var s = $('.marca-id-perfu').val();
		var x = $('#terminobuscarfragancia').val();
		var y = $('.genero-id-perfu').val();
		var numeroCaracteres = 0;
		var textoArea = $('#terminobuscarfragancia').val();
		numeroCaracteres = textoArea.length;
		var keycode = event.keyCode;
		if (keycode == '13') {

			if (numeroCaracteres >= 3) {
				$("#elSpan").text("");
				$.ajax({
					data: {
						"perfurgenero": y,
						"perfurterminobuscar": x,
						"perfurmarca": s,

					},
					url: "<?php echo \Cake\Routing\Router::url(array('controller' => 'Carritos', 'action' => 'buscarperfumesdelia')); ?>",
					type: "post",
					success: function(response) {

						$('.div-fragancia').addClass("hide");
						$('.div-fragancia_search').removeClass("hide");
						$('.div-fragancia_search').html(response);
						$("#foot").addClass("hide");
						$("#elSpan").text("");
						$("#tab2").focus();
						Paginacionperfu();
						makeAllSortable();

					}

				});
			}
		} else {
			$("#elSpan").addClass("text-danger");
			$("#elSpan").text("Ingrese mínimo tres caracteres y presione Enter");

		}


	}
	//BUSQUEDA EN INPUT DERMO PROXIMAMENTE
	function BusquedaDermoEnter() {
		var s = $('#marca-id').val();
		var x = $('#terminobuscardermo').val();
		var y = $('#grupo-id').val();
		var z = $('#subgrupo-id').val();
		var numeroCaracteres = 0;
		var textoArea = $('#terminobuscardermo').val();
		numeroCaracteres = textoArea.length;
		var keycode = event.keyCode;
		if (keycode == '13') {

			if (numeroCaracteres >= 3) {
				$("#elSpan").text("");
				$.ajax({
					data: {
						"dermosubgrupo": z,
						"dermogrupo": y,
						"dermoterminobuscar": x,
						"dermomarca": s,

					},
					url: "<?php echo \Cake\Routing\Router::url(array('controller' => 'Carritos', 'action' => 'buscarperfumesdeliadermo')); ?>",
					type: "post",
					success: function(response) {

						$('.dermocontenedor').addClass("hide");
						$('.dermocontenedor_search').removeClass("hide");
						$('.dermocontenedor_search').html(response);
						$("#foot").addClass("hide");
						$("#elSpan").text("");
						$("#tab2").focus();
						Paginacion();
						makeAllSortable();
					}

				});
			}
		} else {
			$("#elSpan").addClass("text-danger");
			$("#elSpan").text("Ingrese mínimo tres caracteres y presione Enter");

		}


	}
	//BUSQUEDA EN SELEC DERMO PROXIMAMENTE
	function BusquedaDermoSelect() {
		var s = $('#marca-id').val();
		var x = $('#dermoterminobuscar').val();
		var y = $('#grupo-id').val();
		var z = $('#subgrupo-id').val();

		$.ajax({
			data: {
				"dermosubgrupo": z,
				"dermogrupo": y,
				"dermoterminobuscar": x,
				"dermomarca": s,
			},
			url: "<?php echo \Cake\Routing\Router::url(array('controller' => 'Carritos', 'action' => 'buscarperfumesdeliadermo')); ?>",
			type: "post",
			success: function(response) {
				$('.dermocontenedor').addClass("hide");
				$('.dermocontenedor_search').removeClass("hide");
				$('.dermocontenedor_search').html(response);
				$("#foot").addClass("hide");
				$("#elSpan").text("");
				$("#tab2").focus();
				Paginacion();
				makeAllSortable();
			}

		});


	}
	//BUSQUEDA EN CLICK IMAGEN DERMO PROXIMAMENTE
	function BusquedaDermoImg(s) {
		s = s;

		$.ajax({
			data: {

				"dermomarca": s,

			},
			url: "<?php echo \Cake\Routing\Router::url(array('controller' => 'Carritos', 'action' => 'buscarperfumesdeliadermo')); ?>",
			type: "post",
			success: function(response) {
				$('.dermocontenedor').addClass("hide");
				$('.dermocontenedor_search').removeClass("hide");
				$('.dermocontenedor_search').html(response);
				$("#foot").addClass("hide");
				$("#elSpan").text("");
				$("#tab2").focus();
				Paginacion();
				makeAllSortable();

			}

		});
	}
	//BUSQUEDA EN INPUT PRODMEDICO
	function BusquedaPromedicoEnter() {
		var s = $('.terminobuscarprodmed').val();
		var x = $('.prodmedicoid').val();
		var numeroCaracteres = 0;
		var textoArea = $('.terminobuscarprodmed').val();
		numeroCaracteres = textoArea.length;
		var keycode = event.keyCode;
		if (keycode == '13') {

			if (numeroCaracteres >= 3) {
				$("#elSpan").text("");


				$.ajax({
					data: {

						"terminobuscar": s,
						"laboratorio_id": x,
					},
					url: "<?php echo \Cake\Routing\Router::url(array('controller' => 'Carritos', 'action' => 'buscarprodmedico')); ?>",
					type: "post",
					success: function(response) {
						$('.prodmcontenedor').addClass("hide");
						$('.prodmcontenedor_search').removeClass("hide");
						$('.prodmcontenedor_search').html(response);;
						$("#foot").addClass("hide");
						$("#elSpan").text("");
						$("#tab2").focus();
						Paginacioncar();
						makeAllSortable();
					}

				});

			}
		} else {
			$("#elSpan").addClass("text-danger");
			$("#elSpan").text("Ingrese mínimo tres caracteres y presione Enter");

		}


	}
	//BUSQUEDA SELEC PRODMEDICO
	function BusquedaPromedicoSelect() {
		var s = $('.terminobuscarprodmed').val();
		var x = $('.prodmedicoid').val();


		$.ajax({
			data: {

				"terminobuscar": s,
				"laboratorio_id": x,
			},
			url: "<?php echo \Cake\Routing\Router::url(array('controller' => 'Carritos', 'action' => 'buscarprodmedico')); ?>",
			type: "post",
			success: function(response) {
				$('.prodmcontenedor').addClass("hide");
				$('.prodmcontenedor_search').removeClass("hide");
				$('.prodmcontenedor_search').html(response);;
				$("#foot").addClass("hide");
				$("#elSpan").text("");
				$("#tab2").focus();
				Paginacioncar();
				makeAllSortable();
			}

		});


	}
	//BUSQUEDA EN CLICK IMAGEN PROMEDICO
	function BusquedaPromedicoImg(s) {
		s = s;

		$.ajax({
			data: {

				"laboratorio_id": s,

			},
			url: "<?php echo \Cake\Routing\Router::url(array('controller' => 'Carritos', 'action' => 'buscarprodmedico')); ?>",
			type: "post",
			success: function(response) {
				$('.prodmcontenedor').addClass("hide");
				$('.prodmcontenedor_search').removeClass("hide");
				$('.prodmcontenedor_search').html(response);
				$("#foot").addClass("hide");
				$("#elSpan").text("");
				$("#tab2").focus();
				Paginacioncar();
				makeAllSortable();

			}

		});
	}
	//BUSQUEDA EN CLICK IMAGEN CARRITO

	//BUSQUEDA EN CLICK IMAGEN CARRITO
	function buscarCarritosPromocion(w, x, z, v, cat, y) {
		ter = w;
		lab = z;
		tipo = x;
		vista = v;
		term = y;
		cat = cat;
		if (vista > 0) {
			if (vista == 1) {

				$.ajax({
					data: {

						"terminobuscar": ter,
						"categoria": cat,

					},
					url: "<?php echo \Cake\Routing\Router::url(array('controller' => 'Carritos', 'action' => 'buscarcarritos')); ?>",
					type: "post",
					success: function(response) {
						$("#foot").removeClass("hide");
						$('#foot').html(response);
						$("#mydivbuscar").addClass("hide");
						$("#footinteresarte").addClass("hide");
						$("#elSpan").text("");
						$("#tab2").focus();
						Paginacioncar();
						makeAllSortable();
					}

				});

			}
			if (vista == 2) {

				$.ajax({
					data: {
						"terminobuscar": term,
						"laboratorio": lab,
						"tipooferta": tipo,
						"vista": vista,
					},
					url: "<?php echo \Cake\Routing\Router::url(array('controller' => 'Carritos', 'action' => 'buscarcarritospromocion')); ?>",
					type: "post",
					success: function(response) {

						$("#foot").removeClass("hide");
						$('#foot').html(response);
						$("#mydivbuscar").addClass("hide");
						$("#footinteresarte").addClass("hide");
						$("#elSpan").text("");
						$("#tab2").focus();
						Paginacion();
						makeAllSortable();

					}

				});



			}
			if (vista == 3) {
				$.ajax({
					data: {
						"terminobuscar": term,
						"laboratorio": lab,
						"tipooferta": tipo,
						"vista": vista,
					},
					url: "<?php echo \Cake\Routing\Router::url(array('controller' => 'Carritos', 'action' => 'buscarcarritospoint')); ?>",
					type: "post",
					success: function(response) {

						$("#foot").removeClass("hide");
						$('#foot').html(response);
						$("#mydivbuscar").addClass("hide");
						$("#footinteresarte").addClass("hide");
						$("#elSpan").text("");
						$("#tab2").focus();
						Paginacion();
						makeAllSortable();
					}

				});


			}
			if (vista == 4) {
			

				$.ajax({
					data: {
						"terminobuscar": term,
						"laboratorio": lab,
						"tipooferta": tipo,
						"vista": vista,
					},
					url: "<?php echo \Cake\Routing\Router::url(array('controller' => 'Carritos', 'action' => 'buscarvista4')); ?>",
					type: "post",
					success: function(response) {

						$("#foot").removeClass("hide");
						$('#vista4').html(response);
						$("#mydivbuscar").addClass("hide");
						$("#footinteresarte").addClass("hide");
						$("#elSpan").text("");
						$("#tab2").focus();
						Paginacion();
						makeAllSortable();
					}

				});

			}

		} else {
			console.log("el producto no tiene codigo de vista");
			alert("error, usted no respuesta.");


		}

	}
	//BUSQUEDA EN CLICK IMAGEN PERFUMERIA
	function BusquedaPerfumeriaImg(s) {
		s = s;

		$.ajax({
			data: {

				"perfurmarca": s,

			},
			url: "<?php echo \Cake\Routing\Router::url(array('controller' => 'Carritos', 'action' => 'buscarperfumesdelia')); ?>",
			type: "post",
			success: function(response) {
				$('.div-fragancia').addClass("hide");
				$('.div-fragancia_search').removeClass("hide");
				$('.div-fragancia_search').html(response);
				$("#foot").addClass("hide");
				$("#elSpan").text("");
				$("#tab2").focus();
				Paginacionperfu();
				makeAllSortable();
			}

		});
	}
	//BUSQUEDA CLICK IMAGEN EN NUTRICION
	function BusquedaNutricion(s) {

		s = s;
		$.ajax({
			data: {

				"marca_id": s,
			},
			url: "<?php echo \Cake\Routing\Router::url(array('controller' => 'Carritos', 'action' => 'buscarnutricionydeportes')); ?>",
			type: "post",
			success: function(response) {
				$('#nutricion_div_marcas').addClass("hide");
				$('#nutricion_div_marcas_search').removeClass("hide");
				$('#nutricion_div_marcas_search').html(response);
				$("#foot").addClass("hide");
				$("#elSpan").text("");
				$("#tab2").focus();
				Paginacioncar();
				makeAllSortable();

			}

		});

	}
	//BUSQUEDA TECLA ENTER  EN NUTRICION
	function EnterBusquedaNutricion() {
		var numeroCaracteres = 0;

		var textoArea = $('#terminobuscar').val();
		numeroCaracteres = textoArea.length;

		var x = $('#terminobuscar').val();
		var y = $('.marca-id').val();

		if (x == "" && y == "") {
			$('#nutricion_div_marcas').removeClass("hide");
			$('#nutricion_div_marcas_search').addClass("hide");
			$("#foot").removeClass("hide");

		} else {
			var keycode = event.keyCode;
			if (keycode == '13') {

				if (numeroCaracteres >= 3) {
					$("#elSpan").text("");

					{
						$.ajax({
							data: {
								"terminobusqueda": x,
								"marca_id": y,
								"categonutricion": 4,
							},
							url: "<?php echo \Cake\Routing\Router::url(array('controller' => 'Carritos', 'action' => 'buscarnutricionydeportes')); ?>",
							type: "post",
							success: function(response) {
								$('#nutricion_div_marcas').addClass("hide");
								$('#nutricion_div_marcas_search').removeClass("hide");
								$('#nutricion_div_marcas_search').html(response);
								$("#foot").addClass("hide");
								$("#elSpan").text("");
								$("#tab2").focus();
								PaginacionCar();
								makeAllSortable();
							}

						});

					}
				} else {
					$("#elSpan").addClass("text-danger");
					$("#elSpan").text("Ingrese mínimo tres caracteres y presione Enter");

				}
			}
		}

	}
	//BUSQUEDA CLICK SELECT EN TRANSFER
	function BusquedaTransferSelect(s) {
		s = s;


		var x = $('.terminobuscartransfer').val();

		$.ajax({
			data: {

				"transferterminobuscar": x,
				"transferlaboratorio": s,

			},
			url: "<?php echo \Cake\Routing\Router::url(array('controller' => 'Carritos', 'action' => 'buscarpatagoniamed')); ?>",
			type: "post",
			success: function(response) {
				$('.gallery-contenedor').addClass("hide");
				$('.gallery-contenedor_search').removeClass("hide");
				$('.gallery-contenedor_search').html(response);
				$("#foot").addClass("hide");
				$("#elSpan").text("");
				$("#tab2").focus();
				Paginacion();
				makeAllSortable();

			}

		});
		//if ($('.terminobuscartransfer').val().length == 0) { //} //else {}




	}
	//BUSQUEDA CLICK IMAGEN EN TRANSFER
	function BusquedaTransferImg(s, x) {
		s = s;
		desase = x;

		$.ajax({
			data: {

				"transferlaboratorio": s,
				"desase": desase,

			},
			url: "<?php echo \Cake\Routing\Router::url(array('controller' => 'Carritos', 'action' => 'buscarpatagoniamed')); ?>",
			type: "post",
			success: function(response) {
				$('.gallery-contenedor').addClass("hide");
				$('.gallery-contenedor_search').removeClass("hide");
				$('.gallery-contenedor_search').html(response);
				$("#foot").addClass("hide");
				$("#elSpan").text("");
				$("#tab2").focus();
				Paginacion();
				makeAllSortable();
			}

		});
	}
	//BUSQUEDA TECLA ENTER  EN TRANSFER
	function EnterBusquedaTransfer() {
		var numeroCaracteres = 0;

		var textoArea = $('.terminobuscartransfer').val();
		numeroCaracteres = textoArea.length;

		var x = $('.terminobuscartransfer').val();
		var y = $('#laboratorio-id').val();

		var keycode = event.keyCode;
		if (keycode == '13') {

			if (numeroCaracteres >= 3) {
				$("#elSpan").text("");

				{


					$.ajax({
						data: {

							"transferterminobuscar": x,
							"transferlaboratorio": y,

						},
						url: "<?php echo \Cake\Routing\Router::url(array('controller' => 'Carritos', 'action' => 'buscarpatagoniamed')); ?>",
						type: "post",
						success: function(response) {
							$('.gallery-contenedor').addClass("hide");
							$('.gallery-contenedor_search').removeClass("hide");
							$('.gallery-contenedor_search').html(response);
							$("#foot").addClass("hide");
							$("#elSpan").text("");
							$("#tab2").focus();
							Paginacion();
				makeAllSortable();

						}

					});



				}
			} else {
				$("#elSpan").addClass("text-danger");
				$("#elSpan").text("Ingrese mínimo tres caracteres y presione Enter");

			}
		}


	}
	//ACTUALIZAR ITEMS AL CARRITO
	function ajaxcart(id, quantity, pv_id, id_input) {


		$.ajax({
			type: "POST",
			url: "<?php echo \Cake\Routing\Router::url(array('controller' => 'Carritos', 'action' => 'itemupdate')); ?>",
			data: {
				id: id,
				quantity: quantity,
				descuento_id: pv_id,
				id_input: id_input

			},
			dataType: "json",
			success: function(data, textStatus) {
				//alert(data.responseText);
				switch (data.responseText) {

					case "ok":

						$("#" + id_input).val(data.carros.cantidad);
						$('input[data-id=' + id + ']').val(quantity);
						$('#openerts').attr('data-value', data.subtotal[3]);
						if (data.carros.cantidad >= data.carros.unidad_minima) {

							$('tr[id=tr' + id + ']').attr("class", "");
							if ($('tr[id="trBody' + id + '"]').length) {
								$('tr[id="trBody' + id + '"]').attr("class", "");
							}


						} else {
							$('tr[id="tr' + id + '"]').attr("class", "carrito_item_sinoferta");
							$('tr[id="tr' + id + '"]').attr("title", 'Dto:' + data.carros.descuento + "%" + 'Uni. Min:' + data.carros.unidad_minima + 'T.Of.:' + data.carros.tipo_oferta);

							if ($('tr[id="trBody' + id + '"]').length) {

								$('tr[id="trBody' + id + '"]').attr("class", "carrito_item_sinoferta");
								$('tr[id="trBody' + id + '"]').attr("title", 'Dto:' + data.carros.descuento + "%" + 'Uni. Min:' + data.carros.unidad_minima + 'T.Of.:' + data.carros.tipo_oferta);
							}
						}

						var numero = data.subtotal[1];
						const noTruncarDecimales = {
							maximumFractionDigits: 2,
							minimumFractionDigits: 2
						};
						ptos = numero.toLocaleString('es', noTruncarDecimales);

						if (data.subtotal[3] >= 100) {
							document.getElementById('openerts').innerHTML = "+99";
							document.getElementById('modalitems').innerHTML = data.subtotal[0] + "/" + data.subtotal[3];
							if ($("#modalitems1").length) {
								document.getElementById('modalitems1').innerHTML = data.subtotal[0] + "/" + data.subtotal[3];
							}
							if ($('#unidades').length) {
								document.getElementById('unidades').innerHTML = data.subtotal[0] + "/" + data.subtotal[3];
							}

						} else {
							document.getElementById('openerts').innerHTML = data.subtotal[3];
							document.getElementById('modalitems').innerHTML = data.subtotal[0] + "/" + data.subtotal[3];
							if ($("#modalitems1").length) {
								document.getElementById('modalitems1').innerHTML = data.subtotal[0] + "/" + data.subtotal[3];
							}
							if ($('#unidades').length) {
								document.getElementById('unidades').innerHTML = data.subtotal[0] + "/" + data.subtotal[3];
							}

						}

						$("#carrito_importe_view").html("$ " + ptos);
						$("#carrito_importe").html("$ " + ptos);
						$("#carrito_importe1").html("$ " + ptos);
						if ($("#modalitems1").length) {
							document.getElementById('modalitems1').innerHTML = data.subtotal[0] + "/" + data.subtotal[3];
						}

						alertify.success("Cantidad Modificada Con Exito!");



						break;

					case "6":

						$('<div class="jquery-notify-bar error top" id="__notifyBar4826526" style=""><span class="notify-bar-text-wrapper">No se puede agregar este producto al carro de compras.</span><a href="#" onclick="cerrarDiv()" class="notify-bar-close">×</a></div>').appendTo('body');
						$('#terminobuscar').val("");
						$("#mydivBuscar").html("<p>No tienes Permisos para agregar productos de esta categoria.</p>");
						$('.formcartcant').val("");
						break;
					case "5":
						$('<div class="jquery-notify-bar error top" id="__notifyBar4826526" style=""><span class="notify-bar-text-wrapper">No se puede agregar este producto al carro de compras. </span><a href="#" onclick="cerrarDiv()"class="notify-bar-close">×</a></div>').appendTo('body');
						$('#terminobuscar').val("");
						$("#mydivBuscar").html("<p>No tienes Permisos para agregar productos de esta categoria.</p>");
						$('.formcartcant').val("");
						break;
					case "0":
						$('<div class="jquery-notify-bar error top" id="__notifyBar4826526" style=""><span class="notify-bar-text-wrapper">No se puede agregar este producto al carro de compras. </span><a href="#" onclick="cerrarDiv()"class="notify-bar-close">×</a></div>').appendTo('body');
						$('#terminobuscar').val("");
						$("#mydivBuscar").html("<p>No tienes Permisos para agregar productos de esta categoria.</p>");
						$('.formcartcant').val("");
						break;


					case "eliminado":

						alertify.success("Eliminado con exito!");
						if (data.subtotal[3] >= 100) {
							document.getElementById('openerts').innerHTML = "+99";
							document.getElementById('modalitems').innerHTML = data.subtotal[0] + "/" + data.subtotal[3];
							if ($("#modalitems1").length) {
								document.getElementById('modalitems1').innerHTML = data.subtotal[0] + "/" + data.subtotal[3];
							}
							if ($('#unidades').length) {
								document.getElementById('unidades').innerHTML = data.subtotal[0] + "/" + data.subtotal[3];
							}

						} else {
							document.getElementById('openerts').innerHTML = data.subtotal[3];
							document.getElementById('modalitems').innerHTML = data.subtotal[0] + "/" + data.subtotal[3];
							if ($("#modalitems1").length) {
								document.getElementById('modalitems1').innerHTML = data.subtotal[0] + "/" + data.subtotal[3];
							}
							if ($('#unidades').length) {
								document.getElementById('unidades').innerHTML = data.subtotal[0] + "/" + data.subtotal[3];
							}

						}
						$("#carrito_importe_view").html(data.subtotal[1].toFixed(2));
						$("#carrito_importe").html("$" + data.subtotal[1].toFixed(2));
						$("#carrito_importe1").html(data.subtotal[1].toFixed(2));



						var concarro = data.contenidocarro;
					



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

						break;



				}


				//$.each(data.carro, function(key, value) {});




			},
			/*ALERTA DE ERROR*/
			error: function(textStatus) {

				if (textStatus = "Success") {


				}
				console.log(textStatus);


				//window.location.replace("/products/clear");
			}
		});
	}
	//ACTUALIZAR ITEMS EN STORE DELIA
	function ajaxcartDelia(id, quantity, pv_id, id_input) {

		$.ajax({
			type: "POST",
			url: "/./ds3/Carritos/itemupdate",
			data: {
				id: id,
				quantity: quantity,
				descuento_id: pv_id,
				id_input: id_input

			},
			dataType: "json",
			success: function(data, textStatus) {
				//alert(data.responseText);
				switch (data.responseText) {

					case "ok":


						var concarro = data.contenidocarro;

						var numero = data.subtotal[1];
						const noTruncarDecimales = {
							maximumFractionDigits: 2,
							minimumFractionDigits: 2
						};
						ptos = numero.toLocaleString('es', noTruncarDecimales);

						//preguntamos si existe el id en la tabla el tr

						if ($('tr[id=tr' + id + ']').length) {
							if (data.carros.cantidad >= data.carros.unidad_minima) {

								$('tr[id=tr' + id + ']').attr("class", "");
								if ($('tr[id=trBody' + id + ']').length) {
									$('tr[id=trBody' + id + ']').attr("class", "");
								}


							} else {
								$('tr[id=tr' + id + ']').attr("class", "carrito_item_sinoferta");
								$('tr[id=tr' + id + ']').attr("title", 'Dto:' + data.carros.descuento + "%" + 'Uni. Min:' + data.carros.unidad_minima + 'T.Of.:' + data.carros.tipo_oferta);

								if ($('tr[id=trBody' + id + ']').length) {

									$('tr[id=trBody' + id + ']').attr("class", "carrito_item_sinoferta");
									$('tr[id=trBody' + id + ']').attr("title", 'Dto:' + data.carros.descuento + "%" + 'Uni. Min:' + data.carros.unidad_minima + 'T.Of.:' + data.carros.tipo_oferta);
								}
							}

							alertify.success("Cantidad Modificada Con Exito!");
							$('input[data-id=' + id + ']').val(data.carros.cantidad);
							$("#" + id_input).val(data.carros.cantidad);

							if (data.subtotal[3] >= 100) {
								document.getElementById('openerts').innerHTML = "+99";
								document.getElementById('modalitems').innerHTML = data.subtotal[0] + "/" + data.subtotal[3];
								if ($("#modalitems1").length) {
									document.getElementById('modalitems1').innerHTML = data.subtotal[0] + "/" + data.subtotal[3];
								}
								if ($('#unidades').length) {
									document.getElementById('unidades').innerHTML = data.subtotal[0] + "/" + data.subtotal[3];
								}

							} else {
								document.getElementById('openerts').innerHTML = data.subtotal[3];
								document.getElementById('modalitems').innerHTML = data.subtotal[0] + "/" + data.subtotal[3];
								if ($("#modalitems1").length) {
									document.getElementById('modalitems1').innerHTML = data.subtotal[0] + "/" + data.subtotal[3];
								}
								if ($('#unidades').length) {
									document.getElementById('unidades').innerHTML = data.subtotal[0] + "/" + data.subtotal[3];
								}

							}

							$("#carrito_importe_view").html("$ " + ptos);
							$("#carrito_importe").html("$ " + ptos);
							$("#carrito_importe1").html("$ " + ptos);

							$("#" + data.carros.articulo_id).val(data.carros.cantidad);


						} else {
							$("#table").removeClass("hide");
							$("#tabla").removeClass("hide");

							//creamos el div openerts 
							$('#tablaprueba').remove();
							//$("#tablaprueba1").addClass("hide");


							$('<div class="carro_unidades_ico" alt="Ver" id="openert"   ><div><div class="carro_unidades_nro" id="openerts" onclick="focusMethod()"  ></div></div>').appendTo('.menu');
							$('<div id="unidades"></div>').appendTo('.carrito_importe_s');
							//asignamos valor al value de openert


							if (data.subtotal[3] >= 100) {
								document.getElementById('openerts').innerHTML = "+99";
								document.getElementById('modalitems').innerHTML = data.subtotal[0] + "/" + data.subtotal[3];
								if ($("#modalitems1").length) {
									document.getElementById('modalitems1').innerHTML = data.subtotal[0] + "/" + data.subtotal[3];
								}
								if ($('#unidades').length) {
									document.getElementById('unidades').innerHTML = data.subtotal[0] + "/" + data.subtotal[3];
								}

							} else {
								document.getElementById('openerts').innerHTML = data.subtotal[3];
								document.getElementById('modalitems').innerHTML = data.subtotal[0] + "/" + data.subtotal[3];
								if ($("#modalitems1").length) {
									document.getElementById('modalitems1').innerHTML = data.subtotal[0] + "/" + data.subtotal[3];
								}
								if ($('#unidades').length) {
									document.getElementById('unidades').innerHTML = data.subtotal[0] + "/" + data.subtotal[3];
								}

							}
							$("#carrito_importe_view").html("$ " + ptos);
							$("#carrito_importe").html("$ " + ptos);
							$("#carrito_importe1").html("$ " + ptos);
							// si no existe  




							let tabla = document.getElementById("table");


							document.getElementById("table").innerHTML = "";
							for (const ccarro of concarro) {
								if (ccarro.cantidad >= ccarro.unidad_minima) {
									let tr = document.createElement('tr');
									let tdDESCRIPCION = document.createElement('td');
									let tdEDITAR = document.createElement('td');
									let tdEDITAR1 = document.createElement('td');
									let img = document.createElement('img');
									let aeliminar = document.createElement('a');
									let tdCANTIDAD = document.createElement('input');
									let tdform = document.createElement('input');
									let tdbuttonmas = document.createElement("button");
									let tdbuttonmenos = document.createElement("button");
									let form = document.createElement("form");
									tabla.className = ('table table-striped');
									tr.id = ("tr" + ccarro.articulo_id);
									//tr.className =('carrito_item_sinoferta');
									tdDESCRIPCION.className = ('carrito_item_descripcion');
									tdCANTIDAD.className = ('formcarritocant text-center');
									tdCANTIDAD.onkeypress = soloNumeros;
									tdCANTIDAD.id = ("car" + ccarro.articulo_id);
									tdCANTIDAD.value = (ccarro.cantidad);
									tdCANTIDAD.maxLength = 3;
									tdCANTIDAD.setAttribute("data-pv-id", ccarro.descuento_id);
									tdCANTIDAD.setAttribute("data-id", ccarro.articulo_id);
									tdCANTIDAD.setAttribute("data-id-input", ccarro.articulo_id);
									aeliminar.href = ('#');
									aeliminar.id = ('delete');
									aeliminar.onclick = function() {
										alertify.confirm('Eliminar Datos', '¿Esta seguro de eliminar este Articulo?',
											function() {
												eliminarDatos(ccarro.id, ccarro.articulo_id)
											},
											function() {
												alertify.error('Se cancelo la operación')
											});
									};
									img.src = '/ds3/img/delete_ico.png';
									img.class = ("delete");
									form.method = "POST";
									form.style = "display:none;";
									form.name = "";
									tdform.name = "_method";
									tdform.value = "POST";
									tdEDITAR.className = ('c');
									tdbuttonmas.className = ('btn btn-sm');
									tdbuttonmenos.className = ('btn btn-sm');
									tdbuttonmas.innerHTML = '+';
									tdbuttonmas.onclick = function() {
										increment(ccarro.articulo_id, ccarro.descuento_id, ccarro.articulo_id)
									};
									tdbuttonmenos.onclick = function() {
										decrement(ccarro.articulo_id, ccarro.descuento_id, ccarro.articulo_id, ccarro.id)
									};
									tdEDITAR1.className = ('carrito_item_cantida');
									tdbuttonmenos.innerHTML = '-';
									tdDESCRIPCION.innerText = ccarro.descripcion;
									tdCANTIDAD.innerText = ccarro.cantidad;

									tdCANTIDAD.onchange = function() {
										var quantity = Math.round($(this).val());
										ajaxcart($(this).attr("data-id"), quantity, $(this).attr("data-pv-id"), $(this).attr("data-id-input"));

									};
									tr.appendChild(tdDESCRIPCION);
									tr.appendChild(tdEDITAR1);
									tr.appendChild(tdEDITAR);
									tdEDITAR.appendChild(form);
									tdEDITAR1.appendChild(tdbuttonmenos);
									tdEDITAR1.appendChild(tdCANTIDAD);
									tdEDITAR1.appendChild(tdbuttonmas);
									form.appendChild(tdform);


									tdEDITAR.appendChild(aeliminar);

									aeliminar.appendChild(img);
									tabla.appendChild(tr);


								} else {
									let tr = document.createElement('tr');
									let tdDESCRIPCION = document.createElement('td');
									let tdEDITAR = document.createElement('td');
									let tdEDITAR1 = document.createElement('td');
									let img = document.createElement('img');
									let aeliminar = document.createElement('a');
									let tdCANTIDAD = document.createElement('input');
									let tdform = document.createElement('input');
									let tdbuttonmas = document.createElement("button");
									let tdbuttonmenos = document.createElement("button");
									let form = document.createElement("form");
									tabla.className = ('table table-striped');
									tr.id = ("tr" + ccarro.articulo_id);
									tr.className = ('carrito_item_sinoferta');
									tdDESCRIPCION.className = ('carrito_item_descripcion');
									tdCANTIDAD.className = ('formcarritocant text-center');
									tdCANTIDAD.onkeypress = soloNumeros;
									tdCANTIDAD.id = ("car" + ccarro.articulo_id);
									tdCANTIDAD.value = (ccarro.cantidad);
									tdCANTIDAD.maxLength = 3;
									tdCANTIDAD.setAttribute("data-pv-id", ccarro.descuento_id);
									tdCANTIDAD.setAttribute("data-id", ccarro.articulo_id);
									tdCANTIDAD.setAttribute("data-id-input", ccarro.articulo_id);
									aeliminar.href = ('#');
									aeliminar.id = ('delete');
									aeliminar.onclick = function() {
										alertify.confirm('Eliminar Datos', '¿Esta seguro de eliminar este Articulo?',
											function() {
												eliminarDatos(ccarro.id, ccarro.articulo_id)
											},
											function() {
												alertify.error('Se cancelo la operación')
											});
									};
									img.src = '/ds3/img/delete_ico.png';
									img.class = ("delete");
									form.method = "POST";
									form.style = "display:none;";
									form.name = "";
									tdform.name = "_method";
									tdform.value = "POST";
									tdEDITAR.className = ('c');
									tdbuttonmas.className = ('btn btn-sm');
									tdbuttonmenos.className = ('btn btn-sm');
									tdbuttonmas.innerHTML = '+';
									tdbuttonmas.onclick = function() {
										increment(ccarro.articulo_id, ccarro.descuento_id, ccarro.articulo_id)
									};
									tdbuttonmenos.onclick = function() {
										decrement(ccarro.articulo_id, ccarro.descuento_id, ccarro.articulo_id, ccarro.id)
									};
									tdEDITAR1.className = ('carrito_item_cantida');
									tdbuttonmenos.innerHTML = '-';
									tdDESCRIPCION.innerText = ccarro.descripcion;
									tdCANTIDAD.innerText = ccarro.cantidad;

									tdCANTIDAD.onchange = function() {
										var quantity = Math.round($(this).val());
										ajaxcart($(this).attr("data-id"), quantity, $(this).attr("data-pv-id"), $(this).attr("data-id-input"));

									};
									tr.appendChild(tdDESCRIPCION);
									tr.appendChild(tdEDITAR1);
									tr.appendChild(tdEDITAR);
									tdEDITAR.appendChild(form);
									tdEDITAR1.appendChild(tdbuttonmenos);
									tdEDITAR1.appendChild(tdCANTIDAD);
									tdEDITAR1.appendChild(tdbuttonmas);
									form.appendChild(tdform);


									tdEDITAR.appendChild(aeliminar);

									aeliminar.appendChild(img);
									tabla.appendChild(tr);





								}
							}

							if ($('#tablaprueba1').length) {
								//alert("existe tabla prueba1")
								let table = document.getElementById("table1");
								document.getElementById("table1").innerHTML = "";
								$("#tablaprueba1").addClass("hide");
								$("#table1").removeClass("hide");
								$("#tabla1").removeClass("hide");

								for (const ccarro of concarro) {
									if (ccarro.cantidad >= ccarro.unidad_minima) {
										let tr = document.createElement('tr');
										let tdDESCRIPCION = document.createElement('td');
										let tdEDITAR = document.createElement('td');
										let tdEDITAR1 = document.createElement('td');
										let img = document.createElement('img');
										let aeliminar = document.createElement('a');
										let tdCANTIDAD = document.createElement('input');
										let tdform = document.createElement('input');
										let tdbuttonmas = document.createElement("button");
										let tdbuttonmenos = document.createElement("button");
										let form = document.createElement("form");
										table.className = ('table table-striped');
										tr.id = ("trBody" + ccarro.articulo_id);
										//tr.className =('carrito_item_sinoferta');
										tdDESCRIPCION.className = ('carrito_item_descripcion');
										tdCANTIDAD.className = ('formcarritocant text-center');
										tdCANTIDAD.onkeypress = soloNumeros;
										tdCANTIDAD.id = ("carb" + ccarro.articulo_id);
										tdCANTIDAD.value = (ccarro.cantidad);
										tdCANTIDAD.maxLength = 3;
										tdCANTIDAD.setAttribute("data-pv-id", ccarro.descuento_id);
										tdCANTIDAD.setAttribute("data-id", ccarro.articulo_id);
										tdCANTIDAD.setAttribute("data-id-input", ccarro.articulo_id);
										aeliminar.href = ('#');
										aeliminar.id = ('delete');
										aeliminar.onclick = function() {
											alertify.confirm('Eliminar Datos', '¿Esta seguro de eliminar este Articulo?',
												function() {
													eliminarDatos(ccarro.id, ccarro.articulo_id)
												},
												function() {
													alertify.error('Se cancelo la operación')
												});
										};
										img.src = '/ds3/img/delete_ico.png';
										img.class = ("delete");
										form.method = "POST";
										form.style = "display:none;";
										form.name = "";
										tdform.name = "_method";
										tdform.value = "POST";
										tdEDITAR.className = ('c');
										tdbuttonmas.className = ('btn btn-sm');
										tdbuttonmenos.className = ('btn btn-sm');
										tdbuttonmas.innerHTML = '+';
										tdbuttonmas.onclick = function() {
											increment(ccarro.articulo_id, ccarro.descuento_id, ccarro.articulo_id)
										};
										tdbuttonmenos.onclick = function() {
											decrement(ccarro.articulo_id, ccarro.descuento_id, ccarro.articulo_id, ccarro.id)
										};
										tdEDITAR1.className = ('carrito_item_cantida');
										tdbuttonmenos.innerHTML = '-';
										tdDESCRIPCION.innerText = ccarro.descripcion;
										tdCANTIDAD.innerText = ccarro.cantidad;

										tdCANTIDAD.onchange = function() {
											var quantity = Math.round($(this).val());
											ajaxcart($(this).attr("data-id"), quantity, $(this).attr("data-pv-id"), $(this).attr("data-id-input"));

										};
										tr.appendChild(tdDESCRIPCION);
										tr.appendChild(tdEDITAR1);
										tr.appendChild(tdEDITAR);
										tdEDITAR.appendChild(form);
										tdEDITAR1.appendChild(tdbuttonmenos);
										tdEDITAR1.appendChild(tdCANTIDAD);
										tdEDITAR1.appendChild(tdbuttonmas);
										form.appendChild(tdform);


										tdEDITAR.appendChild(aeliminar);

										aeliminar.appendChild(img);
										table.appendChild(tr);



									} else {
										let tr = document.createElement('tr');
										let tdDESCRIPCION = document.createElement('td');
										let tdEDITAR = document.createElement('td');
										let tdEDITAR1 = document.createElement('td');
										let img = document.createElement('img');
										let aeliminar = document.createElement('a');
										let tdCANTIDAD = document.createElement('input');
										let tdform = document.createElement('input');
										let tdbuttonmas = document.createElement("button");
										let tdbuttonmenos = document.createElement("button");
										let form = document.createElement("form");
										table.className = ('table table-striped');
										tr.id = ("trBody" + ccarro.articulo_id);
										tr.className = ('carrito_item_sinoferta');
										tdDESCRIPCION.className = ('carrito_item_descripcion');
										tdCANTIDAD.className = ('formcarritocant text-center');
										tdCANTIDAD.onkeypress = soloNumeros;
										tdCANTIDAD.id = ("carb" + ccarro.articulo_id);
										tdCANTIDAD.value = (ccarro.cantidad);
										tdCANTIDAD.maxLength = 3;
										tdCANTIDAD.setAttribute("data-pv-id", ccarro.descuento_id);
										tdCANTIDAD.setAttribute("data-id", ccarro.articulo_id);
										tdCANTIDAD.setAttribute("data-id-input", ccarro.articulo_id);
										aeliminar.href = ('#');
										aeliminar.id = ('delete');
										aeliminar.onclick = function() {
											alertify.confirm('Eliminar Datos', '¿Esta seguro de eliminar este Articulo?',
												function() {
													eliminarDatos(ccarro.id, ccarro.articulo_id)
												},
												function() {
													alertify.error('Se cancelo la operación')
												});
										};
										img.src = '/ds3/img/delete_ico.png';
										img.class = ("delete");
										form.method = "POST";
										form.style = "display:none;";
										form.name = "";
										tdform.name = "_method";
										tdform.value = "POST";
										tdEDITAR.className = ('c');
										tdbuttonmas.className = ('btn btn-sm');
										tdbuttonmenos.className = ('btn btn-sm');
										tdbuttonmas.innerHTML = '+';
										tdbuttonmas.onclick = function() {
											increment(ccarro.articulo_id, ccarro.descuento_id, ccarro.articulo_id)
										};
										tdbuttonmenos.onclick = function() {
											decrement(ccarro.articulo_id, ccarro.descuento_id, ccarro.articulo_id, ccarro.id)
										};
										tdEDITAR1.className = ('carrito_item_cantida');
										tdbuttonmenos.innerHTML = '-';
										tdDESCRIPCION.innerText = ccarro.descripcion;
										tdCANTIDAD.innerText = ccarro.cantidad;

										tdCANTIDAD.onchange = function() {
											var quantity = Math.round($(this).val());
											ajaxcart($(this).attr("data-id"), quantity, $(this).attr("data-pv-id"), $(this).attr("data-id-input"));

										};
										tr.appendChild(tdDESCRIPCION);
										tr.appendChild(tdEDITAR1);
										tr.appendChild(tdEDITAR);
										tdEDITAR.appendChild(form);
										tdEDITAR1.appendChild(tdbuttonmenos);
										tdEDITAR1.appendChild(tdCANTIDAD);
										tdEDITAR1.appendChild(tdbuttonmas);
										form.appendChild(tdform);


										tdEDITAR.appendChild(aeliminar);

										aeliminar.appendChild(img);
										table.appendChild(tr);





									}
								}
							}




							alertify.success("Cantidad Agregada Con Exito!");
							$('.page_cart').remove();
							$('table.table-striped').each(function() {
								var currentPage = 0;
								var numPerPage = 8;
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

						}


						//}
						//para editar comprobamos si ya la cantidad es mayor a 0 	




						break;

					case "6":

						$('<div class="jquery-notify-bar error top" id="__notifyBar4826526" style=""><span class="notify-bar-text-wrapper">No se puede agregar este producto al carro de compras.</span><a href="#" onclick="cerrarDiv()" class="notify-bar-close">×</a></div>').appendTo('body');
						$('#terminobuscar').val("");
						$("#mydivBuscar").html("<p>No tienes Permisos para agregar productos de esta categoria.</p>");
						$('.formcartcant').val("");
						break;
					case "5":
						$('<div class="jquery-notify-bar error top" id="__notifyBar4826526" style=""><span class="notify-bar-text-wrapper">No se puede agregar este producto al carro de compras. </span><a href="#" onclick="cerrarDiv()"class="notify-bar-close">×</a></div>').appendTo('body');
						$('#terminobuscar').val("");
						$("#mydivBuscar").html("<p>No tienes Permisos para agregar productos de esta categoria.</p>");
						$('.formcartcant').val("");
						break;
					case "0":
						$('<div class="jquery-notify-bar error top" id="__notifyBar4826526" style=""><span class="notify-bar-text-wrapper">No se puede agregar este producto al carro de compras. </span><a href="#" onclick="cerrarDiv()"class="notify-bar-close">×</a></div>').appendTo('body');
						$('#terminobuscar').val("");
						$("#mydivBuscar").html("<p>No tienes Permisos para agregar productos de esta categoria.</p>");
						$('.formcartcant').val("");
						break;

					case "eliminado":

						alertify.success("Eliminado con exito!");
						if (data.subtotal[3] >= 100) {
							document.getElementById('openerts').innerHTML = "+99";
							document.getElementById('modalitems').innerHTML = data.subtotal[0] + "/" + data.subtotal[3];
							if ($("#modalitems1").length) {
								if ($("#modalitems1").length) {
									document.getElementById('modalitems1').innerHTML = data.subtotal[0] + "/" + data.subtotal[3];
								}
							}

							if ($('#unidades').length) {
								document.getElementById('unidades').innerHTML = data.subtotal[0] + "/" + data.subtotal[3];
							}
						} else {
							document.getElementById('openerts').innerHTML = data.subtotal[3];
							document.getElementById('modalitems').innerHTML = data.subtotal[0] + "/" + data.subtotal[3];
							if ($("#modalitems1").length) {
								document.getElementById('modalitems1').innerHTML = data.subtotal[0] + "/" + data.subtotal[3];
							}
							if ($('#unidades').length) {
								document.getElementById('unidades').innerHTML = data.subtotal[0] + "/" + data.subtotal[3];
							}

						}
						$("#carrito_importe_view").html(data.subtotal[1].toFixed(2));
						$("#carrito_importe").html(data.subtotal[1].toFixed(2));
						$("#carrito_importe1").html(data.subtotal[1].toFixed(2));



						var concarro = data.contenidocarro;
						$('#tr' + id).remove();



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

						break;




				}
				//$.each(data.carro, function(key, value) {});

				/* ALERTA DE EXITO */

				//$("#modalcar").load(" #modalcar");



			},
			/*ALERTA DE ERROR*/
			error: function(textStatus) {

				if (textStatus = "Success") {


				}
				console.log(textStatus);


				//window.location.replace("/products/clear");
			}
		});
	}

	function ajaxcartImport(id, quantity, pv_id, id_input) {


		$.ajax({
			type: "POST",
			url: "<?php echo \Cake\Routing\Router::url(array('controller' => 'Carritos', 'action' => 'itemupdatetemps')); ?>",
			data: {
				id: id,
				quantity: quantity,
				descuento_id: pv_id,
				id_input: id_input

			},
			dataType: "json",
			success: function(data, textStatus) {
				//alert(data.responseText);
				switch (data.responseText) {

					case "ok":
						var numero = data.subtotal[1];
						var unidades = data.subtotal[3];

						const noTruncarDecimales = {
							maximumFractionDigits: 2,
							minimumFractionDigits: 2
						};
						ptos = numero.toLocaleString('es', noTruncarDecimales)

						const contenidocarritostemp = data.contenidocarrotemps;

						$('#totalitemss').text(contenidocarritostemp.length + " items");
						$('#totalunidadess').text(unidades + "Unid.");
						$('#totaltall').text("Total $ " + ptos);

						$('input[data-id=' + id + ']').val(quantity);


						/*
						$('#openerts').attr('data-value', data.subtotal[3]);
						if (data.carros.cantidad >= data.carros.unidad_minima) {

						$('tr[id=tr' + id + ']').attr("class", "");

						if ($('tr[id="trBody' + id + '"]').length) {
						$('tr[id="trBody' + id + '"]').attr("class", "");
						}


						} else {
						$('tr[id="tr' + id + '"]').attr("class", "carrito_item_sinoferta");
						$('tr[id="tr' + id + '"]').attr("title", 'Dto:' + data.carros.descuento + "%" + 'Uni. Min:' + data.carros.unidad_minima + 'T.Of.:' + data.carros.tipo_oferta);

						if ($('tr[id="trBody' + id + '"]').length) {

						$('tr[id="trBody' + id + '"]').attr("class", "carrito_item_sinoferta");
						$('tr[id="trBody' + id + '"]').attr("title", 'Dto:' + data.carros.descuento + "%" + 'Uni. Min:' + data.carros.unidad_minima + 'T.Of.:' + data.carros.tipo_oferta);
						}
						}
						*/
						/*
											var numero = data.subtotal[1];
											const noTruncarDecimales = {
												maximumFractionDigits: 2,
												minimumFractionDigits: 2
											};
											ptos = numero.toLocaleString('es', noTruncarDecimales);
						*/
						/*
						if (data.subtotal[3] >= 100) {
						document.getElementById('openerts').innerHTML = "+99";
						document.getElementById('modalitems').innerHTML = data.subtotal[0] + "/" + data.subtotal[3];
						if ($("#modalitems1").length) {
						document.getElementById('modalitems1').innerHTML = data.subtotal[0] + "/" + data.subtotal[3];
						}
						if ($('#unidades').length) {
						document.getElementById('unidades').innerHTML = data.subtotal[0] + "/" + data.subtotal[3];
						}

						} else {
						document.getElementById('openerts').innerHTML = data.subtotal[3];
						document.getElementById('modalitems').innerHTML = data.subtotal[0] + "/" + data.subtotal[3];
						if ($("#modalitems1").length) {
						document.getElementById('modalitems1').innerHTML = data.subtotal[0] + "/" + data.subtotal[3];
						}
						if ($('#unidades').length) {
						document.getElementById('unidades').innerHTML = data.subtotal[0] + "/" + data.subtotal[3];
						}

						}*/
						/*
											$("#carrito_importe_view").html("$ " + ptos);
											$("#carrito_importe").html("$ " + ptos);
											$("#carrito_importe1").html("$ " + ptos);
											if ($("#modalitems1").length) {
												document.getElementById('modalitems1').innerHTML = data.subtotal[0] + "/" + data.subtotal[3];
											}
						*/
						alertify.success("Cantidad Modificada Con Exito!");



						break;

					case "6":

						$('<div class="jquery-notify-bar error top" id="__notifyBar4826526" style=""><span class="notify-bar-text-wrapper">No se puede agregar este producto al carro de compras.</span><a href="#" onclick="cerrarDiv()" class="notify-bar-close">×</a></div>').appendTo('body');
						$('#terminobuscar').val("");
						$("#mydivBuscar").html("<p>No tienes Permisos para agregar productos de esta categoria.</p>");
						$('.formcartcant').val("");
						break;
					case "5":
						$('<div class="jquery-notify-bar error top" id="__notifyBar4826526" style=""><span class="notify-bar-text-wrapper">No se puede agregar este producto al carro de compras. </span><a href="#" onclick="cerrarDiv()"class="notify-bar-close">×</a></div>').appendTo('body');
						$('#terminobuscar').val("");
						$("#mydivBuscar").html("<p>No tienes Permisos para agregar productos de esta categoria.</p>");
						$('.formcartcant').val("");
						break;
					case "0":
						$('<div class="jquery-notify-bar error top" id="__notifyBar4826526" style=""><span class="notify-bar-text-wrapper">No se puede agregar este producto al carro de compras. </span><a href="#" onclick="cerrarDiv()"class="notify-bar-close">×</a></div>').appendTo('body');
						$('#terminobuscar').val("");
						$("#mydivBuscar").html("<p>No tienes Permisos para agregar productos de esta categoria.</p>");
						$('.formcartcant').val("");
						break;


					case "eliminado":

						alertify.success("Eliminado con exito!");
						if (data.subtotal[3] >= 100) {
							document.getElementById('openerts').innerHTML = "+99";
							document.getElementById('modalitems').innerHTML = data.subtotal[0] + "/" + data.subtotal[3];
							if ($("#modalitems1").length) {
								document.getElementById('modalitems1').innerHTML = data.subtotal[0] + "/" + data.subtotal[3];
							}
							if ($('#unidades').length) {
								document.getElementById('unidades').innerHTML = data.subtotal[0] + "/" + data.subtotal[3];
							}

						} else {
							document.getElementById('openerts').innerHTML = data.subtotal[3];
							document.getElementById('modalitems').innerHTML = data.subtotal[0] + "/" + data.subtotal[3];
							if ($("#modalitems1").length) {
								document.getElementById('modalitems1').innerHTML = data.subtotal[0] + "/" + data.subtotal[3];
							}
							if ($('#unidades').length) {
								document.getElementById('unidades').innerHTML = data.subtotal[0] + "/" + data.subtotal[3];
							}

						}
						$("#carrito_importe_view").html(data.subtotal[1].toFixed(2));
						$("#carrito_importe").html("$" + data.subtotal[1].toFixed(2));
						$("#carrito_importe1").html(data.subtotal[1].toFixed(2));



						var concarro = data.contenidocarro;
						$('#tr' + id).remove();



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

						break;



				}


				//$.each(data.carro, function(key, value) {});




			},
			/*ALERTA DE ERROR*/
			error: function(textStatus) {

				if (textStatus = "Success") {


				}
				console.log(textStatus);


				//window.location.replace("/products/clear");
			}
		});
	}
	//ACTUALIZAR ITEMS AL CARRITO
	function ajaxcartAgregar(id, quantity, pv_id, id_input) {

		$.ajax({
			type: "POST",
			url: "<?php echo \Cake\Routing\Router::url(array('controller' => 'Carritos', 'action' => 'itemupdate')); ?>",
			data: {
				id: id,
				quantity: quantity,
				descuento_id: pv_id,
				id_input: id_input

			},
			dataType: "json",
			success: function(data, textStatus) {
				//alert(data.responseText);
				switch (data.responseText) {

					case "ok":


						var concarro = data.contenidocarro;

						var numero = data.subtotal[1];
						const noTruncarDecimales = {
							maximumFractionDigits: 2,
							minimumFractionDigits: 2
						};
						ptos = numero.toLocaleString('es', noTruncarDecimales);

						//preguntamos si existe el id en la tabla el tr

						if ($('tr[id=tr' + id + ']').length) {
							if (data.carros.cantidad >= data.carros.unidad_minima) {

								$('tr[id=tr' + id + ']').attr("class", "");
								if ($('tr[id=trBody' + id + ']').length) {
									$('tr[id=trBody' + id + ']').attr("class", "");
								}


							} else {
								$('tr[id=tr' + id + ']').attr("class", "carrito_item_sinoferta");
								$('tr[id=tr' + id + ']').attr("title", 'Dto:' + data.carros.descuento + "%" + 'Uni. Min:' + data.carros.unidad_minima + 'T.Of.:' + data.carros.tipo_oferta);

								if ($('tr[id=trBody' + id + ']').length) {

									$('tr[id=trBody' + id + ']').attr("class", "carrito_item_sinoferta");
									$('tr[id=trBody' + id + ']').attr("title", 'Dto:' + data.carros.descuento + "%" + 'Uni. Min:' + data.carros.unidad_minima + 'T.Of.:' + data.carros.tipo_oferta);
								}
							}

							alertify.success("Cantidad Modificada Con Exito!");
							$('input[data-id=' + id + ']').val(data.carros.cantidad);
							$("#" + id_input).val(data.carros.cantidad);

							if (data.subtotal[3] >= 100) {
								document.getElementById('openerts').innerHTML = "+99";
								document.getElementById('modalitems').innerHTML = data.subtotal[0] + "/" + data.subtotal[3];
								if ($("#modalitems1").length) {
									document.getElementById('modalitems1').innerHTML = data.subtotal[0] + "/" + data.subtotal[3];
								}
								if ($('#unidades').length) {
									document.getElementById('unidades').innerHTML = data.subtotal[0] + "/" + data.subtotal[3];
								}

							} else {
								document.getElementById('openerts').innerHTML = data.subtotal[3];
								document.getElementById('modalitems').innerHTML = data.subtotal[0] + "/" + data.subtotal[3];
								if ($("#modalitems1").length) {
									document.getElementById('modalitems1').innerHTML = data.subtotal[0] + "/" + data.subtotal[3];
								}
								if ($('#unidades').length) {
									document.getElementById('unidades').innerHTML = data.subtotal[0] + "/" + data.subtotal[3];
								}

							}

							$("#carrito_importe_view").html("$ " + ptos);
							$("#carrito_importe").html("$ " + ptos);
							$("#carrito_importe1").html("$ " + ptos);

							$("#" + data.carros.articulo_id).val(data.carros.cantidad);
							$('#openerts').attr('data-value', data.subtotal[3]);

						} else {
							$("#table").removeClass("hide");
							$("#tabla").removeClass("hide");

							//creamos el div openerts 
							$('#tablaprueba').remove();
							//$("#tablaprueba1").addClass("hide");


							$('<div class="carro_unidades_ico" alt="Ver" id="openert"   ><div><div class="carro_unidades_nro" id="openerts" onclick="focusMethod()"  ></div></div>').appendTo('.menu');
							$('<div id="unidades"></div>').appendTo('.carrito_importe_s');
							//asignamos valor al value de openert


							if (data.subtotal[3] >= 100) {
								document.getElementById('openerts').innerHTML = "+99";
								document.getElementById('modalitems').innerHTML = data.subtotal[0] + "/" + data.subtotal[3];
								if ($("#modalitems1").length) {
									document.getElementById('modalitems1').innerHTML = data.subtotal[0] + "/" + data.subtotal[3];
								}
								if ($('#unidades').length) {
									document.getElementById('unidades').innerHTML = data.subtotal[0] + "/" + data.subtotal[3];
								}

							} else {
								document.getElementById('openerts').innerHTML = data.subtotal[3];
								document.getElementById('modalitems').innerHTML = data.subtotal[0] + "/" + data.subtotal[3];
								if ($("#modalitems1").length) {
									document.getElementById('modalitems1').innerHTML = data.subtotal[0] + "/" + data.subtotal[3];
								}
								if ($('#unidades').length) {
									document.getElementById('unidades').innerHTML = data.subtotal[0] + "/" + data.subtotal[3];
								}

							}
							$("#carrito_importe_view").html("$ " + ptos);
							$("#carrito_importe").html("$ " + ptos);
							$("#carrito_importe1").html("$ " + ptos);
							$('#openerts').attr('data-value', data.subtotal[3]);
							// si no existe  




							let tabla = document.getElementById("table");


							document.getElementById("table").innerHTML = "";
							for (const ccarro of concarro) {
								if (ccarro.cantidad >= ccarro.unidad_minima) {
									let tr = document.createElement('tr');
									let tdDESCRIPCION = document.createElement('td');
									let tdEDITAR = document.createElement('td');
									let tdEDITAR1 = document.createElement('td');
									let img = document.createElement('img');
									let aeliminar = document.createElement('a');
									let tdCANTIDAD = document.createElement('input');
									let tdform = document.createElement('input');
									let tdbuttonmas = document.createElement("button");
									let tdbuttonmenos = document.createElement("button");
									let form = document.createElement("form");
									tabla.className = ('table table-striped');
									tr.id = ("tr" + ccarro.articulo_id);
									//tr.className =('carrito_item_sinoferta');
									tdDESCRIPCION.className = ('carrito_item_descripcion');
									tdCANTIDAD.className = ('formcarritocant text-center');
									tdCANTIDAD.onkeypress = soloNumeros;
									tdCANTIDAD.id = ("car" + ccarro.articulo_id);
									tdCANTIDAD.value = (ccarro.cantidad);
									tdCANTIDAD.maxLength = 3;
									tdCANTIDAD.setAttribute("data-pv-id", ccarro.descuento_id);
									tdCANTIDAD.setAttribute("data-id", ccarro.articulo_id);
									tdCANTIDAD.setAttribute("data-id-input", ccarro.articulo_id);
									aeliminar.href = ('#');
									aeliminar.id = ('delete');
									aeliminar.onclick = function() {
										alertify.confirm('Eliminar Datos', '¿Esta seguro de eliminar este Articulo?',
											function() {
												eliminarDatos(ccarro.id, ccarro.articulo_id)
											},
											function() {
												alertify.error('Se cancelo la operación')
											});
									};
									img.src = '/ds3/img/delete_ico.png';
									img.class = ("delete");
									form.method = "POST";
									form.style = "display:none;";
									form.name = "";
									tdform.name = "_method";
									tdform.value = "POST";
									tdEDITAR.className = ('c');
									tdbuttonmas.className = ('btn btn-sm');
									tdbuttonmenos.className = ('btn btn-sm');
									tdbuttonmas.innerHTML = '+';
									tdbuttonmas.onclick = function() {
										increment(ccarro.articulo_id, ccarro.descuento_id, ccarro.articulo_id)
									};
									tdbuttonmenos.onclick = function() {
										decrement(ccarro.articulo_id, ccarro.descuento_id, ccarro.articulo_id, ccarro.id)
									};
									tdEDITAR1.className = ('carrito_item_cantida');
									tdbuttonmenos.innerHTML = '-';
									tdDESCRIPCION.innerText = ccarro.descripcion;
									tdCANTIDAD.innerText = ccarro.cantidad;

									tdCANTIDAD.onchange = function() {
										var quantity = Math.round($(this).val());
										ajaxcart($(this).attr("data-id"), quantity, $(this).attr("data-pv-id"), $(this).attr("data-id-input"));

									};
									tr.appendChild(tdDESCRIPCION);
									tr.appendChild(tdEDITAR1);
									tr.appendChild(tdEDITAR);
									tdEDITAR.appendChild(form);
									tdEDITAR1.appendChild(tdbuttonmenos);
									tdEDITAR1.appendChild(tdCANTIDAD);
									tdEDITAR1.appendChild(tdbuttonmas);
									form.appendChild(tdform);


									tdEDITAR.appendChild(aeliminar);

									aeliminar.appendChild(img);
									tabla.appendChild(tr);


								} else {
									let tr = document.createElement('tr');
									let tdDESCRIPCION = document.createElement('td');
									let tdEDITAR = document.createElement('td');
									let tdEDITAR1 = document.createElement('td');
									let img = document.createElement('img');
									let aeliminar = document.createElement('a');
									let tdCANTIDAD = document.createElement('input');
									let tdform = document.createElement('input');
									let tdbuttonmas = document.createElement("button");
									let tdbuttonmenos = document.createElement("button");
									let form = document.createElement("form");
									tabla.className = ('table table-striped');
									tr.id = ("tr" + ccarro.articulo_id);
									tr.className = ('carrito_item_sinoferta');
									tdDESCRIPCION.className = ('carrito_item_descripcion');
									tdCANTIDAD.className = ('formcarritocant text-center');
									tdCANTIDAD.onkeypress = soloNumeros;
									tdCANTIDAD.id = ("car" + ccarro.articulo_id);
									tdCANTIDAD.value = (ccarro.cantidad);
									tdCANTIDAD.maxLength = 3;
									tdCANTIDAD.setAttribute("data-pv-id", ccarro.descuento_id);
									tdCANTIDAD.setAttribute("data-id", ccarro.articulo_id);
									tdCANTIDAD.setAttribute("data-id-input", ccarro.articulo_id);
									aeliminar.href = ('#');
									aeliminar.id = ('delete');
									aeliminar.onclick = function() {
										alertify.confirm('Eliminar Datos', '¿Esta seguro de eliminar este Articulo?',
											function() {
												eliminarDatos(ccarro.id, ccarro.articulo_id)
											},
											function() {
												alertify.error('Se cancelo la operación')
											});
									};
									img.src = '/ds3/img/delete_ico.png';
									img.class = ("delete");
									form.method = "POST";
									form.style = "display:none;";
									form.name = "";
									tdform.name = "_method";
									tdform.value = "POST";
									tdEDITAR.className = ('c');
									tdbuttonmas.className = ('btn btn-sm');
									tdbuttonmenos.className = ('btn btn-sm');
									tdbuttonmas.innerHTML = '+';
									tdbuttonmas.onclick = function() {
										increment(ccarro.articulo_id, ccarro.descuento_id, ccarro.articulo_id)
									};
									tdbuttonmenos.onclick = function() {
										decrement(ccarro.articulo_id, ccarro.descuento_id, ccarro.articulo_id, ccarro.id)
									};
									tdEDITAR1.className = ('carrito_item_cantida');
									tdbuttonmenos.innerHTML = '-';
									tdDESCRIPCION.innerText = ccarro.descripcion;
									tdCANTIDAD.innerText = ccarro.cantidad;

									tdCANTIDAD.onchange = function() {
										var quantity = Math.round($(this).val());
										ajaxcart($(this).attr("data-id"), quantity, $(this).attr("data-pv-id"), $(this).attr("data-id-input"));

									};
									tr.appendChild(tdDESCRIPCION);
									tr.appendChild(tdEDITAR1);
									tr.appendChild(tdEDITAR);
									tdEDITAR.appendChild(form);
									tdEDITAR1.appendChild(tdbuttonmenos);
									tdEDITAR1.appendChild(tdCANTIDAD);
									tdEDITAR1.appendChild(tdbuttonmas);
									form.appendChild(tdform);


									tdEDITAR.appendChild(aeliminar);

									aeliminar.appendChild(img);
									tabla.appendChild(tr);





								}
							}

							if ($('#tablaprueba1').length) {
								//alert("existe tabla prueba1")
								let table = document.getElementById("table1");
								document.getElementById("table1").innerHTML = "";
								$("#tablaprueba1").addClass("hide");
								$("#table1").removeClass("hide");
								$("#tabla1").removeClass("hide");

								for (const ccarro of concarro) {
									if (ccarro.cantidad >= ccarro.unidad_minima) {
										let tr = document.createElement('tr');
										let tdDESCRIPCION = document.createElement('td');
										let tdEDITAR = document.createElement('td');
										let tdEDITAR1 = document.createElement('td');
										let img = document.createElement('img');
										let aeliminar = document.createElement('a');
										let tdCANTIDAD = document.createElement('input');
										let tdform = document.createElement('input');
										let tdbuttonmas = document.createElement("button");
										let tdbuttonmenos = document.createElement("button");
										let form = document.createElement("form");
										table.className = ('table table-striped');
										tr.id = ("trBody" + ccarro.articulo_id);
										//tr.className =('carrito_item_sinoferta');
										tdDESCRIPCION.className = ('carrito_item_descripcion');
										tdCANTIDAD.className = ('formcarritocant text-center');
										tdCANTIDAD.onkeypress = soloNumeros;
										tdCANTIDAD.id = ("carb" + ccarro.articulo_id);
										tdCANTIDAD.value = (ccarro.cantidad);
										tdCANTIDAD.maxLength = 3;
										tdCANTIDAD.setAttribute("data-pv-id", ccarro.descuento_id);
										tdCANTIDAD.setAttribute("data-id", ccarro.articulo_id);
										tdCANTIDAD.setAttribute("data-id-input", ccarro.articulo_id);
										aeliminar.href = ('#');
										aeliminar.id = ('delete');
										aeliminar.onclick = function() {
											alertify.confirm('Eliminar Datos', '¿Esta seguro de eliminar este Articulo?',
												function() {
													eliminarDatos(ccarro.id, ccarro.articulo_id)
												},
												function() {
													alertify.error('Se cancelo la operación')
												});
										};
										img.src = '/ds3/img/delete_ico.png';
										img.class = ("delete");
										form.method = "POST";
										form.style = "display:none;";
										form.name = "";
										tdform.name = "_method";
										tdform.value = "POST";
										tdEDITAR.className = ('c');
										tdbuttonmas.className = ('btn btn-sm');
										tdbuttonmenos.className = ('btn btn-sm');
										tdbuttonmas.innerHTML = '+';
										tdbuttonmas.onclick = function() {
											increment(ccarro.articulo_id, ccarro.descuento_id, ccarro.articulo_id)
										};
										tdbuttonmenos.onclick = function() {
											decrement(ccarro.articulo_id, ccarro.descuento_id, ccarro.articulo_id, ccarro.id)
										};
										tdEDITAR1.className = ('carrito_item_cantida');
										tdbuttonmenos.innerHTML = '-';
										tdDESCRIPCION.innerText = ccarro.descripcion;
										tdCANTIDAD.innerText = ccarro.cantidad;

										tdCANTIDAD.onchange = function() {
											var quantity = Math.round($(this).val());
											ajaxcart($(this).attr("data-id"), quantity, $(this).attr("data-pv-id"), $(this).attr("data-id-input"));

										};
										tr.appendChild(tdDESCRIPCION);
										tr.appendChild(tdEDITAR1);
										tr.appendChild(tdEDITAR);
										tdEDITAR.appendChild(form);
										tdEDITAR1.appendChild(tdbuttonmenos);
										tdEDITAR1.appendChild(tdCANTIDAD);
										tdEDITAR1.appendChild(tdbuttonmas);
										form.appendChild(tdform);


										tdEDITAR.appendChild(aeliminar);

										aeliminar.appendChild(img);
										table.appendChild(tr);



									} else {
										let tr = document.createElement('tr');
										let tdDESCRIPCION = document.createElement('td');
										let tdEDITAR = document.createElement('td');
										let tdEDITAR1 = document.createElement('td');
										let img = document.createElement('img');
										let aeliminar = document.createElement('a');
										let tdCANTIDAD = document.createElement('input');
										let tdform = document.createElement('input');
										let tdbuttonmas = document.createElement("button");
										let tdbuttonmenos = document.createElement("button");
										let form = document.createElement("form");
										table.className = ('table table-striped');
										tr.id = ("trBody" + ccarro.articulo_id);
										tr.className = ('carrito_item_sinoferta');
										tdDESCRIPCION.className = ('carrito_item_descripcion');
										tdCANTIDAD.className = ('formcarritocant text-center');
										tdCANTIDAD.onkeypress = soloNumeros;
										tdCANTIDAD.id = ("carb" + ccarro.articulo_id);
										tdCANTIDAD.value = (ccarro.cantidad);
										tdCANTIDAD.maxLength = 3;
										tdCANTIDAD.setAttribute("data-pv-id", ccarro.descuento_id);
										tdCANTIDAD.setAttribute("data-id", ccarro.articulo_id);
										tdCANTIDAD.setAttribute("data-id-input", ccarro.articulo_id);
										aeliminar.href = ('#');
										aeliminar.id = ('delete');
										aeliminar.onclick = function() {
											alertify.confirm('Eliminar Datos', '¿Esta seguro de eliminar este Articulo?',
												function() {
													eliminarDatos(ccarro.id, ccarro.articulo_id)
												},
												function() {
													alertify.error('Se cancelo la operación')
												});
										};
										img.src = '/ds3/img/delete_ico.png';
										img.class = ("delete");
										form.method = "POST";
										form.style = "display:none;";
										form.name = "";
										tdform.name = "_method";
										tdform.value = "POST";
										tdEDITAR.className = ('c');
										tdbuttonmas.className = ('btn btn-sm');
										tdbuttonmenos.className = ('btn btn-sm');
										tdbuttonmas.innerHTML = '+';
										tdbuttonmas.onclick = function() {
											increment(ccarro.articulo_id, ccarro.descuento_id, ccarro.articulo_id)
										};
										tdbuttonmenos.onclick = function() {
											decrement(ccarro.articulo_id, ccarro.descuento_id, ccarro.articulo_id, ccarro.id)
										};
										tdEDITAR1.className = ('carrito_item_cantida');
										tdbuttonmenos.innerHTML = '-';
										tdDESCRIPCION.innerText = ccarro.descripcion;
										tdCANTIDAD.innerText = ccarro.cantidad;

										tdCANTIDAD.onchange = function() {
											var quantity = Math.round($(this).val());
											ajaxcart($(this).attr("data-id"), quantity, $(this).attr("data-pv-id"), $(this).attr("data-id-input"));

										};
										tr.appendChild(tdDESCRIPCION);
										tr.appendChild(tdEDITAR1);
										tr.appendChild(tdEDITAR);
										tdEDITAR.appendChild(form);
										tdEDITAR1.appendChild(tdbuttonmenos);
										tdEDITAR1.appendChild(tdCANTIDAD);
										tdEDITAR1.appendChild(tdbuttonmas);
										form.appendChild(tdform);


										tdEDITAR.appendChild(aeliminar);

										aeliminar.appendChild(img);
										table.appendChild(tr);





									}
								}
							}




							alertify.success("Cantidad Agregada Con Exito!");
							$('.page_cart').remove();
							$('table.table-striped').each(function() {
								var currentPage = 0;
								var numPerPage = 8;
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

						}


						//}
						//para editar comprobamos si ya la cantidad es mayor a 0 	




						break;

					case "6":

						$('<div class="jquery-notify-bar error top" id="__notifyBar4826526" style=""><span class="notify-bar-text-wrapper">No se puede agregar este producto al carro de compras.</span><a href="#" onclick="cerrarDiv()" class="notify-bar-close">×</a></div>').appendTo('body');
						$('#terminobuscar').val("");
						$("#mydivBuscar").html("<p>No tienes Permisos para agregar productos de esta categoria.</p>");
						$('.formcartcant').val("");
						break;
					case "5":
						$('<div class="jquery-notify-bar error top" id="__notifyBar4826526" style=""><span class="notify-bar-text-wrapper">No se puede agregar este producto al carro de compras. </span><a href="#" onclick="cerrarDiv()"class="notify-bar-close">×</a></div>').appendTo('body');
						$('#terminobuscar').val("");
						$("#mydivBuscar").html("<p>No tienes Permisos para agregar productos de esta categoria.</p>");
						$('.formcartcant').val("");
						break;
					case "0":
						$('<div class="jquery-notify-bar error top" id="__notifyBar4826526" style=""><span class="notify-bar-text-wrapper">No se puede agregar este producto al carro de compras. </span><a href="#" onclick="cerrarDiv()"class="notify-bar-close">×</a></div>').appendTo('body');
						$('#terminobuscar').val("");
						$("#mydivBuscar").html("<p>No tienes Permisos para agregar productos de esta categoria.</p>");
						$('.formcartcant').val("");
						break;

					case "eliminado":

						alertify.success("Eliminado con exito!");
						if (data.subtotal[3] >= 100) {
							document.getElementById('openerts').innerHTML = "+99";
							document.getElementById('modalitems').innerHTML = data.subtotal[0] + "/" + data.subtotal[3];
							if ($("#modalitems1").length) {
								if ($("#modalitems1").length) {
									document.getElementById('modalitems1').innerHTML = data.subtotal[0] + "/" + data.subtotal[3];
								}
							}

							if ($('#unidades').length) {
								document.getElementById('unidades').innerHTML = data.subtotal[0] + "/" + data.subtotal[3];
							}
						} else {
							document.getElementById('openerts').innerHTML = data.subtotal[3];
							document.getElementById('modalitems').innerHTML = data.subtotal[0] + "/" + data.subtotal[3];
							if ($("#modalitems1").length) {
								document.getElementById('modalitems1').innerHTML = data.subtotal[0] + "/" + data.subtotal[3];
							}
							if ($('#unidades').length) {
								document.getElementById('unidades').innerHTML = data.subtotal[0] + "/" + data.subtotal[3];
							}

						}
						$("#carrito_importe_view").html(data.subtotal[1].toFixed(2));
						$("#carrito_importe").html(data.subtotal[1].toFixed(2));
						$("#carrito_importe1").html(data.subtotal[1].toFixed(2));



						var concarro = data.contenidocarro;
						$('#tr' + id).remove();



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

						break;




				}
				//$.each(data.carro, function(key, value) {});

				/* ALERTA DE EXITO */

				//$("#modalcar").load(" #modalcar");



			},
			/*ALERTA DE ERROR*/
			error: function(textStatus) {

				if (textStatus = "Success") {


				}
				console.log(textStatus);


				//window.location.replace("/products/clear");
			}
		});
	}
	//ACTUALIZAR ITEMS EN STORE DE OFERTAS EN GENERAL CON UNIDADES MINIMAS
	function ajaxcartOferta(id, quantity, pv_id, id_input) {

		$.ajax({
			type: "POST",
			url: "<?php echo \Cake\Routing\Router::url(array('controller' => 'Carritos', 'action' => 'itemupdateofertas')); ?>",
			data: {
				id: id,
				quantity: quantity,
				descuento_id: pv_id,
				id_input: id_input

			},
			dataType: "json",
			success: function(data, textStatus) {
				//alert(data.responseText);
				switch (data.responseText) {

					case "ok":


						var concarro = data.contenidocarro;

						var numero = data.subtotal[1];
						const noTruncarDecimales = {
							maximumFractionDigits: 2,
							minimumFractionDigits: 2
						};
						ptos = numero.toLocaleString('es', noTruncarDecimales);

						//preguntamos si existe el id en la tabla el tr

						if ($('tr[id="tr' + id + '"]').length) {
							if (data.carros.cantidad >= data.carros.unidad_minima) {

								$('tr[id="tr' + id + '"]').attr("class", "");
								if ($('tr[id="trBody' + id + '"]').length) {
									$('tr[id="trBody' + id + '"]').attr("class", "");
								}


							} else {
								$('tr[id="tr' + id + '"]').attr("class", "carrito_item_sinoferta");
								$('tr[id"=tr' + id + '"]').attr("title", 'Dto:' + data.carros.descuento + "%" + 'Uni. Min:' + data.carros.unidad_minima + 'T.Of.:' + data.carros.tipo_oferta);

								if ($('tr[id="trBody' + id + '"]').length) {

									$('tr[id="trBody' + id + '"]').attr("class", "carrito_item_sinoferta");
									$('tr[id="trBody' + id + '"]').attr("title", 'Dto:' + data.carros.descuento + "%" + 'Uni. Min:' + data.carros.unidad_minima + 'T.Of.:' + data.carros.tipo_oferta);
								}
							}

							alertify.success("Cantidad Modificada Con Exito!");
							$('input[data-id=' + id + ']').val(data.carros.cantidad);
							$("#" + id_input).val(data.carros.cantidad);
							$("#bu" + id).val(data.carros.cantidad);


							if (data.subtotal[3] >= 100) {
								document.getElementById('openerts').innerHTML = "+99";
								document.getElementById('modalitems').innerHTML = data.subtotal[0] + "/" + data.subtotal[3];
								if ($("#modalitems1").length) {
									document.getElementById('modalitems1').innerHTML = data.subtotal[0] + "/" + data.subtotal[3];
								}
								if ($('#unidades').length) {
									document.getElementById('unidades').innerHTML = data.subtotal[0] + "/" + data.subtotal[3];
								}

							} else {
								document.getElementById('openerts').innerHTML = data.subtotal[3];
								document.getElementById('modalitems').innerHTML = data.subtotal[0] + "/" + data.subtotal[3];
								if ($("#modalitems1").length) {
									document.getElementById('modalitems1').innerHTML = data.subtotal[0] + "/" + data.subtotal[3];
								}
								if ($('#unidades').length) {
									document.getElementById('unidades').innerHTML = data.subtotal[0] + "/" + data.subtotal[3];
								}

							}

							$("#carrito_importe_view").html("$ " + ptos);
							$("#carrito_importe").html("$ " + ptos);
							$("#carrito_importe1").html("$ " + ptos);

							$("#" + data.carros.articulo_id).val(data.carros.cantidad);
							$("#bu" + data.carros.articulo_id).val(data.carros.cantidad);
							$('#openerts').attr('data-value', data.subtotal[3]);

						} else {
							$("#table").removeClass("hide");
							$("#tabla").removeClass("hide");

							//creamos el div openerts 
							$('#tablaprueba').remove();
							//$("#tablaprueba1").addClass("hide");


							$('<div class="carro_unidades_ico" alt="Ver" id="openert"   ><div><div class="carro_unidades_nro" id="openerts" onclick="focusMethod()"  ></div></div>').appendTo('.menu');
							$('<div id="unidades"></div>').appendTo('.carrito_importe_s');
							//asignamos valor al value de openert


							if (data.subtotal[3] >= 100) {
								document.getElementById('openerts').innerHTML = "+99";
								document.getElementById('modalitems').innerHTML = data.subtotal[0] + "/" + data.subtotal[3];
								if ($("#modalitems1").length) {
									document.getElementById('modalitems1').innerHTML = data.subtotal[0] + "/" + data.subtotal[3];
								}
								if ($('#unidades').length) {
									document.getElementById('unidades').innerHTML = data.subtotal[0] + "/" + data.subtotal[3];
								}

							} else {
								document.getElementById('openerts').innerHTML = data.subtotal[3];
								document.getElementById('modalitems').innerHTML = data.subtotal[0] + "/" + data.subtotal[3];
								if ($("#modalitems1").length) {
									document.getElementById('modalitems1').innerHTML = data.subtotal[0] + "/" + data.subtotal[3];
								}
								if ($('#unidades').length) {
									document.getElementById('unidades').innerHTML = data.subtotal[0] + "/" + data.subtotal[3];
								}

							}
							$("#carrito_importe_view").html("$ " + ptos);
							$("#carrito_importe").html("$ " + ptos);
							$("#carrito_importe1").html("$ " + ptos);
							$('#openerts').attr('data-value', data.subtotal[3]);
							$("#bu" + id).val(data.carros.cantidad);
							// si no existe  




							let tabla = document.getElementById("table");


							document.getElementById("table").innerHTML = "";
							for (const ccarro of concarro) {
								if (ccarro.cantidad >= ccarro.unidad_minima) {
									let tr = document.createElement('tr');
									let tdDESCRIPCION = document.createElement('td');
									let tdEDITAR = document.createElement('td');
									let tdEDITAR1 = document.createElement('td');
									let img = document.createElement('img');
									let aeliminar = document.createElement('a');
									let tdCANTIDAD = document.createElement('input');
									let tdform = document.createElement('input');
									let tdbuttonmas = document.createElement("button");
									let tdbuttonmenos = document.createElement("button");
									let form = document.createElement("form");
									tabla.className = ('table table-striped');
									tr.id = ("tr" + ccarro.articulo_id);
									//tr.className =('carrito_item_sinoferta');
									tdDESCRIPCION.className = ('carrito_item_descripcion');
									tdCANTIDAD.className = ('formcarritocant text-center');
									tdCANTIDAD.onkeypress = soloNumeros;
									tdCANTIDAD.id = ("car" + ccarro.articulo_id);
									tdCANTIDAD.value = (ccarro.cantidad);
									tdCANTIDAD.maxLength = 3;
									tdCANTIDAD.setAttribute("data-pv-id", ccarro.descuento_id);
									tdCANTIDAD.setAttribute("data-id", ccarro.articulo_id);
									tdCANTIDAD.setAttribute("data-id-input", ccarro.articulo_id);
									aeliminar.href = ('#');
									aeliminar.id = ('delete');
									aeliminar.onclick = function() {
										alertify.confirm('Eliminar Datos', '¿Esta seguro de eliminar este Articulo?',
											function() {
												eliminarDatos(ccarro.id, ccarro.articulo_id)
											},
											function() {
												alertify.error('Se cancelo la operación')
											});
									};
									img.src = '/ds3/img/delete_ico.png';
									img.class = ("delete");
									form.method = "POST";
									form.style = "display:none;";
									form.name = "";
									tdform.name = "_method";
									tdform.value = "POST";
									tdEDITAR.className = ('c');
									tdbuttonmas.className = ('btn btn-sm');
									tdbuttonmenos.className = ('btn btn-sm');
									tdbuttonmas.innerHTML = '+';
									tdbuttonmas.onclick = function() {
										increment(ccarro.articulo_id, ccarro.descuento_id, ccarro.articulo_id)
									};
									tdbuttonmenos.onclick = function() {
										decrement(ccarro.articulo_id, ccarro.descuento_id, ccarro.articulo_id, ccarro.id)
									};
									tdEDITAR1.className = ('carrito_item_cantida');
									tdbuttonmenos.innerHTML = '-';
									tdDESCRIPCION.innerText = ccarro.descripcion;
									tdCANTIDAD.innerText = ccarro.cantidad;

									tdCANTIDAD.onchange = function() {
										var quantity = Math.round($(this).val());
										ajaxcart($(this).attr("data-id"), quantity, $(this).attr("data-pv-id"), $(this).attr("data-id-input"));

									};
									tr.appendChild(tdDESCRIPCION);
									tr.appendChild(tdEDITAR1);
									tr.appendChild(tdEDITAR);
									tdEDITAR.appendChild(form);
									tdEDITAR1.appendChild(tdbuttonmenos);
									tdEDITAR1.appendChild(tdCANTIDAD);
									tdEDITAR1.appendChild(tdbuttonmas);
									form.appendChild(tdform);


									tdEDITAR.appendChild(aeliminar);

									aeliminar.appendChild(img);
									tabla.appendChild(tr);


								} else {
									let tr = document.createElement('tr');
									let tdDESCRIPCION = document.createElement('td');
									let tdEDITAR = document.createElement('td');
									let tdEDITAR1 = document.createElement('td');
									let img = document.createElement('img');
									let aeliminar = document.createElement('a');
									let tdCANTIDAD = document.createElement('input');
									let tdform = document.createElement('input');
									let tdbuttonmas = document.createElement("button");
									let tdbuttonmenos = document.createElement("button");
									let form = document.createElement("form");
									tabla.className = ('table table-striped');
									tr.id = ("tr" + ccarro.articulo_id);
									tr.className = ('carrito_item_sinoferta');
									tdDESCRIPCION.className = ('carrito_item_descripcion');
									tdCANTIDAD.className = ('formcarritocant text-center');
									tdCANTIDAD.onkeypress = soloNumeros;
									tdCANTIDAD.id = ("car" + ccarro.articulo_id);
									tdCANTIDAD.value = (ccarro.cantidad);
									tdCANTIDAD.maxLength = 3;
									tdCANTIDAD.setAttribute("data-pv-id", ccarro.descuento_id);
									tdCANTIDAD.setAttribute("data-id", ccarro.articulo_id);
									tdCANTIDAD.setAttribute("data-id-input", ccarro.articulo_id);
									aeliminar.href = ('#');
									aeliminar.id = ('delete');
									aeliminar.onclick = function() {
										alertify.confirm('Eliminar Datos', '¿Esta seguro de eliminar este Articulo?',
											function() {
												eliminarDatos(ccarro.id, ccarro.articulo_id)
											},
											function() {
												alertify.error('Se cancelo la operación')
											});
									};
									img.src = '/ds3/img/delete_ico.png';
									img.class = ("delete");
									form.method = "POST";
									form.style = "display:none;";
									form.name = "";
									tdform.name = "_method";
									tdform.value = "POST";
									tdEDITAR.className = ('c');
									tdbuttonmas.className = ('btn btn-sm');
									tdbuttonmenos.className = ('btn btn-sm');
									tdbuttonmas.innerHTML = '+';
									tdbuttonmas.onclick = function() {
										increment(ccarro.articulo_id, ccarro.descuento_id, ccarro.articulo_id)
									};
									tdbuttonmenos.onclick = function() {
										decrement(ccarro.articulo_id, ccarro.descuento_id, ccarro.articulo_id, ccarro.id)
									};
									tdEDITAR1.className = ('carrito_item_cantida');
									tdbuttonmenos.innerHTML = '-';
									tdDESCRIPCION.innerText = ccarro.descripcion;
									tdCANTIDAD.innerText = ccarro.cantidad;

									tdCANTIDAD.onchange = function() {
										var quantity = Math.round($(this).val());
										ajaxcart($(this).attr("data-id"), quantity, $(this).attr("data-pv-id"), $(this).attr("data-id-input"));

									};
									tr.appendChild(tdDESCRIPCION);
									tr.appendChild(tdEDITAR1);
									tr.appendChild(tdEDITAR);
									tdEDITAR.appendChild(form);
									tdEDITAR1.appendChild(tdbuttonmenos);
									tdEDITAR1.appendChild(tdCANTIDAD);
									tdEDITAR1.appendChild(tdbuttonmas);
									form.appendChild(tdform);


									tdEDITAR.appendChild(aeliminar);

									aeliminar.appendChild(img);
									tabla.appendChild(tr);





								}
							}

							if ($('#tablaprueba1').length) {
								//alert("existe tabla prueba1")
								let table = document.getElementById("table1");
								document.getElementById("table1").innerHTML = "";
								$("#tablaprueba1").addClass("hide");
								$("#table1").removeClass("hide");
								$("#tabla1").removeClass("hide");

								for (const ccarro of concarro) {
									if (ccarro.cantidad >= ccarro.unidad_minima) {
										let tr = document.createElement('tr');
										let tdDESCRIPCION = document.createElement('td');
										let tdEDITAR = document.createElement('td');
										let tdEDITAR1 = document.createElement('td');
										let img = document.createElement('img');
										let aeliminar = document.createElement('a');
										let tdCANTIDAD = document.createElement('input');
										let tdform = document.createElement('input');
										let tdbuttonmas = document.createElement("button");
										let tdbuttonmenos = document.createElement("button");
										let form = document.createElement("form");
										table.className = ('table table-striped');
										tr.id = ("trBody" + ccarro.articulo_id);
										//tr.className =('carrito_item_sinoferta');
										tdDESCRIPCION.className = ('carrito_item_descripcion');
										tdCANTIDAD.className = ('formcarritocant text-center');
										tdCANTIDAD.onkeypress = soloNumeros;
										tdCANTIDAD.id = ("carb" + ccarro.articulo_id);
										tdCANTIDAD.value = (ccarro.cantidad);
										tdCANTIDAD.maxLength = 3;
										tdCANTIDAD.setAttribute("data-pv-id", ccarro.descuento_id);
										tdCANTIDAD.setAttribute("data-id", ccarro.articulo_id);
										tdCANTIDAD.setAttribute("data-id-input", ccarro.articulo_id);
										aeliminar.href = ('#');
										aeliminar.id = ('delete');
										aeliminar.onclick = function() {
											alertify.confirm('Eliminar Datos', '¿Esta seguro de eliminar este Articulo?',
												function() {
													eliminarDatos(ccarro.id, ccarro.articulo_id)
												},
												function() {
													alertify.error('Se cancelo la operación')
												});
										};
										img.src = '/ds3/img/delete_ico.png';
										img.class = ("delete");
										form.method = "POST";
										form.style = "display:none;";
										form.name = "";
										tdform.name = "_method";
										tdform.value = "POST";
										tdEDITAR.className = ('c');
										tdbuttonmas.className = ('btn btn-sm');
										tdbuttonmenos.className = ('btn btn-sm');
										tdbuttonmas.innerHTML = '+';
										tdbuttonmas.onclick = function() {
											increment(ccarro.articulo_id, ccarro.descuento_id, ccarro.articulo_id)
										};
										tdbuttonmenos.onclick = function() {
											decrement(ccarro.articulo_id, ccarro.descuento_id, ccarro.articulo_id, ccarro.id)
										};
										tdEDITAR1.className = ('carrito_item_cantida');
										tdbuttonmenos.innerHTML = '-';
										tdDESCRIPCION.innerText = ccarro.descripcion;
										tdCANTIDAD.innerText = ccarro.cantidad;

										tdCANTIDAD.onchange = function() {
											var quantity = Math.round($(this).val());
											ajaxcart($(this).attr("data-id"), quantity, $(this).attr("data-pv-id"), $(this).attr("data-id-input"));

										};
										tr.appendChild(tdDESCRIPCION);
										tr.appendChild(tdEDITAR1);
										tr.appendChild(tdEDITAR);
										tdEDITAR.appendChild(form);
										tdEDITAR1.appendChild(tdbuttonmenos);
										tdEDITAR1.appendChild(tdCANTIDAD);
										tdEDITAR1.appendChild(tdbuttonmas);
										form.appendChild(tdform);


										tdEDITAR.appendChild(aeliminar);

										aeliminar.appendChild(img);
										table.appendChild(tr);



									} else {
										let tr = document.createElement('tr');
										let tdDESCRIPCION = document.createElement('td');
										let tdEDITAR = document.createElement('td');
										let tdEDITAR1 = document.createElement('td');
										let img = document.createElement('img');
										let aeliminar = document.createElement('a');
										let tdCANTIDAD = document.createElement('input');
										let tdform = document.createElement('input');
										let tdbuttonmas = document.createElement("button");
										let tdbuttonmenos = document.createElement("button");
										let form = document.createElement("form");
										table.className = ('table table-striped');
										tr.id = ("trBody" + ccarro.articulo_id);
										tr.className = ('carrito_item_sinoferta');
										tdDESCRIPCION.className = ('carrito_item_descripcion');
										tdCANTIDAD.className = ('formcarritocant text-center');
										tdCANTIDAD.onkeypress = soloNumeros;
										tdCANTIDAD.id = ("carb" + ccarro.articulo_id);
										tdCANTIDAD.value = (ccarro.cantidad);
										tdCANTIDAD.maxLength = 3;
										tdCANTIDAD.setAttribute("data-pv-id", ccarro.descuento_id);
										tdCANTIDAD.setAttribute("data-id", ccarro.articulo_id);
										tdCANTIDAD.setAttribute("data-id-input", ccarro.articulo_id);
										aeliminar.href = ('#');
										aeliminar.id = ('delete');
										aeliminar.onclick = function() {
											alertify.confirm('Eliminar Datos', '¿Esta seguro de eliminar este Articulo?',
												function() {
													eliminarDatos(ccarro.id, ccarro.articulo_id)
												},
												function() {
													alertify.error('Se cancelo la operación')
												});
										};
										img.src = '/ds3/img/delete_ico.png';
										img.class = ("delete");
										form.method = "POST";
										form.style = "display:none;";
										form.name = "";
										tdform.name = "_method";
										tdform.value = "POST";
										tdEDITAR.className = ('c');
										tdbuttonmas.className = ('btn btn-sm');
										tdbuttonmenos.className = ('btn btn-sm');
										tdbuttonmas.innerHTML = '+';
										tdbuttonmas.onclick = function() {
											increment(ccarro.articulo_id, ccarro.descuento_id, ccarro.articulo_id)
										};
										tdbuttonmenos.onclick = function() {
											decrement(ccarro.articulo_id, ccarro.descuento_id, ccarro.articulo_id, ccarro.id)
										};
										tdEDITAR1.className = ('carrito_item_cantida');
										tdbuttonmenos.innerHTML = '-';
										tdDESCRIPCION.innerText = ccarro.descripcion;
										tdCANTIDAD.innerText = ccarro.cantidad;

										tdCANTIDAD.onchange = function() {
											var quantity = Math.round($(this).val());
											ajaxcart($(this).attr("data-id"), quantity, $(this).attr("data-pv-id"), $(this).attr("data-id-input"));

										};
										tr.appendChild(tdDESCRIPCION);
										tr.appendChild(tdEDITAR1);
										tr.appendChild(tdEDITAR);
										tdEDITAR.appendChild(form);
										tdEDITAR1.appendChild(tdbuttonmenos);
										tdEDITAR1.appendChild(tdCANTIDAD);
										tdEDITAR1.appendChild(tdbuttonmas);
										form.appendChild(tdform);


										tdEDITAR.appendChild(aeliminar);

										aeliminar.appendChild(img);
										table.appendChild(tr);





									}
								}
							}




							alertify.success("Cantidad Agregada Con Exito!");
							$('.page_cart').remove();
							$('table.table-striped').each(function() {
								var currentPage = 0;
								var numPerPage = 8;
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

						}


						//}
						//para editar comprobamos si ya la cantidad es mayor a 0 	




						break;

					case "6":

						$('<div class="jquery-notify-bar error top" id="__notifyBar4826526" style=""><span class="notify-bar-text-wrapper">No se puede agregar este producto al carro de compras.</span><a href="#" onclick="cerrarDiv()" class="notify-bar-close">×</a></div>').appendTo('body');
						$('#terminobuscar').val("");
						$("#mydivBuscar").html("<p>No tienes Permisos para agregar productos de esta categoria.</p>");
						$('.formcartcant').val("");
						break;
					case "5":
						$('<div class="jquery-notify-bar error top" id="__notifyBar4826526" style=""><span class="notify-bar-text-wrapper">No se puede agregar este producto al carro de compras. </span><a href="#" onclick="cerrarDiv()"class="notify-bar-close">×</a></div>').appendTo('body');
						$('#terminobuscar').val("");
						$("#mydivBuscar").html("<p>No tienes Permisos para agregar productos de esta categoria.</p>");
						$('.formcartcant').val("");
						break;
					case "0":
						$('<div class="jquery-notify-bar error top" id="__notifyBar4826526" style=""><span class="notify-bar-text-wrapper">No se puede agregar este producto al carro de compras. </span><a href="#" onclick="cerrarDiv()"class="notify-bar-close">×</a></div>').appendTo('body');
						$('#terminobuscar').val("");
						$("#mydivBuscar").html("<p>No tienes Permisos para agregar productos de esta categoria.</p>");
						$('.formcartcant').val("");
						break;

					case "eliminado":

						alertify.success("Eliminado con exito!");
						if (data.subtotal[3] >= 100) {
							document.getElementById('openerts').innerHTML = "+99";
							document.getElementById('modalitems').innerHTML = data.subtotal[0] + "/" + data.subtotal[3];
							if ($("#modalitems1").length) {
								if ($("#modalitems1").length) {
									document.getElementById('modalitems1').innerHTML = data.subtotal[0] + "/" + data.subtotal[3];
								}
							}

							if ($('#unidades').length) {
								document.getElementById('unidades').innerHTML = data.subtotal[0] + "/" + data.subtotal[3];
							}
						} else {
							document.getElementById('openerts').innerHTML = data.subtotal[3];
							document.getElementById('modalitems').innerHTML = data.subtotal[0] + "/" + data.subtotal[3];
							if ($("#modalitems1").length) {
								document.getElementById('modalitems1').innerHTML = data.subtotal[0] + "/" + data.subtotal[3];
							}
							if ($('#unidades').length) {
								document.getElementById('unidades').innerHTML = data.subtotal[0] + "/" + data.subtotal[3];
							}

						}
						$("#carrito_importe_view").html(data.subtotal[1].toFixed(2));
						$("#carrito_importe").html(data.subtotal[1].toFixed(2));
						$("#carrito_importe1").html(data.subtotal[1].toFixed(2));



						var concarro = data.contenidocarro;
						$('#tr' + id).remove();



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

						break;




				}
				//$.each(data.carro, function(key, value) {});

				/* ALERTA DE EXITO */

				//$("#modalcar").load(" #modalcar");



			},
			/*ALERTA DE ERROR*/
			error: function(textStatus) {

				if (textStatus = "Success") {


				}
				console.log(textStatus);


				//window.location.replace("/products/clear");
			}
		});
	}

	function Paginacionperfu() {

		$('div.fraganciacontenedorajust').each(function() {


			var currentPage = 0;
			var numPerPage = 200;
			var $table = $(this);
			var rowCount = $('div.fraganciadiv').length;
			$table.bind('repaginate', function() {
				$table.find('div.fraganciadiv').hide().slice(currentPage * numPerPage, (currentPage + 1) * numPerPage).show();
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

	function Paginacioncar() {
		$('table.tablasearch').each(function() {
			var currentPage = 0;
			var numPerPage = 200;
			var $table = $(this);
			var rowCount = $('table.tablasearch tbody tr td.formcartcanttd').length;
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
	
	function sortTable(table, col, reverse) {
                    var tb = table.tBodies[0], // use `<tbody>` to ignore `<thead>` and `<tfoot>` rows
                        tr = Array.prototype.slice.call(tb.rows, 0), // put rows into array
                        i;
                    reverse = -((+reverse) || -1);
                    tr = tr.sort(function (a, b) { // sort rows
                        return reverse // `-1 *` if want opposite order
                            * (a.cells[col].textContent.trim() // using `.textContent.trim()` for test
                                .localeCompare(b.cells[col].textContent.trim())

                            );
                    });
                    for(i = 0; i < tr.length; ++i) tb.appendChild(tr[i]);
					 // append each row in order
                }

                function makeSortable(table) {
                    var th = table.tHead, i;
                    th && (th = th.rows[0]) && (th = th.cells);
                    if (th) i = th.length;
                    else return; // if no `<thead>` then do nothing
                    while (--i >= 0) (function (i) {
                        var dir = 1;
                        th[i].addEventListener('click', function () {sortTable(table, i, (dir = 1 - dir))});
                    }(i));
					console.log("usted hizo")
					
                }

                function makeAllSortable(parent) {
                    parent = parent || document.body;
                    var t = parent.getElementsByTagName('table'), i = t.length;
                    while (--i >= 0) makeSortable(t[i]);
					console.log("usted ya hizo")
                }

		


				window.onload = function () {makeAllSortable();};


	

	
                
</script>