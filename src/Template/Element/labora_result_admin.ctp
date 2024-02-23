<style>
.marca_img{
    width: 150px;
  height: 75px;
  object-fit: contain;
}
</style>

<div>	
<div id="tab1" class="tab_content">
<table class="tablesorter"> 
<thead> 
<tr>
<th><?= $this->Paginator->sort('id','id') ?></th>
<th><?= $this->Paginator->sort('codigo','Codigo') ?></th>
<th><?= $this->Paginator->sort('nombre','Laboratorio') ?></th>
<th><?= $this->Paginator->sort('unidades','Unidades') ?></th>
<th><?= $this->Paginator->sort('restricciones','Restricción') ?></th>
<th class="actions"><?= __('') ?></th>
</tr>
</thead>
<tbody>
<?php $indice=0; foreach ($laboratorios as $labora): ?>
  <?php echo '<tr id="trBody' . $labora['id'] . '">';?> 
<td><?= $labora->id?></td>
<td><?= $labora->codigo ?></td>
<td><?= $labora->nombre ?></td>
<td><?= $labora->unidades ?></td>
<td><?php  if($labora->restriciones){
  echo "Articulos con restrición";

}else{

} ?></td>
<td class="actions">
<?=	$this->Html->image("admin/icn_edit.png", array( "alt" => "Edit","onclick"=>"modalview('".$labora->id."','".$labora->nombre."','".$labora->restriciones."','".$labora->unidades."');")); ?>
<?php 
?>
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
<?php echo $this->Paginator->counter('{{count}} Total'); ?>
</div>
</div>
</div>		
<script>		

/*
function eliminarDatos(id) {
  $.ajax({
    type: "post",
    url: myBaseUrlsedit,
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
    "¿Esta seguro de eliminar esta Marca/Logo?",
    function () {
      eliminarDatos(id);
    },
    function () {
      alertify.error("Se cancelo la operación");
    }
  );
}

*/</script>