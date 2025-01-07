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

<table class="tablesorter"> 
<thead> 
<tr>
<th><?= $this->Paginator->sort('id','Nro') ?></th>
<th><?= $this->Paginator->sort('nombre','Nombre') ?></th>
<th><?= $this->Paginator->sort('ubicacion') ?></th>
<th><?= $this->Paginator->sort('activo','Activa') ?></th>
<th><?= $this->Paginator->sort('orden','ORD') ?></th>
<th class="actions"><?= __('') ?></th>
</tr>
</thead>
<tbody>
<?php $ubicacion = array('1'=>'Exterior', '2'=>'Principal','3'=>'Tiendas','4'=>'Sliders de Producto','5'=>'Eventos Especiales');?>
<?php $i=0; ?>
<?php foreach ($ofertastipos as $ofertatipo): ?>
<?php echo '<tr id="trBody'. $ofertatipo['id'].'"><td>'.$ofertatipo['id'];?>  </td>
<td> <?= $ofertatipo['nombre'] ?> </td>
<td><?= $ubicacion[$ofertatipo['ubicacion']] ?></td>
<td><?php if($ofertatipo['activo']==1)
echo "SI";
else
echo "NO"
?>
</td>
<td><?= $ofertatipo['orden'] ?></td>
<td class="actions">
<?php
echo $this->Html->image("admin/admin_edit.png", ["alt" => "Edit",'url' => ['controller' => 'OfertasTipos', 'action' => 'edit_admin',  $ofertatipo->id],
'data-static'=>'../img/admin/admin_edit.png','data-hover'=>'../img/admin/admin_edit.gif','class'=>'hover-gif','style'=>'width=50px']); 
?>
<a href="#" onclick="preguntarSiNo(<?php echo $ofertatipo->id ?>)">
<?php echo $this->Html->image("admin/admin_delete.png", ["alt" => "imagen_reset",'data-static'=>'../img/admin/admin_delete.png','data-hover'=>'../img/admin/admin_delete.gif','class'=>'hover-gif','style'=>'width=50px']); ?>
</a>


</td>
</tr>
<?php endforeach; ?>
</tbody> 
</table>

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



var myBaseUrlsdelete = '<?php echo \Cake\Routing\Router::url(array('controller' => 'OfertasTipos', 'action' => 'delete_admin')); ?>';
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

