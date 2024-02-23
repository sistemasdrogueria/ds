<style>
    .lab_name{text-align: center; }
    .lab_name a{ color: #000; font-size: 15px; text-align: center; font-weight: bold;}
</style>
<?php $indice=0;?>
<div class="row" style ="text-align: center;">
<div class="prodmcontenedor_search hide">
</div>
<div class = "gallery-contenedor prodmcontenedor" style="margin:0px auto;">
<!-- div class="nutricioncontenedor" -->
<?php foreach ($PatagoniaMed as $lab): ?>
<div class="gallery-oferta">
<!--div class="nutricionmarcadiv" -->
<div class=product-item-6 style="height:210px ; width:210px;border: 5px solid #2a80b9;  display: flex; justify-content: center; align-items: center; border-radius: 5px; ">
<div class="divprodm"  id="<?php  echo $lab['Laboratorios']['id']; ?>">
<a href="#">
<?php 
$uploadPath = 'logos/';
$imageFile = '/img/'.$uploadPath.$lab['Laboratorios']['id'].'.jpg';
$imagePath = WWW_ROOT.$imageFile;
if (file_exists($imagePath))
echo $this->Html->image($uploadPath.$lab['Laboratorios']['id'].'.jpg', ['loading'=>'lazy','alt' => str_replace('"', '', $lab['Laboratorios']['nombre']),'width' => 200,'url' => ['controller' => 'AccesoriosYProductosMedicos', 'action' => 'search',$lab['Laboratorios']['id']]]);	
else
echo '<div class=lab_name>'.$this->Html->link(str_replace('"', '', $lab['Laboratorios']['nombre']), ['controller' => 'AccesoriosYProductosMedicos', 'action' => 'search', $lab['Laboratorios']['id']]).'</div>';
?> 
</a>
</div> 
</div>
</div>
<?php endforeach; ?>
</div>
</div>