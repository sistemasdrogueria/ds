<script>

var mot = [];
mot[4]="Mercadería Dañada";
mot[5]="Mercadería Vencida";
mot[6]="Mercadería Solicitada por error";
mot[3]="Mercadería No Solicitada";
var mot2 = [];
mot2[1]="Mercadería Mal Facturada";
mot2[2]="Mercadería No recibida";
mot2[8]="Rectificación de Lote";
mot2[7]="Problemas de Trazabilidad";
		
var options = {0 : mot,1 : mot2}

$(function(){
	var fillSecondary = function(){
		var selected = $('#form_tipo').val();
		$('#form_reclamos_tipo_id').empty();
		options[selected].forEach(function(element,index){$('#form_reclamos_tipo_id').append('<option value="'+index+'">'+element+'</option>');});
	}
	$('#form_tipo').change(fillSecondary);
	fillSecondary();
});

</script>
<div class="search-form">
<?= $this->Form->create('Tickets',['id'=>'searchform4','url'=>['controller'=>'Tickets','action'=>'add']]); //,'onsubmit'=>'return validar2()'?>
<fieldset>
 
   
<?php
$motivo_tipo= [0=>'Devolución', 1=>'Reclamo'];
echo $this->Form->input('tipo', ['label'=>'Tipo','options' =>$motivo_tipo , 'empty'=>'Seleccionar tipo','id'=>'form_tipo','required'=>true]);
echo $this->Form->input('reclamos_tipo_id', ['label'=>'Motivo','options' => $reclamostipos, 'empty'=>'Seleccionar motivo','id'=>'form_reclamos_tipo_id','required'=>true ]);
echo $this->Form->input('factura_numero',['placeholder'=>"e.g. 0007-04222400",'title'=>"Número de factura e.g. 0007-04222400",
'name'=>'factura_numero','label'=>'Número Factura','pattern'=>'[0-9]{4}[-]{1}[0-9]{8}','required'=>true ]);
?>
</fieldset>
</div>
<div class="col-md-12 col-sm-12">
<div class="button-holder">
<?= $this->Form->submit('Validar',['class'=>'button-holder2']); ?>
</div> 
</div>
<?= $this->Form->end() ?>