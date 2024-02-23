<div class="esteticacontenedor">
<?php foreach ($grupos2 as $grupo): ?>
<div class="esteticagrupodiv" >
<a href="#">
<div  align="center">
<?php 
$uploadPath = 'grupos/';
if (file_exists('www.drogueriasur.com.ar/ds/webroot/img/'.$uploadPath.$grupo['imagen'] ))
echo $this->Html->image($uploadPath.$grupo['imagen'], ['alt' => str_replace('"', '', $grupo['nombre']),'width' => 300,'url' => ['controller' => 'DeliaPerfumerias', 'action' => 'resultestetica',$grupo['id']]]);
else
echo $this->Html->image($uploadPath.$grupo['imagen'], ['alt' => str_replace('"', '', $grupo['nombre']),'width' => 300, 'url' => ['controller' => 'DeliaPerfumerias', 'action' => 'resultestetica',$grupo['id']]]);
//echo $this->Html->image($uploadPath.$grupo['imagen'], ['alt' => str_replace('"', '', $grupo['nombre']),'width' => 300,'onsubmit' => 'return false;']);
?> 
</div> 
</a>
</div>
<?php endforeach; ?>
</div>