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
var options = {
		0 : mot,
		1 : mot2
}
$(function(){
	var fillSecondary = function(){
		var selected = $('#form_tipo').val();
		$('#form_reclamos_tipo_id').empty();
		options[selected].forEach(function(element,index){
			$('#form_reclamos_tipo_id').append('<option value="'+index+'">'+element+'</option>');
		});
	}
	$('#form_tipo').change(fillSecondary);
	fillSecondary();
});
</script>


<div class="search-form">
    <?= $this->Form->create('Tickets',['url'=>['controller'=>'Tickets','action'=>'index'],'id'=>'searchform4','onsubmit'=>'return validar()']); ?>
	<?= $this->Form->input('fechadesde', ['label'=>'Desde:','id'=>'fechadesde','name'=>'fechadesde', 'type'=>'text','placeholder'=>'Fecha Desde']);?>
	<?=	$this->Form->input('fechahasta', ['label'=>'Hasta:','id'=>'fechahasta','name'=>'fechahasta', 'type'=>'text','placeholder'=>'Fecha Hasta']);?>
	<?php
		$motivo_tipo= [0=>'Devolución', 1=>'Reclamo'];
		echo $this->Form->input('tipo', ['label'=>'Tipo','options' =>$motivo_tipo , 'empty'=>'Seleccionar tipo','id'=>'form_tipo','required'=>true]);
		echo $this->Form->input('reclamos_tipo_id', ['label'=>'Motivo','options' => $reclamostipos, 'empty'=>'Seleccionar motivo','id'=>'form_reclamos_tipo_id','required'=>true ]);

 // $this->Form->input('reclamos_tipo_id', ['label'=>'Motivo:','options' => $reclamostipos, 'empty'=>'Seleccionar motivo','id'=>'form_reclamos_tipo_id']);?>
	<?= $this->Form->input('terminobuscar', ['label'=>'Buscar','id'=>'terminobuscar','placeholder'=>'Buscar Producto','name'=>'terminobuscar', 'type'=>'text','onchange'=>'javascript:document.confirmInput.submit();']);?>	
	<?= $this->Form->submit('Buscar',['class'=>'mainBtn']); ?>
	<?= $this->Form->end() ?>
</div> <!-- /.search-form -->