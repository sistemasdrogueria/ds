<?php
$confirmed= $this->element('cartconfirmclient');
$infocliente =$this->element('cliente_parameters');
echo '<div id="redimensionar"class="redimensionar"><div class="col-md-5">
<div class="product-item-3"> 
<div class="product-content">
<div class="row">
<div class="col-md-12 col-sm-12">
'.$confirmed.'
</div> 
</div> 
</div> 
<div class="product-content">
<div class="row">    
'.$infocliente.'
</div>
</div> <!-- /.product-content -->
<div class="product-thumb">
Si querés modificar tus datos, comunicate al 0291-4583077. 
</div> <!-- /.product-thumb -->
</div> <!--.product-item-1 -->  
</div> <!-- /.col-md-4 -->
<div id="mostrarresultado" class="hide">
</div>
</div> ';

?>