<?php
$nombre_fichero = 'farmacia/'.$this->request->session()->read('Auth.User.codigo').'.JPG';
if (file_exists('/opt/lampp/htdocs/ds/webroot/img/'.$nombre_fichero )){
$confirmed= $this->element('cartconfirmclient');
$infocliente =$this->element('infoclient');
echo '<div style="display: flex;flex-wrap: wrap;align-content: space-around;justify-content: space-evenly;align-items:flex-start;"><div class="col-md-5">
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
<div class="col-md-7">
<div class="product-item-3">';
if ($this->request->session()->read('Auth.User.perfile_id')==1):
endif;
echo '<div  id="mostrarresultado">
<div class="row">
<div class="farmacia_img">
';
$nombre_fichero = 'farmacia/'.$this->request->session()->read('Auth.User.codigo').'.JPG';
if (file_exists('/opt/lampp/htdocs/ds/webroot/img/'.$nombre_fichero ))
echo $this->Html->image($nombre_fichero,['id'=>'farmacia_image']);
echo '
</div>
</div>
</div>
</div> <!-- /.product-item -->
</div>
</div> ';
}else{
$confirmed= $this->element('cartconfirmclient');
$infocliente =$this->element('infoclient');
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
}
?>