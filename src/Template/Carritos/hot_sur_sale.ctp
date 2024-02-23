<style>
*{margin: 0; padding: 0;}
#caja{
  display: flex;
  flex-flow: column wrap;
  justify-content: center;
  align-items: center;
}
#box{
  overflow: hidden;
}
#box img{
  width: 100%;
  height: auto;
}
@supports(object-fit: cover){
    .box img{
      height: 100%;
      object-fit: cover;
      object-position: center center;
    }
}
</style>
<div class="col-md-9">
<div class="product-item-3">  
<div class="product-content" >
<div id=caja>
<div id=box>
<?php echo $this->Html->image('logos/HSS_'.$lab_id.'.jpg', ['alt' => 'Promoción', 'style'=>'margin-bottom:20px;    margin-left: auto;   margin-right: auto;  display: block;' ]);?> 
</div>
</div>
</br>

<?php 

  /*  if ($tipo_oferta !='SS')
    {
    if ($tipo_oferta =='P' )
        echo $this->element('carrito_search_result_hss');    
    else
        echo $this->element('carrito_farmapoint_result');
    }
    else
     {
        if ($indice !='1' )
            echo $this->element('carrito_search_result_hss');    
        else
            echo $this->element('carrito_farmapoint_result');
        

     }   

}
else
{
*/
 echo $this->element('carrito_search_result_hss'); 
 //echo $this->element('referencia'); 

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