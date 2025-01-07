<style>
.marca_img{
    width: 150px;
  height: 75px;
  object-fit: contain;
}

#scrollToTopBtn { display: none; position: fixed; bottom: 20px; right: 20px; font-size: 24px; padding: 10px 15px; text-align: center; cursor: pointer; z-index: 1000; text-decoration: none; }

</style>

<div>	
<div id="tab1" class="tab_content">
<table class="tablesorter"> 
<thead> 
<tr>
<th><?= $this->Paginator->sort('id','Imagen') ?></th>
<th><?= $this->Paginator->sort('id','Nro') ?></th>
<th><?= $this->Paginator->sort('nombre','Nombre') ?></th>
<th><?= $this->Paginator->sort('marcas_tipos_id','Tipo') ?></th>
<th><?= $this->Paginator->sort('orden','Orden') ?></th>
<th class="actions"><?= __('') ?></th>
</tr>
</thead>
<tbody>
<?php $indice=0; foreach ($marcas as $marca): ?>
  <?php echo '<tr id="trBody' . $marca['id'] . '">';?> 
<td>
<?php 
  if ($marca['marcas_tipos_id']!=11 && $marca['marcas_tipos_id']!=12)
  $uploadPath = 'marcas/';
else
  $uploadPath = 'logos/';

$filename = WWW_ROOT . 'img' . DS .$uploadPath.$marca['imagen'] ;						
if (file_exists($filename))
{
if (is_null($marca['imagen']))
{ echo $this->Html->image('sin_logo_marca.png', ['alt' => 'NO TIENE','class' => 'marca_img']); 
  
}
else
  echo $this->Html->image($uploadPath.$marca['imagen'], ['alt' => str_replace('"', '','NO TIENE'),'class' => 'marca_img']); 
}
  ?> 
</td>
<td><?= $this->Number->format($marca->id) ?></td>
<td><?= $marca->nombre ?></td>
<td>
<?php echo $marcastipos[$marca->marcas_tipos_id];?>
</td>
<td>
<?php echo $marca->orden?>
</td>
<td class="actions">
<?php
echo $this->Html->image("admin/admin_edit.png", ["alt" => "Edit",'url' => ['controller' => 'marcas', 'action' => 'edit_admin',  $marca->id],
'data-static'=>'../img/admin/admin_edit.png','data-hover'=>'../img/admin/admin_edit.gif','class'=>'hover-gif','style'=>'width=50px']);
?>
  <a href="#" onclick="preguntarSiNo(<?php echo $marca->id ?>)"><?php 
  echo $this->Html->image("admin/admin_delete.png", ["alt" => "imagen_reset",'data-static'=>'../img/admin/admin_delete.png','data-hover'=>'../img/admin/admin_delete.gif','class'=>'hover-gif','style'=>'width=50px']);
  ?>
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
<?php echo $this->Paginator->counter('{{count}} Total'); ?>
</div>
</div>
</div>		
<?php 
echo $this->Html->image("admin/admin_up.png", ["alt" => "Edit",'id'=>'scrollToTopBtn',/*'class'=>'scroll-to-top',*/
'data-static'=>'../img/admin/admin_up.png','data-hover'=>'../img/admin/admin_up.gif','class'=>'hover-gif','style'=>'width=50px']);
?>

<script>
let scrollToTopBtn = document.getElementById("scrollToTopBtn");

// Muestra el botón cuando el usuario se desplaza hacia abajo
window.onscroll = function() {
    if (document.body.scrollTop > 100 || document.documentElement.scrollTop > 100) {
        scrollToTopBtn.style.display = "block";
    } else {
        scrollToTopBtn.style.display = "none";
    }
};

// Cuando el usuario hace clic en el botón, lo lleva a la parte superior
scrollToTopBtn.addEventListener("click", function(event) {
    event.preventDefault();
    window.scrollTo({
        top: 0,
        behavior: "smooth"
    });
});
	
var myBaseUrlsdelete = '';
function eliminarDatos(id) {
  
	  
  $.ajax({
    type: "post",
    url: '<?php echo \Cake\Routing\Router::url(array('controller' => 'Marcas', 'action' => 'delete_admin')); ?>',
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
}</script>