<div>	
<div id="tab1" class="tab_content">
<div class="paginationtop">
<ul>
<?php
echo $this->Paginator->prev(__('Anterior'), array('tag' => 'li'), null, array('tag' => 'li','disabledTag' => 'a'));
echo $this->Paginator->numbers(array('separator' => '','currentTag' => 'a', 'currentClass' => 'active','tag' => 'li','first' => 1));
echo $this->Paginator->next(__('Siguiente'), array('tag' => 'li','currentClass' => 'disabled'), null, array('tag' => 'li','disabledTag' => 'a'));?>
</ul>
<div class="total">
<?php echo $this->Paginator->counter('{{count}} Total');?>
</div>
</div>
<?= $this->Form->create('Fragancias',['url'=>['controller'=>'Fragancias','action'=>'edit_fragancias_admin']]); ?>
<table class="tablesorter"> 
<thead> 
<tr>
<th><?= $this->Paginator->sort('id','Imagen') ?></th>
<th><?= $this->Paginator->sort('nombre','Descripción') ?></th>
<th><?= $this->Paginator->sort('marca_id') ?></th>
<th><?= $this->Paginator->sort('genero_id') ?></th>
<th><?= $this->Paginator->sort('eliminado','Elimando') ?></th>
<th><?= $this->Paginator->sort('creado') ?></th>
<th class="actions"><?= __('') ?></th>
</tr>
</thead>
<tbody>
<?php $indice=0; ?>
<?php foreach ($fragancias as $fragancia): ?>
<?php echo '<tr id="trBody' . $fragancia['id'] . '">';?> 
<td>
<?php 		
$uploadPath = 'fragancias/';
if (file_exists('www.drogueriasur.com.ar/ds/webroot/img/'.$uploadPath.$fragancia['imagen'] ))
echo $this->Html->image($uploadPath.$fragancia['imagen'], ['alt' => str_replace('"', '', $fragancia['nombre']),'height' => 100]);
else
echo $this->Html->image($uploadPath.$fragancia['imagen'], ['alt' => str_replace('"', '', $fragancia['nombre']),'height' => 100]);
?> 
</td>
<td><?= $fragancia->nombre ?></td>
<td><?= $fragancia->has('marca') ? $fragancia->marca->nombre : '' ?></td>
<td><?= $fragancia->has('genero') ? $fragancia->genero->nombre : '' ?></td>
<td><?php //if($fragancia->eliminado==0)	echo "SI";			else			echo "NO";		?>
<?php
$indice+=1;
$encabezado = $indice.'.';
echo $this->Form->input($encabezado.'id',['type'=>'hidden','value'=> $fragancia['id']]);
$eliminado = $fragancia->eliminado;
echo $this->Form->input($encabezado.'eliminado', ['tabindex'=>$indice,'label'=>'','type'=>'checkbox','checked'=>$eliminado]); ?>
</td>
<td><?= h($fragancia->creado) ?></td>
<td class="actions">
<?=	$this->Html->image("admin/icn_edit.png", ["alt" => "Edit",'url' => ['controller' => 'fragancias', 'action' => 'edit_admin',  $fragancia->id]]);?>
<?=	$this->Html->image("admin/icn_view.png", ["alt" => "Ver", 'url' => ['controller' => 'fragancias', 'action' => 'view_admin',  $fragancia->id]]);?>
<a href="#" onclick="preguntarSiNo(<?php echo $fragancia->id ?>)"><img src="/ds3/img/admin/icn_trash.png" alt=""></a>
</td>
</tr>
<?php endforeach; ?>
</tbody> 
</table>
<?= $this->Form->submit('Guardar Cambios',['id'=>'buttonsearch']); ?>
<?= $this->Form->end() ?>
</div><!-- end of .tab_container -->
<div class="pagination">
<ul>
<?php
echo $this->Paginator->prev(__('Anterior'), array('tag' => 'li'), null, array('tag' => 'li','disabledTag' => 'a'));
echo $this->Paginator->numbers(array('separator' => '','currentTag' => 'a', 'currentClass' => 'active','tag' => 'li','first' => 1));
echo $this->Paginator->next(__('Siguiente'), array('tag' => 'li','currentClass' => 'disabled'), null, array('tag' => 'li','disabledTag' => 'a'));?>
</ul>
<div class="total">
<?php echo $this->Paginator->counter('{{count}} Total');?>
</div>
</div>
</div>		

<script>
var myBaseUrlsdelete = '<?php echo \Cake\Routing\Router::url(array('controller' => 'Fragancias', 'action' => 'delete_admin')); ?>';
function eliminarDatos(id) {
$.ajax({
type: "post",
url: myBaseUrlsdelete,
data: "id=" + id,
dataType: "json",
success: function (data, response) {
if ((response = "ok")) {
//$("input[data-id=" + arti + "]").val("");
$("tr[id=trBody" + id + "]").remove();
alertify.message("").dismissOthers();
alertify.success("Eliminado con exito!");
}
}
});
}

function preguntarSiNo(id) {
alertify.confirm(
"Eliminar",
"¿Esta seguro de eliminar esta fragancia?",
function () {
eliminarDatos(id);
},
function () {
alertify.error("Se cancelo la operación");
}
);
}</script>