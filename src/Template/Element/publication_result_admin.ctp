<script>
$(document).ready(function() {
$(".formpublicationactive").change(function() {
var id=$(this).attr("data-id");
ajaxactive(id);
});
var inputs = document.querySelectorAll("input,select");
for (var i = 0; i < inputs.length; i++) {
inputs[i].addEventListener("keypress", function(e) {
if (e.which == 13 || e.keyCode == 40 || e.keyCode == 38 || e.keyCode == 18 || e.keyCode == 9) {
e.preventDefault();
var nextInput = document.querySelectorAll('[tabIndex="' + (this.tabIndex + 1) + '"]');
if (nextInput.length === 0) {
nextInput = document.querySelectorAll('[tabIndex="1"]');
}
nextInput[0].focus();
}
})
}
function ajaxactive(id) {
$.ajax({
type: "POST",
url: "<?php echo \Cake\Routing\Router::url(array('controller' => 'Publications', 'action' => 'update_admin')); ?>",
data: {
id: id,
},
dataType: "json",
success: function(data, textStatus) {
//alertify.message("").dismissOthers();
//	alertify.success("Cantidad Agregada Con Exito!");
},
error: function(textStatus) {
//console.log(textStatus);
//window.location.replace("/products/clear");
}
});
}
});
</script> 

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

<?= $this->Form->create('Publications',['url'=>['controller'=>'Publications','action'=>'edit_publication_admin']]); ?>
<table class="tablesorter"> 
<thead> 
<tr>
<th><?= $this->Paginator->sort('id','Imagen') ?></th>
<th><?= $this->Paginator->sort('id','Nro') ?></th>
<th><?= $this->Paginator->sort('descripcion','Descripción') ?></th>
<th><?= $this->Paginator->sort('fecha_desde') ?></th>
<th><?= $this->Paginator->sort('fecha_hasta') ?></th>
<th><?= $this->Paginator->sort('ubicacion','Ubicación') ?></th>
<th><?= $this->Paginator->sort('orden', 'Orden') ?></th>
<th><?= $this->Paginator->sort('habilitada','Activa') ?></th>
<th class="actions"><?= __('') ?></th>
</tr>
</thead>
<tbody>
<?php $indice=0; foreach ($publications as $publication): ?>
<?php echo '<tr id="trBody' . $publication['id'] . '">';?> 
<td>
<?php 
if ($publication['ubicacion']!=1 && $publication['ubicacion']!=9) $uploadPath = 'publicaciones/';
else $uploadPath = 'inicio/';
$filename = WWW_ROOT . 'img' . DS .$uploadPath.$publication['imagen'] ;						
if (file_exists($filename))
echo $this->Html->image($uploadPath.$publication['imagen'], ['alt' => str_replace('"', '', $publication['descripcion']),'style'=>"height:75px; max-width:250px;"]);
?> 
</td>
<td><?= $this->Number->format($publication->id) ?></td>
<td><?= $publication->descripcion ?></td>
<td><?php echo date_format($publication->fecha_desde,'d-m-Y');?></td>
<td><?php echo date_format($publication->fecha_hasta,'d-m-Y');?></td>
<td><?php 
//$ubicacion= [0=>'A determinar',1=>'SLIDER',2=>'INICIO PP',3=>'CONFIRMAR PEDIDO UP',4=>'VER CARRO PP',5=>'IMPORTAR PEDIDO PP',6=>'UNDER THE CART I',7=>'UNDER THE CART S',8=>'CUENTA CORRIENTE',9=>'EXPOSUR SLIDER',10=>'UNDER THE CART N',12=>'SUR FS'];
echo $publicationsTipos[$publication['ubicacion']];
?></td>
<td><?php echo $publication['orden'];?></td>
<td>
<?php 
$indice+=1;
$encabezado = $indice.'.';
echo $this->Form->input($encabezado.'id',['type'=>'hidden','value'=> $publication->id]);
$habilitada = $publication->habilitada;
echo $this->Form->input($encabezado.'habilitada', ['tabindex'=>$indice,'label'=>'','type'=>'checkbox','checked'=>$habilitada, 'class'=>'formpublicationactive','data-id' =>$publication->id]); ?>
</td>
<td class="actions">
<?=	$this->Html->image("admin/icn_edit.png", ["alt" => "Edit",'url' => ['controller' => 'publications', 'action' => 'edit_admin',  $publication->id]]); ?>
<a href="#" onclick="preguntarSiNo(<?php echo $publication->id ?>)"><?php echo $this->Html->image('admin/icn_trash.png');?></a>
</td>
</tr>
<?php endforeach; ?>
</tbody> 
</table>
<?php // $this->Form->submit('Guardar Cambios',['id'=>'buttonsearch']);  $this->Form->end() ?>
</div><!-- end of .tab_container -->
<div class="pagination">
<ul>
<?php
echo $this->Paginator->prev(__('Anterior'), array('tag' => 'li'), null, array('tag' => 'li','disabledTag' => 'a'));
echo $this->Paginator->numbers(array('separator' => '','currentTag' => 'a', 'currentClass' => 'active','tag' => 'li','first' => 1));
echo $this->Paginator->next(__('Siguiente'), array('tag' => 'li','currentClass' => 'disabled'), null, array('tag' => 'li','disabledTag' => 'a'));
?>
</ul>
<div class="total">
<?php echo $this->Paginator->counter('{{count}} Total'); ?>
</div>
</div>
</div>
<script>		
var myBaseUrlsdelete = '<?php echo \Cake\Routing\Router::url(array('controller' => 'Publications', 'action' => 'delete_admin')); ?>';
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
    "¿Esta seguro de eliminar esta publicación?",
    function () {
      eliminarDatos(id);
    },
    function () {
      alertify.error("Se cancelo la operación");
    }
  );
}</script>
