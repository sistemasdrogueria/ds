<div class="search-form">
    <?= $this->Form->create('Reclamos',['url'=>['controller'=>'Reclamos','action'=>'search'],'id'=>'searchform4','onsubmit'=>'return validar()']); ?>
	<?= $this->Form->input('fechadesde', ['label'=>'Desde:','id'=>'fechadesde','name'=>'fechadesde', 'type'=>'text','placeholder'=>'Fecha Desde']);?>
	<?=	$this->Form->input('fechahasta', ['label'=>'Hasta:','id'=>'fechahasta','name'=>'fechahasta', 'type'=>'text','placeholder'=>'Fecha Hasta']);?>
	<?= $this->Form->input('reclamos_tipo_id', ['label'=>'Motivo Reclamo:','options' => $reclamostipos, 'empty'=>'Seleccionar motivo','id'=>'form_reclamos_tipo_id']);?>
	<?= $this->Form->input('terminobuscar', ['label'=>'Buscar','id'=>'terminobuscar','placeholder'=>'Buscar Producto','name'=>'terminobuscar', 'type'=>'text','onchange'=>'javascript:document.confirmInput.submit();']);?>	
	<?= $this->Form->submit('Buscar',['class'=>'mainBtn']); ?>
	<?= $this->Form->end() ?>
</div> <!-- /.search-form -->