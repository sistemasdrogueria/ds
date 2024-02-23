			<div class="search-form">
				<?= $this->Form->create('Reclamos',['id'=>'searchform4','url'=>['controller'=>'Reclamos','action'=>'confirm'],'onsubmit'=>'return validar2()']); ?>
			<fieldset>
				<?php
					echo $this->Form->input('factura_numero',['name'=>'factura_numero','type'=>'text','label'=>'Número Pedido','disabled' => 'disabled','value'=>$reclamo['factura_numero']]);
					echo $this->Form->input('fecha_recepcion', ['label'=>'Fecha Pedido','id'=>'fecha_recepcion','name'=>'fecha_recepcion', 'type'=>'text','placeholder'=>'Fecha Pedido','disabled' => 'disabled','value'=>$reclamo['fecha_recepcion']]);
					echo $this->Form->input('reclamos_tipo_id', ['label'=>'Motivo del Reclamo','options' => $reclamostipos, 'empty'=>'Seleccionar motivo','id'=>'form_reclamos_tipo_id','disabled' => 'disabled','value'=>$reclamo['reclamos_tipo_id']]);
					echo $this->Form->input('observaciones',['type'=>'textarea','id'=>'form_observaciones','disabled' => 'disabled','value'=>$reclamo['observaciones']]);
				
			
				?>
			</fieldset>
			</div>
			<div class="col-md-12 col-sm-12">
				
				<div class="button-holder">
					<?=
					$this->Html->link(
					'Vaciar',
					['controller' => 'ReclamosItemsTemps', 'action' => 'vaciar'],
					['onsubmit'=>'return validar2()','escape' => false],
					['id'=>'vaciarreclamos']
					//['confirm' => 'Esta seguro de vaciar el carrito']
					) ?>
				</div> <!-- /.button-holder -->
				<div class="button-holder">
					<?= $this->Form->submit('Enviar',['class'=>'button-holder2']); ?>
				</div> <!-- /.button-holder -->
			</div> <!-- /.col-md-12 -->
			<?= $this->Form->end() ?>
			
<script>
	function validar2(){
		//$('#vaciarreclamos').click(function(){
					//Almacenamos los valores
			var facturanumero=$('#factura_numero').val();
			var fecharecepcion=$('#fecha_recepcion').val();
			var reclamostipoid=$('#form_reclamos_tipo_id').val();
		   //Comprobamos la longitud de caracteres
			if ((facturanumero.length>5) && (reclamostipoid.length>1) && (reclamostipoid.length>1))
			{ 
			alert(0);
				return true;
			}
			else {
					var mensaje= 'complete todos los campos ';
					return false;		
			}
			};	

	
</script>