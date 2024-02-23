<?php
echo $this->Html->css('bootstrap.css');
echo $this->Html->script('bootstrap.js');
//echo $this->Html->script('boostrap.'); 	
?>
<article class="module width_3_quarter">
	<header>
		<h3 class="tabs_involved"><?= $titulo ?></h3>

		<div class="tabs_bt_nuevo">
			<?= $this->Html->image("admin/icn_edit.png", array("title" => "Modificar todos los laboratorios", "onclick" => "modalviewall();", 'style' => 'cursor:pointer;margin-top:10px')); ?>
		</div>
	</header>

	<div class="tab_container">
		<?php echo $this->element('labora_search_admin'); ?>
		<?php echo $this->element('labora_result_admin'); ?>
	</div><!-- end of .tab_container -->
</article><!-- end of content manager article -->

<div class="modal" id="myModal" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title"></h5>
				<button type="button" class="close btn-cerrar" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<table class="tablesorter">
					<thead>
						<tr>
							<th>Laboratorio</th>
							<th>Unidades</th>
							<th>Restricción</th>
						</tr>
					</thead>
					<tbody class="laboratorio-id">
						<tr>
							<td><input disabled class="form-control" id="nlab"></td>
							<td><input class="form-control" id="unilab"></td>
							<td><select clas="terminobusquedaselect" id="selectlab" style="height:26px">
									<option value="">Selecione un estado</option>
									<option value="0">Sin restriciones</option>
									<option value="1">Con restriciones</option>
								</select></td>
						</tr>
					</tbody>
				</table>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary btn-save-restricion">Guardar Cambios</button>
				<button type="button" class="btn btn-secondary btn-cerrar" data-dismiss="modal">Cerrar</button>
			</div>
		</div>
	</div>
</div>


<div class="modal" id="myModalall" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title"></h5>
				<button type="button" class="close btn-cerrar2" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<table class="tablesorter">
					<thead>
						<tr>
							<th>Laboratorio</th>
							<th>Unidades</th>
							<th>Restricción</th>
						</tr>
					</thead>
					<tbody class="laboratorio-id">
						<tr>
							<td><input disabled class="form-control" id="nlaball" Value="todos los laboratorios"></td>
							<td><input class="form-control" id="unilaball"></td>
							<td><select clas="terminobusquedaselect" id="selectlaball" style="height:26px">
									<option value="">Selecione un estado</option>
									<option value="0">Sin restriciones</option>
									<option value="1">Con restriciones</option>
								</select></td>
						</tr>
					</tbody>
				</table>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary btn-save-restricion-all">Guardar Cambios</button>
				<div id="loadingMessage" style="display: none;">Cargando...</div>
				<button type="button" class="btn btn-secondary btn-cerrar2" data-dismiss="modal">Cerrar</button>
			</div>
		</div>
	</div>
</div>
<script>
	$('.btn-cerrar').on('click', function() {

		$('#myModal').hide();

	});

	$('.btn-cerrar2').on('click', function() {


		$('#myModalall').hide();
	});

	$('#unilaball').on('change', function() {

		var unidadesValue = $('#unilaball').val();
		console.log(unidadesValue)
		if (unidadesValue > 0) {
			$("#selectlaball option[value='1']").attr("selected", true);

		} else {
			$("#selectlaball option[value='0']").attr("selected", true);

		}

	});

	$('#unilab').on('change', function() {

		var unidadesValue = $('#unilab').val();
		console.log(unidadesValue)
		if (unidadesValue > 0) {
			$("#selectlab option[value='1']").attr("selected", true);

		} else {
			$("#selectlab option[value='0']").attr("selected", true);
		}


	});

	function modalviewall() {
		var myBaseUrlsedit = '<?php echo \Cake\Routing\Router::url(array('controller' => 'Laboratorios', 'action' => 'edit_admin_all')); ?>';

		$('#myModalall').show();

		$('.btn-save-restricion-all').on('click', function() {
			    $(this).prop("disabled", true);
				 $("#loadingMessage").show();
			var restriccionesValue = $("#selectlaball option:selected").val();
			var unidadesValue = $('#unilaball').val();

			// Validación de campos vacíos
			if (!restriccionesValue || !unidadesValue) {
				alertify.error("Por favor, completa ambos campos: restricciones y unidades.");
				return;
			}
              
			var dataToSend = {
				restriciones: restriccionesValue,
				unidades: unidadesValue,
			};

			$.ajax({
				type: "post",
				url: myBaseUrlsedit,
				data: dataToSend,
				dataType: "json",
				success: function(data, response) {
					if ((response = "ok")) {

						alertify.message("").dismissOthers();
						alertify.success("Modificado con exito!");
						$('#myModalall').hide();
						location.reload();
					} else {
						alertify.success("Hubo un error intente nuevamente.");
					}
				}
			});

		});


	}

	function modalview(id, laboratorio, restricion, unidades) {
		var myBaseUrlsedit = '<?php echo \Cake\Routing\Router::url(array('controller' => 'Laboratorios', 'action' => 'edit_admin')); ?>';
		$('#myModal').show();
		$('#nlab').text(laboratorio);
		$('#nlab').val(laboratorio);
		$('#unilab').text(unidades);
		$('#unilab').val(unidades);


		if (restricion == "") {
			$("#selectlab option[value='']").attr("selected", true);
		} else if (restricion == 0) {
			$("#selectlab option[value='0']").attr("selected", true);

		} else {
			$("#selectlab option[value='1']").attr("selected", true);

		}

		$('.btn-save-restricion').on('click', function() {

			var restriccionesValue = $("#selectlab option:selected").val();
			var unidadesValue = $('#unilab').val();

			// Validación de campos vacíos
			if (!restriccionesValue || !unidadesValue) {
				alertify.error("Por favor, completa ambos campos: restricciones y unidades.");
				return;
			}


			var dataToSend = {
				id: id,
				restriciones: restriccionesValue,
				unidades: unidadesValue,
			};

			$.ajax({
				type: "post",
				url: myBaseUrlsedit,
				data: dataToSend,
				dataType: "json",
				success: function(data, response) {
					if ((response = "ok")) {

						alertify.message("").dismissOthers();
						alertify.success("Modificado con exito!");
						$('#myModal').hide();
					location.reload();
					} else {
						alertify.success("Hubo un error intente nuevamente.");
					}
				}
			});
		});
	}
</script>