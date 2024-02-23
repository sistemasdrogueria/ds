<div class="search-form">
    <?= $this->Form->create('Facturas',['url'=>['controller'=>'Facturas','action'=>'pami'],'id'=>'searchform4','onsubmit'=>'return validar()']); ?>
	<?= $this->Form->input('fechadesde', ['label'=>'','id'=>'fechadesde','name'=>'fechadesde', 'type'=>'text','placeholder'=>'Fecha Desde:']);?>
	<?=	$this->Form->input('fechahasta', ['label'=>'','id'=>'fechahasta','name'=>'fechahasta', 'type'=>'text','placeholder'=>'Fecha Hasta:']);?>
	<?= $this->Form->input('terminobuscar', ['label'=>'','id'=>'terminobuscar','name'=>'terminobuscar', 'type'=>'text','placeholder'=>'Buscar termino','onchange'=>'javascript:document.confirmInput.submit();']);?>	
</div>

<div class="search-form">	
	<?= $this->Form->submit('Buscar',['id'=>'buttonsearch']); ?>
	<?= $this->Form->end() ?>
</div> <!-- /.search-form -->