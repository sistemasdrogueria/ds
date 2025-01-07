/*$(document).ready(function(){
mantenimiento();

	function mantenimiento(){
var actionform=document.querySelectorAll("searchform3");
console.log($("search-form"));
actionform.action="#";
$("#searchform3").attr("onsubmit","return false;");
$("#searchform3").attr("action","#");

$('#mainbuttonmanten').attr("onclick","mantenimientomensaje();");
$('.sendbtn').attr("onclick","mantenimientomensaje();");
//$('#enviarcarritocompleto').attr("action","#");
//$('#enviarcarritocompleto').attr("onsubmit","return false;");
}
});


function mantenimientomensaje(){

	$('<div class="jquery-notify-bar error top" id="__notifyBar4826526" style=""><span class="notify-bar-text-wrapper">Estamos realizando un mantenimiento en la pagina web, estará habilitada para cargar datos aproximadamente en 1 hora.</span><a href="#" onclick="cerrarDiv()"class="notify-bar-close">×</a></div>').appendTo('body');
						$('#terminobuscar').val("");
	
}
*/

$('#codigobarras').on("change", function(){
     if($("#codigobarras").is(":checked")) {
        //$("#codigobarras").prop("checked", false);
        //$("#codigobarras").removeAttr("checked");
        $("#monodroga-id").prop("disabled", true);
        $("#accionfar-id").prop("disabled", true);
        $("#laboratorio-id").prop("disabled", true);
        $("#ofertas").prop("disabled", true);
        $("#terminobuscar").attr("placeholder", "Buscar Producto");
     }else{
       $("#monodroga-id").prop("disabled", false);
        $("#accionfar-id").prop("disabled", false);
        $("#laboratorio-id").prop("disabled", false);
        $("#ofertas").prop("disabled", false);
     }
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
function ajaxcart(id, quantity, pv_id, id_input) {




		$.ajax({
			//aca es metodo POST
			type: "POST",
			url: itemupdate,
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
						$("#" + id_input).html(data.carros.cantidad);
						$('input[data-id=' + id + ']').val(quantity);
						$("input[data-id=" + id + "]").val(data.carros.cantidad);
						//	console.log(quantity)
						$('#openerts').attr('data-value', data.subtotal[3]);
						if (data.carros.cantidad >= data.carros.unidad_minima) {

							$('tr[id=tr' + id + ']').attr("class", "");
							if ($('tr[id="trBody' + id + '"]').length) {
								$('tr[id="trBody' + id + '"]').attr("class", "");
							}
							if (data.carros.descuento > 0) {
								$('.imgoferta' + id + '').attr("src", "");
								$('.imgoferta' + id + '').attr("src", imggeneral + "/oferta_adquirida.png");
							}
						} else {
							$('tr[id="tr' + id + '"]').attr("class", "carrito_item_sinoferta");
							$('tr[id="tr' + id + '"]').attr("title", 'Dto:' + data.carros.descuento + "%" + 'Uni. Min:' + data.carros.unidad_minima + 'T.Of.:' + data.carros.tipo_oferta);
							if (data.carros.descuento > 0) {
								$('.imgoferta' + id + '').attr("src", "");
								$('.imgoferta' + id + '').attr("src", imggeneral + "/oferta_perdida.png");
							}
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
						$("#carrito_importe2").html("$ " + ptos);
						if ($("#modalitems1").length) {
							document.getElementById('modalitems1').innerHTML = data.subtotal[0] + "/" + data.subtotal[3];
						}
						alertify.message('').dismissOthers();
						
          if (data.validarUnidades) {
            if (data.validarUnidades.validar == 1) {
              alertify.success(
                "Cantidad modificada con exito " +
                  data.validarUnidades.cantidad +
                  ", el limite diario es de" +
                  data.validarUnidades.limite +
                  "!"
              );
            } else if (data.validarUnidades.validar == 0) {
              alertify.success(
                "Ya agotaste el límite de unidades que puedes agregar de este artículo por día el limite es " +
                  data.validarUnidades.limite +
                  "!"
              );
            } else {
              alertify.success("Cantidad Modificada Con Exito!");
            }
          } else {
            alertify.success("Cantidad Modificada Con Exito!");
          }

						if ($("#tablaviewresult").length) {
							var articulo = data.carros;

							const noTruncarDecimaless = {
								maximumFractionDigits: 2,
								minimumFractionDigits: 2
							};
							var numeros = data.subtotal[4];
							pntos = numeros.toLocaleString('es', noTruncarDecimaless);
							$('td[data-subtotal="sub' + articulo.articulo_id + '"]').html('$ ' + pntos);
							$('.page_cart1').remove();


						}



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
					case "7":
						$('<div class="jquery-notify-bar error top" id="__notifyBar4826526" style=""><span class="notify-bar-text-wrapper">No se puede agregar este producto al carro de compras. </span><a href="#" onclick="cerrarDiv()"class="notify-bar-close">×</a></div>').appendTo('body');
						$('#terminobuscar').val("");
						$("#mydivBuscar").html("<p>Según nuestros registros, tu farmacia no se encuentra adherida a la dispensa, razón por la cual no podemos cargar la carro de compras este producto. Cualquier inquietud, comunícate con nuestro equipo. </br>¡Estamos para ayudarte!</p>");
						$('.formcartcant').val("");
						break;
					case "0":
						$('<div class="jquery-notify-bar error top" id="__notifyBar4826526" style=""><span class="notify-bar-text-wrapper">No se puede agregar este producto al carro de compras. </span><a href="#" onclick="cerrarDiv()"class="notify-bar-close">×</a></div>').appendTo('body');
						$('#terminobuscar').val("");
						$("#mydivBuscar").html("<p>No tienes Permisos para agregar productos de esta categoria.</p>");
						$('.formcartcant').val("");
						break;


					case "eliminado":
						alertify.message('').dismissOthers();
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
						$("#carrito_importe1").html("$" + data.subtotal[1].toFixed(2));
						$("#carrito_importe2").html("$" + data.subtotal[1].toFixed(2));



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
/*
						case "mantenimiento":
						$('<div class="jquery-notify-bar error top" id="__notifyBar4826526" style=""><span class="notify-bar-text-wrapper">Estamos realizando un mantenimiento en la pagina web, estará habilitada para cargar datos aproximadamente en 1 hora.</span><a href="#" onclick="cerrarDiv()"class="notify-bar-close">×</a></div>').appendTo('body');
						$('#terminobuscar').val("");
					
						break;*/


				}


				//$.each(data.carro, function(key, value) {});




			},
			/*ALERTA DE ERROR*/
			error: function(textStatus) {
				$('<div class="jquery-notify-bar error top" id="__notifyBar4826526" style=""><span class="notify-bar-text-wrapper">No se puede Modificar este producto en el carro de compras. </span><a href="#" onclick="cerrarDiv()"class="notify-bar-close">×</a></div>').appendTo('body');
				$('#terminobuscar').val("");
				$("#mydivBuscar").html("<p>No tienes Permisos para agregar productos de esta categoria.</p>");
				$('.formcartcant').val("");
				if (textStatus = "Success") {


				}



				//window.location.replace("/products/clear");
			}
		});
	}
function ajaxcartAgregar(id, quantity, pv_id, id_input,tipo_oferta) {

		$.ajax({
			//aca es type POST
			type: "POST",
			url: itemupdate,
			data: {
				id: id,
				quantity: quantity,
				descuento_id: pv_id,
				id_input: id_input,
				 tipo_oferta:tipo_oferta

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

								if (data.carros.descuento > 0) {
									$('.imgoferta' + id + '').attr("src", "");
									$('.imgoferta' + id + '').attr("src", imggeneral + "/oferta_adquirida.png");
								}
								$('tr[id=tr' + id + ']').attr("class", "");
								if ($('tr[id=trBody' + id + ']').length) {
									$('tr[id=trBody' + id + ']').attr("class", "");
								}


							} else {
								if (data.carros.descuento > 0) {
									$('.imgoferta' + id + '').attr("src", "");
									$('.imgoferta' + id + '').attr("src", imggeneral + "/oferta_perdida.png");
								}
								$('tr[id=tr' + id + ']').attr("class", "carrito_item_sinoferta");
								$('tr[id=tr' + id + ']').attr("title", 'Dto:' + data.carros.descuento + "%" + 'Uni. Min:' + data.carros.unidad_minima + 'T.Of.:' + data.carros.tipo_oferta);

								if ($('tr[id=trBody' + id + ']').length) {

									$('tr[id=trBody' + id + ']').attr("class", "carrito_item_sinoferta");
									$('tr[id=trBody' + id + ']').attr("title", 'Dto:' + data.carros.descuento + "%" + 'Uni. Min:' + data.carros.unidad_minima + 'T.Of.:' + data.carros.tipo_oferta);
								}
							}
							alertify.message('').dismissOthers();
							
            if (data.validarUnidades) {
              if (data.validarUnidades.validar == 1) {
                alertify.success(
                  "Cantidad modificada con exito " +
                    data.validarUnidades.cantidad +
                    ", el limite diario es de" +
                    data.validarUnidades.limite +
                    "!"
                );
              } else if (data.validarUnidades.validar == 0) {
                alertify.success(
                  "Ya agotaste el límite de unidades que puedes agregar de este artículo por día el limite es " +
                    data.validarUnidades.limite +
                    "!"
                );
              } else {
                alertify.success("Cantidad Modificada Con Exito!");
              }
            } else {
              alertify.success("Cantidad Modificada Con Exito!");
            }
							$("input[data-id=" + id + "]").val(data.carros.cantidad);
							$("#" + id_input).val(data.carros.cantidad);
							//	console.log(data.carros.cantidad);

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
									let divEDITAR1 = document.createElement('div');
									let img = document.createElement('img');
									//let imgdescripcionlink = document.createElement("img");
									let imgofertalink = document.createElement("img");
									let imgdescripcion = document.createElement("a");
									let aeliminar = document.createElement('a');
									let tdCANTIDAD = document.createElement('input');
									let tdform = document.createElement('input');
									let tdbuttonmas = document.createElement("button");
									let tdbuttonmenos = document.createElement("button");
									let form = document.createElement("form");
									tabla.className = ('table table-striped');
									tr.id = ("tr" + ccarro.articulo_id);
									imgdescripcion.className = "ico";
									imgdescripcion.setAttribute("data-ean", ccarro.articulo.imagen);
									//imgdescripcionlink.className= "icon";
									//imgdescripcionlink.src=imgarticulos+"/"+ccarro.articulo.imagen;
									tdDESCRIPCION.className = ('carrito_item_descripcion');
									tdDESCRIPCION.onmouseover = mostrarimgproducto;
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
									img.src = imgborrarcar;
									img.class = ("delete");
									form.method = "POST";
									form.style = "display:none;";
									form.name = "";
									tdform.name = "_method";
									tdform.value = "POST";
									tdEDITAR.className = ('carrito_item_borrar');
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
									divEDITAR1.className = ('carrito_item_cantidad_2');
									tdbuttonmenos.innerHTML = '-';
									imgdescripcion.innerText = ccarro.descripcion;
									tdCANTIDAD.innerText = ccarro.cantidad;

									tdCANTIDAD.onchange = function() {
										var quantity = Math.round($(this).val());
										ajaxcart($(this).attr("data-id"), quantity, $(this).attr("data-pv-id"), $(this).attr("data-id-input"));

									};
									tr.appendChild(tdDESCRIPCION);
									tr.appendChild(tdEDITAR1);
									tr.appendChild(tdEDITAR);
									tdDESCRIPCION.appendChild(imgdescripcion);
									// imgdescripcion.appendChild(imgdescripcionlink);
									if (ccarro.descuento > 0) {
										imgofertalink.src = imggeneral + "/oferta_adquirida.png";
										imgofertalink.className = "off_perdida imgoferta" + ccarro.articulo_id + "";
										tdDESCRIPCION.appendChild(imgofertalink);
									}
									tdEDITAR.appendChild(form);
									tdEDITAR1.appendChild(divEDITAR1);
									divEDITAR1.appendChild(tdbuttonmenos);
									divEDITAR1.appendChild(tdCANTIDAD);
									divEDITAR1.appendChild(tdbuttonmas);
									form.appendChild(tdform);

									tdEDITAR.appendChild(aeliminar);

									aeliminar.appendChild(img);
									tabla.appendChild(tr);


								} else {
									let tr = document.createElement('tr');
									let tdDESCRIPCION = document.createElement('td');
									let tdEDITAR = document.createElement('td');
									let tdEDITAR1 = document.createElement('td');
									let divEDITAR1 = document.createElement('div');
									let img = document.createElement('img');
									//let imgdescripcionlink = document.createElement("img");
									let imgofertalink = document.createElement("img");
									let imgdescripcion = document.createElement("a");
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
									tdDESCRIPCION.onmouseover = mostrarimgproducto;
									tdCANTIDAD.className = ('formcarritocant text-center');
									tdCANTIDAD.onkeypress = soloNumeros;
									tdCANTIDAD.id = ("car" + ccarro.articulo_id);
									tdCANTIDAD.value = (ccarro.cantidad);
									tdCANTIDAD.maxLength = 3;
									tdCANTIDAD.setAttribute("data-pv-id", ccarro.descuento_id);
									tdCANTIDAD.setAttribute("data-id", ccarro.articulo_id);
									tdCANTIDAD.setAttribute("data-id-input", ccarro.articulo_id);
									imgdescripcion.className = "ico";
									imgdescripcion.setAttribute("data-ean", ccarro.articulo.imagen);
									//imgdescripcionlink.className= "icon";
									//imgdescripcionlink.src=imgarticulos+"/"+ccarro.articulo.imagen;
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
									img.src = imgborrarcar;
									img.class = ("delete");
									form.method = "POST";
									form.style = "display:none;";
									form.name = "";
									tdform.name = "_method";
									tdform.value = "POST";
									tdEDITAR.className = ('carrito_item_borrar');
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
									divEDITAR1.className = ('carrito_item_cantidad_2');
									tdbuttonmenos.innerHTML = '-';
									imgdescripcion.innerText = ccarro.descripcion;
									tdCANTIDAD.innerText = ccarro.cantidad;

									tdCANTIDAD.onchange = function() {
										var quantity = Math.round($(this).val());
										ajaxcart($(this).attr("data-id"), quantity, $(this).attr("data-pv-id"), $(this).attr("data-id-input"));

									};
									tr.appendChild(tdDESCRIPCION);
									tr.appendChild(tdEDITAR1);
									tr.appendChild(tdEDITAR);
									tdDESCRIPCION.appendChild(imgdescripcion);
									// imgdescripcion.appendChild(imgdescripcionlink);
									if (ccarro.descuento > 0) {
										imgofertalink.src = imggeneral + "/oferta_perdida.png";
										imgofertalink.className = "off_perdida imgoferta" + ccarro.articulo_id + "";
										tdDESCRIPCION.appendChild(imgofertalink);
									}
									tdEDITAR.appendChild(form);
									tdEDITAR1.appendChild(divEDITAR1);
									divEDITAR1.appendChild(tdbuttonmenos);
									divEDITAR1.appendChild(tdCANTIDAD);
									divEDITAR1.appendChild(tdbuttonmas);
									form.appendChild(tdform);

									tdEDITAR.appendChild(aeliminar);

									aeliminar.appendChild(img);
									tabla.appendChild(tr);





								}
							}

							if ($('#tablaprueba1').length) {

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
										let divEDITAR1 = document.createElement('div');
										let img = document.createElement('img');
										//let imgdescripcionlink = document.createElement("img"); 
										let imgofertalink = document.createElement("img");
										let imgdescripcion = document.createElement("a");
										let aeliminar = document.createElement('a');
										let tdCANTIDAD = document.createElement('input');
										let tdform = document.createElement('input');
										let tdbuttonmas = document.createElement("button");
										let tdbuttonmenos = document.createElement("button");
										let form = document.createElement("form");
										table.className = ('table table-striped');
										tr.id = ("trBody" + ccarro.articulo_id);
										//tr.className =('carrito_item_sinoferta');
										imgdescripcion.className = "ico";
										imgdescripcion.setAttribute("data-ean", ccarro.articulo.imagen);
										//imgdescripcionlink.className= "icon";
										//imgdescripcionlink.src=imgarticulos+"/"+ccarro.articulo.imagen;
										tdDESCRIPCION.className = ('carrito_item_descripcion');
										tdDESCRIPCION.onmouseover = mostrarimgproducto;
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
										img.src = imgborrarcar;
										img.class = ("delete");
										form.method = "POST";
										form.style = "display:none;";
										form.name = "";
										tdform.name = "_method";
										tdform.value = "POST";
										tdEDITAR.className = ('carrito_item_borrar');
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
										divEDITAR1.className = ('carrito_item_cantidad_2');
										tdbuttonmenos.innerHTML = '-';
										imgdescripcion.innerText = ccarro.descripcion;
										tdCANTIDAD.innerText = ccarro.cantidad;

										tdCANTIDAD.onchange = function() {
											var quantity = Math.round($(this).val());
											ajaxcart($(this).attr("data-id"), quantity, $(this).attr("data-pv-id"), $(this).attr("data-id-input"));

										};
										tr.appendChild(tdDESCRIPCION);
										tr.appendChild(tdEDITAR1);
										tr.appendChild(tdEDITAR);
										tdDESCRIPCION.appendChild(imgdescripcion);
										//imgdescripcion.appendChild(imgdescripcionlink);
										if (ccarro.descuento > 0) {
											imgofertalink.src = imggeneral + "/oferta_adquirida.png";
											imgofertalink.className = "off_perdida imgoferta" + ccarro.articulo_id + "";
											tdDESCRIPCION.appendChild(imgofertalink);
										}
										tdEDITAR.appendChild(form);
										tdEDITAR1.appendChild(divEDITAR1);
										divEDITAR1.appendChild(tdbuttonmenos);
										divEDITAR1.appendChild(tdCANTIDAD);
										divEDITAR1.appendChild(tdbuttonmas);
										form.appendChild(tdform);
										tdEDITAR.appendChild(aeliminar);
										aeliminar.appendChild(img);
										table.appendChild(tr);






									} else {
										let tr = document.createElement('tr');
										let tdDESCRIPCION = document.createElement('td');
										let tdEDITAR = document.createElement('td');
										let tdEDITAR1 = document.createElement('td');
										let divEDITAR1 = document.createElement('div');
										let img = document.createElement('img');
										//let imgdescripcionlink = document.createElement("img");
										let imgofertalink = document.createElement("img");
										let imgdescripcion = document.createElement("a");
										let aeliminar = document.createElement('a');
										let tdCANTIDAD = document.createElement('input');
										let tdform = document.createElement('input');
										let tdbuttonmas = document.createElement("button");
										let tdbuttonmenos = document.createElement("button");
										let form = document.createElement("form");
										table.className = ('table table-striped');
										tr.id = ("trBody" + ccarro.articulo_id);
										imgdescripcion.className = "ico";
										imgdescripcion.setAttribute("data-ean", ccarro.articulo.imagen);
										//	imgdescripcionlink.className= "icon";
										//  imgdescripcionlink.src=imgarticulos+"/"+ccarro.articulo.imagen;
										tr.className = ('carrito_item_sinoferta');
										tdDESCRIPCION.className = ('carrito_item_descripcion');
										tdDESCRIPCION.onmouseover = mostrarimgproducto;
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
										img.src = imgborrarcar;
										img.class = ("delete");
										form.method = "POST";
										form.style = "display:none;";
										form.name = "";
										tdform.name = "_method";
										tdform.value = "POST";
										tdEDITAR.className = ('carrito_item_borrar');
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
										divEDITAR1.className = ('carrito_item_cantidad_2');
										tdbuttonmenos.innerHTML = '-';
										imgdescripcion.innerText = ccarro.descripcion;
										tdCANTIDAD.innerText = ccarro.cantidad;

										tdCANTIDAD.onchange = function() {
											var quantity = Math.round($(this).val());
											ajaxcart($(this).attr("data-id"), quantity, $(this).attr("data-pv-id"), $(this).attr("data-id-input"));

										};
										tr.appendChild(tdDESCRIPCION);
										tr.appendChild(tdEDITAR1);
										tr.appendChild(tdEDITAR);
										tdDESCRIPCION.appendChild(imgdescripcion);
										// imgdescripcion.appendChild(imgdescripcionlink);
										if (ccarro.descuento > 0) {
											imgofertalink.src = imggeneral + "/oferta_perdida.png";
											imgofertalink.className = "off_perdida imgoferta" + ccarro.articulo_id + "";
											tdDESCRIPCION.appendChild(imgofertalink);
										}

										tdEDITAR.appendChild(form);
										tdEDITAR1.appendChild(divEDITAR1);
										divEDITAR1.appendChild(tdbuttonmenos);
										divEDITAR1.appendChild(tdCANTIDAD);
										divEDITAR1.appendChild(tdbuttonmas);
										form.appendChild(tdform);
										tdEDITAR.appendChild(aeliminar);
										aeliminar.appendChild(img);
										table.appendChild(tr);





									}
								}
							}
							alertify.message('').dismissOthers();
							 if (data.validarUnidades) {
              if (data.validarUnidades.validar == 1) {
                alertify.success(
                  "Cantidad Agregada Con Exito " +
                    data.validarUnidades.cantidad +
                    " el limite diario es de" +
                    data.validarUnidades.limite +
                    "!"
                );
              } else if (data.validarUnidades.validar == 0) {
                alertify.success(
                  "Cantidad Agregada Con Exito, Ya agotaste el límite de unidades que puedes agregar de este artículo por día, el limite es " +
                    data.validarUnidades.limite +
                    "!"
                );
              } else {
                alertify.success("Cantidad Agregada Con Exito!");
              }
			   } else {
              alertify.success("Cantidad Agregada Con Exito!");
            }
							$('input[data-id=' + id + ']').val(data.carros.cantidad);
							$("#" + id_input).val(data.carros.cantidad);
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

						if ($("#tablaviewresult").length) {
							var articulo = data.carros;

							const noTruncarDecimaless = {
								maximumFractionDigits: 2,
								minimumFractionDigits: 2
							};
							var numeros = data.subtotal[4];
							pntos = numeros.toLocaleString('es', noTruncarDecimaless);
							$('td[data-subtotal="sub' + articulo.articulo_id + '"]').html('$ ' + pntos);
							$('.page_cart1').remove();
							Paginacioncarcar();

						}


						break;

					case "6":

						$('<div class="jquery-notify-bar error top" id="__notifyBar4826526" style=""><span class="notify-bar-text-wrapper">No se puede agregar este producto al carro de compras.</span><a href="#" onclick="cerrarDiv()" class="notify-bar-close">×</a></div>').appendTo('body');
						$('#terminobuscar').val("");
						$("#mydivBuscar").html("<p>No tienes Permisos para agregar productos de esta categoria.</p>");
						$('.formcartcant').val("");
						break;
					case "5":
						$('<div class="jquery-notify-bar error top" id="__notifyBar4826526" style=""><span class="notify-bar-text-wrapper">Producto trazable. Tu GLN se encuentra vencido. </span><a href="#" onclick="cerrarDiv()"class="notify-bar-close">×</a></div>').appendTo('body');
						$('#terminobuscar').val("");
						$("#mydivBuscar").html("<p>No tienes Permisos para agregar productos de esta categoria.</p>");
						$('.formcartcant').val("");

						break;
					case "7":
						$('<div class="jquery-notify-bar error top" id="__notifyBar4826526" style=""><span class="notify-bar-text-wrapper">Según nuestros registros, tu farmacia no se encuentra adherida a la dispensa, razón por la cual no podemos cargar al carro de compras este producto. Cualquier inquietud, comunícate con nuestro equipo. </br>¡Estamos para ayudarte! </span><a href="#" onclick="cerrarDiv()"class="notify-bar-close">×</a></div>').appendTo('body');
						$('#terminobuscar').val("");
						$("#mydivBuscar").html("<p>Según nuestros registros, tu farmacia no se encuentra adherida a la dispensa, razón por la cual no podemos cargar la carro de compras este producto. Cualquier inquietud, comunícate con nuestro equipo. </br>¡Estamos para ayudarte!</p>");
						$('.formcartcant').val("");
						break;
					case "0":
						$('<div class="jquery-notify-bar error top" id="__notifyBar4826526" style=""><span class="notify-bar-text-wrapper">No se puede agregar este producto al carro de compras. </span><a href="#" onclick="cerrarDiv()"class="notify-bar-close">×</a></div>').appendTo('body');
						$('#terminobuscar').val("");
						$("#mydivBuscar").html("<p>No tienes Permisos para agregar productos de esta categoria.</p>");
						$('.formcartcant').val("");
						break;

					case "eliminado":
						alertify.message('').dismissOthers();
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
						$('#trBody' + id).remove();



						$('.page_cart').remove();
						$('.tablaprueba0').each(function() {
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
						/*
						case "mantenimiento":
						$('<div class="jquery-notify-bar error top" id="__notifyBar4826526" style=""><span class="notify-bar-text-wrapper">Estamos realizando un mantenimiento en la pagina web, estará habilitada para cargar datos aproximadamente en 1 hora.</span><a href="#" onclick="cerrarDiv()"class="notify-bar-close">×</a></div>').appendTo('body');
						$('#terminobuscar').val("");
					
						break;*/



				}
				//$.each(data.carro, function(key, value) {});

				/* ALERTA DE EXITO */

				//$("#modalcar").load(" #modalcar");



			},
			/*ALERTA DE ERROR*/
			error: function(textStatus) {
				$('<div class="jquery-notify-bar error top" id="__notifyBar4826526" style=""><span class="notify-bar-text-wrapper">No se puede agregar este producto al carro de compras. </span><a href="#" onclick="cerrarDiv()"class="notify-bar-close">×</a></div>').appendTo('body');
				$('#terminobuscar').val("");
				$("#mydivBuscar").html("<p>No tienes Permisos para agregar productos de esta categoria.</p>");
				$('.formcartcant').val("");

				if (textStatus = "Success") {


				}



				//window.location.replace("/products/clear");
			}
		});
	}

