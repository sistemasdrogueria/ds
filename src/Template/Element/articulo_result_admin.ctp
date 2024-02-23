<div>
<div>
<?= $this->Form->create('Articulos',['url'=>['controller'=>'Articulos','action'=>'imagenesreset']]); ?>
<table class="tablesorter">    
<thead>
<tr>	
<th>Img</th>
<th><?= $this->Paginator->sort('descripcion_pag','Descripción') ?></th>
<th><?= $this->Paginator->sort('categoria_id') ?></th>
<th><?= $this->Paginator->sort('codigo_barras') ?></th>
<th><?= $this->Paginator->sort('troquel') ?></th>
<th><?= $this->Paginator->sort('precio_publico','P.Farmacia') ?></th>
<th><?= $this->Paginator->sort('precio_publico','P.Publico') ?></th>
<th><?= $this->Paginator->sort('stock') ?></th>
<th><?= $this->Paginator->sort('fecha_alta','F.ALTA') ?></th>
<th></th>
</tr>
</thead>
<tbody>
<?php $i=1; ?>
<?php foreach ($articulos as $articulo): ?>
<?php  $encabezado = $i."."; ?>
<tr>
<td class='formcartcanttd'>
<?php
    echo $this->Html->image('productos/'.$articulo['imagen'], ['alt' => str_replace('"', '', $articulo['descripcion']),'height' => 75,'class'=>'imgFoto']);
    echo $this->Form->input('id',['type'=>'hidden','value'=>$articulo->id]);
?>
</td>
<td><?= h($articulo->descripcion_pag) ?></td>
<td>
<?= $articulo->has('categoria') ? $articulo->categoria->nombre : '' ?>
</td>
<td><?= h($articulo->codigo_barras) ?></td>
<td><?= h($articulo->troquel) ?></td>
<td class='colprecio'><?php echo number_format(round(h($articulo->precio_publico)*0.807, 3),2); ?></td>
<td class='colprecio'><?= h($articulo->precio_publico) ?></td>
<td><?php
switch ($articulo['stock']) {
case 'B': echo $this->Html->image('bajo.png',['title' => 'Stock Bajo, Consultar Operadora'] );	break;
case 'F': echo $this->Html->image('falta.png',['title' => 'Producto en Falta']);				break;
case 'S': echo $this->Html->image('alto.png',['title' => 'Stock Habitual']);					break;
case 'R': echo $this->Html->image('restrin.png',['title' => 'Producto sujeto a stock']);		break;
case 'D': echo $this->Html->image('descont.png',['title' => 'Producto Discontinuo']);			break;
}
?>
</td>
<td class='colprecio'><?php 
if ($articulo->fecha_alta!=null) 
echo date_format($articulo->fecha_alta ,'d-m-Y');
?></td>

<td>
<?php echo $this->Form->input($encabezado.'id',['type'=>'hidden','value'=>$articulo->id]);
echo $this->Form->input($encabezado.'eliminado', ['tabindex'=>$i+1,'label'=>'','type'=>'checkbox','checked'=>0]); 
?>
<?=	$this->Html->image("admin/icn_edit.png", array(
"alt" => "Edit",
'url' => array('controller' => 'Articulos', 'action' => 'edit',  $articulo->id)
));

?>
<?=	$this->Html->image("admin/icn_trash.png", array(
"alt" => "imagen_reset",
'url' => array('controller' => 'Articulos', 'action' => 'imagenreset',  $articulo->id)
));
?>
</td>
</tr>
<?php $i=$i+1; endforeach; ?>
</tbody>
</table>
</div>
<?= $this->Form->submit('Resetear Imagenes',['id'=>'buttonsearch']); ?>
<?= $this->Form->end() ?>
<div class="pagination">
<ul>
<?php
echo $this->Paginator->prev(__('Anterior'), array('tag' => 'li'), null, array('tag' => 'li','disabledTag' => 'a'));
echo $this->Paginator->numbers(array('separator' => '','currentTag' => 'a', 'currentClass' => 'active','tag' => 'li','first' => 1));
echo $this->Paginator->next(__('Siguiente'), array('tag' => 'li','currentClass' => 'disabled'), null, array('tag' => 'li','disabledTag' => 'a'));
?>
</ul>
<div class="total">
<?php
echo $this->Paginator->counter('{{count}} Total');
?>
</div>
</div>
</div>
<div class="modal fade" id="enlargeImageModal" tabindex="-1" role="dialog" aria-labelledby="enlargeImageModal" aria-hidden="true">
<div class="modal-dialog modal-lg" role="document">
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
</div>
<div class="modal-body">       
<img src="" class="enlargeImageModalSource" style="width: 100%;">       
</div>
</div>
</div>
</div>
<script type="text/javascript">
$("tr").not(':first').hover(
function () {
$(this).css("background","#8FA800");
}, 
function () {
$(this).css("background","");
}
);
</script>
<script>
$(function() {
$('.imgFoto').on('click', function() {
var str =  $(this).attr('src');
//alert (str);
//var str = str.replace("foto.png", "productos/"+$(this).data("id"));
var res = str.replace("productos/", "productos/big_");
var a = new XMLHttpRequest;
a.open( "GET", res, false );
a.send( null );
if (a.status === 404)
{
var res =  $(this).attr('src');
//var res = res.replace("foto.png", "productos/"+$(this).data("id"));
}			
//var res =  $(this).attr('src');
$('.enlargeImageModalSource').attr('src',res);
$('#enlargeImageModal').modal('show');
});
});
</script>