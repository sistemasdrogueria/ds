
	function preguntarSiNo(id, arti) {
		alertify.confirm('Eliminar Datos', '¿Esta seguro de eliminar este Articulo?',
			function() {
				eliminarDatos(id, arti)
			},
			function() {
				alertify.error('Se cancelo la operación')

			});
	}

	function preguntarSiNoMenos(id, arti) {
		alertify.confirm('Eliminar Datos', '¿Esta seguro de eliminar este Articulo?',
			function() {
				eliminarDatos(id, arti)

			},
			function() {
				alertify.error('Se cancelo la operación')
				document.getElementById('' + arti).value++;
				$('input[data-id=' + arti + ']').val("1");
			});
	}

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

	function increment(id, di, d) {

		id = "" + id;
		document.getElementById('' + id).value++;
		var quantity = $("#" + id).val();
		ajaxcart(d, quantity, di);

		//alertify.success("Cantidad Agregada Con Exito!");


	}

	function incrementEstetica(id, di, d) {
		id = id;

		document.getElementById('bu' + id).value++;
		var quantity = $("#bu" + id).val();

		ajaxcart(d, quantity, di);

	}

	function decrement(id, di, d, idcarro) {
		id = "" + id;
		document.getElementById('' + id).value--;
		var quantity = $("#" + id).val();

		//alertify.success("Cantidad Eliminada Con Exito!");

		if (quantity == 0) {

			$('input[data-id=' + id + ']').val("");
			preguntarSiNoMenos(idcarro, id);

		} else {

			ajaxcart(d, quantity, di);
			$('input[data-id=' + id + ']').val(quantity);
		}

	}

	function decrementCarritoView(id, di, d) {
		id = "" + id;
		document.getElementById('' + id).value--;
		var quantity = $("#" + id).val();

		//alertify.success("Cantidad Eliminada Con Exito!");

		if (quantity == 0) {

			$('input[data-id=' + id + ']').val("");
			$('#tr' + id).remove();

		} else {

			$('input[data-id=' + id + ']').val(quantity);
		}
		ajaxcart(d, quantity, di);
	}

	function eliminarDatos(id, arti) {

		id = "id=" + id;
		arti = arti;

		$.ajax({
			type: "post",
			url: "/./ds3/Carritos/delete",
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
						//	document.getElementById('unidades').innerHTML = data.subtotal[0]+"/"+data.subtotal[3];

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

	function vaciarCarrito(id) {

		id = "id=" + id;



		$.ajax({
			type: "post",
			url: "/./ds3/Carritos/vaciar",
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
					$('.cantidad').val("");
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

	function ajaxcart(id, quantity, pv_id, id_input) {

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

						$("#" + id_input).val(data.carros.cantidad);
						$('input[data-id=' + id + ']').val(quantity);
						$('#openerts').attr('data-value', data.subtotal[3]);
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
								if ( $("#modalitems1").length ) {
									document.getElementById('modalitems1').innerHTML = data.subtotal[0] + "/" + data.subtotal[3];
														}
							if ($('#unidades').length) {
								document.getElementById('unidades').innerHTML = data.subtotal[0] + "/" + data.subtotal[3];
							}

						} else {
							document.getElementById('openerts').innerHTML = data.subtotal[3];
							document.getElementById('modalitems').innerHTML = data.subtotal[0] + "/" + data.subtotal[3];
								if ( $("#modalitems1").length ) {
									document.getElementById('modalitems1').innerHTML = data.subtotal[0] + "/" + data.subtotal[3];
														}
							if ($('#unidades').length) {
								document.getElementById('unidades').innerHTML = data.subtotal[0] + "/" + data.subtotal[3];
							}

						}
						$("#carrito_importe_view").html(data.subtotal[1].toFixed(2));
						$("#carrito_importe").html("$" +data.subtotal[1].toFixed(2));
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


				$.each(data.carro, function(key, value) {});




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
