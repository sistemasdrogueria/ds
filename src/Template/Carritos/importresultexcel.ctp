<div class="col-md-9">
<div class="product-item-3">
<div class="product-content">
<span class="cliente_info_span">Acticulos importados: </span>
<?php if ($articulos!=null )
echo $this->element('searchimportresult'); 
else
echo $this->element('searchsinresult'); 
?>
</div> <!-- /.product-content -->
<div class="product-content">
<?php echo $this->element('referencia'); ?>
</div> <!-- /.product-content -->

        <div class="product-content">
            <?php if(isset($_SESSION['destarray'])) {
                if(!empty($_SESSION['destarray'])) {
                    echo '<span class="cliente_info_span">PRODUCTOS MODIFICADOS POR RESTRICIONES DE UNIDADES</span>';
                    echo $this->element('searchimportresultmodcant');
                }
            }
            ?>
        </div>
<div class="product-content">
<span class="cliente_info_span">No se encontraron los siguientes productos: </span>
<?php echo $this->element('searchimportresultnotfind');  ?>	
<div class="importconfirm2">	
<div class="button-holder3">
<?= $this->Html->link('Descargar Archivo',['controller' => 'Carritos', 'action' => 'downloadfile']) ?>
</div>
</div>
<div class="importconfirm2">	
<div class="button-holder3">
<?= $this->Html->link('Descargar Excel',['controller' => 'Carritos', 'action' => 'excel']) ?>
</div>
</div>
</div> <!-- /.product-content -->
</div> <!-- /.product-item -->
</div> <!-- /.col-md-3 -->
<div class="col-md-3">
<div class="product-item-3"> 
<div class="product-content">
<div class="row">
<?php echo $this->element('cartresum'); ?>
</div> <!-- /.row -->
</div> <!-- /.product-content -->
<div class="product-content">
<div class='cliente_info_class3'>
<?php echo $this->Html->image('ofertaagregarcarro.png'); ?>
</div>
<div class='cliente_info_class2'>Carro de Compras</div>
<div class="row">   
<?php echo $this->element('botonescarro2'); ?>
<div class="cartresul">			
<?php echo $this->element('cartresult'); ?>
</div>
</div> <!-- /.row -->
</div> <!-- /.product-content -->
</div> <!--.product-item-1 -->  
</div> <!-- /.col-md-4 -->