<?php 
$indice=0;
$grupos= $grupos->toArray();
?>
<div class="farmaydecocontenedor">
<?php foreach ($grupos as $grupo): ?>
<div class="farmaydecogrupodiv" >
<a href="#">
<div  align="center">
<?php 
$uploadPath = 'grupos/';
if (file_exists('www.drogueriasur.com.ar/ds/webroot/img/'.$uploadPath.$grupo['imagen'] ))
echo $this->Html->image($uploadPath.$grupo['imagen'], ['alt' => str_replace('"', '', $grupo['nombre']),'width' => 300,'url' => ['controller' => 'HomeYDecos', 'action' => 'search',$grupo['id']]]);
else
echo $this->Html->image($uploadPath.$grupo['imagen'], ['alt' => str_replace('"', '', $grupo['nombre']),'width' => 300, 'url' => ['controller' => 'HomeYDecos', 'action' => 'search',$grupo['id']]]);
//echo $this->Html->image($uploadPath.$grupo['imagen'], ['alt' => str_replace('"', '', $grupo['nombre']),'width' => 300,'onsubmit' => 'return false;']);
?> 
</div> 
</a>
</div>
<?php endforeach; ?>
</div>