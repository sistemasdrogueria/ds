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
<?= $this->Form->create('Ofertas',['url'=>['controller'=>'Ofertas','action'=>'edit_oferta'],'name'=>'f1','id'=>'f1']); ?>
<table class="tablesorter"> 
<thead> 
<tr>
<th><?= $this->Paginator->sort('id','Imagen') ?></th>
<th><?= $this->Paginator->sort('articulo_id','Descripción') ?></th>
<th><?= $this->Paginator->sort('descuento_producto','Desc.') ?></th>
<th><?= $this->Paginator->sort('unidades_minimas','U.Min') ?></th>
<th><?= $this->Paginator->sort('plazos','Plazos') ?></th>
<th><?= $this->Paginator->sort('fecha_desde', 'F. Desde') ?></th>
<th><?= $this->Paginator->sort('fecha_hasta','F. Hasta')?></th>
<th><?= $this->Paginator->sort('oferta_tipo_id') ?></th>
<th><?= $this->Paginator->sort('habilitada','Activa') ?></th>
<th><input type="checkbox" id="selectall"></th>
<th><?= $this->Paginator->sort('orden','ORD') ?></th>
<th class="actions"><?= __('') ?></th>
</tr>
</thead>
<tbody>

<?php $i=0; ?>
<?php foreach ($ofertas as $oferta): ?>

<?php echo '<tr id="trBody' . $oferta['id'] . '">';?>    
<td>
<?php 
$i=$i+1;
$encabezado = $i.".";
if ($oferta->oferta_tipo_id<2)
{
   $uploadPath = 'productos//' ;
   $filename = WWW_ROOT . 'img' . DS .$uploadPath.$oferta['articulo']['imagen'] ;
}
else
{
   $uploadPath = 'ofertas//' ;
   $filename = WWW_ROOT . 'img' . DS .$uploadPath.$oferta['imagen'] ;						
}
if (file_exists($filename))
{
   if ($oferta->oferta_tipo_id<2)
   {
      echo $this->Html->image($uploadPath.$oferta['articulo']['imagen'], ['alt' => str_replace('"', '', $oferta['descripcion']),'height' => 75]);
   }
   else
   {
     echo $this->Html->image($uploadPath.$oferta['imagen'], ['alt' => str_replace('"', '', $oferta['descripcion']),'height' => 75]);
  
   }
   
}
//else
//echo $uploadPath.$oferta['imagen'];	
?>       
</td>
<td>
<?= $oferta->descripcion ?>
</td>
<td><?php echo $oferta->descuento_producto.' %' ?></td>
<td><?= $oferta->unidades_minimas ?></td>
<td><?= $oferta->plazos ?></td>
<td><?php echo date_format($oferta->fecha_desde,'d-m-Y');?></td>
<td><?php echo date_format($oferta->fecha_hasta,'d-m-Y');?></td>

<td><?= $oferta['ofertas_tipo']['nombre'] ?></td>
<td><?php if($oferta->habilitada==1)
echo "SI";
else
echo "NO"
?>
</td>
<td>
<?php 
echo $this->Form->input($encabezado.'id',['type'=>'hidden','value'=>$oferta->id]);
$habilitada = $oferta->habilitada;
echo $this->Form->input($encabezado.'habilitada', ['tabindex'=>$i,'label'=>'','type'=>'checkbox','checked'=>$habilitada],['class'=>'case[]']); ?>
</td>
<td>
<?php echo $oferta->orden;?>
</td>
<td class="actions">
<?=	$this->Html->image("admin/icn_edit.png",  ["alt" => "Edit",'url' => ['controller' => 'ofertas', 'action' => 'edit_admin',  $oferta->id]]);?>
<?=	$this->Html->image("admin/icn_view.png",  ["alt" => "Ver", 'url' => ['controller' => 'ofertas', 'action' => 'view_admin',  $oferta->id]]);?>
<a href="#" onclick="preguntarSiNo(<?php echo $oferta->id ?>)"><?php echo $this->Html->image('admin/icn_trash.png');?></a>
</td>
</tr>
<?php endforeach; ?>
</tbody> 
</table>
<?= $this->Form->submit('Habilitar Seleccionados',['name'=>'btn1']); ?>
<?= $this->Form->submit('Borrar Selecionados',['name'=>'btn2', 'confirm' => __('Esta seguro de eliminar')]); ?>
<?= $this->Form->end() ?>
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
<?php
echo $this->Paginator->counter('{{count}} Total');
?>
</div>
</div>
</div>	

<script>
   function seleccionar_todo(valor){

   for (i=0;i<document.f1.elements.length;i++)
      if(document.f1.elements[i].type == "checkbox")
         document.f1.elements[i].checked=valor;
} 

$("#selectall").on("click", function() {
   var x = document.getElementById("selectall").checked;
   seleccionar_todo(x);
});



var myBaseUrlsdelete = '<?php echo \Cake\Routing\Router::url(array('controller' => 'Ofertas', 'action' => 'delete_admin')); ?>';
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
    "¿Esta seguro de eliminar esta oferta?",
    function () {
      eliminarDatos(id);
    },
    function () {
      alertify.error("Se cancelo la operación");
    }
  );
}</script>

