<style>
.button_continuar .label{
	width : 150px; 
}
label{
	width : 250px;
}
</style>
<div class="col-md-12">
<div class="product-item-3" style="margin-bottom: 0px;">
<div class="product-content">
<h1>Nuevo Transfer</h1>
</div><!-- /.product-content -->
</div> <!-- /.col-md- -->
<div class="product-item-3">

<div class="product-thumb">
<!--div style="height:100px" -->
<div class="search-form">
<?= $this->Form->create('Transfers',['url'=>['controller'=>'Transfers','action' => 'add'],'id'=>'searchform5']) ?>
<?php echo $this->Form->control('codigo', ['empty' => true,'class' =>'codigoimput','label'=>'Ingrese un código de cliente','placeholder'=>'Ingrese un código de cliente']);  
	  echo $this->Form->submit('Continuar',['class'=>'mainBtn']);?>
<?= $this->Form->end() ?>

</div>
</div><!-- /.product-content -->
</div> <!-- /.col-md- -->
</div>