function ajaxcartOferta(id, quantity, pv_id, id_input) {

		$.ajax({
			//aca es metodo POST
			type: "POST",
			url: myBaseUrlsitemupdateofertas,
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

								if (data.carros.descuento > 0) {
									$('.imgoferta' + id + '').attr("src", "");
									$('.imgoferta' + id + '').attr("src", imggeneral + "/oferta_adquirida.png");
								}

								$('tr[id=tr' + id + ']').attr("class", "");
								if ($('tr[id=trBody' + id + ']').length) {
									$('tr[id=trBody' + id + ']').attr("class", "");
								}


							} else {

								if (data.carros.descuento > 0) {
									$('.imgoferta' + id + '').attr("src", "");
									$('.imgoferta' + id + '').attr("src", imggeneral + "/oferta_perdida.png");
								}
								$('tr[id=tr' + id + ']').attr("class", "carrito_item_sinoferta");
								$('tr[id=tr' + id + ']').attr("title", 'Dto:' + data.carros.descuento + "%" + 'Uni. Min:' + data.carros.unidad_minima + 'T.Of.:' + data.carros.tipo_oferta);

								if ($('tr[id=trBody' + id + ']').length) {

									$('tr[id=trBody' + id + ']').attr("class", "carrito_item_sinoferta");
									$('tr[id=trBody' + id + ']').attr("title", 'Dto:' + data.carros.descuento + "%" + 'Uni. Min:' + data.carros.unidad_minima + 'T.Of.:' + data.carros.tipo_oferta);
								}
							}
							alertify.message('').dismissOthers();
							if (data.validarUnidades) {
              if (data.validarUnidades.validar == 1) {
                alertify.success(
                  "Cantidad Modificada Con Exito " +
                    data.validarUnidades.cantidad +
                    " el limite diario es de" +
                    data.validarUnidades.limite +
                    "!"
                );
              } else if (data.validarUnidades.validar == 0) {
                alertify.success(
                  "Cantidad Modificada con exito, Ya agotaste el límite de unidades que puedes agregar de este artículo por día, el limite es " +
                    data.validarUnidades.limite +
                    "!"
                );
              } else {
                alertify.success("Cantidad Modificada Con Exito!");
              }
            } else {
              alertify.success("Cantidad Modificada Con Exito!");
            }
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
									let divEDITAR1 = document.createElement('div');
									let img = document.createElement('img');
									//let imgdescripcionlink = document.createElement("img");
									let imgofertalink = document.createElement("img");
									let imgdescripcion = document.createElement("a");
									let aeliminar = document.createElement('a');
									let tdCANTIDAD = document.createElement('input');
									let tdform = document.createElement('input');
									let tdbuttonmas = document.createElement("button");
									let tdbuttonmenos = document.createElement("button");
									let form = document.createElement("form");
									tabla.className = ('table table-striped');
									tr.id = ("tr" + ccarro.articulo_id);
									//tr.className =('carrito_item_sinoferta');
									imgdescripcion.className = "ico";
									imgdescripcion.setAttribute("data-ean", ccarro.articulo.imagen);
									//imgdescripcionlink.className= "icon";
									// imgdescripcionlink.src=imgarticulos+"/"+ccarro.articulo.imagen;
									tdDESCRIPCION.className = ('carrito_item_descripcion');
									tdDESCRIPCION.onmouseover = mostrarimgproducto;
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
									img.src = imgborrarcar;
									img.class = ("delete");
									form.method = "POST";
									form.style = "display:none;";
									form.name = "";
									tdform.name = "_method";
									tdform.value = "POST";
									tdEDITAR.className = ('carrito_item_borrar');
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
									divEDITAR1.className = ('carrito_item_cantidad_2');
									tdbuttonmenos.innerHTML = '-';
									imgdescripcion.innerText = ccarro.descripcion;
									tdCANTIDAD.innerText = ccarro.cantidad;

									tdCANTIDAD.onchange = function() {
										var quantity = Math.round($(this).val());
										ajaxcart($(this).attr("data-id"), quantity, $(this).attr("data-pv-id"), $(this).attr("data-id-input"));

									};
									tr.appendChild(tdDESCRIPCION);
									tr.appendChild(tdEDITAR1);
									tr.appendChild(tdEDITAR);
									tdDESCRIPCION.appendChild(imgdescripcion);
									// imgdescripcion.appendChild(imgdescripcionlink);
									if (ccarro.descuento > 0) {
										imgofertalink.src = imggeneral + "/oferta_adquirida.png";
										imgofertalink.className = "off_perdida imgoferta" + ccarro.articulo_id + "";
										tdDESCRIPCION.appendChild(imgofertalink);
									}
									tdEDITAR.appendChild(form);
									tdEDITAR1.appendChild(divEDITAR1);
									divEDITAR1.appendChild(tdbuttonmenos);
									divEDITAR1.appendChild(tdCANTIDAD);
									divEDITAR1.appendChild(tdbuttonmas);
									form.appendChild(tdform);

									tdEDITAR.appendChild(aeliminar);

									aeliminar.appendChild(img);
									tabla.appendChild(tr);


								} else {
									let tr = document.createElement('tr');
									let tdDESCRIPCION = document.createElement('td');
									let tdEDITAR = document.createElement('td');
									let tdEDITAR1 = document.createElement('td');
									let divEDITAR1 = document.createElement('div');
									let img = document.createElement('img');
									//let imgdescripcionlink = document.createElement("img");
									let imgofertalink = document.createElement("img");
									let imgdescripcion = document.createElement("a");
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
									tdDESCRIPCION.onmouseover = mostrarimgproducto;
									tdCANTIDAD.className = ('formcarritocant text-center');
									tdCANTIDAD.onkeypress = soloNumeros;
									tdCANTIDAD.id = ("car" + ccarro.articulo_id);
									tdCANTIDAD.value = (ccarro.cantidad);
									tdCANTIDAD.maxLength = 3;
									tdCANTIDAD.setAttribute("data-pv-id", ccarro.descuento_id);
									tdCANTIDAD.setAttribute("data-id", ccarro.articulo_id);
									tdCANTIDAD.setAttribute("data-id-input", ccarro.articulo_id);
									imgdescripcion.className = "ico";
									imgdescripcion.setAttribute("data-ean", ccarro.articulo.imagen);
									//imgdescripcionlink.className= "icon";
									//imgdescripcionlink.src=imgarticulos+"/"+ccarro.articulo.imagen;
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
									img.src = imgborrarcar;
									img.class = ("delete");
									form.method = "POST";
									form.style = "display:none;";
									form.name = "";
									tdform.name = "_method";
									tdform.value = "POST";
									tdEDITAR.className = ('carrito_item_borrar');
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
									divEDITAR1.className = ('carrito_item_cantidad_2');
									tdbuttonmenos.innerHTML = '-';
									imgdescripcion.innerText = ccarro.descripcion;
									tdCANTIDAD.innerText = ccarro.cantidad;

									tdCANTIDAD.onchange = function() {
										var quantity = Math.round($(this).val());
										ajaxcart($(this).attr("data-id"), quantity, $(this).attr("data-pv-id"), $(this).attr("data-id-input"));

									};
									tr.appendChild(tdDESCRIPCION);
									tr.appendChild(tdEDITAR1);
									tr.appendChild(tdEDITAR);
									tdDESCRIPCION.appendChild(imgdescripcion);
									//imgdescripcion.appendChild(imgdescripcionlink);
									if (ccarro.descuento > 0) {
										imgofertalink.src = imggeneral + "/oferta_perdida.png";
										imgofertalink.className = "off_perdida imgoferta" + ccarro.articulo_id + "";
										tdDESCRIPCION.appendChild(imgofertalink);
									}
									tdEDITAR.appendChild(form);
									tdEDITAR1.appendChild(divEDITAR1);
									divEDITAR1.appendChild(tdbuttonmenos);
									divEDITAR1.appendChild(tdCANTIDAD);
									divEDITAR1.appendChild(tdbuttonmas);
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
										let divEDITAR1 = document.createElement('div');
										let img = document.createElement('img');
										// let imgdescripcionlink = document.createElement("img");
										let imgofertalink = document.createElement("img");
										let imgdescripcion = document.createElement("a");
										let aeliminar = document.createElement('a');
										let tdCANTIDAD = document.createElement('input');
										let tdform = document.createElement('input');
										let tdbuttonmas = document.createElement("button");
										let tdbuttonmenos = document.createElement("button");
										let form = document.createElement("form");
										table.className = ('table table-striped');
										tr.id = ("trBody" + ccarro.articulo_id);
										//tr.className =('carrito_item_sinoferta');
										imgdescripcion.className = "ico";
										imgdescripcion.setAttribute("data-ean", ccarro.articulo.imagen);
										//imgdescripcionlink.className= "icon";
										//imgdescripcionlink.src=imgarticulos+"/"+ccarro.articulo.imagen;
										tdDESCRIPCION.className = ('carrito_item_descripcion');
										tdDESCRIPCION.onmouseover = mostrarimgproducto;
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
										img.src = imgborrarcar;
										img.class = ("delete");
										form.method = "POST";
										form.style = "display:none;";
										form.name = "";
										tdform.name = "_method";
										tdform.value = "POST";
										tdEDITAR.className = ('carrito_item_borrar');
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
										divEDITAR1.className = ('carrito_item_cantidad_2');
										tdbuttonmenos.innerHTML = '-';
										imgdescripcion.innerText = ccarro.descripcion;
										tdCANTIDAD.innerText = ccarro.cantidad;

										tdCANTIDAD.onchange = function() {
											var quantity = Math.round($(this).val());
											ajaxcart($(this).attr("data-id"), quantity, $(this).attr("data-pv-id"), $(this).attr("data-id-input"));

										};
										tr.appendChild(tdDESCRIPCION);
										tr.appendChild(tdEDITAR1);
										tr.appendChild(tdEDITAR);
										tdDESCRIPCION.appendChild(imgdescripcion);
										//imgdescripcion.appendChild(imgdescripcionlink);
										if (ccarro.descuento > 0) {
											imgofertalink.src = imggeneral + "/oferta_adquirida.png";
											imgofertalink.className = "off_perdida imgoferta" + ccarro.articulo_id + "";
											tdDESCRIPCION.appendChild(imgofertalink);
										}
										tdEDITAR.appendChild(form);
										tdEDITAR1.appendChild(divEDITAR1);
										divEDITAR1.appendChild(tdbuttonmenos);
										divEDITAR1.appendChild(tdCANTIDAD);
										divEDITAR1.appendChild(tdbuttonmas);
										form.appendChild(tdform);
										tdEDITAR.appendChild(aeliminar);
										aeliminar.appendChild(img);
										table.appendChild(tr);






									} else {
										let tr = document.createElement('tr');
										let tdDESCRIPCION = document.createElement('td');
										let tdEDITAR = document.createElement('td');
										let tdEDITAR1 = document.createElement('td');
										let divEDITAR1 = document.createElement('div');
										let img = document.createElement('img');
										//let imgdescripcionlink = document.createElement("img");
										let imgofertalink = document.createElement("img");
										let imgdescripcion = document.createElement("a");
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
										tdDESCRIPCION.onmouseover = mostrarimgproducto;
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
										img.src = imgborrarcar;
										img.class = ("delete");
										form.method = "POST";
										form.style = "display:none;";
										form.name = "";
										tdform.name = "_method";
										tdform.value = "POST";
										tdEDITAR.className = ('carrito_item_borrar');
										tdbuttonmas.className = ('btn btn-sm');
										tdbuttonmenos.className = ('btn btn-sm');
										tdbuttonmas.innerHTML = '+';
										imgdescripcion.className = "ico";
										imgdescripcion.setAttribute("data-ean", ccarro.articulo.imagen);
										//imgdescripcionlink.className= "icon";
										//imgdescripcionlink.src=imgarticulos+"/"+ccarro.articulo.imagen;
										tdbuttonmas.onclick = function() {
											increment(ccarro.articulo_id, ccarro.descuento_id, ccarro.articulo_id)
										};
										tdbuttonmenos.onclick = function() {
											decrement(ccarro.articulo_id, ccarro.descuento_id, ccarro.articulo_id, ccarro.id)
										};
										tdEDITAR1.className = ('carrito_item_cantida');
										divEDITAR1.className = ('carrito_item_cantidad_2');
										tdbuttonmenos.innerHTML = '-';
										imgdescripcion.innerText = ccarro.descripcion;
										tdCANTIDAD.innerText = ccarro.cantidad;

										tdCANTIDAD.onchange = function() {
											var quantity = Math.round($(this).val());
											ajaxcart($(this).attr("data-id"), quantity, $(this).attr("data-pv-id"), $(this).attr("data-id-input"));

										};
										tr.appendChild(tdDESCRIPCION);
										tr.appendChild(tdEDITAR1);
										tr.appendChild(tdEDITAR);
										tdDESCRIPCION.appendChild(imgdescripcion);
										// imgdescripcion.appendChild(imgdescripcionlink);
										if (ccarro.descuento > 0) {
											imgofertalink.src = imggeneral + "/oferta_perdida.png";
											imgofertalink.className = "off_perdida imgoferta" + ccarro.articulo_id + "";
											tdDESCRIPCION.appendChild(imgofertalink);
										}
										tdEDITAR.appendChild(form);
										tdEDITAR1.appendChild(divEDITAR1);
										divEDITAR1.appendChild(tdbuttonmenos);
										divEDITAR1.appendChild(tdCANTIDAD);
										divEDITAR1.appendChild(tdbuttonmas);
										form.appendChild(tdform);
										tdEDITAR.appendChild(aeliminar);
										aeliminar.appendChild(img);
										table.appendChild(tr);
									}
								}
							}



							alertify.message('').dismissOthers();
							   $("input[data-id=" + id + "]").val(data.carros.cantidad);
                 if (data.validarUnidades) {
              if (data.validarUnidades.validar == 1) {
                alertify.success(
                  "Cantidad Agregada Con Exito " +
                    data.validarUnidades.cantidad +
                    " el limite diario es de" +
                    data.validarUnidades.limite +
                    "!"
                );
              } else if (data.validarUnidades.validar == 0) {
                alertify.success(
                  "Cantidad Agregada con exito, Ya agotaste el límite de unidades que puedes agregar de este artículo por día, el limite es " +
                    data.validarUnidades.limite +
                    "!"
                );
              } else {
                alertify.success("Cantidad Agregada Con Exito!");
              }
            } else {
              alertify.success("Cantidad Agregada Con Exito!");
            }
							$('input[data-id=' + id + ']').val(data.carros.cantidad);
							$("#" + id_input).val(data.carros.cantidad);
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

						if ($("#tablaviewresult").length) {
							var articulo = data.carros;

							const noTruncarDecimaless = {
								maximumFractionDigits: 2,
								minimumFractionDigits: 2
							};
							var numeros = data.subtotal[4];
							pntos = numeros.toLocaleString('es', noTruncarDecimaless);
							$('td[data-subtotal="sub' + articulo.articulo_id + '"]').html('$ ' + pntos);
							$('.page_cart1').remove();
							Paginacioncarcar();

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
						alertify.message('').dismissOthers();
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
						$('#trBody' + id).remove();



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
/*
						break;
								case "mantenimiento":
						$('<div class="jquery-notify-bar error top" id="__notifyBar4826526" style=""><span class="notify-bar-text-wrapper">Estamos realizando un mantenimiento en la pagina web, estará habilitada para cargar datos aproximadamente en 1 hora.</span><a href="#" onclick="cerrarDiv()"class="notify-bar-close">×</a></div>').appendTo('body');
						$('#terminobuscar').val("");
					
						break;
						*/




				}
				//$.each(data.carro, function(key, value) {});

				/* ALERTA DE EXITO */

				//$("#modalcar").load(" #modalcar");



			},
			/*ALERTA DE ERROR*/
			error: function(textStatus) {
				$('<div class="jquery-notify-bar error top" id="__notifyBar4826526" style=""><span class="notify-bar-text-wrapper">No se puede agregar este producto al carro de compras. </span><a href="#" onclick="cerrarDiv()"class="notify-bar-close">×</a></div>').appendTo('body');
				$('#terminobuscar').val("");
				$("#mydivBuscar").html("<p>No tienes Permisos para agregar productos de esta categoria.</p>");
				$('.formcartcant').val("");
				if (textStatus = "Success") {


				}



				//window.location.replace("/products/clear");
			}
		});
	}
