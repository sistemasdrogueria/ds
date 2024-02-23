<div class="col-md-12">
<div class="product-item-3">
<div class="product-content">
<span class="cliente_info_span">Acticulos importados: </span>
<?php if ($articulos!=null )
echo $this->element('transfer_importresult'); ?>
</div> <!-- /.product-content -->
<div class="product-content">
<span class="cliente_info_span">No se encontraron los siguientes productos: </span>
<?php echo $this->element('transfer_importresult_notfound');  ?>	
<div class="importconfirm2">	
<div class="button-holder3">
<?=$this->Html->link('Descargar Archivo',['controller' => 'Transfers', 'action' => 'downloadfile'])?>
</div>
</div>
<div class="importconfirm2">	
<div class="button-holder3">
<?=$this->Html->link('Descargar Excel',['controller' => 'Transfers', 'action' => 'import_excel'])?>
</div>
</div>
</div> <!-- /.product-content -->
</div> <!-- /.product-item -->
</div> <!-- /.col-md-3 -->