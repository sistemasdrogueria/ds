<div class="search-form">
    <?= $this->Form->create('Pedidos',['url'=>['controller'=>'Pedidos','action'=>'search'],'id'=>'searchform4','onsubmit'=>'return validar()']); ?>

	<?= $this->Form->input('fechadesde', ['label'=>'Desde:','id'=>'fechadesde','name'=>'fechadesde', 'type'=>'text','placeholder'=>'Fecha Desde:']);?>
	<?=	$this->Form->input('fechahasta', ['label'=>'Hasta:','id'=>'fechahasta','name'=>'fechahasta', 'type'=>'text','placeholder'=>'Fecha Hasta:']);?>
	<?= $this->Form->input('terminobuscar', ['label'=>'','id'=>'terminobuscar','name'=>'terminobuscar', 'type'=>'text','placeholder'=>'Buscar termino','onchange'=>'javascript:document.confirmInput.submit();']);?>	

	<?= $this->Form->submit('Buscar',['class'=>'mainBtn']); ?>
	<?= $this->Form->end() ?>
</div> <!-- /.search-form -->
