<div class="col-md-9">
<div class="product-item-3">  
<div class="product-content">
</br>
<?php 
if ($tipo_oferta !='TD'&&$tipo_oferta !='TH' && $tipo_oferta !='OR')
{
    if ($tipo_oferta !='BF')
    {
    if ($tipo_oferta =='P' )
        echo $this->element('carrito_search_result');    
    else
        echo $this->element('carrito_farmapoint_result');
    }
    else
     {
        if ($indice !='1' )
            echo $this->element('carrito_search_result');    
        else
            echo $this->element('carrito_farmapoint_result');
        

     }   

}
else
{

 echo $this->element('carrito_search_result'); 
 echo $this->element('referencia'); 
}
?> 
							
</div> <!-- /.product-content -->							
</div> <!-- /.product-item -->
</div> <!-- /.col-md-3 -->
<div class="col-md-3">
<div class="product-item-5"> 
<div class="product-content">
<div class="row">
<?php echo $this->element('cartresum'); ?>
</div> <!-- /.row -->
</div> <!-- /.product-content -->
</div>
<div class="product-item-5">	
<div class="product-content">
<div class='cliente_info_class3'>
<?php echo $this->Html->image('ofertaagregarcarro.png');?>
</div>
<div class='cliente_info_class2'>Carro de Compras</div>
<div class="row">   
<?php echo $this->element('botonescarro'); ?>
<div class="cartresul">			
<?php echo $this->element('cartresult'); ?>
</div>
</div> <!-- /.row -->
</div> <!-- /.product-content -->
</div> <!--.product-item-1 -->  
</div> <!-- /.col-md-4 -->