<div class="search-form">
    <?= $this->Form->create('Comprobantes',['url'=>['controller'=>'Comprobantes','action'=>'search'],'id'=>'searchform4','onsubmit'=>'return validar()']); ?>
	<?= $this->Form->input('cliente_id',['id'=>'selectcuenta','options'=> $clientes,'label'=>'Cuenta:','default'=>$this->request->session()->read('cliente_id'),'onChange'=>'document.getElementById("searchform4").submit();']); ?>
	
	<?= $this->Form->input('fechadesde', ['label'=>'Desde:','id'=>'fechadesde','name'=>'fechadesde', 'type'=>'text','placeholder'=>'Fecha Desde:']);?>
	<?=	$this->Form->input('fechahasta', ['label'=>'Hasta:','id'=>'fechahasta','name'=>'fechahasta', 'type'=>'text','placeholder'=>'Fecha Hasta:']);?>
	<?= $this->Form->input('terminobuscar', ['label'=>'','id'=>'terminobuscar','name'=>'terminobuscar', 'type'=>'text','placeholder'=>'Buscar termino','onchange'=>'javascript:document.confirmInput.submit();']);?>	
</div>
<div class="cliente_info">
	<?php echo $this->Form->input('factura', ['label'=>'Factura','type'=>'checkbox','value'=>1,'checked'=>1]); ?>
	<?php echo $this->Form->input('notacredito', ['label'=>'Nota de Credito','type'=>'checkbox','value'=>1,'checked'=>1]);?>
	<?php echo $this->Form->input('notadebito', ['label'=>'Nota de Debito','type'=>'checkbox','value'=>1,'checked'=>1]);?>
	<?php echo $this->Form->input('recibo',['label'=>'Recibo Oficial','type'=>'checkbox','value'=>1,'checked'=>1]);	//,'checked'?>
</div>
<div class="search-form">	
	<?= $this->Form->submit('Buscar',['id'=>'buttonsearch','name'=>'btnsearch']); ?>

</div> <!-- /.search-form -->
