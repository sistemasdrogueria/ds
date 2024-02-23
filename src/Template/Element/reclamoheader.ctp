			<div class="search-form">
				<?= $this->Form->create('Reclamos',['id'=>'searchform4','url'=>['controller'=>'Reclamos','action'=>'add_reclamo'],'onsubmit'=>'return validar2()']); ?>
			<fieldset>
				<?php
					echo $this->Form->input('factura_numero',['name'=>'factura_numero','type'=>'text','label'=>'Número Pedido','onchange' => "javascript:checkpedido(this);"]);
					echo $this->Form->input('fecha_recepcion', ['label'=>'Fecha Pedido','id'=>'fecha_recepcion','name'=>'fecha_recepcion', 'type'=>'text','placeholder'=>'Fecha Pedido']);
					echo $this->Form->input('reclamos_tipo_id', ['label'=>'Motivo del Reclamo','options' => $reclamostipos, 'empty'=>'Seleccionar motivo','id'=>'form_reclamos_tipo_id','onchange' => "javascript:checkmotivo(this);"]);
					echo $this->Form->input('observaciones',['type'=>'textarea','id'=>'form_observaciones','onchange' => "javascript:checkobservacion(this);"])
				?>
			</fieldset>
			</div>
			<div class="col-md-12 col-sm-12">
				
				
				<div class="button-holder">
					<?= $this->Form->submit('Continuar',['class'=>'button-holder2']); ?>
				</div> <!-- /.button-holder -->
			</div> <!-- /.col-md-12 -->
			<?= $this->Form->end() ?>
			
<script>
	function validar2(){
		//$('#vaciarreclamos').click(function(){
					//Almacenamos los valores
			var facturanumero=$('#factura-numero').val();
			var fecharecepcion=$('#fecha_recepcion').val();
			var reclamostipoid=$('#form_reclamos_tipo_id').val();
		   //Comprobamos la longitud de caracteres
			
			if (facturanumero.length<4)
			{	
					var mensaje= 'N° de pedido: La cantidad de caracteres es menor a 4.';
					alert(mensaje);
					return false;
			}
			if (fecharecepcion.length<1)
			{
					var mensaje= 'Seleccione una fecha.';
					alert(mensaje);
					return false;					}
			if (reclamostipoid.length<1)
			{
					var mensaje= 'Seleccione un tipo de delvo/reclamo.';
					alert(mensaje);
					return false;					}
			return true;	
			};	

	$(document).ready(function() {
				//attach keypress to input
				$('#factura-numero').keydown(function(event) {
					// Allow special chars + arrows 
					if (event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 
						|| event.keyCode == 27 || event.keyCode == 13 
						|| (event.keyCode == 65 && event.ctrlKey === true) 
						|| (event.keyCode >= 35 && event.keyCode <= 39)){
							if (event.keyCode == 9 )
							{
								//document.confirmInput.submit();
								//document.getElementById("formaddcart").submit();
								//myFunction();
								//document.getElementById("formaddcart").submit();
							}
							return;
					}else {
						// If it's not a number stop the keypress
						if (event.shiftKey || (event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105 )) {
							event.preventDefault(); 
						}   
					}
				});
	});
</script>