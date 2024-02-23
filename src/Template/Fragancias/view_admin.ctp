<style>
.infofrag {display: flex;
margin-bottom: 10px; font-size: 15px;}

</style>
<?php //><script type="text/javascript">
$previous = "javascript:history.go(-1)";
if(isset($_SERVER['HTTP_REFERER'])) {
$previous = $_SERVER['HTTP_REFERER'];
}
?>
<article class="module width_3_quarter">
<header><h3 class="tabs_involved"><?= $titulo ?></h3>
<div class="volveratras"><a href="<?= $previous ?>"><?php echo $this->Html->image('icn_volver.png');?></a></div>

</header>
<div class="tab_container">
<div style="float: right;">
<?php  
$uploadPath = 'fragancias/';
//		if (file_exists('www.drogueriasur.com.ar/ds/webroot/img/'.$uploadPath.$fragancia['imagen'] ))

echo $this->Html->image($uploadPath.$fragancia['imagen'], ['alt' => str_replace('"', '', $fragancia['nombre']),'height' => 300]);
?>;
</div>
<div style="float: left; margin:10px;">
<div class=infofrag><?php echo 'Nombre: '.$fragancia['nombre'];?></div>
<div class=infofrag><?php echo 'Marca: '.$marcas[$fragancia['marca_id']];?></div>
<div class=infofrag><?php echo 'Genero; '.$generos[$fragancia['genero_id']];?></div>
<div class=infofrag><?php echo 'Activo. '; if ($fragancia['eliminado']) echo 'SI'; else echo 'NO';?></div>

</div>
</fieldset>
</div><!-- end of .tab_container -->
<div class="fraganciasPresentaciones index large-9 medium-8 columns content">
<table class="tablesorter" cellpadding="0" cellspacing="0">
<thead>
<tr>
<th><?= $this->Paginator->sort('detalle','tamaño') ?></th>
<th>Descripción Sistema</th>
<th>Stock</th>
<th>Precio</th>
<th><?= $this->Paginator->sort('creado') ?></th>
<th class="actions"><?= __('Actions') ?></th>
</tr>
</thead>
<tbody>
<?php foreach ($fraganciaspresentaciones as $fraganciasPresentacione): ?>
<tr>
<?php  $articulo= $fraganciasPresentacione->articulo; ?>
<td><?= h($fraganciasPresentacione->detalle).' ml' ?></td>
<td><?php echo $articulo['descripcion_pag'] ?></td>
<td>
<?php
switch ($articulo['stock']) {
case 'B':
echo $this->Html->image('bajo.png',['title' => 'Stock Bajo, Consultar Operadora'] );
break;
case 'F':
echo $this->Html->image('falta.png',['title' => 'Producto en Falta']);
break;
case 'S':
echo $this->Html->image('alto.png',['title' => 'Stock Habitual']);
break;
case 'R':
echo $this->Html->image('restrin.png',['title' => 'Producto sujeto a stock']);
break;
case 'D':
echo $this->Html->image('descont.png',['title' => 'Producto Discontinuo']);
break;
}
?>
</td>		
<td class='fragpre'>
<?php

echo '$ '.number_format(round(h($articulo['precio_publico'])*0.807, 3),2,',','.'); 
?>
</td>
<td><?= h($fraganciasPresentacione->creado) ?></td>
<td class="actions">
<?=	$this->Html->image("admin/icn_edit.png", array(
"alt" => "Edit",
'url' => array('controller' => 'FraganciasPresentaciones', 'action' => 'edit_admin',  $fraganciasPresentacione->id)
));
?>
<?php 
echo $this->Form->postLink(
$this->Html->image('admin/icn_trash.png',
array("alt" => __('Delete'), "title" => __('Delete'))), 
array('controller'=>'FraganciasPresentaciones','action' => 'delete_admin', $fraganciasPresentacione->id), 
array('escape' => false, 'confirm' => __('Esta seguro de eliminar a # {0}?', $fraganciasPresentacione->detalle))
);
?>
</td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
</div>
<fieldset>
<div class="search-form">
<?= $this->Form->create('Fragancias',['url'=>['controller'=>'Fragancias','action'=>'edit_admin_search'],'id'=>'searchformfragancia','onsubmit'=>'return validar()']); ?>
<?php
echo $this->Form->input('terminobuscar', ['label'=>'','id'=>'terminobuscar','name'=>'terminobuscar', 'type'=>'text','onchange'=>'javascript:document.confirmInput.submit();']);
echo $this->Form->submit('Buscar');
echo $this->Form->end() 
?>
</div> <!-- /.search-form -->
</fieldset>
</article><!-- end of content manager article -->
<script>
function validar(){
//Almacenamos los valores
var nombre=$('#terminobuscar').val();
//Comprobamos la longitud de caracteres
if (nombre.length>2){ 
return true;
}
else 
{
var mensaje= 'Minimo 3 caractere ';
alert(mensaje);
return false;		
}

}
</script>