<style>
.all_fragancia{color: black;text-decoration: none;}
.one_fragancia{display: inline-block;  width: 30% ; margin: 5px;}
.one_fragancia a{font: 13px/21px "Open Sans",Arial,sans-serif;font-weight: bold;height: 200px; width: 100% ;color: black;font-size: 21px;display: flex;align-items: center;justify-content: center;border: 5px solid #303030;border-radius: 5px;}
</style>
<?php 
$indice=0;
//$marcas= $marcas->toArray();
?>
<div class="fraganciacontenedor" style="background-color:#fff">
<?php
if (is_null($marcas2))
{
echo '<div class=all_fragancia>';
echo '<div class = one_fragancia>';
echo $this->Html->link(
    'SELECTIVAS',
    ['controller' => 'DeliaPerfumerias', 'action' => 'fragancia', 'select','_full' => true]
);
echo '</div>';
echo '<div class = one_fragancia >';
echo $this->Html->link(
    'SEMISELECTIVAS',
    ['controller' => 'DeliaPerfumerias', 'action' => 'fragancia', 'semiselect','_full' => true]
);
echo '</div></div>';
//echo '</div>';
}
else
foreach ($marcas2 as $marca): ?>
<div class="fraganciamarcadiv">
<div  align="center">
<?php 
$uploadPath = 'marcas/';
if (file_exists('www.drogueriasur.com.ar/ds/webroot/img/'.$uploadPath.$marca['imagen'] ))
echo $this->Html->image($uploadPath.$marca['imagen'], ['alt' => str_replace('"', '', $marca['nombre']),'width' => 125]);
else
echo $this->Html->image($uploadPath.$marca['imagen'], ['alt' => str_replace('"', '', $marca['nombre']),'width' => 125, 'url' => ['controller' => 'DeliaPerfumerias', 'action' => 'resultfragancia',$pass,$marca['id'] ,0]]);
?> 
</div> 
</div>
<?php endforeach; ?>
</div>