function ajaxcartDelia(id, quantity, pv_id, id_input) {

		$.ajax({
			type: "POST",
			url: itemupdate,
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

								if (data.carros.descuento > 0) {
									$('.imgoferta' + id + '').attr("src", "");
									$('.imgoferta' + id + '').attr("src", imggeneral + "/oferta_adquirida.png");
								}

								$('tr[id=tr' + id + ']').attr("class", "");
								if ($('tr[id=trBody' + id + ']').length) {
									$('tr[id=trBody' + id + ']').attr("class", "");
								}


							} else {
								if (data.carros.descuento > 0) {
									$('.imgoferta' + id + '').attr("src", "");
									$('.imgoferta' + id + '').attr("src", imggeneral + "/oferta_perdida.png");
								}
								$('tr[id=tr' + id + ']').attr("class", "carrito_item_sinoferta");
								$('tr[id=tr' + id + ']').attr("title", 'Dto:' + data.carros.descuento + "%" + 'Uni. Min:' + data.carros.unidad_minima + 'T.Of.:' + data.carros.tipo_oferta);

								if ($('tr[id=trBody' + id + ']').length) {

									$('tr[id=trBody' + id + ']').attr("class", "carrito_item_sinoferta");
									$('tr[id=trBody' + id + ']').attr("title", 'Dto:' + data.carros.descuento + "%" + 'Uni. Min:' + data.carros.unidad_minima + 'T.Of.:' + data.carros.tipo_oferta);
								}
							}
							alertify.message('').dismissOthers();
							           if (data.validarUnidades) {
              if (data.validarUnidades.validar == 1) {
                alertify.success(
                  "Cantidad Modificada Con Exito " +
                    data.validarUnidades.cantidad +
                    " el limite diario es de" +
                    data.validarUnidades.limite +
                    "!"
                );
              } else if (data.validarUnidades.validar == 0) {
                alertify.success(
                  "Cantidad Modificada con exito, Ya agotaste el límite de unidades que puedes agregar de este artículo por día, el limite es " +
                    data.validarUnidades.limite +
                    "!"
                );
              } else {
                alertify.success("Cantidad Modificada Con Exito!");
              }
            } else {
              alertify.success("Cantidad Modificada Con Exito!");
            }
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
									let divEDITAR1 = document.createElement('div');
									let img = document.createElement('img');
									//	let imgdescripcionlink = document.createElement("img");
									let imgofertalink = document.createElement("img");
									let imgdescripcion = document.createElement("a");
									let aeliminar = document.createElement('a');
									let tdCANTIDAD = document.createElement('input');
									let tdform = document.createElement('input');
									let tdbuttonmas = document.createElement("button");
									let tdbuttonmenos = document.createElement("button");
									let form = document.createElement("form");
									tabla.className = ('table table-striped');
									tr.id = ("tr" + ccarro.articulo_id);
									//tr.className =('carrito_item_sinoferta');
									imgdescripcion.className = "ico";
									imgdescripcion.setAttribute("data-ean", ccarro.articulo.imagen);
									//imgdescripcionlink.className= "icon";
									// imgdescripcionlink.src=imgarticulos+"/"+ccarro.articulo.imagen;
									tdDESCRIPCION.className = ('carrito_item_descripcion');
									tdDESCRIPCION.onmouseover = mostrarimgproducto;
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
									img.src = imgborrarcar;
									img.class = ("delete");
									form.method = "POST";
									form.style = "display:none;";
									form.name = "";
									tdform.name = "_method";
									tdform.value = "POST";
									tdEDITAR.className = ('carrito_item_borrar');
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
									divEDITAR1.className = ('carrito_item_cantidad_2');
									tdbuttonmenos.innerHTML = '-';
									imgdescripcion.innerText = ccarro.descripcion;
									tdCANTIDAD.innerText = ccarro.cantidad;

									tdCANTIDAD.onchange = function() {
										var quantity = Math.round($(this).val());
										ajaxcart($(this).attr("data-id"), quantity, $(this).attr("data-pv-id"), $(this).attr("data-id-input"));

									};
									tr.appendChild(tdDESCRIPCION);
									tr.appendChild(tdEDITAR1);
									tr.appendChild(tdEDITAR);
									tdDESCRIPCION.appendChild(imgdescripcion);
									// imgdescripcion.appendChild(imgdescripcionlink);
									if (ccarro.descuento > 0) {
										imgofertalink.src = imggeneral + "/oferta_adquirida.png";
										imgofertalink.className = "off_perdida imgoferta" + ccarro.articulo_id + "";
										tdDESCRIPCION.appendChild(imgofertalink);
									}
									tdEDITAR.appendChild(form);
									tdEDITAR1.appendChild(divEDITAR1);
									divEDITAR1.appendChild(tdbuttonmenos);
									divEDITAR1.appendChild(tdCANTIDAD);
									divEDITAR1.appendChild(tdbuttonmas);
									form.appendChild(tdform);

									tdEDITAR.appendChild(aeliminar);

									aeliminar.appendChild(img);
									tabla.appendChild(tr);


								} else {
									let tr = document.createElement('tr');
									let tdDESCRIPCION = document.createElement('td');
									let tdEDITAR = document.createElement('td');
									let tdEDITAR1 = document.createElement('td');
									let divEDITAR1 = document.createElement('div');
									let img = document.createElement('img');
									//let imgdescripcionlink = document.createElement("img");
									let imgofertalink = document.createElement("img")
									let imgdescripcion = document.createElement("a");
									let aeliminar = document.createElement('a');
									let tdCANTIDAD = document.createElement('input');
									let tdform = document.createElement('input');
									let tdbuttonmas = document.createElement("button");
									let tdbuttonmenos = document.createElement("button");
									let form = document.createElement("form");
									tabla.className = ('table table-striped');
									tr.id = ("tr" + ccarro.articulo_id);
									imgdescripcion.className = "ico";
									imgdescripcion.setAttribute("data-ean", ccarro.articulo.imagen);
									//imgdescripcionlink.className= "icon";
									// imgdescripcionlink.src=imgarticulos+"/"+ccarro.articulo.imagen;
									tr.className = ('carrito_item_sinoferta');
									tdDESCRIPCION.className = ('carrito_item_descripcion');
									tdDESCRIPCION.onmouseover = mostrarimgproducto;
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
									img.src = imgborrarcar;
									img.class = ("delete");
									form.method = "POST";
									form.style = "display:none;";
									form.name = "";
									tdform.name = "_method";
									tdform.value = "POST";
									tdEDITAR.className = ('carrito_item_borrar');
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
									divEDITAR1.className = ('carrito_item_cantidad_2');
									tdbuttonmenos.innerHTML = '-';
									imgdescripcion.innerText = ccarro.descripcion;
									tdCANTIDAD.innerText = ccarro.cantidad;

									tdCANTIDAD.onchange = function() {
										var quantity = Math.round($(this).val());
										ajaxcart($(this).attr("data-id"), quantity, $(this).attr("data-pv-id"), $(this).attr("data-id-input"));

									};
									tr.appendChild(tdDESCRIPCION);
									tr.appendChild(tdEDITAR1);
									tr.appendChild(tdEDITAR);
									tdDESCRIPCION.appendChild(imgdescripcion);
									//  imgdescripcion.appendChild(imgdescripcionlink);
									if (ccarro.descuento > 0) {
										imgofertalink.src = imggeneral + "/oferta_perdida.png";
										imgofertalink.className = "off_perdida imgoferta" + ccarro.articulo_id + "";
										tdDESCRIPCION.appendChild(imgofertalink);
									}
									tdEDITAR.appendChild(form);
									tdEDITAR1.appendChild(divEDITAR1);
									divEDITAR1.appendChild(tdbuttonmenos);
									divEDITAR1.appendChild(tdCANTIDAD);
									divEDITAR1.appendChild(tdbuttonmas);
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
										let divEDITAR1 = document.createElement('div');
										let img = document.createElement('img');
										//let imgdescripcionlink = document.createElement("img");
										let imgofertalink = document.createElement("img");
										let imgdescripcion = document.createElement("a");
										let aeliminar = document.createElement('a');
										let tdCANTIDAD = document.createElement('input');
										let tdform = document.createElement('input');
										let tdbuttonmas = document.createElement("button");
										let tdbuttonmenos = document.createElement("button");
										let form = document.createElement("form");
										table.className = ('table table-striped');
										tr.id = ("trBody" + ccarro.articulo_id);
										//tr.className =('carrito_item_sinoferta')
										imgdescripcion.className = "ico";
										imgdescripcion.setAttribute("data-ean", ccarro.articulo.imagen);
										//imgdescripcionlink.className= "icon";
										// imgdescripcionlink.src=imgarticulos+"/"+ccarro.articulo.imagen;
										tdDESCRIPCION.className = ('carrito_item_descripcion');
										tdDESCRIPCION.onmouseover = mostrarimgproducto;
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
										img.src = imgborrarcar;
										img.class = ("delete");
										form.method = "POST";
										form.style = "display:none;";
										form.name = "";
										tdform.name = "_method";
										tdform.value = "POST";
										tdEDITAR.className = ('carrito_item_borrar');
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
										divEDITAR1.className = ('carrito_item_cantidad_2');
										tdbuttonmenos.innerHTML = '-';
										imgdescripcion.innerText = ccarro.descripcion;
										tdCANTIDAD.innerText = ccarro.cantidad;

										tdCANTIDAD.onchange = function() {
											var quantity = Math.round($(this).val());
											ajaxcart($(this).attr("data-id"), quantity, $(this).attr("data-pv-id"), $(this).attr("data-id-input"));

										};
										tr.appendChild(tdDESCRIPCION);
										tr.appendChild(tdEDITAR1);
										tr.appendChild(tdEDITAR);
										tdDESCRIPCION.appendChild(imgdescripcion);
										// imgdescripcion.appendChild(imgdescripcionlink);
										if (ccarro.descuento > 0) {
											imgofertalink.src = imggeneral + "/oferta_adquirida.png";
											imgofertalink.className = "off_perdida imgoferta" + ccarro.articulo_id + "";
											tdDESCRIPCION.appendChild(imgofertalink);
										}
										tdEDITAR.appendChild(form);
										tdEDITAR1.appendChild(divEDITAR1);
										divEDITAR1.appendChild(tdbuttonmenos);
										divEDITAR1.appendChild(tdCANTIDAD);
										divEDITAR1.appendChild(tdbuttonmas);
										form.appendChild(tdform);
										tdEDITAR.appendChild(aeliminar);
										aeliminar.appendChild(img);
										table.appendChild(tr);


									} else {
										let tr = document.createElement('tr');
										let tdDESCRIPCION = document.createElement('td');
										let tdEDITAR = document.createElement('td');
										let tdEDITAR1 = document.createElement('td');
										let divEDITAR1 = document.createElement('div');
										let img = document.createElement('img');
										//let imgdescripcionlink = document.createElement("img");
										let imgofertalink = document.createElement("img");
										let imgdescripcion = document.createElement("a");
										let aeliminar = document.createElement('a');
										let tdCANTIDAD = document.createElement('input');
										let tdform = document.createElement('input');
										let tdbuttonmas = document.createElement("button");
										let tdbuttonmenos = document.createElement("button");
										let form = document.createElement("form");
										table.className = ('table table-striped');
										tr.id = ("trBody" + ccarro.articulo_id);
										imgdescripcion.className = "ico";
										imgdescripcion.setAttribute("data-ean", ccarro.articulo.imagen);
										//imgdescripcionlink.className= "icon";
										//imgdescripcionlink.src=imgarticulos+"/"+ccarro.articulo.imagen;
										tr.className = ('carrito_item_sinoferta');
										tdDESCRIPCION.className = ('carrito_item_descripcion');
										tdDESCRIPCION.onmouseover = mostrarimgproducto;
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
										img.src = imgborrarcar;
										img.class = ("delete");
										form.method = "POST";
										form.style = "display:none;";
										form.name = "";
										tdform.name = "_method";
										tdform.value = "POST";
										tdEDITAR.className = ('carrito_item_borrar');
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
										divEDITAR1.className = ('carrito_item_cantidad_2');
										tdbuttonmenos.innerHTML = '-';
										imgdescripcion.innerText = ccarro.descripcion;
										tdCANTIDAD.innerText = ccarro.cantidad;

										tdCANTIDAD.onchange = function() {
											var quantity = Math.round($(this).val());
											ajaxcart($(this).attr("data-id"), quantity, $(this).attr("data-pv-id"), $(this).attr("data-id-input"));

										};
										tr.appendChild(tdDESCRIPCION);
										tr.appendChild(tdEDITAR1);
										tr.appendChild(tdEDITAR);
										tdDESCRIPCION.appendChild(imgdescripcion);
										// imgdescripcion.appendChild(imgdescripcionlink);
										if (ccarro.descuento > 0) {
											imgofertalink.src = imggeneral + "/oferta_perdida.png";
											imgofertalink.className = "off_perdida imgoferta" + ccarro.articulo_id + "";
											tdDESCRIPCION.appendChild(imgofertalink);
										}
										tdEDITAR.appendChild(form);
										tdEDITAR1.appendChild(divEDITAR1);
										divEDITAR1.appendChild(tdbuttonmenos);
										divEDITAR1.appendChild(tdCANTIDAD);
										divEDITAR1.appendChild(tdbuttonmas);
										form.appendChild(tdform);
										tdEDITAR.appendChild(aeliminar);
										aeliminar.appendChild(img);
										table.appendChild(tr);





									}
								}
							}



							alertify.message('').dismissOthers();
							  if (data.validarUnidades) {
              if (data.validarUnidades.validar == 1) {
                alertify.success(
                  "Cantidad Agregada Con Exito " +
                    data.validarUnidades.cantidad +
                    " el limite diario es de" +
                    data.validarUnidades.limite +
                    "!"
                );
              } else if (data.validarUnidades.validar == 0) {
                alertify.success(
                  "Cantidad Agregada con exito, Ya agotaste el límite de unidades que puedes agregar de este artículo por día, el limite es " +
                    data.validarUnidades.limite +
                    "!"
                );
              } else {
                alertify.success("Cantidad Agregada Con Exito!");
              }
            } else {
              alertify.success("Cantidad Agregada Con Exito!");
            }
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


						if ($("#tablaviewresult").length) {
							var articulo = data.carros;

							const noTruncarDecimaless = {
								maximumFractionDigits: 2,
								minimumFractionDigits: 2
							};
							var numeros = data.subtotal[4];
							pntos = numeros.toLocaleString('es', noTruncarDecimaless);
							$('td[data-subtotal="sub' + articulo.articulo_id + '"]').html('$ ' + pntos);
							$('.page_cart1').remove();
							Paginacioncarcar();

						}

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
					case "7":
						$('<div class="jquery-notify-bar error top" id="__notifyBar4826526" style=""><span class="notify-bar-text-wrapper">No se puede agregar este producto al carro de compras. </span><a href="#" onclick="cerrarDiv()"class="notify-bar-close">×</a></div>').appendTo('body');
						$('#terminobuscar').val("");
						$("#mydivBuscar").html("<p>Según nuestros registros, tu farmacia no se encuentra adherida a la dispensa, razón por la cual no podemos cargar la carro de compras este producto. Cualquier inquietud, comunícate con nuestro equipo. </br>¡Estamos para ayudarte!</p>");
						$('.formcartcant').val("");
						break;
					case "0":
						$('<div class="jquery-notify-bar error top" id="__notifyBar4826526" style=""><span class="notify-bar-text-wrapper">No se puede agregar este producto al carro de compras. </span><a href="#" onclick="cerrarDiv()"class="notify-bar-close">×</a></div>').appendTo('body');
						$('#terminobuscar').val("");
						$("#mydivBuscar").html("<p>No tienes Permisos para agregar productos de esta categoria.</p>");
						$('.formcartcant').val("");
						break;
					case "eliminado":
						alertify.message('').dismissOthers();
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
						$('#trBody' + id).remove();



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
						/*						
					case "mantenimiento":
						$('<div class="jquery-notify-bar error top" id="__notifyBar4826526" style=""><span class="notify-bar-text-wrapper">Estamos realizando un mantenimiento en la pagina web, estará habilitada para cargar datos aproximadamente en 1 hora.</span><a href="#" onclick="cerrarDiv()"class="notify-bar-close">×</a></div>').appendTo('body');
						$('#terminobuscar').val("");
					
						break;
						*/
				}
				//$.each(data.carro, function(key, value) {});

				/* ALERTA DE EXITO */

				//$("#modalcar").load(" #modalcar");
			},
			/*ALERTA DE ERROR*/
			error: function(textStatus) {

				$('<div class="jquery-notify-bar error top" id="__notifyBar4826526" style=""><span class="notify-bar-text-wrapper">No se puede agregar este producto al carro de compras. </span><a href="#" onclick="cerrarDiv()"class="notify-bar-close">×</a></div>').appendTo('body');
				$('#terminobuscar').val("");
				$("#mydivBuscar").html("<p>No tienes Permisos para agregar productos de esta categoria.</p>");
				$('.formcartcant').val("");
				if (textStatus = "Success") {
				}

				//window.location.replace("/products/clear");
			}
		});
	}
	
function ajaxcartImport(id, quantity, pv_id, um, descto) {
		$.ajax({
			type: "POST",
			url: myBaseUrlsitemupdatetemps,
			data: {
				id: id,
				quantity: quantity,
				descuento_id: pv_id,
				um: um,
				descto: descto,
			},
			dataType: "json",
			success: function(data, textStatus) {
				//alert(data.responseText);
				switch (data.responseText) {
					case "ok":
						var numero = data.subtotal[1];
						var unidades = data.subtotal[3];

						var contenidocarritostemp = data.contenidocarrotemps;
						if (descto > 0) {
							if (quantity >= um) {

								$('.imgoferta1' + id + '').attr("src", "");
								$('.imgoferta1' + id + '').attr("src", imggeneral + "/oferta_adquirida.png");
							} else {
								$('.imgoferta1' + id + '').attr("src", "");
								$('.imgoferta1' + id + '').attr("src", imggeneral + "/oferta_perdida.png");
							}
						}

						const noTruncarDecimales = {
							maximumFractionDigits: 2,
							minimumFractionDigits: 2,
						};
						ptos = numero.toLocaleString("es", noTruncarDecimales);


						$("#totalitemss").text(contenidocarritostemp.length + " items");
						$("#totalunidadess").text(unidades + "Unid.");
						$("#totaltall").text("Total $ " + ptos);

						$("input[data-id=" + id + "]").val(quantity);


						alertify.message("").dismissOthers();
						if (data.validarUnidades) {
            if (data.validarUnidades.validar == 1) {
              //console.log(id,data.validarUnidades.cantidad);
              $("input[data-id=" + id + "]").val(data.validarUnidades.cantidad);
              $("input[data-id=" + id + "]").html(data.validarUnidades.cantidad);
              alertify.success(
                "Cantidad modificada con exito " +
                  data.validarUnidades.cantidad +
                  ", el limite diario es de" +
                  data.validarUnidades.limite +
                  "!"
              );
            } else if (data.validarUnidades.validar == 0) {
              alertify.success(
                "Ya agotaste el límite de unidades que puedes agregar de este artículo por día el limite es " +
                  data.validarUnidades.limite +
                  "!"
              );
            } else {
              alertify.success("Cantidad Modificada Con Exito!");
            }
          } else {
            alertify.success("Cantidad Modificada Con Exito!");
          }
						alertify.success("Cantidad Modificada Con Exito!");

						if ($("#tablaviewresult").length) {
							var articulo = data.carros;

							const noTruncarDecimaless = {
								maximumFractionDigits: 2,
								minimumFractionDigits: 2,
							};
							var numeros = data.subtotal[4];
							pntos = numeros.toLocaleString("es", noTruncarDecimaless);
							$('td[data-subtotal="sub' + articulo.articulo_id + '"]').html(
								"$ " + pntos
							);
							$(".page_cart1").remove();
							Paginacioncarcar();
						}

						break;

					case "6":
						$(
							'<div class="jquery-notify-bar error top" id="__notifyBar4826526" style=""><span class="notify-bar-text-wrapper">No se puede agregar este producto al carro de compras.</span><a href="#" onclick="cerrarDiv()" class="notify-bar-close">×</a></div>'
						).appendTo("body");
						$("#terminobuscar").val("");
						$("#mydivBuscar").html(
							"<p>No tienes Permisos para agregar productos de esta categoria.</p>"
						);
						$(".formcartcant").val("");
						break;
					case "5":
						$(
							'<div class="jquery-notify-bar error top" id="__notifyBar4826526" style=""><span class="notify-bar-text-wrapper">No se puede agregar este producto al carro de compras. </span><a href="#" onclick="cerrarDiv()"class="notify-bar-close">×</a></div>'
						).appendTo("body");
						$("#terminobuscar").val("");
						$("#mydivBuscar").html(
							"<p>No tienes Permisos para agregar productos de esta categoria.</p>"
						);
						$(".formcartcant").val("");
						break;
					case "0":
						$(
							'<div class="jquery-notify-bar error top" id="__notifyBar4826526" style=""><span class="notify-bar-text-wrapper">No se puede agregar este producto al carro de compras. </span><a href="#" onclick="cerrarDiv()"class="notify-bar-close">×</a></div>'
						).appendTo("body");
						$("#terminobuscar").val("");
						$("#mydivBuscar").html(
							"<p>No tienes Permisos para agregar productos de esta categoria.</p>"
						);
						$(".formcartcant").val("");
						break;
					case "eliminado":
						alertify.message("").dismissOthers();
						alertify.success("Eliminado con exito!");
						if (data.subtotal[3] >= 100) {
							document.getElementById("openerts").innerHTML = "+99";
							document.getElementById("modalitems").innerHTML =
								data.subtotal[0] + "/" + data.subtotal[3];
							if ($("#modalitems1").length) {
								document.getElementById("modalitems1").innerHTML =
									data.subtotal[0] + "/" + data.subtotal[3];
							}
							if ($("#unidades").length) {
								document.getElementById("unidades").innerHTML =
									data.subtotal[0] + "/" + data.subtotal[3];
							}
						} else {
							document.getElementById("openerts").innerHTML = data.subtotal[3];
							document.getElementById("modalitems").innerHTML =
								data.subtotal[0] + "/" + data.subtotal[3];
							if ($("#modalitems1").length) {
								document.getElementById("modalitems1").innerHTML =
									data.subtotal[0] + "/" + data.subtotal[3];
							}
							if ($("#unidades").length) {
								document.getElementById("unidades").innerHTML =
									data.subtotal[0] + "/" + data.subtotal[3];
							}
						}

						$("#totalitemss").text(data.contenidocarrotemps.length + " items");
						$("#totalunidadess").text(unidades + "Unid.");
						$("#totaltall").text("Total $ " + ptos);

						var articulo = data.carros;
						$("tr[id=trimport" + articulo.articulo_id + "]").remove();

						var concarro = data.contenidocarro;
						$("#tr" + id).remove();

						$(".page_cart").remove();
						$("table.table-striped").each(function() {
							var currentPage = 0;
							var numPerPage = 200;
							var $table = $(this);
							$table.bind("repaginate", function() {
								$table
									.find("tr")
									.hide()
									.slice(currentPage * numPerPage, (currentPage + 1) * numPerPage)
									.show();
							});
							$table.trigger("repaginate");
							var numRows = $table.find("tr").length;
							var numPages = Math.ceil(numRows / numPerPage);
							var $pager = $('<div class="page_cart"></div>');
							for (var page = 0; page < numPages; page++) {
								$('<div class="page-number"></div>')
									.text(page + 1)
									.bind(
										"click", {
											newPage: page,
										},
										function(event) {
											currentPage = event.data["newPage"];
											$table.trigger("repaginate");
											$(this).addClass("active").siblings().removeClass("active");
										}
									)
									.appendTo($pager)
									.addClass("clickable");
							}
							$pager
								.insertAfter($table)
								.find("div.page-number:first")
								.addClass("active");
						});

						break;	
						/*		
				    case "mantenimiento":
						$('<div class="jquery-notify-bar error top" id="__notifyBar4826526" style=""><span class="notify-bar-text-wrapper">Estamos realizando un mantenimiento en la pagina web, estará habilitada para cargar datos aproximadamente en 1 hora.</span><a href="#" onclick="cerrarDiv()"class="notify-bar-close">×</a></div>').appendTo('body');
						$('#terminobuscar').val("");
					
				    break;
					*/
				}


			},
			/*ALERTA DE ERROR*/
			error: function(textStatus) {
				if ((textStatus = "Success")) {}
				console.log(textStatus);

				//window.location.replace("/products/clear");
			},
		});
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

function eliminarDatos(id, arti) {

		id = "id=" + id;
		arti = arti;

		$.ajax({
			type: "post",
			url: myBaseUrlsdelete,
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
						$("#pagination_countv").text(data.subtotal[0] + " Articulos");

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

function eliminarItemsTemps(id, arti) {
		id = "id=" + id;
		arti = arti;

		$.ajax({
			type: "post",
			url: myBaseUrlsvaciardeletecarritotemps,
			data: id,
			arti,
			dataType: "json",
			success: function(data, response) {
				if ((response = "ok")) {
					var numero = data.subtotal[1];
					var unidades = data.subtotal[3];

					const noTruncarDecimales = {
						maximumFractionDigits: 2,
						minimumFractionDigits: 2,
					};
					ptos = numero.toLocaleString("es", noTruncarDecimales);

					const contenidocarritostemp = data.contenidocarrotemps;

					$("#totalitemss").text(contenidocarritostemp.length + " items");
					$("#totalunidadess").text(unidades + "Unid.");
					$("#totaltall").text("Total $ " + ptos);

					$("tr[id=trimport" + arti + "]").remove();

					if ($("tr[id=trBody" + arti + "]").length) {
						$("tr[id=trBody" + arti + "]").remove();
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
					alertify.message("").dismissOthers();
					alertify.success("Eliminado con exito!");
					$('#ubicacion').focus();

					$(".page_cart1").remove();
					$("table#formaddcart").each(function() {
						var currentPage = 0;
						var numPerPage = 80;
						var $table = $(this);
						var rowCount = $(
							"table.tablasearch tbody tr td.formcartcanttd"
						).length;
						$table.bind("repaginate", function() {
							$table
								.find("tr")
								.hide()
								.slice(currentPage * numPerPage, (currentPage + 1) * numPerPage)
								.show();
						});
						$table.trigger("repaginate");
						var numRows = $table.find("tbody tr").length;
						var numPages = Math.ceil(numRows / numPerPage);
						var $pager = $('<div class="page_cart1"></div>');
						var $anterior = $(
							'<li class="prev disabled anterior"><a disabled "href="#"onclick="anterior();">Anterior</a></li>'
						);
						var $case = $('<li class="prev"></li>');
						var $siguiente = $(
							'<li class="prev siguiente"><a onclick="siguiente();" onsubmit="return false;">Siguiente></a></li>'
						);
						var $total = $(
							'<li class="pagination_count"><span id="totalitemss">' +
							contenidocarritostemp.length +
							' Articulos</span></li><li class="pagination_count"><span id="totalunidadess">' +
							unidades +
							'Unid.</span></li><li class="pagination_count"><span id="totaltall">Total $ ' +
							ptos +
							"</span></li>"
						);
						var $ul = $(
							'<ul id="uli" style="display: inline-flex;" class="pagination"></ul>'
						);
						$anterior.appendTo($ul);

						for (var page = 0; page < numPages; page++) {
							var $linum = $(
									'<div class="page-number" id=pag' + (page + 1) + "><a></a></div>"
								)
								.text(page + 1)
								.bind(
									"click", {
										newPage: page,
									},
									function(event) {
										currentPage = event.data["newPage"];
										$table.trigger("repaginate");

										$(this).addClass("active").siblings().removeClass("active");
									}
								)
								.appendTo($ul)
								.addClass("clickeable");
						}
						$siguiente.appendTo($ul);

						$total.appendTo($ul);
						$ul.appendTo($pager);
						$pager
							.insertAfter($table)
							.find("div.page-number:first")
							.addClass("active");
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
			},
		});
	}

function vaciarCarrito(id) {
		id = "id=" + id;
		$.ajax({
			type: "post",
			url: myBaseUrlsvaciar,
			data: id,
			success: function(response) {

				if (response = "ok") {

					$('#openerts').attr('data-value', 0);
					$("#openerts").html("0");
					$("#carrito_importe").html("0");
					$("#carrito_importe1").html("0");
					$("#carrito_importe_s").html("0");
					$('#carrito_importe_view').html("0");
					$("#mydivBuscar").html("");
					$("#modalitems").html("0/0");
					$("#unidades").html("0/0");
					$("#modalitems1").html("0/0");
					$('#terminobuscar').val("");
					$("#tablaprueba1").html("");
					$("#table1").html("");
					$("#table").html("");
					$("#tablaprueba").html("");
					$("#tablaviewresult").html("");
					$(".carrito-items").html("");
					$('.formcartcant').val("");
					$('.fragcant').val("");
					$('.cantidad').val("");
					$('.product-promotion-button-submit').val("");
					$('.cantidadoferta').val("");
					$("#foot").removeClass("hide");
					$(".gallery-contenedor").removeClass("hide");
					$(".page_cart").html("");



					alertify.message('').dismissOthers();
					alertify.success("Eliminado con exito!");

				} else {

					alertify.error("Fallo el servidor :(");
				}
			}
		});
	}
	/*
let button = document.getElementsByClassName('sendbtn');

//var form =button.prevObject[0].forms;
console.log(button);
$(button[0]).attr('onsubmit','return false();');
$(button[0].form).attr('onclick','mantenimiento();')
for(var i=0; i <= button.length; i++){
}*/
  //button.disabled = true; 

    //consola de aca se comento esto pero ahora deberia de cambiar el tamaño de las funciones que agregamos